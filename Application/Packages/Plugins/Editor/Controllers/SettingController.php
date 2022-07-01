<?php

	namespace Application\Packages\Plugins\Editor\Controllers;

	/**
     * Router Prefix
     * @RoutePrefix( "/:admin/packages/plugins/editor/setting" )
     *
     * Access Control List
     * @Acl( "controller" = "Plugins\Editor\Controllers\Setting", name = "Editor Setting",  "description" = "" )
     */
	class SettingController extends \Phalcon\Mvc\Controller {

		/**
		 * Router Index Prefix
		 * @Get( "/", "name" = "editor-setting" )
		 * @Get( "/index" )
		 *
		 * Set Permission
		 * @Acl( "key" = "index", "name" = "Index", "description" = "Editor Setting Index." )
		 */
		public function indexAction ( ) {

			$this->view->setVar( '_', $language = $this->language->load( array(
				'system' 	=> 'Index',
				'Index',
				'Setting/Index'
			)));

			$settings = Setting::getAllByGroup( 'editor' );

			$this->tag->setDefault( 'source_dir', 	$settings['source_dir']->getValue( ) );

			$this->view->setVar( 'var_breadcrumbs', array(
				$language->_( 'text_editors' ) 		=> $this->url->get( array(
					'for' => 'editor',
				)),
				$language->_( 'text_settings' ) 	=> $this->url->get( array(
					'for' => 'editor-setting',
				))
			));

			$this->view->setVar( 'var_save_url', array(
				'for'	 => 'editor-setting-save'
			));

			$this->view->pick( 'Setting/Index' );

		}

		/**
		 * Router Save Prefix
		 * @Post( "/save", "name" = "editor-setting-save" )
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

				$validator = new Validation( );
				$validator->add( 'source_dir', new PresenceOf( array(
					'cancelOnFail'	=> true,
					'message'		=> $language->_( 'validate_source_dir_presence' ),
				)));

				if ( count( $validator->getMessages( ) ) ) {
					foreach( $validator->getMessages( ) as $message ) {
						$this->flicker->error( $message->getMessage( ) );
					}

					$this->dispatcher->forward( array(
						'for' => 'editor-setting',
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
							'for' => 'editor-setting',
						));
					} else {
						$this->flicker->error( $language->_( 'error_message' ) );
						$this->dispatcher->forward( array(
							'for' => 'editor-setting',
						));
					}
				}

				return;

			} else {
				$this->flicker->error( $language->_( 'validate_access_tokken' ) );
			}

			$this->view->disable( );
			return $this->response->redirect( array(
				'for' => 'editor-setting',
			));

		}

		private function _store ( $data ) {

			$setting_data = new Setting( );

			$data->data 		= $setting_data;
			$data->is_saved		= true;
			$data->messages		= $setting_data->getMessages( );

			return $data;

		}

	} // END CLASS SETTINGCONTROLLER