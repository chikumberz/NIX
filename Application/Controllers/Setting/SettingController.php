<?php

	namespace Application\Controllers\Setting;

	use \Phalcon\Paginator\Adapter\QueryBuilder as AdapterPaginator;

	use \Phalcon\Validation,
		\Phalcon\Validation\Validator\PresenceOf,
		\Phalcon\Validation\Validator\Email,
		\Phalcon\Validation\Validator\Identical,
		\Phalcon\Validation\Validator\StringLength,
		\Phalcon\Validation\Validator\Confirmation,
		\Phalcon\Validation\Validator\Regex,
		\Phalcon\Validation\Validator\InclusionIn;

	use \Application\Libraries\Engine\Paginator\Paginator;

	use \Application\Models\Setting\Setting,
		\Application\Models\User\Status;

	/**
	 * Access Control List
	 *
	 * @Acl( "controller" = "Setting", "description" = "Setting Access." )
	 */

	class SettingController extends \Application\Controllers\BaseController {

		/**
		 * Set Permission
		 *
		 * @Acl( "key" = "index", "name" = "Index", "description" = "Setting Index." )
		 */

		public function indexAction ( ) {

			$language 	= $this->language->load( 'system', array( 'Index', 'Setting/Common', 'Setting/Index' ) );

			$settings = $this->setting->getAllByGroup( 'sys' );

			$this->view->setVar( '_', 						$language );

			$this->view->setVar( 'var_settings', 			$settings );
			
			$backend_themes = array( );
			$backend_language = array( );
			$frontend_themes = array( );
			$frontend_language = array( );

			$var_backend_themes = array_diff( scandir( $this->config->directories->public->themes->system->dir ), array( '..', '.' ) );
			foreach ( $var_backend_themes as $key => $value ) {
				$backend_themes[$value] = $value;
			}
			$var_backend_language = array_diff( scandir( sprintf( $this->config->directories->public->themes->system->languages->dir, $settings['backend_theme']->getValue( ) ) ), array( '..', '.' ) );
			foreach ( $var_backend_language as $key => $value ) {
				$backend_language[$value] = $value;
			}

			$var_frontend_themes = array_diff( scandir( $this->config->directories->public->themes->shared->dir ), array( '..', '.' ) );
			foreach ( $var_frontend_themes as $key => $value ) {
				$frontend_themes[$value] = $value;
			}
			$var_frontend_language = array_diff( scandir( sprintf( $this->config->directories->public->themes->shared->languages->dir, $settings['frontend_theme']->getValue( ) ) ), array( '..', '.' ) );
			foreach ( $var_frontend_language as $key => $value ) {
				$frontend_language[$value] = $value;
			}

			$this->view->setVar( 'var_backend_themes',  	$backend_themes );
			$this->view->setVar( 'var_backend_languages',  	$backend_language );
			$this->view->setVar( 'var_frontend_themes', 	$frontend_themes );
			$this->view->setVar( 'var_frontend_languages',  $frontend_language );
			$this->view->setVar( 'var_user_status',  		Status::find( array(  
				'( is_archived = 0 OR is_archived IS NULL )'
			)));

			$this->tag->setDefault( 'title', 				$settings['title']->getValue( ) );
			$this->tag->setDefault( 'description', 			$settings['description']->getValue( ) );
			$this->tag->setDefault( 'address', 				$settings['address']->getValue( ) );
			$this->tag->setDefault( 'backend_url', 			$settings['backend_url']->getValue( ) );
			$this->tag->setDefault( 'backend_theme', 		$settings['backend_theme']->getValue( ) );
			$this->tag->setDefault( 'frontend_theme', 		$settings['frontend_theme']->getValue( ) );
			$this->tag->setDefault( 'backend_language', 	$settings['backend_language']->getValue( ) );
			$this->tag->setDefault( 'frontend_language', 	$settings['frontend_language']->getValue( ) );
			$this->tag->setDefault( 'avatar_size', 			$settings['avatar_size']->getValue( ) );
			$this->tag->setDefault( 'table_show', 			implode( ',', $settings['table_show']->getValue( ) ) );
			$this->tag->setDefault( 'table_show_default', 	$settings['table_show_default']->getValue( ) );
			$this->tag->setDefault( 'seo_url', 				$settings['seo_url']->getValue( ) );
			$this->tag->setDefault( 'maintenance', 			$settings['maintenance']->getValue( ) );
			$this->tag->setDefault( 'user_status_active', 	$settings['user_status_active']->getValue( ) );
			$this->tag->setDefault( 'error_display', 		$settings['error_display']->getValue( ) );
			$this->tag->setDefault( 'error_log', 			$settings['error_log']->getValue( ) );
			$this->tag->setDefault( 'error_log_file', 		$settings['error_log_file']->getValue( ) );
			$this->tag->setDefault( 'sql_log', 				$settings['sql_log']->getValue( ) );
			$this->tag->setDefault( 'sql_log_file', 		$settings['sql_log_file']->getValue( ) );
			$this->tag->setDefault( 'class_log', 			$settings['class_log']->getValue( ) );
			$this->tag->setDefault( 'class_log_file', 		$settings['class_log_file']->getValue( ) );

			$this->view->setVar( 'var_token_key',	$this->security->getTokenKey( ) );
			$this->view->setVar( 'var_token', 		$this->security->getToken( ) );

			$this->view->setVar( 'var_breadcrumbs', array(
				'Settings' 		=> $this->url->get( array(
					'for' 			=> 'admin-controller',
					'folder' 		=> 'setting',
					'controller' 	=> 'setting',
				))
			));

			$this->view->setVar( 'var_form_url', $this->url->get( array(
				'for'			=> 'admin-action',
				'folder'		=> 'setting',
				'controller'	=> 'setting',
				'action'		=> 'save'
			)));

			$this->view->pick( 'Setting/Index' );

		}

		public function saveAction ( ) {

			if ( $this->request->isPost( ) == true ) {

				$common_language 	= $this->language->load( 'system', array( 'Setting/Common', 'Setting/Index' ) );
				
				if ( $this->security->checkToken( ) ) {

					$data 					  = new \stdClass( );

					$data->title              = $this->request->getPost( 'title', 'string' );
					$data->description        = $this->request->getPost( 'description', 'string' );
					$data->address            = $this->request->getPost( 'address', 'string' );
					$data->backend_url        = $this->request->getPost( 'backend_url', 'string' );
					$data->backend_theme      = $this->request->getPost( 'backend_theme', 'string' );
					$data->frontend_theme     = $this->request->getPost( 'frontend_theme', 'string' );
					$data->backend_language   = $this->request->getPost( 'backend_language', 'string' );
					$data->frontend_language  = $this->request->getPost( 'frontend_language', 'string' );
					$data->avatar_size  	  = $this->request->getPost( 'avatar_size', 'string' );
					$data->table_show         = $this->request->getPost( 'table_show' );
					$data->table_show_default = $this->request->getPost( 'table_show_default', 'int' );
					$data->seo_url            = $this->request->getPost( 'seo_url', 'string' );
					$data->maintenance        = $this->request->getPost( 'maintenance', 'int' );
					$data->user_status_active = $this->request->getPost( 'user_status_active', 'int' );
					$data->error_display      = $this->request->getPost( 'error_display', 'int' );
					$data->error_log          = $this->request->getPost( 'error_log', 'int' );
					$data->error_log_file     = $this->request->getPost( 'error_log_file', 'string' );
					$data->sql_log            = $this->request->getPost( 'sql_log', 'int' );
					$data->sql_log_file       = $this->request->getPost( 'sql_log_file', 'string' );
					$data->class_log          = $this->request->getPost( 'class_log', 'int' );
					$data->class_log_file     = $this->request->getPost( 'class_log_file', 'string' );
					
					$validator = new Validation( );
					$validator->add( 'title', new PresenceOf( array(
						'cancelOnFail'	=> true,
						'message'		=> $common_language->_( 'validate_setting' ),
					)));

					if ( count( $validator->getMessages( ) ) ) {
						foreach( $validator->getMessages( ) as $message ) {
							$this->flash->error( $message->getMessage( ) );
						}

						$this->dispatcher->forward( array(
							'for' 			=> 'admin-controller',
							'folder'		=> 'setting',
							'controller' 	=> 'setting',
						));
					} else {
						$data = $this->_store( ( object ) $data );

						foreach( $data->messages as $message ) {
							$this->flash->error( $message->getMessage( ) );
						}

						if ( $data->is_saved == true ) {
							$this->view->disable( );
							$this->flash->success( $common_language->_( 'success_message' ) );
							$this->response->redirect( array(
								'for' 			=> 'admin-controller',
								'folder'		=> 'setting',
								'controller' 	=> 'setting',
							));
						} else {
							$this->flash->error( $common_language->_( 'error_message' ) );
							$this->dispatcher->forward( array(
								'for' 			=> 'admin-controller',
								'folder'		=> 'setting',
								'controller' 	=> 'setting',
							));
						}
					}

					return;

				} else {
					$this->flash->error( $common_language->_( 'validate_access_tokken' ) );
				}
			}

			$this->view->disable( );
			$this->response->redirect( array(
				'for' 			=> 'admin-controller',
				'folder'		=> 'setting',
				'controller' 	=> 'setting'
			));

			return;

		}

		private function _store ( $data ) {

			$setting_data = new Setting( );
			$setting_data->set( 'sys', 'title', $data->title )->save( );
			$setting_data->set( 'sys', 'description', $data->description )->save( );
			$setting_data->set( 'sys', 'address', $data->address )->save( );
			$setting_data->set( 'sys', 'backend_url', $data->backend_url )->save( );
			$setting_data->set( 'sys', 'backend_theme', $data->backend_theme )->save( );
			$setting_data->set( 'sys', 'frontend_theme', $data->frontend_theme )->save( );
			$setting_data->set( 'sys', 'backend_language', $data->backend_language )->save( );
			$setting_data->set( 'sys', 'frontend_language', $data->frontend_language )->save( );
			$setting_data->set( 'sys', 'avatar_size', $data->avatar_size )->save( );
			
			$table_show = array( );
			foreach ( explode( ',', $data->table_show ) as $list ) {
				$table_show[$list] = $list;
			}

			$setting_data->set( 'sys', 'table_show', serialize( $table_show ), true )->save( );
			$setting_data->set( 'sys', 'table_show_default', $data->table_show_default )->save( );
			$setting_data->set( 'sys', 'seo_url', $data->seo_url )->save( );
			$setting_data->set( 'sys', 'maintenance', $data->maintenance )->save( );
			$setting_data->set( 'sys', 'user_status_active', $data->user_status_active )->save( );
			$setting_data->set( 'sys', 'error_display', $data->error_display )->save( );
			$setting_data->set( 'sys', 'error_log', $data->error_log )->save( );
			$setting_data->set( 'sys', 'error_log_file', $data->error_log_file )->save( );
			$setting_data->set( 'sys', 'sql_log', $data->sql_log )->save( );
			$setting_data->set( 'sys', 'sql_log_file', $data->sql_log_file )->save( );
			$setting_data->set( 'sys', 'class_log', $data->class_log )->save( );
			$setting_data->set( 'sys', 'class_log_file', $data->class_log_file )->save( );

			$data->data 					= $setting_data;
			$data->is_saved					= true;
			$data->messages					= $setting_data->getMessages( );

			return $data;

		}

	} // END CLASS SETTING CONTROLLER