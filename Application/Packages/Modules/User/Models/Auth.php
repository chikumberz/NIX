<?php

	namespace Application\Packages\Modules\User\Models;

	use Application\Packages\Modules\User\Models\Account,
		Application\Packages\Modules\User\Models\Log,
		Application\Packages\Modules\User\Models\Token;

	class Auth extends \Phalcon\Mvc\User\Component {

		CONST AUTH_KEY 				= 'nix-auth-identity';
		CONST AUTH_USER_ID_KEY		= 'AUI';
		CONST AUTH_USER_TOKEN_KEY 	= 'AUT';

		public function load ( ) {

			if ( $this->hasIdentity( ) ) {

				$identity = $this->getIdentity( );

				$this->authUserById( ( int ) $identity['id'] );

			} else {
				$this->remove( );
			}

		}

		public function check ( $credential ) {

			$account = Account::findFirst( array(
				'( is_archived = 0 OR is_archived IS NULL ) AND email = ?0 OR username = ?0',
				'bind'	=> array(
					$credential['username']
				)
			));

			if ( is_object( $account ) ) {

				if ( $this->security->checkHash( $credential['password'], $account->password ) || $this->security->checkHash( $credential['password'], $account->forgot_password ) ) {

					if ( isset( $credential['remember'] ) ) {
						$this->setToken( $account );
					}

					return $this->setIdentity( $account );

				} else {
					$this->registerAccountThrottling( $account->getId( ) );
				}

			} else {
				$this->registerAccountThrottling( );
			}

			return false;

		}

		public function checkWithCookie ( ) {

			$account_id 	= $this->cookies->get( self::AUTH_USER_ID_KEY )->getValue( );
			$account_token = $this->cookies->get( self::AUTH_USER_TOKEN_KEY )->getValue( );

			$account =  Account::findFirstById( $account_id );

			if ( is_object( $account ) ) {

				$_account_username 		= $account->getUsername( );
				$_account_password 		= $account->getPassword( );
				$_account_user_agent 	= $this->request->getUserAgent( );
				$_account_ip_address 	= $this->request->getClientAddress( );

				$_token 	 			= $this->security->hash( $_user_email . $_user_password . $_user_agent );

				if ( $_token == $account_token  ) {

					$token = $this->getToken( );

					if ( is_object( $token ) ) {

						if ( ( time( ) - ( 86400 * 8 ) ) < strtotime( $token->created_on ) ) {

							return $this->setIdentity( $account );

						}

					}

				}

			}

			$this->remove( );

			return false;

		}

		public function getUser ( ) {

			$identity = $this->getIdentity( );

			if ( isset( $identity['id'] ) ) {

				$user = Account::findFirstById( ( int ) $identity['id'] );

				if ( is_object( $user ) ) {
					return $user;
				}

			}

			return false;

		}

		public function setIdentity ( Account $account ) {

			$account_profile 	= $account->getUserProfile( );
			$account_group 		= $account->getUserGroup( );

			$this->session->set( self::AUTH_KEY, array(
				'id' 				=> $account->getId( ),
				'avatar' 			=> $account->getAvatar( ),
				'avatar_tmb' 		=> $account->getAvatar( true ),
				'first_name'		=> $account_profile->getFirstName( ),
				'last_name'			=> $account_profile->getlastName( ),
				'full_name'			=> $account_profile->getFirstName( ) . ' ' . $account_profile->getMiddleName( ) . ' ' . $account_profile->getlastName( ),
				'full_name_reverse'	=> $account_profile->getlastName( ) . ', ' . $account_profile->getFirstName( ) . ' ' . $account_profile->getMiddleName( ),
				'group'				=> $account_group->getGroup( ),
				'permissions'		=> $account_group->getPermissions( )
			));

			$this->log( $account->getId( ), Log::TYPE_DEFAULT_ACTIVE );

			return true;

		}

		public function getIdentity ( ) {

			return $this->session->get( self::AUTH_KEY );

		}

		public function hasIdentity ( ) {

			return ( boolean ) ( is_array( $this->session->get( self::AUTH_KEY ) ) && $this->session->get( self::AUTH_KEY ) ) ? true : false;

		}

		public function authUserById ( $id ) {

			$account = Account::findFirst( ( int ) $id );

			if ( is_object( $account ) ) {
				$this->setIdentity( $account );
			}

			return false;

		}

		public function setToken ( Account $account ) {

			$_account_id 			= $account->getId( );
			$_account_username 		= $account->getUsername( );
			$_account_password 		= $account->getPassword( );
			$_account_user_agent 	= $this->request->getUserAgent( );
			$_account_ip_address 	= $this->request->getClientAddress( );

			$_token 	 			= $this->security->hash( $_account_username . $_account_password . $_account_user_agent );

			$token 					= new Token( );
			$token->user_acount_id 	= $_account_id;
			$token->token 			= $_token;
			$token->ip_address		= $_account_ip_address;
			$token->user_agent		= $_account_user_agent;

			if ( $token->save( ) == true ) {

				$expire = time( ) + 86400 * 8;

				$this->cookies->set( self::AUTH_USER_ID_KEY, $token->user_acount_id, $expire );
				$this->cookies->set( self::AUTH_USER_TOKEN_KEY, $token->tokken, $expire );

			}

		}

		public function getToken ( $return_default = false ) {

			if ( $this->hasToken( ) ) {

				if ( $this->cookies->has( self::AUTH_USER_ID_KEY ) ) {

					$token = Token::findFirst( array(
		                '[user_account_id] = :user_account_id: AND [token] = :token:',
		                'bind' => array(
		                    'user_account_id' 	=> $this->cookies->get( self::AUTH_USER_ID_KEY ),
		                    'token' 			=> $this->cookies->get( self::AUTH_USER_TOKEN_KEY )
		                )
		            ));

		            if ( $token ) {
		            	return $token;
		            }
	           }

			}

			return $return_default;

		}

		public function hasToken ( ) {

			return $this->cookies->has( self::AUTH_USER_TOKEN_KEY );

		}

		public function remove ( ) {

			if ( $this->cookies->has( self::AUTH_USER_ID_KEY ) )
				$this->cookies->get( self::AUTH_USER_ID_KEY )->delete( );

			if ( $this->cookies->has( self::AUTH_USER_TOKEN_KEY ) )
				$this->cookies->get( self::AUTH_USER_TOKEN_KEY )->delete( );

			$this->session->remove( self::AUTH_KEY );

		}

		public function registerAccountThrottling ( $account_id = false ) {

			$this->log( $account_id );

			$attempts = Log::count( array(
				'[ip_address] = :ip_address: AND [created_on] >= :created_on:',
				'bind' => array(
					'ip_address' 	=> $this->request->getClientAddress( ),
					'created_on'	=> date( 'Y-m-d H:i:s', time( ) - 3600 * 6 )
				)
			));

			switch ( $attempts ) {
				case 1:
				case 2:
					break;

				case 3:
				case 4:
					sleep( 2 );
					break;

				default:
					sleep( 4 );
					break;
			}

		}

		public function log ( $account_id = false, $type_id = Log::TYPE_DEFAULT ) {

			$log = new Log ( );
			$log->user_account_id 	= ( int ) $account_id;
			$log->ip_address 		= $this->request->getClientAddress( );
			$log->user_agent 		= $this->request->getUserAgent( );
			$log->type_id 			= ( int ) $type_id;
			$log->created_on		= date( 'Y-m-d H:i:s' );
			$log->save( );

		}

		public function hasPermission ( $controller, $action ) {

			if ( $this->acl->isPrivate( $controller, $action ) ) {

				$identity = $this->getIdentity( );

				if ( is_array( $identity ) ) {
					if ( !$this->acl->isAllowed( $identity['group'], $controller, $action ) ) {
						return false;
					}
				} else {
					return false;
				}

			}

			return true;

		}

	} // END CLASS AUTH