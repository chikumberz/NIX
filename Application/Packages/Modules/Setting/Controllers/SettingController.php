<?php

	namespace Application\Packages\Modules\Setting\Controllers;

	use \Application\Packages\Modules\Setting\Models\Setting;

	use \Phalcon\Validation,
		\Phalcon\Validation\Validator\PresenceOf,
		\Phalcon\Validation\Validator\Email,
		\Phalcon\Validation\Validator\Identical,
		\Phalcon\Validation\Validator\StringLength,
		\Phalcon\Validation\Validator\Confirmation,
		\Phalcon\Validation\Validator\Regex,
		\Phalcon\Validation\Validator\InclusionIn;

	/**
	 * Router Prefix
	 * @RoutePrefix( "/:admin/setting" )
	 *
	 * Access Control List
	 * @Acl( "controller" = "Modules\Setting\Controllers\Setting", name = "Setting",  "description" = "Setting Access." )
	 */
	class SettingController extends \Phalcon\Mvc\Controller {

		/**
		 * Router Index Prefix
		 * @Get( "/", "name" = "setting" )
		 * @Get( "/index" )
		 *
		 * Set Permission
		 * @Acl( "key" = "index", "name" = "Index", "description" = "Setting Index." )
		 */
		public function indexAction ( ) {

			$this->view->setVar( '_', $language = $this->language->load( array(
				'system' 	=> 'Index',
				'Index',
				'Setting/Index'
			)));

			$settings = Setting::getAllByGroup( 'sys' );

			$themes 	= array( );
			$languages 	= array( );

			$var_themes = array_diff( scandir( $this->config->directories->public->themes->system->dir ), array( '..', '.' ) );
			foreach ( $var_themes as $key => $value ) {
				$themes[$value] = $value;
			}
			$var_language = array_diff( scandir( sprintf( $this->config->directories->public->themes->system->languages->dir, $settings['theme']->getValue( ) ) ), array( '..', '.' ) );
			foreach ( $var_language as $key => $value ) {
				$languages[$value] = $value;
			}

			$mail_protocols = array(
				'Mail',
				'SMTP'
			);

			$this->view->setVar( 'var_settings', 		$settings );
			$this->view->setVar( 'var_themes',  		$themes );
			$this->view->setVar( 'var_languages',  		$languages );
			$this->view->setVar( 'var_mail_protocols',  $mail_protocols );

			$this->tag->setDefault( 'title', 				$settings['title']->getValue( ) );
			$this->tag->setDefault( 'description', 			$settings['description']->getValue( ) );
			$this->tag->setDefault( 'keywords', 			$settings['keywords']->getValue( ) );
			$this->tag->setDefault( 'address', 				$settings['address']->getValue( ) );
			$this->tag->setDefault( 'email', 				$settings['email']->getValue( ) );
			$this->tag->setDefault( 'telephone_no', 		$settings['telephone_no']->getValue( ) );
			$this->tag->setDefault( 'fax_no', 				$settings['fax_no']->getValue( ) );
			$this->tag->setDefault( 'url', 					$settings['url']->getValue( ) );
			$this->tag->setDefault( 'theme', 				$settings['theme']->getValue( ) );
			$this->tag->setDefault( 'language', 			$settings['language']->getValue( ) );
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
			$this->tag->setDefault( 'mail_protocol', 		$settings['mail_protocol']->getValue( ) );
			$this->tag->setDefault( 'mail_parameter', 		$settings['mail_parameter']->getValue( ) );
			$this->tag->setDefault( 'smtp_host', 			$settings['smtp_host']->getValue( ) );
			$this->tag->setDefault( 'smtp_username', 		$settings['smtp_username']->getValue( ) );
			$this->tag->setDefault( 'smtp_password', 		$settings['smtp_password']->getValue( ) );
			$this->tag->setDefault( 'smtp_port', 			$settings['smtp_port']->getValue( ) );
			$this->tag->setDefault( 'smtp_timeout', 		$settings['smtp_timeout']->getValue( ) );
			$this->tag->setDefault( 'emails', 				$settings['emails']->getValue( ) );

			$this->view->setVar( 'var_breadcrumbs', array(
				$language->_( 'text_settings' ) 		=> $this->url->get( array(
					'for' => 'setting',
				))
			));

			$this->view->setVar( 'var_save_url', array(
				'for'	 => 'setting-save'
			));

			$this->view->pick( 'Index' );

		}

		/**
		 * Router Save Prefix
		 * @Post( "/save", "name" = "setting-save" )
		 *
		 */
		public function saveAction ( ) {

			$language = $this->language->load( array(
				'system' 	=> 'Index',
				'Index',
				'Setting/Index'
			));

			if ( $this->security->checkToken( ) ) {

				$data 					  = new \stdClass( );

				$data->title              = $this->request->getPost( 'title', 'string' );
				$data->description        = $this->request->getPost( 'description', 'string' );
				$data->keywords           = $this->request->getPost( 'keywords', 'string' );
				$data->address            = $this->request->getPost( 'address', 'string' );
				$data->email              = $this->request->getPost( 'email', 'string' );
				$data->telephone_no       = $this->request->getPost( 'telephone_no', 'string' );
				$data->fax_no             = $this->request->getPost( 'fax_no', 'string' );
				$data->url                = $this->request->getPost( 'url', 'string' );
				$data->theme              = $this->request->getPost( 'theme', 'string' );
				$data->language           = $this->request->getPost( 'language', 'string' );
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
				$data->mail_protocol      = $this->request->getPost( 'mail_protocol', 'string' );
				$data->mail_parameter     = $this->request->getPost( 'mail_parameter', 'string' );
				$data->smtp_host          = $this->request->getPost( 'smtp_host', 'string' );
				$data->smtp_username      = $this->request->getPost( 'smtp_username', 'string' );
				$data->smtp_password      = $this->request->getPost( 'smtp_password', 'string' );
				$data->smtp_port          = $this->request->getPost( 'smtp_port', 'string' );
				$data->smtp_timeout       = $this->request->getPost( 'smtp_timeout', 'string' );
				$data->emails             = $this->request->getPost( 'emails', 'string' );

				$validator = new Validation( );
				$validator->add( 'title', new PresenceOf( array(
					'cancelOnFail'	=> true,
					'message'		=> $language->_( 'validate_setting' ),
				)));

				if ( count( $validator->getMessages( ) ) ) {
					foreach( $validator->getMessages( ) as $message ) {
						$this->flicker->error( $message->getMessage( ) );
					}

					$this->dispatcher->forward( array(
						'for' => 'setting',
					));
				} else {
					$data = $this->_store( ( object ) $data );

					foreach( $data->messages as $message ) {
						$this->flicker->error( $message->getMessage( ) );
					}

					if ( $data->is_saved == true ) {
						$this->view->disable( );
						$this->flicker->success( $language->_( 'success_message' ) );
						$this->response->redirect( array(
							'for' => 'setting',
						));
					} else {
						$this->flicker->error( $language->_( 'error_message' ) );
						$this->dispatcher->forward( array(
							'for' => 'setting',
						));
					}
				}

				return;

			} else {
				$this->flicker->error( $language->_( 'validate_access_tokken' ) );
			}

			$this->view->disable( );
			return $this->response->redirect( array(
				'for' => 'setting',
			));

		}

		private function _store ( $data ) {

			$setting_data = new Setting( );
			$setting_data->set( 'sys', 'title', $data->title );
			$setting_data->set( 'sys', 'description', $data->description );
			$setting_data->set( 'sys', 'keywords', $data->keywords );
			$setting_data->set( 'sys', 'address', $data->address );
			$setting_data->set( 'sys', 'email', $data->email );
			$setting_data->set( 'sys', 'telephone_no', $data->telephone_no );
			$setting_data->set( 'sys', 'fax_no', $data->fax_no );
			$setting_data->set( 'sys', 'url', $data->url );
			$setting_data->set( 'sys', 'theme', $data->theme );
			$setting_data->set( 'sys', 'language', $data->language );

			$table_show = array( );
			foreach ( explode( ',', $data->table_show ) as $list ) {
				$table_show[$list] = $list;
			}

			$setting_data->set( 'sys', 'table_show', $table_show, true );
			$setting_data->set( 'sys', 'table_show_default', $data->table_show_default );
			$setting_data->set( 'sys', 'seo_url', $data->seo_url );
			$setting_data->set( 'sys', 'maintenance', $data->maintenance );
			$setting_data->set( 'sys', 'user_status_active', $data->user_status_active );
			$setting_data->set( 'sys', 'error_display', $data->error_display );
			$setting_data->set( 'sys', 'error_log', $data->error_log );
			$setting_data->set( 'sys', 'error_log_file', $data->error_log_file );
			$setting_data->set( 'sys', 'sql_log', $data->sql_log );
			$setting_data->set( 'sys', 'sql_log_file', $data->sql_log_file );
			$setting_data->set( 'sys', 'class_log', $data->class_log );
			$setting_data->set( 'sys', 'class_log_file', $data->class_log_file );
			$setting_data->set( 'sys', 'mail_protocol', $data->mail_protocol );
			echo (int) $setting_data->set( 'sys', 'mail_parameter', $data->mail_parameter );
			$setting_data->set( 'sys', 'smtp_host', $data->smtp_host );
			$setting_data->set( 'sys', 'smtp_username', $data->smtp_username );
			$setting_data->set( 'sys', 'smtp_port', $data->smtp_port );
			$setting_data->set( 'sys', 'smtp_timeout', $data->smtp_timeout );
			$setting_data->set( 'sys', 'emails', $data->emails );

			$data->data 					= $setting_data;
			$data->is_saved					= true;
			$data->messages					= $setting_data->getMessages( );

			return $data;

		}

	} // END CLASS SETTING CONTROLLER