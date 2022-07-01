<?php

	namespace Application\Packages\Plugins\FileManager\Controllers;

	use \Application\Libraries\Engine\File\File,
		\Application\Libraries\Engine\File\Directory;

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
     * @RoutePrefix( "/:admin/packages/plugins/file-manager/setting" )
     *
     * Access Control List
     * @Acl( "controller" = "Plugins\FileManager\Controllers\Setting", name = "File Manager Setting",  "description" = "" )
     */
	class SettingController extends \Phalcon\Mvc\Controller {

		/**
		 * Router Index Prefix
		 * @Get( "/", "name" = "file-manager-setting" )
		 * @Get( "/index" )
		 *
		 * Set Permission
		 * @Acl( "key" = "index", "name" = "Index", "description" = "File Manager Setting Index." )
		 */
		public function indexAction ( ) {

			$this->view->setVar( '_', $language = $this->language->load( array(
				'system' 	=> 'Index',
				'Index',
				'Setting/Index'
			)));

			$settings = Setting::getAllByGroup( 'file-manager' );

			$this->tag->setDefault( 'source_dir', 										$settings['source_dir']->getValue( ) );
			$this->tag->setDefault( 'source_path', 										$settings['source_path']->getValue( ) );
			$this->tag->setDefault( 'icon_theme', 										$settings['icon_theme']->getValue( ) );
			$this->tag->setDefault( 'default_view', 									$settings['default_view']->getValue( ) );
			$this->tag->setDefault( 'file_number_limit_js', 							$settings['file_number_limit_js']->getValue( ) );
			$this->tag->setDefault( 'ellipsis_title_after_first_row', 					$settings['ellipsis_title_after_first_row']->getValue( ) );
			$this->tag->setDefault( 'lazy_loading_file_number_threshold', 				$settings['lazy_loading_file_number_threshold']->getValue( ) );
			$this->tag->setDefault( 'remember_text_filter', 							$settings['remember_text_filter']->getValue( ) );
			$this->tag->setDefault( 'show_folder_size', 								$settings['show_folder_size']->getValue( ) );
			$this->tag->setDefault( 'show_sorting_bar', 								$settings['show_sorting_bar']->getValue( ) );
			$this->tag->setDefault( 'copy_cut_max_size', 								$settings['copy_cut_max_size']->getValue( ) );
			$this->tag->setDefault( 'copy_cut_max_count', 								$settings['copy_cut_max_count']->getValue( ) );
			$this->tag->setDefault( 'enable_transliteration', 							$settings['enable_transliteration']->getValue( ) );
			$this->tag->setDefault( 'convert_spaces', 									$settings['convert_spaces']->getValue( ) );
			$this->tag->setDefault( 'replace_with', 									$settings['replace_with']->getValue( ) );
			$this->tag->setDefault( 'max_size_upload', 									$settings['max_size_upload']->getValue( ) );
			$this->tag->setDefault( 'enable_java_upload', 								$settings['enable_java_upload']->getValue( ) );
			$this->tag->setDefault( 'java_upload_max_size', 							$settings['java_upload_max_size']->getValue( ) );
			$this->tag->setDefault( 'hidden_folders', 									$settings['hidden_folders']->getValue( ) );
			$this->tag->setDefault( 'hidden_files', 									$settings['hidden_files']->getValue( ) );
			$this->tag->setDefault( 'enable_create_files', 								$settings['enable_create_files']->getValue( ) );
			$this->tag->setDefault( 'enable_delete_files', 								$settings['enable_delete_files']->getValue( ) );
			$this->tag->setDefault( 'enable_create_folders', 							$settings['enable_create_folders']->getValue( ) );
			$this->tag->setDefault( 'enable_delete_folders', 							$settings['enable_delete_folders']->getValue( ) );
			$this->tag->setDefault( 'enable_upload_files', 								$settings['enable_upload_files']->getValue( ) );
			$this->tag->setDefault( 'enable_rename_files', 								$settings['enable_rename_files']->getValue( ) );
			$this->tag->setDefault( 'enable_rename_folders', 							$settings['enable_rename_folders']->getValue( ) );
			$this->tag->setDefault( 'enable_duplicate_files', 							$settings['enable_duplicate_files']->getValue( ) );
			$this->tag->setDefault( 'enable_copy_cut_files', 							$settings['enable_copy_cut_files']->getValue( ) );
			$this->tag->setDefault( 'enable_copy_cut_folders', 							$settings['enable_copy_cut_folders']->getValue( ) );
			$this->tag->setDefault( 'enable_chmod_files', 								$settings['enable_chmod_files']->getValue( ) );
			$this->tag->setDefault( 'enable_chmod_folders', 							$settings['enable_chmod_folders']->getValue( ) );
			$this->tag->setDefault( 'enable_preview_text_files', 						$settings['enable_preview_text_files']->getValue( ) );
			$this->tag->setDefault( 'enable_edit_text_files', 							$settings['enable_edit_text_files']->getValue( ) );
			$this->tag->setDefault( 'enable_create_text_files', 						$settings['enable_create_text_files']->getValue( ) );
			$this->tag->setDefault( 'enable_googledoc', 								$settings['enable_googledoc']->getValue( ) );
			$this->tag->setDefault( 'enable_viewerjs', 									$settings['enable_viewerjs']->getValue( ) );
			$this->tag->setDefault( 'extensions_previewable_text_file_no_prettify', 	$settings['extensions_previewable_text_file_no_prettify']->getValue( ) );
			$this->tag->setDefault( 'extensions_previewable_text_file', 				$settings['extensions_previewable_text_file']->getValue( ) );
			$this->tag->setDefault( 'extensions_editable_text_file', 					$settings['extensions_editable_text_file']->getValue( ) );
			$this->tag->setDefault( 'extensions_googledoc_file', 						$settings['extensions_googledoc_file']->getValue( ) );
			$this->tag->setDefault( 'extensions_viewerjs_file', 						$settings['extensions_viewerjs_file']->getValue( ) );
			$this->tag->setDefault( 'extensions_image', 								$settings['extensions_image']->getValue( ) );
			$this->tag->setDefault( 'extensions_file', 									$settings['extensions_file']->getValue( ) );
			$this->tag->setDefault( 'extensions_video', 								$settings['extensions_video']->getValue( ) );
			$this->tag->setDefault( 'extensions_audio', 								$settings['extensions_audio']->getValue( ) );
			$this->tag->setDefault( 'extensions_misc', 									$settings['extensions_misc']->getValue( ) );
			$this->tag->setDefault( 'image_max_width', 									$settings['image_max_width']->getValue( ) );
			$this->tag->setDefault( 'image_max_height', 								$settings['image_max_height']->getValue( ) );
			$this->tag->setDefault( 'image_max_mode', 									$settings['image_max_mode']->getValue( ) );
			$this->tag->setDefault( 'enable_image_resizing', 							$settings['enable_image_resizing']->getValue( ) );
			$this->tag->setDefault( 'image_resizing_width', 							$settings['image_resizing_width']->getValue( ) );
			$this->tag->setDefault( 'image_resizing_height', 							$settings['image_resizing_height']->getValue( ) );
			$this->tag->setDefault( 'image_resizing_mode', 								$settings['image_resizing_mode']->getValue( ) );
			$this->tag->setDefault( 'image_resizing_override', 							$settings['image_resizing_override']->getValue( ) );
			$this->tag->setDefault( 'enable_fixed_image_creation', 					 	$settings['enable_fixed_image_creation']->getValue( ) );
			$this->tag->setDefault( 'fixed_path_from_file_manager', 					$settings['fixed_path_from_file_manager']->getValue( ) );
			$this->tag->setDefault( 'fixed_image_creation_name_to_prepend', 			$settings['fixed_image_creation_name_to_prepend']->getValue( ) );
			$this->tag->setDefault( 'fixed_image_creation_name_to_append', 				$settings['fixed_image_creation_name_to_append']->getValue( ) );
			$this->tag->setDefault( 'fixed_image_creation_width', 						$settings['fixed_image_creation_width']->getValue( ) );
			$this->tag->setDefault( 'fixed_image_creation_height', 						$settings['fixed_image_creation_height']->getValue( ) );
			$this->tag->setDefault( 'fixed_image_creation_option', 						$settings['fixed_image_creation_option']->getValue( ) );
			$this->tag->setDefault( 'enable_relative_image_creation', 					$settings['enable_relative_image_creation']->getValue( ) );
			$this->tag->setDefault( 'relative_path_from_current_pos', 					$settings['relative_path_from_current_pos']->getValue( ) );
			$this->tag->setDefault( 'relative_image_creation_name_to_prepend', 			$settings['relative_image_creation_name_to_prepend']->getValue( ) );
			$this->tag->setDefault( 'relative_image_creation_name_to_append', 			$settings['relative_image_creation_name_to_append']->getValue( ) );
			$this->tag->setDefault( 'relative_image_creation_width', 					$settings['relative_image_creation_width']->getValue( ) );
			$this->tag->setDefault( 'relative_image_creation_height', 					$settings['relative_image_creation_height']->getValue( ) );
			$this->tag->setDefault( 'relative_image_creation_option', 					$settings['relative_image_creation_option']->getValue( ) );
			$this->tag->setDefault( 'enable_aviary', 									$settings['enable_aviary']->getValue( ) );
			$this->tag->setDefault( 'aviary_api_key', 									$settings['aviary_api_key']->getValue( ) );
			$this->tag->setDefault( 'aviary_api_secret', 								$settings['aviary_api_secret']->getValue( ) );

			$this->view->setVar( 'var_breadcrumbs', array(
				$language->_( 'text_file-managers' ) 		=> $this->url->get( array(
					'for' => 'file-manager',
				)),
				$language->_( 'text_settings' ) 		=> $this->url->get( array(
					'for' => 'file-manager-setting',
				))
			));

			$this->view->setVar( 'var_save_url', array(
				'for'	 => 'file-manager-setting-save'
			));

			$this->view->pick( 'Setting/Index' );

		}

		/**
		 * Router Save Prefix
		 * @Post( "/save", "name" = "file-manager-setting-save" )
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

				$data->source_dir                                   = $this->request->getPost( 'source_dir', 'string' );
				$data->source_path                                  = $this->request->getPost( 'source_path', 'string' );
				$data->icon_theme                                   = $this->request->getPost( 'icon_theme', 'string' );
				$data->default_view                                 = $this->request->getPost( 'default_view', 'string' );
				$data->file_number_limit_js                         = $this->request->getPost( 'file_number_limit_js', 'int' );
				$data->ellipsis_title_after_first_row               = $this->request->getPost( 'ellipsis_title_after_first_row', 'int' );
				$data->lazy_loading_file_number_threshold           = $this->request->getPost( 'lazy_loading_file_number_threshold', 'int' );
				$data->remember_text_filter                         = $this->request->getPost( 'remember_text_filter', 'int' );
				$data->show_folder_size                             = $this->request->getPost( 'show_folder_size', 'int' );
				$data->show_sorting_bar                             = $this->request->getPost( 'show_sorting_bar', 'int' );
				$data->copy_cut_max_size                            = $this->request->getPost( 'copy_cut_max_size', 'int' );
				$data->copy_cut_max_count                           = $this->request->getPost( 'copy_cut_max_count', 'int' );
				$data->enable_transliteration                       = $this->request->getPost( 'enable_transliteration', 'int' );
				$data->convert_spaces                               = $this->request->getPost( 'convert_spaces', 'int' );
				$data->replace_with                                 = $this->request->getPost( 'replace_with', 'string' );
				$data->max_size_upload                              = $this->request->getPost( 'max_size_upload', 'int' );
				$data->enable_java_upload                           = $this->request->getPost( 'enable_java_upload', 'int' );
				$data->java_upload_max_size                         = $this->request->getPost( 'java_upload_max_size', 'int' );
				$data->hidden_folders                               = $this->request->getPost( 'hidden_folders', 'string' );
				$data->hidden_files                                 = $this->request->getPost( 'hidden_files', 'string' );
				$data->enable_create_files                          = $this->request->getPost( 'enable_create_files', 'int' );
				$data->enable_delete_files                          = $this->request->getPost( 'enable_delete_files', 'int' );
				$data->enable_create_folders                        = $this->request->getPost( 'enable_create_folders', 'int' );
				$data->enable_delete_folders                        = $this->request->getPost( 'enable_delete_folders', 'int' );
				$data->enable_upload_files                          = $this->request->getPost( 'enable_upload_files', 'int' );
				$data->enable_rename_files                          = $this->request->getPost( 'enable_rename_files', 'int' );
				$data->enable_rename_folders                        = $this->request->getPost( 'enable_rename_folders', 'int' );
				$data->enable_duplicate_files                       = $this->request->getPost( 'enable_duplicate_files', 'int' );
				$data->enable_copy_cut_files                        = $this->request->getPost( 'enable_copy_cut_files', 'int' );
				$data->enable_copy_cut_folders                      = $this->request->getPost( 'enable_copy_cut_folders', 'int' );
				$data->enable_chmod_files                           = $this->request->getPost( 'enable_chmod_files', 'int' );
				$data->enable_chmod_folders                         = $this->request->getPost( 'enable_chmod_folders', 'int' );
				$data->enable_preview_text_files                    = $this->request->getPost( 'enable_preview_text_files', 'int' );
				$data->enable_edit_text_files                       = $this->request->getPost( 'enable_edit_text_files', 'int' );
				$data->enable_create_text_files                     = $this->request->getPost( 'enable_create_text_files', 'int' );
				$data->enable_googledoc                             = $this->request->getPost( 'enable_googledoc', 'int' );
				$data->enable_viewerjs                              = $this->request->getPost( 'enable_viewerjs', 'int' );
				$data->extensions_previewable_text_file_no_prettify = $this->request->getPost( 'extensions_previewable_text_file_no_prettify', 'string' );
				$data->extensions_previewable_text_file             = $this->request->getPost( 'extensions_previewable_text_file', 'string' );
				$data->extensions_editable_text_file                = $this->request->getPost( 'extensions_editable_text_file', 'string' );
				$data->extensions_googledoc_file                    = $this->request->getPost( 'extensions_googledoc_file', 'string' );
				$data->extensions_viewerjs_file                     = $this->request->getPost( 'extensions_viewerjs_file', 'string' );
				$data->extensions_image                             = $this->request->getPost( 'extensions_image', 'string' );
				$data->extensions_file                              = $this->request->getPost( 'extensions_file', 'string' );
				$data->extensions_video                             = $this->request->getPost( 'extensions_video', 'string' );
				$data->extensions_audio                             = $this->request->getPost( 'extensions_audio', 'string' );
				$data->extensions_misc                              = $this->request->getPost( 'extensions_misc', 'string' );
				$data->image_max_width                              = $this->request->getPost( 'image_max_width', 'int' );
				$data->image_max_height                             = $this->request->getPost( 'image_max_height', 'int' );
				$data->image_max_mode                               = $this->request->getPost( 'image_max_mode', 'int' );
				$data->enable_image_resizing                        = $this->request->getPost( 'enable_image_resizing', 'int' );
				$data->image_resizing_width                         = $this->request->getPost( 'image_resizing_width', 'int' );
				$data->image_resizing_height                        = $this->request->getPost( 'image_resizing_height', 'int' );
				$data->image_resizing_mode                          = $this->request->getPost( 'image_resizing_mode', 'int' );
				$data->image_resizing_override                      = $this->request->getPost( 'image_resizing_override', 'int' );
				$data->enable_fixed_image_creation                  = $this->request->getPost( 'enable_fixed_image_creation', 'int' );
				$data->fixed_path_from_file_manager                 = $this->request->getPost( 'fixed_path_from_file_manager', 'string' );
				$data->fixed_image_creation_name_to_prepend         = $this->request->getPost( 'fixed_image_creation_name_to_prepend', 'int' );
				$data->fixed_image_creation_name_to_append          = $this->request->getPost( 'fixed_image_creation_name_to_append', 'string' );
				$data->fixed_image_creation_width                   = $this->request->getPost( 'fixed_image_creation_width', 'int' );
				$data->fixed_image_creation_height                  = $this->request->getPost( 'fixed_image_creation_height', 'int' );
				$data->fixed_image_creation_option                  = $this->request->getPost( 'fixed_image_creation_option', 'string' );
				$data->enable_relative_image_creation               = $this->request->getPost( 'enable_relative_image_creation', 'int' );
				$data->relative_path_from_current_pos               = $this->request->getPost( 'relative_path_from_current_pos', 'int' );
				$data->relative_image_creation_name_to_prepend      = $this->request->getPost( 'relative_image_creation_name_to_prepend', 'string' );
				$data->relative_image_creation_name_to_append       = $this->request->getPost( 'relative_image_creation_name_to_append', 'string' );
				$data->relative_image_creation_width                = $this->request->getPost( 'relative_image_creation_width', 'int' );
				$data->relative_image_creation_height               = $this->request->getPost( 'relative_image_creation_height', 'int' );
				$data->relative_image_creation_option               = $this->request->getPost( 'relative_image_creation_option', 'string' );
				$data->enable_aviary                                = $this->request->getPost( 'enable_aviary', 'int' );
				$data->aviary_api_key                               = $this->request->getPost( 'aviary_api_key', 'string' );
				$data->aviary_api_secret                            = $this->request->getPost( 'aviary_api_secret', 'string' );

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
						'for' => 'file-manager-setting',
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
							'for' => 'file-manager-setting',
						));
					} else {
						$this->flicker->error( $language->_( 'error_message' ) );
						$this->dispatcher->forward( array(
							'for' => 'file-manager-setting',
						));
					}
				}

				return;

			} else {
				$this->flicker->error( $language->_( 'validate_access_tokken' ) );
			}

			$this->view->disable( );
			return $this->response->redirect( array(
				'for' => 'file-manager-setting',
			));

		}

		private function _store ( $data ) {

			$setting_data = new Setting( );

			$setting_data->set( 'file-manager', 'source_dir', $data->source_dir );
			$setting_data->set( 'file-manager', 'source_path', $data->source_path );
			$setting_data->set( 'file-manager', 'icon_theme', $data->icon_theme );
			$setting_data->set( 'file-manager', 'default_view', $data->default_view );
			$setting_data->set( 'file-manager', 'file_number_limit_js', $data->file_number_limit_js );
			$setting_data->set( 'file-manager', 'ellipsis_title_after_first_row', $data->ellipsis_title_after_first_row );
			$setting_data->set( 'file-manager', 'lazy_loading_file_number_threshold', $data->lazy_loading_file_number_threshold );
			$setting_data->set( 'file-manager', 'remember_text_filter', $data->remember_text_filter );
			$setting_data->set( 'file-manager', 'show_folder_size', $data->show_folder_size );
			$setting_data->set( 'file-manager', 'show_sorting_bar', $data->show_sorting_bar );
			$setting_data->set( 'file-manager', 'copy_cut_max_size', $data->copy_cut_max_size );
			$setting_data->set( 'file-manager', 'copy_cut_max_count', $data->copy_cut_max_count );
			$setting_data->set( 'file-manager', 'enable_transliteration', $data->enable_transliteration );
			$setting_data->set( 'file-manager', 'convert_spaces', $data->convert_spaces );
			$setting_data->set( 'file-manager', 'replace_with', $data->replace_with );
			$setting_data->set( 'file-manager', 'max_size_upload', $data->max_size_upload );
			$setting_data->set( 'file-manager', 'enable_java_upload', $data->enable_java_upload );
			$setting_data->set( 'file-manager', 'java_upload_max_size', $data->java_upload_max_size );
			$setting_data->set( 'file-manager', 'hidden_folders', $data->hidden_folders );
			$setting_data->set( 'file-manager', 'hidden_files', $data->hidden_files );
			$setting_data->set( 'file-manager', 'enable_create_files', $data->enable_create_files );
			$setting_data->set( 'file-manager', 'enable_delete_files', $data->enable_delete_files );
			$setting_data->set( 'file-manager', 'enable_create_folders', $data->enable_create_folders );
			$setting_data->set( 'file-manager', 'enable_delete_folders', $data->enable_delete_folders );
			$setting_data->set( 'file-manager', 'enable_upload_files', $data->enable_upload_files );
			$setting_data->set( 'file-manager', 'enable_rename_files', $data->enable_rename_files );
			$setting_data->set( 'file-manager', 'enable_rename_folders', $data->enable_rename_folders );
			$setting_data->set( 'file-manager', 'enable_duplicate_files', $data->enable_duplicate_files );
			$setting_data->set( 'file-manager', 'enable_copy_cut_files', $data->enable_copy_cut_files );
			$setting_data->set( 'file-manager', 'enable_copy_cut_folders', $data->enable_copy_cut_folders );
			$setting_data->set( 'file-manager', 'enable_chmod_files', $data->enable_chmod_files );
			$setting_data->set( 'file-manager', 'enable_chmod_folders', $data->enable_chmod_folders );
			$setting_data->set( 'file-manager', 'enable_preview_text_files', $data->enable_preview_text_files );
			$setting_data->set( 'file-manager', 'enable_edit_text_files', $data->enable_edit_text_files );
			$setting_data->set( 'file-manager', 'enable_create_text_files', $data->enable_create_text_files );
			$setting_data->set( 'file-manager', 'enable_googledoc', $data->enable_googledoc );
			$setting_data->set( 'file-manager', 'enable_viewerjs', $data->enable_viewerjs );
			$setting_data->set( 'file-manager', 'extensions_previewable_text_file_no_prettify', $data->extensions_previewable_text_file_no_prettify );
			$setting_data->set( 'file-manager', 'extensions_previewable_text_file', $data->extensions_previewable_text_file );
			$setting_data->set( 'file-manager', 'extensions_editable_text_file', $data->extensions_editable_text_file );
			$setting_data->set( 'file-manager', 'extensions_googledoc_file', $data->extensions_googledoc_file );
			$setting_data->set( 'file-manager', 'extensions_viewerjs_file', $data->extensions_viewerjs_file );
			$setting_data->set( 'file-manager', 'extensions_image', $data->extensions_image );
			$setting_data->set( 'file-manager', 'extensions_file', $data->extensions_file );
			$setting_data->set( 'file-manager', 'extensions_video', $data->extensions_video );
			$setting_data->set( 'file-manager', 'extensions_audio', $data->extensions_audio );
			$setting_data->set( 'file-manager', 'extensions_misc', $data->extensions_misc );
			$setting_data->set( 'file-manager', 'image_max_width', $data->image_max_width );
			$setting_data->set( 'file-manager', 'image_max_height', $data->image_max_height );
			$setting_data->set( 'file-manager', 'image_max_mode', $data->image_max_mode );
			$setting_data->set( 'file-manager', 'enable_image_resizing', $data->enable_image_resizing );
			$setting_data->set( 'file-manager', 'image_resizing_width', $data->image_resizing_width );
			$setting_data->set( 'file-manager', 'image_resizing_height', $data->image_resizing_height );
			$setting_data->set( 'file-manager', 'image_resizing_mode', $data->image_resizing_mode );
			$setting_data->set( 'file-manager', 'image_resizing_override', $data->image_resizing_override );
			$setting_data->set( 'file-manager', 'enable_fixed_image_creation', $data->enable_fixed_image_creation );
			$setting_data->set( 'file-manager', 'fixed_path_from_file_manager', $data->fixed_path_from_file_manager );
			$setting_data->set( 'file-manager', 'fixed_image_creation_name_to_prepend', $data->fixed_image_creation_name_to_prepend );
			$setting_data->set( 'file-manager', 'fixed_image_creation_name_to_append', $data->fixed_image_creation_name_to_append );
			$setting_data->set( 'file-manager', 'fixed_image_creation_width', $data->fixed_image_creation_width );
			$setting_data->set( 'file-manager', 'fixed_image_creation_height', $data->fixed_image_creation_height );
			$setting_data->set( 'file-manager', 'fixed_image_creation_option', $data->fixed_image_creation_option );
			$setting_data->set( 'file-manager', 'enable_relative_image_creation', $data->enable_relative_image_creation );
			$setting_data->set( 'file-manager', 'relative_path_from_current_pos', $data->relative_path_from_current_pos );
			$setting_data->set( 'file-manager', 'relative_image_creation_name_to_prepend', $data->relative_image_creation_name_to_prepend );
			$setting_data->set( 'file-manager', 'relative_image_creation_name_to_append', $data->relative_image_creation_name_to_append );
			$setting_data->set( 'file-manager', 'relative_image_creation_width', $data->relative_image_creation_width );
			$setting_data->set( 'file-manager', 'relative_image_creation_height', $data->relative_image_creation_height );
			$setting_data->set( 'file-manager', 'relative_image_creation_option', $data->relative_image_creation_option );
			$setting_data->set( 'file-manager', 'enable_aviary', $data->enable_aviary );
			$setting_data->set( 'file-manager', 'aviary_api_key', $data->aviary_api_key );
			$setting_data->set( 'file-manager', 'aviary_api_secret', $data->aviary_api_secret );

			$data->data 		= $setting_data;
			$data->is_saved		= true;
			$data->messages		= $setting_data->getMessages( );

			return $data;

		}

	} // END CLASS SETTING CONTROLLER