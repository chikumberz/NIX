<?php

	namespace Application\Controllers\User;

	class LoginController extends \Application\Controllers\BaseController {

		public function initialize ( ) {
		
			parent::initialize( );

			$this->view->setMainView( 'Common/Blank' );
 
			$language = $this->language->load( 'sys', array( 'Index', 'User/Login/Common' ) );

			$this->tag->setTitle( $this->setting->get( 'sys', 'title' ) );

			if ( $this->auth->hasIdentity( ) ) {
				return $this->response->redirect( array(
					'for'			=> 'admin-controller',
					'folder'		=> 'dashboard',
					'controller'	=> 'dashboard'
				));
			}

		}

		public function indexAction ( ) {

			$language = $this->language->load( 'system', array( 'Index', 'User/Login/Common', 'User/Login/Index' ) );

			$this->view->setVar( '_', 						$language );

			$this->view->setVar( 'var_token_key',			$this->security->getTokenKey( ) );
			$this->view->setVar( 'var_token', 				$this->security->getToken( ) );
			
			$this->view->setVar( 'var_title', 				$this->setting->get( 'sys', 'title' ) );
			$this->view->setVar( 'var_description', 		$this->setting->get( 'sys', 'description' ) );
			$this->view->setVar( 'var_address', 			$this->setting->get( 'sys', 'address' ) );

			$this->view->setVar( 'var_form_url', $this->url->get( array(
				'for'			=> 'admin-action',
				'folder'		=> 'user',
				'controller'	=> 'login',
				'action'		=> 'auth'
			)));

			$this->view->pick( 'User/Login/Index' );

		}

		public function authAction ( ) {

			$language = $this->language->load( 'system', array( 'Index', 'User/Login/Common' ) );

			if ( $this->request->isPost( ) ) {
				if ( $this->security->checkToken( ) ) {

					$username = $this->request->getPost( 'username', 'string' );
					$password = $this->request->getPost( 'password', 'string' );
					
					$auth     = $this->auth->check( array( 
						'username' => $username,
						'password' => $password
					));

					if ( $auth ) {
						return $this->response->redirect( array(
							'for'        => 'admin-controller',
							'folder'     => 'dashboard',
							'controller' => 'dashboard'
						));
					} else {
						$this->flash->error( $language->_( 'validate_login_auth' ) );
					}
				} else {
					$this->flash->error( $language->_( 'validate_access_tokken' ) );
				}
			}

			return $this->response->redirect( array(
				'for'	=> 'admin',
			));

		}

	} // END CLASS LOGIN CONTROLLER