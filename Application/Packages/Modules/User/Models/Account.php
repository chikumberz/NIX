<?php

	namespace Application\Packages\Modules\User\Models;

	class Account extends \Application\Libraries\Engine\Model\Model {

		public $user_account_id;
		public $user_group_id;
		public $user_status_id;
		public $avatar;
		public $email;
		public $username;
		public $password;
		public $password_forgot;
		public $is_login;
		public $is_archived;
		public $is_trashed;
		public $last_login;
		public $last_active;
		public $created_on;
		public $updated_on;
		public $created_by_id;
		public $updated_by_id;

		public function getSource ( ) {

			return 'mod-user_account';

		}

		public function initialize ( ) {

			$this->hasOne( 'user_account_id', 'Application\Packages\Modules\User\Models\Profile', 'user_account_id', array(
				'foreignKey'	=> array(
					'action' => \Phalcon\Mvc\Model\Relation::ACTION_CASCADE
				),
				'alias' 		=> 'UserProfile'
			));

			$this->belongsTo( 'user_group_id', 'Application\Packages\Modules\User\Models\Group', 'user_group_id', array(
				'foreignKey'	=> array(
					'action' => \Phalcon\Mvc\Model\Relation::ACTION_CASCADE
				),
				'alias' 		=> 'UserGroup'
			));

			$this->belongsTo( 'user_status_id', 'Application\Packages\Modules\User\Models\Status', 'user_status_id', array(
				'foreignKey'	=> array(
					'action' => \Phalcon\Mvc\Model\Relation::ACTION_CASCADE
				),
				'alias' 		=> 'UserStatus'
			));

			$this->hasMany( 'user_account_id', 'Application\Packages\Modules\User\Models\Log', 'user_account_id', array(
				'foreignKey'	=> array(
					'action' => \Phalcon\Mvc\Model\Relation::ACTION_CASCADE
				),
				'alias' => 'UserLog'
			));

			$this->hasMany( 'user_account_id', 'Application\Packages\Modules\User\Models\Token', 'user_account_id', array(
				'foreignKey'	=> array(
					'action' => \Phalcon\Mvc\Model\Relation::ACTION_CASCADE
				),
				'alias' => 'UserToken'
			));

			$this->hasOne( 'created_by_id', 'Application\Packages\Modules\User\Models\Account', 'user_account_id', array(
				'alias' 	=> 'CreatedBy'
			));

			$this->hasOne( 'updated_by_id', 'Application\Packages\Modules\User\Models\Account', 'user_account_id', array(
				'alias' 	=> 'UpdatedBy'
			));

			$this->useDynamicUpdate( true );

			$this->skipAttributesOnCreate( array(
				'update_on',
				'updated_by_id'
			));

			$this->skipAttributesOnUpdate( array(
				'created_on',
				'created_by_id'
			));

		}

		public function beforeValidationOnCreate ( ) {

			$this->beforeCreate( );

		}

		public function beforeValidationOnUpdate ( ) {

			$this->beforeUpdate( );

		}

		public function beforeCreate ( ) {

			$auth = $this->getDI( )->get( 'auth' )->getIdentity( );

			$this->created_on 		= date( 'Y-m-d H:i:s' );
			$this->created_by_id 	= ( int ) $auth['id'];

		}

		public function beforeUpdate ( ) {

			$auth = $this->getDI( )->get( 'auth' )->getIdentity( );

			$this->updated_on 		= date( 'Y-m-d H:i:s' );
			$this->updated_by_id 	= ( int ) $auth['id'];

		}

		public function getId ( ) {

			return $this->user_account_id;

		}

		public function getUsername( ) {

			return $this->username;

		}

		public function getPassword ( ) {

			return $this->password;

		}

		public function getAvatar ( $thumb = false, $vai_http = true ) {

			$url       		= $this->getDI( )->get( 'url' );
			$files_path     = $this->getDI( )->get( 'config' )->directories->public->files->system->path;
			$files_dir      = $this->getDI( )->get( 'config' )->directories->public->files->system->dir;
			$avatar_dir     = Setting::get( 'avatar_dir' );
			$avatar_tmb_dir = Setting::get( 'avatar_tmb_dir' );
			$avatar_default = Setting::get( 'avatar_default' );

			if ( $thumb ) {
				if ( $this->avatar && file_exists( $files_dir . $avatar_dir . DS . $avatar_tmb_dir . DS . $this->avatar ) ) {
					if ( $vai_http ) {
						return $url->get(array(
							'for' 		=> 'file-system',
							'folder'	=> $avatar_dir . DS . $avatar_tmb_dir,
							'file'		=> $this->avatar
						));
					} else {
						return $files_dir . $avatar_dir . DS . $avatar_tmb_dir . DS . $this->avatar;
					}
				}
				if ( $vai_http ) {
					return $url->get(array(
						'for' 		=> 'file-system',
						'folder'	=> $avatar_dir . DS . $avatar_tmb_dir,
						'file'		=> $avatar_default
					));
				} else {
					return $files_dir . $avatar_dir . DS . $avatar_tmb_dir . DS . $avatar_default;
				}
			} else {
				if ( $this->avatar && file_exists( $files_dir . $avatar_dir . DS . $this->avatar ) ) {
					if ( $vai_http ) {
						return $url->get(array(
							'for' 		=> 'file-system',
							'folder'	=> $avatar_dir,
							'file'		=> $avatar_default
						));
					} else {
						return $files_dir . $avatar_dir . DS . $avatar_default;
					}
				}

				if ( $vai_http ) {
					return $url->get(array(
						'for' 		=> 'file-system',
						'folder'	=> $avatar_dir,
						'file'		=> $avatar_default
					));
				} else {
					return $files_dir . $avatar_dir . DS . $avatar_default;
				}
			}

		}

	} // END CLASS USERACCOUNT
