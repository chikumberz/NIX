<?php

	namespace Application\Packages\Modules\User\Controllers;

	/**
	 * Router Prefix
	 * @RoutePrefix( "/:admin/login" )
	 *
	 */
	class LoginController extends \Phalcon\Mvc\Controller {

		/**
		 * Router Index Prefix
		 * @Get( "/", "name" = "user-login" )
		 * @Get( "/index" )
		 *
		 */
		public function indexAction ( ) {

			$this->view->setVar( '_', $language = $this->language->load( array(
				'system' => 'Index',
				'Index',
				'Login/Common',
				'Login/index',
			)));

			$this->view->setVar( 'var_title', 				$this->setting->get( 'title' ) );
			$this->view->setVar( 'var_description', 		$this->setting->get( 'description' ) );
			$this->view->setVar( 'var_address', 			$this->setting->get( 'address' ) );

			$this->view->setVar( 'var_login_auth_url', $this->url->get( array(
				'for' => 'user-login-auth'
			)));

			$this->view->setMainView( 'Common/Blank' );

			$this->view->pick( 'Login/Index' );
		}

		/**
		 * Router Index Prefix
		 * @Post( "/auth", "name" = "user-login-auth" )
		 *
		 */
		public function authAction ( ) {

			$this->view->setVar( '_', $language = $this->language->load( array(
				'system' => 'Index',
				'Index',
				'Login/Common'
			)));

			if ( $this->request->isPost( ) ) {
				if ( $this->security->checkToken( ) ) {

					$username = $this->request->getPost( 'username', 'string' );
					$password = $this->request->getPost( 'password', 'string' );

					$auth = $this->auth->check( array(
						'username' => $username,
						'password' => $password
					));

					if ( $auth ) {
						return $this->response->redirect( array(
							'for' => 'setting'
						));
					} else {
						$this->flicker->error( $language->_( 'validate_login_auth' ) );
					}
				} else {
					$this->flicker->error( $language->_( 'validate_access_tokken' ) );
				}
			}

			return $this->response->redirect( array(
				'for'	=> 'user-login',
			));

		}

	} // END CLASS LOGIN CONTROLLER