<?php

	namespace Application\Packages\Modules\User\Controllers;

	use \Application\Libraries\Engine\File\File,
		\Application\Libraries\Engine\File\Directory;

	use \Application\Packages\Modules\User\Models\Setting;

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
	 * @RoutePrefix( "/:admin/user/setting" )
	 *
	 * Access Control List
	 * @Acl( "controller" = "Modules\User\Controllers\Setting", name = "User Setting",  "description" = "User Setting Access." )
	 */
	class SettingController extends \Phalcon\Mvc\Controller {

		/**
		 * Router Index Prefix
		 * @Get( "/", "name" = "user-setting" )
		 * @Get( "/index" )
		 *
		 * Set Permission
		 * @Acl( "key" = "index", "name" = "Index", "description" = "User Setting Index." )
		 */
		public function indexAction ( ) {

			$this->view->setVar( '_', $language = $this->language->load( array(
				'system' 	=> 'Index',
				'Index',
				'Setting/Common',
				'Setting/Index'
			)));

			$settings = Setting::getAll( );

			$this->tag->setDefault( 'avatar_key', 			$settings['avatar_key']->getValue( ) );
			$this->tag->setDefault( 'avatar_dir', 			$settings['avatar_dir']->getValue( ) );
			$this->tag->setDefault( 'avatar_tmb_dir', 		$settings['avatar_tmb_dir']->getValue( ) );
			$this->tag->setDefault( 'avatar_default', 		$settings['avatar_default']->getValue( ) );
			$this->tag->setDefault( 'avatar_tmb_width', 	$settings['avatar_tmb_width']->getValue( ) );
			$this->tag->setDefault( 'avatar_tmb_height', 	$settings['avatar_tmb_height']->getValue( ) );

			$this->view->setVar( 'var_breadcrumbs', array(
				$language->_( 'text_users' ) 		=> $this->url->get( array(
					'for' => 'user-account',
				)),
				$language->_( 'text_settings' ) 		=> $this->url->get( array(
					'for' => 'user-setting',
				))
			));

			$this->view->setVar( 'var_save_url', array(
				'for'	 => 'user-setting-save'
			));

			$this->view->pick( 'Setting/Index' );

		}

		/**
		 * Router Save Prefix
		 * @Post( "/save", "name" = "user-setting-save" )
		 *
		 */
		public function saveAction ( ) {

			$language = $this->language->load( array(
				'system' 	=> 'Index',
				'Index',
				'Setting/Index'
			));

			if ( $this->security->checkToken( ) ) {

				$data = new \stdClass( );

				$data->avatar_key        = $this->request->getPost( 'avatar_key', 'string' );
				$data->avatar_dir        = $this->request->getPost( 'avatar_dir', 'string' );
				$data->avatar_tmb_dir    = $this->request->getPost( 'avatar_tmb_dir', 'string' );
				$data->avatar_default    = $this->request->getPost( 'avatar_default', 'string' );
				$data->avatar_tmb_width  = $this->request->getPost( 'avatar_tmb_width', 'int' );
				$data->avatar_tmb_height = $this->request->getPost( 'avatar_tmb_height', 'int' );

				$validator = new Validation( );
				$validator->add( 'avatar_dir', new PresenceOf( array(
					'cancelOnFail'	=> true,
					'message'		=> $language->_( 'validate_avatar_dir_presence' ),
				)));

				if ( count( $validator->getMessages( ) ) ) {
					foreach( $validator->getMessages( ) as $message ) {
						$this->flicker->error( $message->getMessage( ) );
					}

					$this->dispatcher->forward( array(
						'for' => 'user-setting',
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
							'for' => 'user-setting',
						));
					} else {
						$this->flicker->error( $language->_( 'error_message' ) );
						$this->dispatcher->forward( array(
							'for' => 'user-setting',
						));
					}
				}

				return;

			} else {
				$this->flicker->error( $language->_( 'validate_access_tokken' ) );
			}

			$this->view->disable( );
			return $this->response->redirect( array(
				'for' => 'user-setting',
			));

		}

		private function _store ( $data ) {

			$setting_data = new Setting( );

			$data->avatar_dir 		= rtrim( $data->avatar_dir, DS );
			$data->avatar_tmb_dir 	= rtrim( $data->avatar_tmb_dir, DS );

			$avatar_dir 	= $setting_data->get( 'avatar_dir' );
			$avatar_tmb_dir = $setting_data->get( 'avatar_tmb_dir' );

			$old_avatar_dir = $this->config->directories->public->files->dir . $avatar_dir;
			$new_avatar_dir = $this->config->directories->public->files->dir . $data->avatar_dir;

			$old_avatar_tmb_dir = $this->config->directories->public->files->dir . $avatar_dir . DS . $avatar_tmb_dir;
			$new_avatar_tmb_dir = $this->config->directories->public->files->dir . $avatar_dir . DS . $data->avatar_tmb_dir;

			if ( $avatar_dir != $data->avatar_dir ) {
				if ( $avatar_dir ) {
					Directory::move( $old_avatar_dir, $new_avatar_dir );
				} else if ( $data->avatar_dir ) {
					Directory::create( $new_avatar_dir );
				}
			}

			if ( $avatar_tmb_dir != $data->avatar_tmb_dir ) {
				if ( $avatar_tmb_dir ) {
					Directory::move( $old_avatar_tmb_dir, $new_avatar_tmb_dir );
				} else if ( $data->avatar_tmb_dir ) {
					Directory::create( $new_avatar_dir );
				}
			}

			$setting_data->set( 'avatar_key', 			$data->avatar_key );
			$setting_data->set( 'avatar_dir', 			$data->avatar_dir );
			$setting_data->set( 'avatar_tmb_dir', 		$data->avatar_tmb_dir );
			$setting_data->set( 'avatar_default', 		$data->avatar_default );
			$setting_data->set( 'avatar_tmb_width', 	$data->avatar_tmb_width );
			$setting_data->set( 'avatar_tmb_height', 	$data->avatar_tmb_height );

			$data->data 					= $setting_data;
			$data->is_saved					= true;
			$data->messages					= $setting_data->getMessages( );

			return $data;

		}

	} // END CLASS SETTING CONTROLLER