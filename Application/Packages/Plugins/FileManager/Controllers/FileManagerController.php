<?php

    namespace Application\Packages\Plugins\FileManager\Controllers;

    use Application\Libraries\Engine\File\File,
        Application\Libraries\Engine\File\Directory,
        Application\Packages\Modules\Setting\Models\Setting;

    /**
     * Router Prefix
     * @RoutePrefix( "/:admin/packages/plugins/file-manager" )
     *
     * Access Control List
     * @Acl( "controller" = "Plugins\FileManager\Controllers\Setting", name = "File Manager",  "description" = "File Manager Access." )
     */
    class FileManagerController extends \Phalcon\Mvc\Controller {

        /**
         * Router Index Prefix
         * @Route( "/", "name" = "file-manager" )
         * @Route( "/index" )
         *
         * Set Permission
         * @Acl( "key" = "index", "name" = "Index", "description" = "File Manager Index." )
         */
        public function indexAction ( ) {

            $this->view->setVar( '_', $language = $this->language->load( array(
                'system'    => 'Index',
                'Common',
                'Index',
            )));

            $config     = array( );
            $session    = array( );
            $settings   = Setting::getAllByGroup( 'file-manager' );

            if ( $this->session->has( 'file-manager' ) ) {
                $session = $this->session->get( 'file-manager' );
            }

            $config['icon_theme']                     = ( string ) $settings['icon_theme']->getValue( );
            $config['copy_cut_max_size']              = ( int ) $settings['copy_cut_max_size']->getValue( );
            $config['copy_cut_max_count']             = ( int ) $settings['copy_cut_max_count']->getValue( );
            $config['file_number_limit_js']           = ( int ) $settings['file_number_limit_js']->getValue( );
            $config['show_sorting_bar']               = ( boolean ) $settings['show_sorting_bar']->getValue( );
            $config['show_folder_size']               = ( boolean ) $settings['show_folder_size']->getValue( );
            $config['enable_create_files']            = ( boolean ) $settings['enable_create_files']->getValue( );
            $config['enable_delete_files']            = ( boolean ) $settings['enable_delete_files']->getValue( );
            $config['enable_create_folders']          = ( boolean ) $settings['enable_create_folders']->getValue( );
            $config['enable_delete_folders']          = ( boolean ) $settings['enable_delete_folders']->getValue( );
            $config['enable_upload_files']            = ( boolean ) $settings['enable_upload_files']->getValue( );
            $config['enable_rename_files']            = ( boolean ) $settings['enable_rename_files']->getValue( );
            $config['enable_rename_folders']          = ( boolean ) $settings['enable_rename_folders']->getValue( );
            $config['enable_duplicate_files']         = ( boolean ) $settings['enable_duplicate_files']->getValue( );
            $config['enable_copy_cut_files']          = ( boolean ) $settings['enable_copy_cut_files']->getValue( );
            $config['enable_copy_cut_folders']        = ( boolean ) $settings['enable_copy_cut_folders']->getValue( );
            $config['enable_chmod_files']             = ( boolean ) $settings['enable_chmod_files']->getValue( );
            $config['enable_chmod_folders']           = ( boolean ) $settings['enable_chmod_folders']->getValue( );
            $config['enable_java_upload']             = ( boolean ) $settings['enable_java_upload']->getValue( );
            $config['enable_preview_text_files']      = ( boolean ) $settings['enable_preview_text_files']->getValue( );
            $config['enable_edit_text_files']         = ( boolean ) $settings['enable_edit_text_files']->getValue( );
            $config['enable_create_text_files']       = ( boolean ) $settings['enable_create_text_files']->getValue( );
            $config['enable_googledoc']               = ( boolean ) $settings['enable_googledoc']->getValue( );
            $config['enable_viewerjs']                = ( boolean ) $settings['enable_viewerjs']->getValue( );
            $config['ellipsis_title_after_first_row'] = ( boolean ) $settings['ellipsis_title_after_first_row']->getValue( );
            $config['enable_transliteration']         = ( boolean ) $settings['enable_transliteration']->getValue( );
            $config['convert_spaces']                 = ( boolean ) $settings['convert_spaces']->getValue( );
            $config['replace_with']                   = ( string ) $settings['replace_with']->getValue( );

            if ( $settings['enable_aviary']->getValue( ) ) {
                $config['enable_aviary'] = true;
            } else {
                $config['enable_aviary'] = false;
            }

            $config['aviary_defaults_config']   = array(
                'key'      => $settings['aviary_api_key']->getValue( ),
                'version'  => 3,
                'language' => 'en',
                'theme'    => 'minimum',
                'tools'    => 'all'
            );

            $config['root_dir']          = $this->config->directories->public->files->shared->dir;
            $config['root_path']         = $this->config->directories->public->files->shared->path;
            $config['source_dir']        = $settings['source_dir']->getValue( );
            $config['source_path']       = $settings['source_dir']->getValue( );
            $config['source_cache_dir']  = '@/';
            $config['source_cache_path'] = '@/';

            // MAX SIZE UPLOAD
            if ( ( int ) ( ini_get( 'post_max_size' ) ) < $settings['max_size_upload']->getValue( ) ) {
                $max_size_upload = ini_get( 'post_max_size' );
            } else {
                $max_size_upload = $settings['max_size_upload']->getValue( );
            }

            $config['max_size_upload'] = $max_size_upload;

            // EXTENSION
            $extensions_image                  = explode( ',', $settings['extensions_image']->getValue( ) );
            $extensions_file                   = explode( ',', $settings['extensions_file']->getValue( ) );
            $extensions_video                  = explode( ',', $settings['extensions_video']->getValue( ) );
            $extensions_audio                  = explode( ',', $settings['extensions_audio']->getValue( ) );
            $extensions_misc                   = explode( ',', $settings['extensions_misc']->getValue( ) );
            $extensions                       = array_merge( $extensions_image, $extensions_file, $extensions_video, $extensions_audio, $extensions_misc );
            $extensions_jplayer               = array( 'mp4','flv','webmv','webma','webm','m4a','m4v','ogv','oga','mp3','midi','mid','ogg','wav' );
            $extensions_viewerjs_file         = explode( ',', $settings['extensions_viewerjs_file']->getValue( ) );
            $extensions_googledoc_file        = explode( ',', $settings['extensions_googledoc_file']->getValue( ) );
            $extensions_previewable_text_file = explode( ',', $settings['extensions_previewable_text_file']->getValue( ) );
            $extensions_editable_text_file    = explode( ',', $settings['extensions_editable_text_file']->getValue( ) );

            $config['extensions_image']                  = $extensions_image;
            $config['extensions_file']                   = $extensions_file;
            $config['extensions_video']                  = $extensions_video;
            $config['extensions_audio']                  = $extensions_audio;
            $config['extensions_misc']                   = $extensions_misc;
            $config['extensions']                       = $extensions;
            $config['extensions_jplayer']               = $extensions_jplayer;
            $config['extensions_viewerjs_file']         = $extensions_viewerjs_file;
            $config['extensions_googledoc_file']        = $extensions_googledoc_file;
            $config['extensions_previewable_text_file'] = $extensions_previewable_text_file;
            $config['extensions_editable_text_file']    = $extensions_editable_text_file;

            // CURRENT FOLDER
            if ( !isset( $session['current_directory'] ) ) {
                $session['current_directory'] = '';
            }

            $current_directory = '/';

            if ( !empty( $session['current_directory'] )
                && strpos( $session['current_directory'], '../' ) === false
                && strpos( $session['current_directory'], './' ) === false
                && strpos( $session['current_directory'], '/' ) !== 0
                && strpos( $session['current_directory'], '.' ) === false ) {
                $current_directory = $session['current_directory'];
            }

            $current_directory = rtrim( ltrim( $current_directory, '/' ), '/' );

            if ( $this->request->hasQuery( 'fldr' )
                && strpos( $this->request->getQuery( 'fldr' ), '../' ) === false
                && strpos( $this->request->getQuery( 'fldr' ), './' ) === false ) {
                $current_folder = urldecode( $this->request->getQuery( 'fldr', 'string' ) );
            } else if ( $this->cookies->has( 'current_folder' )
                && !empty( $this->cookies->get( 'current_folder' ) )
                && strpos( $this->cookies->get( 'current_folder' ), '.' ) === false ) {
                $current_folder = $this->cookies->get( 'current_folder' );
            } else {
                $current_folder = '/';
            }

            $current_folder = rtrim( ltrim( $current_folder, '/' ), '/' ) . '/';

            $this->cookies->set( 'current_folder', $current_folder, time( ) + ( 86400 * 7 ) );

            $hidden_folders = explode( ',', $settings['hidden_folders']->getValue( ) );

            if ( count( $hidden_folders ) ){
                $directories = explode( '/', $current_folder );
                foreach ( $directories as $directory ){
                    if ( $directory !== '' && in_array( $directory, $hidden_folders ) ){
                        $current_folder = '/';
                        break;
                    }
                }
            }

            if ( !File::exists( $config['root_dir'] . $config['source_dir'] . $current_directory . $current_folder ) ) {
                $current_folder = '/';
                if ( !File::exists( $config['root_dir'] . $config['source_dir'] . $current_directory . $current_folder ) ) {
                    $current_directory = '/';
                }
            }

            $current_path                   = $config['source_path'] . $current_directory . $current_folder;
            $current_cache_path             = $config['source_cache_path'] . $current_directory . $current_folder;

            $source_current_dir             = $config['source_dir'] . $current_path;
            $source_current_path            = $config['source_path'] . $current_path;
            $source_current_url             = $this->url->get( $source_current_path );
            $source_current_cache_dir       = $config['source_cache_dir'] . $current_path;
            $source_current_cache_path      = $config['source_cache_path'] . $current_path;
            $source_current_cache_url       = $this->url->get( $source_current_cache_path );

            $root_source_current_dir        = $config['root_dir'] . $source_current_dir;
            $root_source_current_path       = $config['root_path'] . $source_current_path;
            $root_source_current_url        = $this->url->get( $root_source_current_path );

            $root_source_current_cache_dir  = $config['root_dir'] . $source_current_cache_dir;
            $root_source_current_cache_path = $config['root_path'] . $source_current_cache_path;
            $root_source_current_cache_url  = $this->url->get( $root_source_current_cache_path );


            if ( $source_current_cache_dir && !is_dir( $root_source_current_cache_dir ) ) {
                Directory::create( $source_current_cache_dir, 0755, true );
            }

            $config['hidden_folders']                 = $hidden_folders;
            $config['current_folder']                 = $current_folder;
            $config['current_directory']              = $current_directory;
            $config['current_path']                   = $current_path;
            $config['current_cache_path']             = $current_cache_path;
            $config['source_current_dir']             = $source_current_dir;
            $config['source_current_path']            = $source_current_path;
            $config['source_current_url']             = $source_current_url;
            $config['source_current_cache_dir']       = $source_current_cache_dir;
            $config['source_current_cache_path']      = $source_current_cache_path;
            $config['source_current_cache_url']       = $source_current_cache_url;
            $config['root_source_current_dir']        = $root_source_current_dir;
            $config['root_source_current_path']       = $root_source_current_path;
            $config['root_source_current_url']        = $root_source_current_url;
            $config['root_source_current_cache_dir']  = $root_source_current_cache_dir;
            $config['root_source_current_cache_path'] = $root_source_current_cache_path;
            $config['root_source_current_cache_url']  = $root_source_current_cache_url;
            $config['source_current_dir_exists']      = ( boolean ) @opendir( $config['root_source_current_dir'] );

            // POPUP
            if ( $this->request->hasQuery( 'popup' ) ) {
                $popup = $this->request->getQuery( 'popup', 'int' );
            } else {
                $session['type'] = 0;
                $popup = 0;
            }

            if ( $popup ) {
                $this->view->setMainView( 'Common/Blank' );
            }

            $config['popup'] =!! $popup;

            // CROSS DOMAIN
            if ( $this->request->hasQuery( 'crossdomain' ) ) {
                $crossdomain = $this->request->getQuery( 'crossdomain', 'int' );
            } else {
                $crossdomain = 0;
            }

            $config['crossdomain'] =!! $crossdomain;

            // VIEW
            if ( $this->request->hasQuery( 'view' ) ) {
                $view = $session['view'] = $this->request->getQuery( 'view', 'int' );
            } else if ( isset( $session['view'] ) ) {
                $view = $session['view'];
            } else {
                $view = $settings['default_view']->getValue( );
            }

            $config['view']  = $view;

            // FILTER
            if ( $this->request->hasQuery( 'filter' ) ) {
                $filter = $session['filter'] = $this->request->getQuery( 'filter', 'string' );
            } else if ( isset( $session['filter'] ) ) {
                $filter = $session['filter'];
            } else {
                $filter = '';
            }

           $config['filter'] = $filter;

           // TYPE
            if ( $this->request->hasQuery( 'type' ) ) {
                $type = $session['type'] = $this->request->getQuery( 'type', 'int' );
            } else if ( isset( $session['type'] ) ) {
                $type = $session['type'];
            } else {
                $type = 0;
            }

            $config['type'] = $type;

            // SORT BY
            if ( $this->request->hasQuery( 'sort_by' ) ) {
                $sort_by = $session['sort_by'] = $this->request->getQuery( 'sort_by', 'string' );
            } else if ( isset( $session['sort_by'] ) ) {
                $sort_by = $session['sort_by'];
            } else {
                $sort_by = 'name';
            }

            $config['sort_by'] = $sort_by;

            // SORT ORDER
            if ( $this->request->hasQuery( 'sort_order' ) ) {
                $sort_order = $session['sort_order'] = $this->request->getQuery( 'sort_order', 'int' ) == 1;
            } else if ( isset( $session['sort_order'] ) ) {
                $sort_order = $session['sort_order'];
            } else {
                $sort_order = 0;
            }

            $config['sort_order'] = $sort_order;

            // EDITOR
            if ( $this->request->hasQuery( 'editor' ) ) {
                $editor = $this->request->getQuery( 'editor', 'string' );
            } else {
                if ( $type == 0 ) {
                    $editor = false;
                } else {
                    $editor = 'tinymce';
                }
            }

            $config['editor'] = $editor;

            // FIELD ID
            if ( $this->request->hasQuery( 'field_id' ) ) {
                $field_id = $this->request->getQuery( 'field_id', 'string' );
            } else {
                $field_id = '';
            }

            $config['field_id'] = $field_id;

            // APPLY
            if ( $type == 1 ) {
                $apply = 'apply_img';
            } else if ( $type == 2 ) {
                $apply = 'apply_link';
            } else if ( $type == 0 && $field_id == '' ) {
                $apply = 'apply_none';
            } else if ( $type == 3 ) {
                $apply = 'apply_video';
            } else {
                $apply = 'apply';
            }

            $config['apply'] = $apply;

            // CLIPBOARD
            if ( isset( $session['clipboard']['action'] ) && trim( $session['clipboard']['action'] ) != null ) {
                $clipboard = true;
            } else {
                $clipboard = false;
            }

            $config['clipboard'] = $clipboard;

            // RETURN RELATIVE URL
            if ( $this->request->hasQuery( 'relative_url' ) && $this->request->getQuery( 'relative_url', 'int' ) == 1 ) {
                $relative_url = true;
            } else {
                $relative_url = false;
            }

            $config['relative_url'] = $relative_url;

            // RETURN CURRENT URL
            $url = $this->url->get( array(
                'for' => 'file-manager'
            ));

            $url_params = array( );

            if ( $config['editor'] ) {
                $url_params['editor'] = $config['editor'];
            }

            if ( $config['type'] ) {
                $url_params['type'] = $config['type'];
            }

            if ( $config['popup'] ) {
                $url_params['popup'] = $config['popup'];
            }

            if ( $config['crossdomain'] ) {
                $url_params['crossdomain'] = $config['crossdomain'];
            }

            if ( $config['field_id'] ) {
                $url_params['field_id'] = $config['field_id'];
            }

            if ( $config['relative_url'] ) {
                $url_params['relative_url'] = $config['relative_url'];
            }

            $url_params['fldr'] = '';
            $url_params = http_build_query( $url_params );

            $current_url = str_replace(
                array(
                    '&filter=' . $config['filter'],
                    '&sort_by=' . $config['sort_by'],
                    '&sort_order=' . intval( $config['sort_order'] )
                ),
                array(
                    ''
                ), $this->request->getURI( )
            );

            $config['url']                 = $url;
            $config['url_params']          = $url_params;
            $config['url_params_build']    = $url . '?' . $url_params;
            $config['current_url']         = $current_url;
            $config['url_view']            = $this->url->get( array( 'for' => 'file-manager-view' ) );
            $config['url_type']            = $this->url->get( array( 'for' => 'file-manager-type' ) );
            $config['url_filter']          = $this->url->get( array( 'for' => 'file-manager-filter' ) );
            $config['url_sort']            = $this->url->get( array( 'for' => 'file-manager-sort' ) );
            $config['url_edit_text']       = $this->url->get( array( 'for' => 'file-manager-edit-text' ) );
            $config['url_save_text']       = $this->url->get( array( 'for' => 'file-manager-save-text' ) );
            $config['url_save_image']      = $this->url->get( array( 'for' => 'file-manager-save-image' ) );
            $config['url_save_mode']       = $this->url->get( array( 'for' => 'file-manager-save-mode' ) );
            $config['url_preview_text']    = $this->url->get( array( 'for' => 'file-manager-preview-text' ) );
            $config['url_preview_media']   = $this->url->get( array( 'for' => 'file-manager-preview-media' ) );
            $config['url_download']        = $this->url->get( array( 'for' => 'file-manager-download' ) );
            $config['url_upload']          = $this->url->get( array( 'for' => 'file-manager-upload' ) );
            $config['url_create_file']     = $this->url->get( array( 'for' => 'file-manager-create-file' ) );
            $config['url_rename_file']     = $this->url->get( array( 'for' => 'file-manager-rename-file' ) );
            $config['url_duplicate_file']  = $this->url->get( array( 'for' => 'file-manager-duplicate-file' ) );
            $config['url_delete_file']     = $this->url->get( array( 'for' => 'file-manager-delete-file' ) );
            $config['url_create_folder']   = $this->url->get( array( 'for' => 'file-manager-create-folder' ) );
            $config['url_rename_folder']   = $this->url->get( array( 'for' => 'file-manager-rename-folder' ) );
            $config['url_delete_folder']   = $this->url->get( array( 'for' => 'file-manager-delete-folder' ) );
            $config['url_extract']         = $this->url->get( array( 'for' => 'file-manager-extract' ) );
            $config['url_chmod']           = $this->url->get( array( 'for' => 'file-manager-chmod' ) );
            $config['url_change_mode']     = $this->url->get( array( 'for' => 'file-manager-change-mode' ) );
            $config['url_clipboard_copy']  = $this->url->get( array( 'for' => 'file-manager-clipboard-copy' ) );
            $config['url_clipboard_cut']   = $this->url->get( array( 'for' => 'file-manager-clipboard-cut' ) );
            $config['url_clipboard_paste'] = $this->url->get( array( 'for' => 'file-manager-clipboard-paste' ) );
            $config['url_clipboard_clear'] = $this->url->get( array( 'for' => 'file-manager-clipboard-clear' ) );

            // BREADCRUMB
            $config['breadcrumbs'] = array( );
            $breadcrumbs =  explode( '/', rtrim( $config['current_folder'], '/' ) );

            $tmp_path = '';
            if ( !empty( $breadcrumbs ) ) {
                foreach ( $breadcrumbs as $key => $breadcrumb ) {
                    $tmp_path .= $breadcrumb . '/';
                    if ( $key == count( $breadcrumbs ) - 1 ) {
                        $config['breadcrumbs']['active'] = array(
                            'name'  => $breadcrumb,
                            'url'   => $config['url_params_build'] . $tmp_path
                        );
                    } else if ( $breadcrumb != '' ) {
                        $config['breadcrumbs'][] = array(
                            'name'  => $breadcrumb,
                            'url'   => $config['url_params_build'] . $tmp_path
                        );
                    }
                }
            }

            // BEGIN SCAN
            $files              = Directory::scan( $config['root_source_current_dir'] );
            $files_cnt          = count( $files );
            $files_sorted       = array( );
            $files_duplicate    = array( );
            $files_image        = array( );
            $files_video        = array( );
            $files_audio        = array( );
            $files_misc         = array( );

            $current_folder       = array( );
            $previous_folder      = array( );

            foreach ( $files as $k => $file ) {
                if ( $file == '@' && trim( $config['current_folder'], '/' ) == ''  ) {
                    continue;
                } else if ( $file == '.' ){
                    $current_folder = array( 'file'=> $file );
                } else if ( $file == '..' && trim( $config['current_folder'], '/' ) != '' ) {
                    $type      = 0;
                    $width     = 0;
                    $height    = 0;

                    $directory = explode( '/', $config['current_path'] );
                    unset( $directory[count( $directory ) - 2 ] );
                    $directory = implode( '/', $directory );

                    $directory_cache = explode( '/', $config['current_cache_path'] );
                    unset( $directory_cache[count( $directory_cache ) - 2 ] );
                    $directory_cache = implode( '/', $directory_cache );

                    $current_path        = $directory;
                    $current_cache_path  = $directory_cache;

                    $source              = $config['root_source_current_dir'] . $directory;
                    $source_path         = $config['root_source_current_path'] . $directory;
                    $source_url          = $this->url->get( $source_path );
                    $source_cache        = $config['root_source_current_cache_dir'] . $directory;
                    $source_cache_path   = $config['root_source_current_cache_path'] . $directory;
                    $source_cache_url    = $this->url->get( $config['root_source_current_cache_path'] . $source_cache_path );

                    $file_image             = $this->config->directories->application->packages->dir . 'Plugins/FileManager/Themes/Images/' . $config['icon_theme'] . '/folder_back.png';
                    $file_image_path        = $this->url->get( $this->config->directories->application->packages->path . 'Plugins/FileManager/Themes/Images/' . $config['icon_theme'] . '/folder_back.png' );
                    $file_image_url         = $this->url->get( $this->config->directories->application->packages->path . 'Plugins/FileManager/Themes/Images/' . $config['icon_theme'] . '/folder_back.png' );
                    $file_image_is_icon     = true;
                    $file_image_is_thumb    = false;
                    $file_image_is_original = false;
                    $file_image_has_icon    = true;
                    $file_image_has_thumb   = false;

                    $previous_folder = array(
                        'file'               => $file,
                        'type'               => $type,
                        'width'              => $width,
                        'height'             => $height,
                        'directory'          => $directory,

                        'current_path'       => $current_path,
                        'current_cache_path' => $current_cache_path,

                        'source'             => $source,
                        'source_path'        => $source_path,
                        'source_url'         => $source_url,
                        'source_cache'       => $source_cache,
                        'source_cache_path'  => $source_cache_path,
                        'source_cache_url'   => $source_cache_url,

                        'image'              => $file_image,
                        'image_path'         => $file_image_path,
                        'image_url'          => $file_image_url,
                        'image_is_icon'      => $file_image_is_icon,
                        'image_is_thumb'     => $file_image_is_thumb,
                        'image_is_original'  => $file_image_is_original,
                        'image_has_icon'     => $file_image_has_icon,
                        'image_has_thumb'    => $file_image_has_thumb,
                    );

                } else if ( is_dir( $config['root_source_current_dir'] . $file ) && $file != '..' && $file != '.' ) {
                    $file_new            = $file;
                    $file_translate      = File::translate( $file );

                    $current_path        = $config['current_path'] . $file;
                    $current_cache_path  = $config['current_cache_path'] . $file;

                    $source              = $config['root_source_current_dir'] . $file;
                    $source_path         = $config['root_source_current_path'] . $file;
                    $source_url          = $this->url->get( $source_path );
                    $source_cache        = $config['root_source_current_cache_dir'] . $file;
                    $source_cache_path   = $config['root_source_current_cache_path'] . $file;
                    $source_cache_url    = $this->url->get( $source_cache_path );

                    $file_image             = $this->config->directories->application->packages->dir . 'Plugins/FileManager/Themes/Images/' . $config['icon_theme'] . '/folder.png';
                    $file_image_path        = $this->url->get( $this->config->directories->application->packages->path . 'Plugins/FileManager/Themes/Images/' . $config['icon_theme'] . '/folder.png' );
                    $file_image_url         = $this->url->get( $this->config->directories->application->packages->path . 'Plugins/FileManager/Themes/Images/' . $config['icon_theme'] . '/folder.png' );
                    $file_image_is_icon     = true;
                    $file_image_is_thumb    = false;
                    $file_image_is_original = false;
                    $file_image_has_icon    = true;
                    $file_image_has_thumb   = false;

                    if ( $config['enable_transliteration'] ) {
                        $file_new = $file_translate;
                    }

                    if ( $file != $file_new ) {
                        if ( Directory::exists( $source ) ) {
                            $source_new            = $config['root_source_current_dir'] . $file_new;
                            $source_path_new       = $config['root_source_current_path'] . $file_new;
                            $source_url_new        = $this->url->get( $source_path_new );

                            $source_cache_new      = $config['root_source_current_cache_dir'] . $file_new;
                            $source_cache_path_new = $config['root_source_current_cache_path'] . $file_new;
                            $source_cache_url_new  = $this->url->get( $source_cache_path_new );

                            if ( !Directory::exists( $source_new ) && $file_new != $source_new ) {
                                if ( Directory::rename( $source, $source_new ) ) {
                                    $file              = $file_new;
                                    $source            = $source_new;
                                    $source_path       = $source_path_new;
                                    $source_path_url   = $source_url_new;

                                    $source_cache      = $source_cache_new;
                                    $source_cache_path = $source_cache_path_new;
                                    $source_cache_url  = $source_cache_url_new;
                                }
                            }
                        }
                    }

                    $name            = $file;
                    $type            = 0;
                    $width           = 0;
                    $height          = 0;
                    $size            = ( $config['show_folder_size'] ) ? Directory::size( $source ) : 0;
                    $date            = Directory::time( $source );
                    $extension       = 'dir';
                    $directory       = $config['current_folder'] . $file . '/';

                    $size_str        = Directory::parseSize( $size );
                    $file_lcase      = strtolower( $file );
                    $name_lcase      = strtolower( $name );
                    $extension_lcase = strtolower( $extension );

                    if ( !Directory::exists( $source_cache ) ) {
                        Directory::create( $source_cache );
                    }

                    $prevent_edit   = true;
                    $prevent_rename = false;
                    $prevent_delete = false;

                    if ( isset( $file_permissions[$file] ) ) {
                        if ( isset( $file_permissions[$file]['duplicate'] ) && $file_permissions[$file]['duplicate']) {
                            $files_duplicate[] = $file;
                        }

                        $prevent_rename = isset( $file_permissions[$file]['rename'] ) && $file_permissions[$file]['rename'];
                        $prevent_delete = isset( $file_permissions[$file]['delete'] ) && $file_permissions[$file]['delete'];
                    }

                    $files_sorted[$k] = array(
                        'file'               => $file,
                        'type'               => $type,
                        'width'              => $width,
                        'height'             => $height,
                        'name'               => $name,
                        'date'               => $date,
                        'size'               => $size,
                        'size_str'           => $size_str,
                        'extension'          => $extension,
                        'directory'          => $directory,

                        'current_path'       => $current_path,
                        'current_cache_path' => $current_cache_path,

                        'source'             => $source,
                        'source_path'        => $source_path,
                        'source_url'         => $source_url,

                        'image'              => $file_image,
                        'image_path'         => $file_image_path,
                        'image_url'          => $file_image_url,
                        'image_is_icon'      => $file_image_is_icon,
                        'image_is_thumb'     => $file_image_is_thumb,
                        'image_is_original'  => $file_image_is_original,
                        'image_has_icon'     => $file_image_has_icon,
                        'image_has_thumb'    => $file_image_has_thumb,

                        'file_lcase'         => $file_lcase,
                        'name_lcase'         => $name_lcase,
                        'extension_lcase'    => $extension_lcase,

                        'prevent_edit'       => $prevent_edit,
                        'prevent_rename'     => $prevent_rename,
                        'prevent_delete'     => $prevent_delete,
                    );

                } else if ( file_exists( $config['root_source_current_dir'] . $file ) && $file != '..' && $file != '.' )  {
                    $file_new            = $file;
                    $file_translate      = File::translate( $file );

                    $current_path        = $config['current_path'] . $file;
                    $current_cache_path  = $config['current_cache_path'] . $file;

                    $source              = $config['root_source_current_dir'] . $file;
                    $source_path         = $config['root_source_current_path'] . $file;
                    $source_url          = $this->url->get( $source_path );
                    $source_cache        = $config['root_source_current_cache_dir'] . $file;
                    $source_cache_path   = $config['root_source_current_cache_path'] . $file;
                    $source_cache_url    = $this->url->get( $source_cache_path );

                    $file_image              = $config['root_source_current_cache_dir'] . $file;
                    $file_image_path         = $config['root_source_current_cache_path'] . $file;
                    $file_image_url          = $this->url->get( $file_image_path );
                    $file_image_is_icon      = false;
                    $file_image_is_thumb     = false;
                    $file_image_is_original  = false;
                    $file_image_has_icon     = false;
                    $file_image_has_thumb    = false;

                    if ( $config['enable_transliteration'] ) {
                        $file_new = $file_translate;
                    }

                    if ( $file != $file_new ) {
                        if ( File::exists( $source ) ) {

                            $current_path_new        = $config['current_path'] . $file_new;
                            $current_cache_path_new  = $config['current_cache_path'] . $file_new;

                            $source_new      = $config['root_source_current_dir'] . $file_new;
                            $source_path_new = $config['root_source_current_path'] . $file_new;
                            $source_url_new  = $this->url->get( $source_path_new );

                            $source_cache_new       = $config['root_source_current_cache_dir'] . $file_new;
                            $source_cache_path_new  = $config['root_source_current_cache_path'] . $file_new;
                            $source_cache_url_new   = $this->url->get( $source_cache_path_new );

                            if ( !File::exists( $source_new ) && $file_new != $source_new ) {
                                if ( File::rename( $source, $source_new ) ) {
                                    $file              = $file_new;

                                    $current_path        = $current_path_new;
                                    $current_cache_path  = $current_cache_path_new;

                                    $source            = $source_new;
                                    $source_path       = $source_path_new;
                                    $source_url        = $source_url_new;

                                    $source_cache      = $source_cache_new;
                                    $source_cache_path = $source_cache_path_new;
                                    $source_cache_url  = $source_cache_url_new;
                                }
                            }
                        }
                    }

                    $detail             = pathinfo( $source );
                    $name               = $detail['filename'];
                    $type               = 0;
                    $width              = 0;
                    $height             = 0;
                    $size               = File::size( $source );
                    $date               = File::time( $source );
                    $extension          = $detail['extension'];

                    $size_str           = File::parseSize( $size );
                    $file_lcase         = strtolower( $file );
                    $name_lcase         = strtolower( $name );
                    $extension_lcase    = strtolower( $extension );

                    if ( in_array( $extension_lcase, $config['extensions_video'] ) ) {
                        $type = 4;
                    } else if ( in_array( $extension_lcase, $config['extensions_image'] ) ) {
                        $type = 2;
                    } else if ( in_array( $extension_lcase, $config['extensions_audio'] ) ) {
                        $type = 5;
                    } else if ( in_array( $extension_lcase, $config['extensions_misc'] ) ) {
                        $type = 3;
                    } else {
                        $type = 1;
                    }


                    if ( in_array( $extension_lcase, $config['extensions_image'] )  ) {

                        list( $image_width, $image_height, $image_type, $attr ) = @getimagesize( $source );

                        $width  = $image_width;
                        $height = $image_height;

                        if ( !File::exists( $source_cache ) ) {
                            if ( $image_width > 122 && $image_height > 91 ) {
                                $image = new \Phalcon\Image\Adapter\GD( $source );
                                $image->resize( 300, 200 );
                                $image->crop( 122, 91 );

                                if ( $image->save( $source_cache, 80 ) ) {
                                    $file_image             = $source_cache;
                                    $file_image_path        = $source_cache_path;
                                    $file_image_url         = $source_cache_url;
                                    $file_image_is_thumb    = true;
                                    $file_image_has_thumb   = true;
                                } else {
                                    $source_cache           = '';
                                    $source_cache_path      = '';
                                    $file_image             = $source;
                                    $file_image_path        = $source_path;
                                    $file_image_url         = $source_url;
                                    $file_image_is_original = true;
                                }
                            } else {
                                $source_cache           = '';
                                $source_cache_path      = '';
                                $file_image             = $source;
                                $file_image_path        = $source_path;
                                $file_image_url         = $source_url;
                                $file_image_is_original = true;
                            }
                        } else {
                            $file_image_is_thumb    = true;
                            $file_image_has_thumb   = true;
                        }
                    }

                    if ( !$file_image_has_thumb && !$file_image_is_original ) {
                        if( file_exists( $this->config->directories->application->packages->dir . 'Plugins/FileManager/Themes/Images/' . $config['icon_theme'] . '/' . $extension_lcase . '.jpg' ) ) {
                            $file_image        = $this->config->directories->application->packages->dir . 'Plugins/FileManager/Themes/Images/' . $config['icon_theme'] . '/' . $extension_lcase . '.jpg';
                            $file_image_path   = $this->url->get( $this->config->directories->application->packages->path . 'Plugins/FileManager/Themes/Images/' . $config['icon_theme'] . '/' . $extension_lcase . '.jpg' );
                            $file_image_url    = $this->url->get( $this->config->directories->application->packages->path . 'Plugins/FileManager/Themes/Images/' . $config['icon_theme'] . '/' . $extension_lcase . '.jpg' );
                        } else {
                            $file_image        = $this->config->directories->application->packages->dir . 'Plugins/FileManager/Themes/Images/' . $config['icon_theme'] . '/default.jpg';
                            $file_image_path   = $this->url->get( $this->config->directories->application->packages->path . 'Plugins/FileManager/Themes/Images/' . $config['icon_theme'] . '/default.jpg' );
                            $file_image_url    = $this->url->get( $this->config->directories->application->packages->path . 'Plugins/FileManager/Themes/Images/' . $config['icon_theme'] . '/default.jpg' );
                        }
                        $file_image_is_icon    = true;
                        $file_image_has_icon   = true;
                    }

                    $prevent_play      = true;
                    $prevent_preview   = true;
                    $prevent_edit      = true;
                    $prevent_rename    = false;
                    $prevent_delete    = false;
                    $prevent_viewerjs  = true;
                    $prevent_googledoc = true;

                    if ( isset( $file_permissions[$file] ) ) {
                        if ( isset( $file_permissions[$file]['duplicate'] ) && $file_permissions[$file]['duplicate']) {
                            $files_duplicate[] = $file;
                        }

                        $prevent_rename = isset( $file_permissions[$file]['rename'] ) && $file_permissions[$file]['rename'];
                        $prevent_delete = isset( $file_permissions[$file]['elete'] ) && $file_permissions[$file]['elete'];
                    }

                    if ( in_array( $extension_lcase, $config['extensions_jplayer'] ) ) {
                        $prevent_play = false;
                    }

                    if ( in_array( $extension_lcase, $config['extensions_previewable_text_file'] ) ) {
                        $prevent_preview = false;
                    }

                    if ( in_array( $extension_lcase, $config['extensions_editable_text_file'] ) ) {
                        $prevent_edit = false;
                    }

                    if ( in_array( $extension_lcase, $config['extensions_viewerjs_file'] ) ) {
                        $prevent_viewerjs = false;
                    }

                    if ( in_array( $extension_lcase, $config['extensions_googledoc_file'] ) ) {
                        $prevent_googledoc = false;
                    }

                    if ( ( $config['type'] == 2 && $type != 2 )
                        || ( ( $config['type'] == 3 && $type != 4 ) && ( $config['type'] == 3 && $type != 5 ) )
                    ) {
                        continue;
                    }

                    $files_sorted[$k] = array(
                        'file'              => $file,
                        'type'              => $type,
                        'width'             => $width,
                        'height'            => $height,
                        'name'              => $name,
                        'date'              => $date,
                        'size'              => $size,
                        'size_str'          => $size_str,
                        'extension'         => $extension,

                        'current_path'       => $current_path,
                        'current_cache_path' => $current_cache_path,

                        'source'            => $source,
                        'source_path'       => $source_path,
                        'source_url'        => $source_url,
                        'source_cache'      => $source_cache,
                        'source_cache_path' => $source_cache_path,
                        'source_cache_url'  => $source_cache_url,

                        'image'             => $file_image,
                        'image_path'        => $file_image_path,
                        'image_url'         => $file_image_url,
                        'image_is_icon'     => $file_image_is_icon,
                        'image_is_thumb'    => $file_image_is_thumb,
                        'image_is_original' => $file_image_is_original,
                        'image_has_icon'    => $file_image_has_icon,
                        'image_has_thumb'   => $file_image_has_thumb,

                        'file_lcase'        => $file_lcase,
                        'name_lcase'        => $name_lcase,
                        'extension_lcase'   => $extension_lcase,

                        'prevent_play'      => $prevent_play,
                        'prevent_preview'   => $prevent_preview,
                        'prevent_edit'      => $prevent_edit,
                        'prevent_rename'    => $prevent_rename,
                        'prevent_delete'    => $prevent_delete,
                        'prevent_viewerjs'  => $prevent_viewerjs,
                        'prevent_googledoc' => $prevent_googledoc,
                    );

                    if ( $type == 4 ) {
                        $files_video[$k] = $files_sorted[$k];
                    } else if ( $type == 2 ) {
                        $files_image[$k] = $files_sorted[$k];
                    } else if ( $type == 5 ) {
                        $files_audio[$k] = $files_sorted[$k];
                    } else if ( $type == 3 ) {
                        $files_misc[$k]  = $files_sorted[$k];
                    }

                }
            }

            switch ( $config['sort_by'] ) {
                case 'date':
                    usort( $files_sorted, function ( $x, $y ) {
                        return $x['date'] <  $y['date'];
                    });
                    break;
                case 'size':
                    usort( $files_sorted, function ( $x, $y ) {
                        return $x['size'] <  $y['size'];
                    });
                    break;
                case 'extension':
                    usort( $files_sorted, function ( $x, $y ) {
                        return $x['extension_lcase'] <  $y['extension_lcase'];
                    });
                    break;
                default:
                    usort( $files_sorted, function ( $x, $y ) {
                        return $x['file_lcase'] <  $y['file_lcase'];
                    });
                    break;
            }

            if ( !$config['sort_order'] ) {
                $config['files_sorted'] = array_reverse( $files_sorted );
            }

            $config['files']           = array_merge( array( $previous_folder ),array( $current_folder ), $files_sorted );
            $config['files_cnt']       = $files_cnt;
            $config['files_duplicate'] = $files_duplicate;

            $config['lazy_loading_file_number_threshold'] = $settings['lazy_loading_file_number_threshold']->getValue( );

            if ( $config['lazy_loading_file_number_threshold'] == 0
                || $config['lazy_loading_file_number_threshold'] != -1
                && $files_cnt > $config['lazy_loading_file_number_threshold'] ) {
                $config['lazy_loading_enabled'] = true;
            } else {
                $config['lazy_loading_enabled'] = false;
            }

            $files_list = array( );
            $folders_list = array( );

            foreach ( $config['files'] as $key => $file ) {

                if ( $file['file'] == '.'
                    || ( isset( $file['extension'] ) && $file['extension'] != 'dir' )
                    || ( $file == '..' && $config['current_folder'] == '' )
                    || in_array( $file['file'], $config['hidden_folders'] )
                    || ( $config['filter'] != '' && $config['files_cnt'] > $config['file_number_limit_js'] && $file['file'] != '..' && stripos( $file['file'], $config['filter'] ) === false ) ) {
                    continue;
                }

                $folders_list[$key] = $file;
            }

            $config['folders_list'] = $folders_list;

            foreach ( $config['files'] as $key => $file ) {

                if ( $file['file'] == '.'
                    || $file['file'] == '..'
                    || is_dir( $config['source_current_dir'] . $file['file'] )
                    || in_array( $file['file'], $config['hidden_folders'] )
                    || !in_array( $file['extension_lcase'], $config['extensions'] )
                    || ( $config['filter'] != '' && $config['files_cnt'] > $config['file_number_limit_js'] && stripos( $file['file'], $config['filter'] ) === false ) ) {
                    continue;
                }

                $files_list[$key] = $file;
            }

            $config['files_list'] = $files_list;

            $this->view->setVar( 'var_config', $config );
            // END SCAN

            $this->session->set( 'file-manager', $session );

            $this->view->pick( 'Index' );

        }

        /**
         * Router View Prefix
         * @Post( "/view", "name" = "file-manager-view" )
         *
         * Set Permission
         * @Acl( "key" = "view", "name" = "View", "description" = "File Manager View." )
         */
        public function viewAction ( ) {

            $this->view->setVar( '_', $language = $this->language->load( array(
                'system'    => 'Index',
                'Common',
                'Index',
            )));

            $session    = $this->session->get( 'file-manager' );
            $settings   = Setting::getAllByGroup( 'file-manager' );

            if ( $this->request->hasPost( 'view' ) ) {
                $session['view'] = $this->request->getPost( 'view' );
                $this->session->set( 'file-manager', $session );
            } else {
                $this->response->setContent( $language->_( 'View Number Missing!' ) );
                return $this->response->send( );
            }

            return $this->view->disable( );

        }

        /**
         * Router Type Prefix
         * @Post( "/type", "name" = "file-manager-type" )
         *
         * Set Permission
         * @Acl( "key" = "type", "name" = "Type", "description" = "File Manager Type." )
         */
        public function typeAction ( ) {

            $this->view->setVar( '_', $language = $this->language->load( array(
                'system'    => 'Index',
                'Common',
                'Index',
            )));

            $session    = $this->session->get( 'file-manager' );
            $settings   = Setting::getAllByGroup( 'file-manager' );

            if ( $this->request->hasPost( 'type' ) ) {
                $session['type'] = $this->request->getPost( 'type' );
                $this->session->set( 'file-manager', $session );
            } else {
                $this->response->setContent( $language->_( 'Type Number Missing!' ) );
                return $this->response->send( );
            }

            return $this->view->disable( );

        }

        /**
         * Router Filter Prefix
         * @Post( "/filter", "name" = "file-manager-filter" )
         *
         * Set Permission
         * @Acl( "key" = "filter", "name" = "Filter", "description" = "File Manager Filter." )
         */
        public function filterAction ( ) {

            $this->view->setVar( '_', $language = $this->language->load( array(
                'system'    => 'Index',
                'Common',
                'Index',
            )));

            $session    = $this->session->get( 'file-manager' );
            $settings   = Setting::getAllByGroup( 'file-manager' );

            if ( $this->request->hasPost( 'filter' ) ) {
                if ( isset( $settings['remember_text_filter'] ) && $settings['remember_text_filter']->getValue( ) ) {
                    $session['filter'] = $this->request->getPost( 'filter' );
                    $this->session->set( 'file-manager', $session );
                }
            } else {
                $this->response->setContent( $language->_( 'Filter Number Missing!' ) );
                return $this->response->send( );
            }

            return $this->view->disable( );

        }

        /**
         * Router Sort Prefix
         * @Post( "/sort", "name" = "file-manager-sort" )
         *
         * Set Permission
         * @Acl( "key" = "sort", "name" = "Sort", "description" = "File Manager Sort." )
         */
        public function sortAction ( ) {

            $this->view->setVar( '_', $language = $this->language->load( array(
                'system'    => 'Index',
                'Common',
                'Index',
            )));

            $session    = $this->session->get( 'file-manager' );
            $settings   = Setting::getAllByGroup( 'file-manager' );

            if ( $this->request->hasPost( 'sort_by' ) && $this->request->hasPost( 'sort_order' ) ) {
                $session['sort_by']     = $this->request->getPost( 'sort_by', 'string' );
                $session['sort_order']  = $this->request->getPost( 'sort_order', 'int' );
                $this->session->set( 'file-manager', $session );
            } else {
                $this->response->setContent( $language->_( 'Filter Number Missing!' ) );
                return $this->response->send( );
            }

            return $this->view->disable( );

        }

        /**
         * Router Preview Text Prefix
         * @Get( "/preview-text", "name" = "file-manager-preview-text" )
         *
         * Set Permission
         * @Acl( "key" = "preview-text", "name" = "Preview Text", "description" = "File Manager Preview Text." )
         */
        public function previewTextAction ( ) {

            $this->view->setVar( '_', $language = $this->language->load( array(
                'system'    => 'Index',
                'Common',
                'Index',
            )));

            $mode           = $this->request->getQuery( 'mode' );
            $name           = $this->request->getQuery( 'name' );
            $file           = $this->request->getQuery( 'file' );
            $file_url       = $this->request->getQuery( 'file_url' );
            $source         = $this->config->directories->public->files->shared->dir . $this->request->getQuery( 'source_path' );
            $source_path    = $this->config->directories->public->files->shared->path . $this->request->getQuery( 'source_path' );
            $info           = File::info( $source );
            $session        = $this->session->get( 'file-manager' );
            $settings       = Setting::getAllByGroup( 'file-manager' );

            // EXTENSION
            $extensions_image                                = explode( ',', $settings['extensions_image']->getValue( ) );
            $extensions_file                                 = explode( ',', $settings['extensions_file']->getValue( ) );
            $extensions_video                                = explode( ',', $settings['extensions_video']->getValue( ) );
            $extensions_audio                                = explode( ',', $settings['extensions_audio']->getValue( ) );
            $extensions_misc                                 = explode( ',', $settings['extensions_misc']->getValue( ) );
            $extensions                                     = array_merge( $extensions_image, $extensions_file, $extensions_video, $extensions_audio, $extensions_misc );
            $extensions_jplayer                             = array( 'mp4','flv','webmv','webma','webm','m4a','m4v','ogv','oga','mp3','midi','mid','ogg','wav' );
            $extensions_viewerjs_file                       = explode( ',', $settings['extensions_viewerjs_file']->getValue( ) );
            $extensions_googledoc_file                      = explode( ',', $settings['extensions_googledoc_file']->getValue( ) );
            $extensions_previewable_text_file               = explode( ',', $settings['extensions_previewable_text_file']->getValue( ) );
            $extensions_previewable_text_file_no_prettify   = explode( ',', $settings['extensions_previewable_text_file_no_prettify']->getValue( ) );
            $extensions_editable_text_file                  = explode( ',', $settings['extensions_editable_text_file']->getValue( ) );

            if ( !File::exists( $source ) ) {
                $this->response->setContent( $language->_( 'text_file_not_found' ) );
                return $this->response->send( );
            }

            if ( $mode == 'text' ) {
                $is_allowed = ( boolean ) $settings['enable_preview_text_files']->getValue( );
                $allowed_file_extensions = $extensions_previewable_text_file;
            } else if ( $mode == 'viewerjs' ) {
                $is_allowed = ( boolean ) $settings['enable_viewerjs']->getValue( );
                $allowed_file_extensions = $extensions_viewerjs_file;
            } else if ( $mode == 'google' ) {
                $is_allowed = ( boolean ) $settings['enable_googledoc']->getValue( );
                $allowed_file_extensions = $extensions_googledoc_file;
            }

            if ( !isset( $allowed_file_extensions ) || !is_array( $allowed_file_extensions ) ) {
                $allowed_file_extensions = array();
            }

            if ( !in_array( $info['extension'], $allowed_file_extensions )
                || !isset( $is_allowed )
                || $is_allowed === false
                || !is_readable( $source ) ) {
                $this->response->setContent( sprintf( $language->_( 'text_file_open_edit_not_allowed' ), strtolower( $language->_( 'text_open' ) ) ) );
                return $this->response->send( );
            }

            if ( $mode == 'text' ) {
                $data = stripslashes( htmlspecialchars( file_get_contents( $source ) ) );

                $html = '';

                if ( !in_array( $info['extension'], $extensions_previewable_text_file_no_prettify ) ) {
                    $html .= '<script src="https://google-code-prettify.googlecode.com/svn/loader/run_prettify.js?lang=' . $info['extension'] . '&skin=sunburst"></script>';
                    $html .= '<div class="text-center"><strong>' . $info['basename'] . '</strong></div><pre class="prettyprint">' . $data . '</pre>';
                } else {
                    $html .= '<div class="text-center"><strong>' . $info['basename'] . '</strong></div><pre class="no-prettify">' . $data . '</pre>';
                }

            } else if ( $mode == 'viewerjs' ) {
                $html = '<iframe id="viewer" src="' . $this->url->get( $this->config->directories->application->packages->path . 'Plugins/FileManager/Themes/Plugins/ViewerJS/#' . urldecode( $file_url ) ) . '" allowfullscreen="" webkitallowfullscreen="" class="viewer-iframe"></iframe>';
            } else if ( $mode == 'google' ) {
                $html = '<div class="text-center"><strong>' . $info['basename'] . '</strong></div>' . '<iframe src="http://docs.google.com/viewer?url=' . urlencode( $file_url ) . '&embedded=true" class="google-iframe"></iframe>';
            }

            $this->response->setContent( $html );
            return $this->response->send( );

            return $this->view->disable( );

        }

        /**
         * Router Preview Media Prefix
         * @Get( "/preview-media", "name" = "file-manager-preview-media" )
         *
         * Set Permission
         * @Acl( "key" = "preview-media", "name" = "Preview Media", "description" = "File Manager Preview Media." )
         */
        public function previewMediaAction ( ) {

            $this->view_simple->setVar( '_', $language = $this->language->load( array(
                'system'    => 'Index',
                'Common',
                'Index',
            )));

            $name           = $this->request->getQuery( 'name', 'string' );
            $file           = $this->request->getQuery( 'file', 'string' );
            $file_url       = $this->request->getQuery( 'file_url' );
            $source         = $this->config->directories->public->files->shared->dir . $this->request->getQuery( 'source_path' );
            $source_path    = $this->config->directories->public->files->shared->path . $this->request->getQuery( 'source_path' );
            $info           = File::info( $source );
            $session        = $this->session->get( 'file-manager' );
            $settings       = Setting::getAllByGroup( 'file-manager' );

            // EXTENSION
            $extensions_image                                = explode( ',', $settings['extensions_image']->getValue( ) );
            $extensions_file                                 = explode( ',', $settings['extensions_file']->getValue( ) );
            $extensions_video                                = explode( ',', $settings['extensions_video']->getValue( ) );
            $extensions_audio                                = explode( ',', $settings['extensions_audio']->getValue( ) );
            $extensions_misc                                 = explode( ',', $settings['extensions_misc']->getValue( ) );
            $extensions                                     = array_merge( $extensions_image, $extensions_file, $extensions_video, $extensions_audio, $extensions_misc );
            $extensions_jplayer                             = array( 'mp4','flv','webmv','webma','webm','m4a','m4v','ogv','oga','mp3','midi','mid','ogg','wav' );
            $extensions_viewerjs_file                       = explode( ',', $settings['extensions_viewerjs_file']->getValue( ) );
            $extensions_googledoc_file                      = explode( ',', $settings['extensions_googledoc_file']->getValue( ) );
            $extensions_previewable_text_file               = explode( ',', $settings['extensions_previewable_text_file']->getValue( ) );
            $extensions_previewable_text_file_no_prettify   = explode( ',', $settings['extensions_previewable_text_file_no_prettify']->getValue( ) );
            $extensions_editable_text_file                  = explode( ',', $settings['extensions_editable_text_file']->getValue( ) );

            if ( !File::exists( $source ) ) {
                $this->response->setContent( $language->_( 'text_file_not_found' ) );
                return $this->response->send( );
            }

            $this->view_simple->setVar( 'var_name', $name );
            $this->view_simple->setVar( 'var_file', $file );
            $this->view_simple->setVar( 'var_file_url', $file_url );
            $this->view_simple->setVar( 'var_file_source', $source );
            $this->view_simple->setVar( 'var_is_audio', false );
            $this->view_simple->setVar( 'var_is_video', false );

            if ( in_array( strtolower( $info['extension'] ), $extensions_audio ) ) {
                $this->view_simple->setVar( 'var_is_audio', true );
            }  else if ( in_array( strtolower( $info['extension'] ), $extensions_video ) ) {
                $this->view_simple->setVar( 'var_is_video', true );
            }

            $this->response->setContent( $this->view_simple->render( 'Media' ) );
            return $this->response->send( );

            return $this->view->disable( );
        }

        /**
         * Router Edit Text Prefix
         * @Post( "/edit-text", "name" = "file-manager-edit-text" )
         *
         * Set Permission
         * @Acl( "key" = "edit-text", "name" = "Edit Text", "description" = "File Manager Edit Text." )
         */
        public function editTextAction ( ) {

            $this->view->setVar( '_', $language = $this->language->load( array(
                'system'    => 'Index',
                'Common',
                'Index',
            )));

            $mode           = $this->request->getPost( 'mode' );
            $name           = $this->request->getPost( 'name' );
            $file           = $this->request->getPost( 'file' );
            $file_url       = $this->request->getPost( 'file_url' );
            $source         = $this->config->directories->public->files->shared->dir . $this->request->getPost( 'source_path' );
            $source_path    = $this->config->directories->public->files->shared->path . $this->request->getPost( 'source_path' );
            $info           = File::info( $source );
            $session        = $this->session->get( 'file-manager' );
            $settings       = Setting::getAllByGroup( 'file-manager' );

            // EXTENSION
            $extensions_image                                = explode( ',', $settings['extensions_image']->getValue( ) );
            $extensions_file                                 = explode( ',', $settings['extensions_file']->getValue( ) );
            $extensions_video                                = explode( ',', $settings['extensions_video']->getValue( ) );
            $extensions_audio                                = explode( ',', $settings['extensions_audio']->getValue( ) );
            $extensions_misc                                 = explode( ',', $settings['extensions_misc']->getValue( ) );
            $extensions                                     = array_merge( $extensions_image, $extensions_file, $extensions_video, $extensions_audio, $extensions_misc );
            $extensions_jplayer                             = array( 'mp4','flv','webmv','webma','webm','m4a','m4v','ogv','oga','mp3','midi','mid','ogg','wav' );
            $extensions_viewerjs_file                       = explode( ',', $settings['extensions_viewerjs_file']->getValue( ) );
            $extensions_googledoc_file                      = explode( ',', $settings['extensions_googledoc_file']->getValue( ) );
            $extensions_previewable_text_file               = explode( ',', $settings['extensions_previewable_text_file']->getValue( ) );
            $extensions_previewable_text_file_no_prettify   = explode( ',', $settings['extensions_previewable_text_file_no_prettify']->getValue( ) );
            $extensions_editable_text_file                  = explode( ',', $settings['extensions_editable_text_file']->getValue( ) );

            if ( !File::exists( $source ) ) {
                $this->response->setContent( $language->_( 'text_file_not_found' ) );
                return $this->response->send( );
            }

            if ( $mode == 'text' ) {
                $is_allowed = ( boolean ) $settings['enable_edit_text_files']->getValue( );
                $allowed_file_extensions = $extensions_editable_text_file;
            } else if ( $mode == 'viewerjs' ) {
                $is_allowed = ( boolean ) $settings['enable_viewerjs']->getValue( );
                $allowed_file_extensions = $extensions_viewerjs_file;
            } else if ( $mode == 'google' ) {
                $is_allowed = ( boolean ) $settings['enable_googledoc']->getValue( );
                $allowed_file_extensions = $extensions_googledoc_file;
            }

            if ( !isset( $allowed_file_extensions ) || !is_array( $allowed_file_extensions ) ) {
                $allowed_file_extensions = array();
            }

            if ( !in_array( $info['extension'], $allowed_file_extensions )
                || !isset( $is_allowed )
                || $is_allowed === false
                || !is_readable( $source ) ) {
                $this->response->setContent( sprintf( $language->_( 'text_file_open_edit_not_allowed' ), strtolower( $language->_( 'text_open' ) ) ) );
                return $this->response->send( );
            }

            $data = stripslashes( htmlspecialchars( file_get_contents( $source ) ) );
            $html = '<textarea id="textfile_edit_area" style="width:100%;height:300px;">' . $data . '</textarea>';

            $this->response->setContent( $html );
            return $this->response->send( );

            return $this->view->disable( );

        }

        /**
         * Router Save Text Prefix
         * @Post( "/save-text", "name" = "file-manager-save-text" )
         *
         * Set Permission
         * @Acl( "key" = "save-text", "name" = "Save Text", "description" = "File Manager Save Text." )
         */
        public function saveTextAction ( ) {

            $this->view->setVar( '_', $language = $this->language->load( array(
                'system'    => 'Index',
                'Common',
                'Index',
            )));

            $name         = $this->request->getPost( 'name' );
            $content      = $this->request->getPost( 'content' );
            $info         = File::info( $this->request->getPost( 'source_path' ) );
            $root_dir     = $this->config->directories->public->files->shared->dir;
            $root_path    = $this->config->directories->public->files->shared->path;
            $source       = $root_dir . $this->request->getPost( 'source_path' );
            $source_cache = $root_dir . $this->request->getPost( 'source_cache_path' );
            $settings     = Setting::getAllByGroup( 'file-manager' );

            if ( !File::exists( $source ) ) {
                $this->response->setContent( $language->_( 'text_file_not_found' ) );
                return $this->response->send( );
            }

            if ( !is_writable( $source ) || !( isset( $settings['enable_edit_text_files'] ) && $settings['enable_edit_text_files']->getValue( ) ) ) {
                $this->response->setContent( sprintf( $language->_( 'text_file_open_edit_not_allowed' ), strtolower( $language->_( 'text_edit' ) ) ) );
                return $this->response->send( );
            }

            if ( @file_put_contents( $source, $content ) === false ) {
                $this->response->setContent( $language->_( 'text_file_save_error' ) );
                return $this->response->send( );
            } else {
                $this->response->setContent( $language->_( 'text_file_save_ok' ) );
                return $this->response->send( );
            }

            return $this->view->disable( );

        }

        /**
         * Router Save Mode Prefix
         * @Post( "/save-mode", "name" = "file-manager-save-mode" )
         *
         * Set Permission
         * @Acl( "key" = "save-mode", "name" = "Save Mode", "description" = "File Manager Save Mode." )
         */
        public function saveModeAction ( ) {

            $this->view->setVar( '_', $language = $this->language->load( array(
                'system'    => 'Index',
                'Common',
                'Index',
            )));

            $mode               = $this->request->getPost( 'mode' );
            $new_permission     = $this->request->getPost( 'new_permission' );
            $chmod_permission   = false;
            $rec_option         = $this->request->getPost( 'rec_option' );
            $valid_options      = array( 'none', 'files', 'folders', 'both' );
            $info               = File::info( $this->request->getPost( 'source_path' ) );
            $root_dir           = $this->config->directories->public->files->shared->dir;
            $root_path          = $this->config->directories->public->files->shared->path;
            $source             = $root_dir . $this->request->getPost( 'source_path' );
            $source_cache       = $root_dir . $this->request->getPost( 'source_cache_path' );
            $settings           = Setting::getAllByGroup( 'file-manager' );

            if ( is_dir( $source ) ) {
                $chmod_permission    = $settings['enable_chmod_folders']->getValue( );
            } else {
                $chmod_permission   = $settings['enable_chmod_files']->getValue( );
            }

            if ( !File::exists( $source ) ) {
                $this->response->setContent( $language->_( 'text_file_not_found' ) );
                return $this->response->send( );
            }

            if ( !$chmod_permission ) {
                $this->response->setContent( sprintf( $language->_( 'text_file_permission_not_allowed' ), ( is_dir( $source ) ? lcfirst( $language->_( 'text_folders' ) ) : lcfirst( $language->_( 'text_folders' ) ) ) ) );
                return $this->response->send( );
            }

            if ( !preg_match( "/^[0-7]{3}$/", $mode ) ) {
                $this->response->setContent( $language->_( 'text_file_permission_wrong_mode' ) );
                return $this->response->send( );
            }

            if ( !in_array( $rec_option, $valid_options ) ){
                $this->response->setContent( $language->_( 'text_wrong_option' ) );
                return $this->response->send( );
            }

            if ( function_exists( 'chmod' ) === false ) {
                $this->response->setContent( sprintf( $language->_( 'text_function_disabled' ), 'chmod' ) );
                return $this->response->send( );
            }

            function rchmod ( $source, $mode, $rec_option = "none", $is_rec = false ) {
                if ( $rec_option == 'none' ) {
                    File::mode( $source, $mode );
                } else {
                    if ( $is_rec === false ) {
                        File::mode( $source, $mode );
                    }

                    $files = Directory::scandir( $source );
                    foreach ( $files as $file ) {
                        if ( $file != '.' && $file != '..' ) {
                            if ( is_dir( $source . DIRECTORY_SEPARATOR . $file ) ) {
                                if ( $rec_option == 'folders' || $rec_option == 'both' ) {
                                    Directory::mode( $source . DIRECTORY_SEPARATOR . $file, $mode );
                                }
                                rchmod( $source . DIRECTORY_SEPARATOR . $file, $mode, $rec_option, true );
                            } else {
                                if ( $rec_option == 'files' || $rec_option == 'both' ) {
                                    File::mode( $source . DIRECTORY_SEPARATOR . $file, $mode );
                                }
                            }
                        }
                    }
                }
            }

            $mode = '0' . $mode;
            $mode = octdec( $mode );

            rchmod( $source, $mode, $rec_option );

            $this->response->setContent( $language->_( 'text_file_permission_changed' ) );
            return $this->response->send( );

            return $this->view->disable( );

        }

        /**
         * Router Save Image Prefix
         * @Post( "/save-image", "name" = "file-manager-save-image" )
         *
         * Set Permission
         * @Acl( "key" = "save-image", "name" = "Save Image", "description" = "File Manager Save Image." )
         */
        public function saveImageAction ( ) {

            $this->view->setVar( '_', $language = $this->language->load( array(
                'system'    => 'Index',
                'Common',
                'Index',
            )));

            $name          = $this->request->getPost( 'name' );
            $name_traslate = File::translate( $name );
            $content       = file_get_contents( $this->request->getPost( 'url' ) );
            $info          = File::info( $name );
            $root_dir      = $this->config->directories->public->files->shared->dir;
            $root_path     = $this->config->directories->public->files->shared->path;
            $source        = $root_dir . $this->request->getPost( 'source_path' );
            $source_cache  = $root_dir . $this->request->getPost( 'source_cache_path' );
            $settings      = Setting::getAllByGroup( 'file-manager' );

            if ( strpos( $this->request->getPost( 'source_path' ), '/') === 0
                || strpos( $this->request->getPost( 'source_path' ), '../') !== false
                || strpos( $this->request->getPost( 'source_path' ), './') === 0
                || strpos( $this->request->getPost( 'url' ), 'http://s3.amazonaws.com/feather' ) !== 0
                || $name != $name_traslate
                || !in_array( strtolower( $info['extension'] ), array( 'jpg', 'jpeg', 'png' ) )
            ) {
                $this->response->setContent( $language->_( 'text_wrong_data' ) );
                return $this->response->send( );
            }

            if ( $content === false ) {
                $this->response->setContent( $language->_( 'text_aviary_no_save' ) );
                return $this->response->send( );
            }

            if ( !File::exists( $source ) ) {
                $this->response->setContent( $language->_( 'text_file_not_found' ) );
                return $this->response->send( );
            }

            $fp = fopen( $source, 'w' );

            fwrite( $fp, $content );
            fclose( $fp );

            $this->response->setContent( $language->_( 'text_file_save_ok' ) );
            return $this->response->send( );


            return $this->view->disable( );

        }

        /**
         * Router Download Prefix
         * @Post( "/download", "name" = "file-manager-download" )
         *
         * Set Permission
         * @Acl( "key" = "download", "name" = "Download", "description" = "File Manager Download." )
         */
        public function downloadAction ( ) {

            $this->view->setVar( '_', $language = $this->language->load( array(
                'system'    => 'Index',
                'Common',
                'Index',
            )));

            $name           = $this->request->getPost( 'source_path' );
            $source         = $this->config->directories->public->files->shared->dir . $this->request->getPost( 'source_path' );
            $source_path    = $this->config->directories->public->files->shared->path . $this->request->getPost( 'source_path' );
            $info           = File::info( $source );
            $size           = ( string ) File::size( $source );
            $mime_type      = File::mimeType( $source );
            $session        = $this->session->get( 'file-manager' );
            $settings       = Setting::getAllByGroup( 'file-manager' );

            // EXTENSION
            $extensions_image                                = explode( ',', $settings['extensions_image']->getValue( ) );
            $extensions_file                                 = explode( ',', $settings['extensions_file']->getValue( ) );
            $extensions_video                                = explode( ',', $settings['extensions_video']->getValue( ) );
            $extensions_audio                                = explode( ',', $settings['extensions_audio']->getValue( ) );
            $extensions_misc                                 = explode( ',', $settings['extensions_misc']->getValue( ) );
            $extensions                                     = array_merge( $extensions_image, $extensions_file, $extensions_video, $extensions_audio, $extensions_misc );
            $extensions_jplayer                             = array( 'mp4','flv','webmv','webma','webm','m4a','m4v','ogv','oga','mp3','midi','mid','ogg','wav' );
            $extensions_viewerjs_file                       = explode( ',', $settings['extensions_viewerjs_file']->getValue( ) );
            $extensions_googledoc_file                      = explode( ',', $settings['extensions_googledoc_file']->getValue( ) );
            $extensions_previewable_text_file               = explode( ',', $settings['extensions_previewable_text_file']->getValue( ) );
            $extensions_previewable_text_file_no_prettify   = explode( ',', $settings['extensions_previewable_text_file_no_prettify']->getValue( ) );
            $extensions_editable_text_file                  = explode( ',', $settings['extensions_editable_text_file']->getValue( ) );

            if ( !in_array( $info['extension'], $extensions ) ) {
                $this->response->setContent( $language->_( 'text_invalid_extension' ) );
                return $this->response->send( );
            }

            if ( !File::exists( $source )  ) {
                $this->response->setContent( $language->_( 'text_file_not_found' ) );
                return $this->response->send( );
            }

            $this->response->setHeader( 'Pragma', 'private' );
            $this->response->setHeader( 'Cache-control', 'private, must-revalidate' );
            $this->response->setHeader( 'Content-Type', $mime_type );
            $this->response->setHeader( 'Content-Length', $size );
            $this->response->setHeader( 'Content-Disposition', 'attachment; filename="' . $name . '"' );
            $this->response->setContent( file_get_contents( $source ) );
            $this->response->send( );

            return $this->view->disable( );

        }

        /**
         * Router Upload Prefix
         * @Post( "/upload", "name" = "file-manager-upload" )
         *
         * Set Permission
         * @Acl( "key" = "upload", "name" = "Upload", "description" = "File Manager Upload." )
         */
        public function uploadAction ( ) {

            $this->view->setVar( '_', $language = $this->language->load( array(
                'system'    => 'Index',
                'Common',
                'Index',
            )));

            $config     = array( );
            $session    = $this->session->get( 'file-manager' );
            $settings   = Setting::getAllByGroup( 'file-manager' );

            $config['root_dir']          = $this->config->directories->public->files->shared->dir;
            $config['root_path']         = $this->config->directories->public->files->shared->path;
            $config['source_dir']        = $settings['source_dir']->getValue( );
            $config['source_path']       = $settings['source_dir']->getValue( );
            $config['source_cache_dir']  = '@/';
            $config['source_cache_path'] = '@/';

            // CONFIG
            $config['enable_transliteration']        = ( boolean ) $settings['enable_transliteration']->getValue( );

            // EXTENSION
            $extensions_image                  = explode( ',', $settings['extensions_image']->getValue( ) );
            $extensions_file                   = explode( ',', $settings['extensions_file']->getValue( ) );
            $extensions_video                  = explode( ',', $settings['extensions_video']->getValue( ) );
            $extensions_audio                  = explode( ',', $settings['extensions_audio']->getValue( ) );
            $extensions_misc                   = explode( ',', $settings['extensions_misc']->getValue( ) );
            $extensions                       = array_merge( $extensions_image, $extensions_file, $extensions_video, $extensions_audio, $extensions_misc );
            $extensions_jplayer               = array( 'mp4','flv','webmv','webma','webm','m4a','m4v','ogv','oga','mp3','midi','mid','ogg','wav' );
            $extensions_viewerjs_file         = explode( ',', $settings['extensions_viewerjs_file']->getValue( ) );
            $extensions_googledoc_file        = explode( ',', $settings['extensions_googledoc_file']->getValue( ) );
            $extensions_previewable_text_file = explode( ',', $settings['extensions_previewable_text_file']->getValue( ) );
            $extensions_editable_text_file    = explode( ',', $settings['extensions_editable_text_file']->getValue( ) );

            $config['extensions_image']                 = $extensions_image;
            $config['extensions_file']                  = $extensions_file;
            $config['extensions_video']                 = $extensions_video;
            $config['extensions_audio']                 = $extensions_audio;
            $config['extensions_misc']                  = $extensions_misc;
            $config['extensions']                       = $extensions;
            $config['extensions_jplayer']               = $extensions_jplayer;
            $config['extensions_viewerjs_file']         = $extensions_viewerjs_file;
            $config['extensions_googledoc_file']        = $extensions_googledoc_file;
            $config['extensions_previewable_text_file'] = $extensions_previewable_text_file;
            $config['extensions_editable_text_file']    = $extensions_editable_text_file;

            if ( $this->request->hasPost( 'source_dir' ) ) {
                $source_dir       = $this->request->getPost( 'source_dir' );
                $source_cache_dir = $this->request->getPost( 'source_cache_dir' );
            } else {
                $source_dir       = $this->request->getPost( 'source_dir' );
                $source_cache_dir = $this->request->getPost( 'source_cache_dir' );
            }

            $config['source_dir']        = $source_dir;
            $config['source_path']       = $source_dir;
            $config['source_cache_dir']  = $source_cache_dir;
            $config['source_cache_path'] = $source_cache_dir;

            $config['root_source_current_dir']        = $config['root_dir'] . $config['source_dir'];
            $config['root_source_current_path']       = $config['root_path'] . $config['source_path'];
            $config['root_source_current_url']        = $this->url->get( $config['root_source_current_path'] );
            $config['root_source_current_cache_dir']  = $config['root_dir'] . $config['source_cache_dir'];
            $config['root_source_current_cache_path'] = $config['root_path'] . $config['source_cache_path'];
            $config['root_source_current_cache_url']  = $this->url->get( $config['root_source_current_cache_path'] );

            if ( $this->request->hasFiles( 'file' ) ) {

                foreach ( $this->request->getUploadedFiles( ) as $ufile ) {
                    $info = File::info( $ufile->getName( ) );

                    if ( in_array( strtolower( $info['extension'] ), $config['extensions'] ) ) {

                        $file           = $ufile->getName( );
                        $file_translate = File::translate( $file );

                        if ( $config['enable_transliteration'] ) {
                            $file = $file_translate;
                        }

                        $info         = File::info( $file );
                        $source       = $config['root_source_current_dir'] . $file;
                        $source_cache = $config['root_source_current_cache_dir'] . $file;

                        if ( File::exists( $source ) ) {

                            $i            = 1;
                            $file         = $info['filename'] . '_' . $i . '.' . $info['extension'];
                            $source       = $config['root_source_current_dir'] . $file;
                            $source_cache = $config['root_source_current_cache_dir'] . $file;

                            while ( File::exists( $source ) ) {
                                $i++;
                            }
                        }

                        $info                    = File::info( $file );
                        $info['file']            = $info['basename'];
                        $info['name']            = $info['filename'];
                        $info['extension_lcase'] = strtolower( $info['extension'] );
                        $info['source']          = $source;
                        $info['source_cache']    = $source_cache;

                        $ufile->moveTo( $info['source'] );

                        File::mode( $info['source'], 0755 );

                        if ( in_array( $info['extension_lcase'], $config['extensions_image'] ) ) {
                            // TEST IF NEEDED TO PUT THUMBNAIL!!!
                        }

                    } else {
                        $this->response->setStatusCode( 406, 'FILE NOT PERMITTED' );
                        return $this->response->send( );
                    }
                }

            } else {
                $this->response->setStatusCode( 405, 'BAD REQUEST' );
                return $this->response->send( );
            }

            if ( $this->request->hasPost( 'submit' ) ) {
                $query = http_build_query( array(
                    'type'      => $this->request->getPost( 'type' ),
                    'popup'     => $this->request->getPost( 'popup' ),
                    'field_id'  => $this->request->getPost( 'field_id' ),
                    'fldr'      => $this->request->getPost( 'fldr' ),
                ));

                $this->response->redirect( array(
                    'for' => 'file-manager'
                ));
            }

            return;
        }

        /**
         * Router Create File Prefix
         * @Post( "/create-file", "name" = "file-manager-create-file" )
         *
         * Set Permission
         * @Acl( "key" = "create-file", "name" = "Create File", "description" = "File Manager Create File." )
         */
        public function createFileAction ( ) {

            $this->view->setVar( '_', $language = $this->language->load( array(
                'system'    => 'Index',
                'Common',
                'Index',
            )));

            $name         = $this->request->getPost( 'name' );
            $content      = $this->request->getPost( 'content' );
            $info         = File::info( $this->request->getPost( 'source_path' ) );
            $root_dir     = $this->config->directories->public->files->shared->dir;
            $root_path    = $this->config->directories->public->files->shared->path;
            $source       = $root_dir . $this->request->getPost( 'source_path' );
            $source_cache = $root_dir . $this->request->getPost( 'source_cache_path' );
            $settings     = Setting::getAllByGroup( 'file-manager' );

            if ( isset( $settings['enable_create_text_files'] ) && $settings['enable_create_text_files']->getValue( ) == false ) {
                $this->response->setContent( sprintf( $language->_( 'text_file_open_edit_not_allowed' ), $language->_( 'text_edit' ) ) );
                return $this->response->send( );
            }

            if ( !isset( $settings['extensions_editable_text_file'] ) ){
                $extensions_editable_text_file = array( );
            } else {
                $extensions_editable_text_file = explode( ',', $settings['extensions_editable_text_file']->getValue( ) );
            }

            if ( isset( $info['extension'] ) && !in_array( strtolower( $info['extension'] ), $extensions_editable_text_file ) ) {
                $this->response->setContent( 'Wrong Extension!');
                return $this->response->send( );
            }

            if ( empty( $name ) ) {
                $this->response->setContent( $language->_( 'text_empty_name' ) );
                return $this->response->send( );
            }

            if ( strpos( $name, '.' ) === false ) {
                $this->response->setContent( $language->_( 'text_no_extension' ) . ' ' . sprintf( $language->_( 'text_valid_extensions' ), implode( ', ', $extensions_editable_text_file ) ) );
                return $this->response->send( );
            }

            if ( strpos( $name, '../' ) !== false ) {
                $this->response->setContent( 'Wrong Name!' );
                return $this->response->send( );
            }

            if ( !in_array( $info['extension'], $extensions_editable_text_file ) ) {
                $this->response->setContent( $language->_( 'text_error_extension' ) . ' ' . sprintf( $language->_( 'text_valid_extensions' ), implode( ', ', $extensions_editable_text_file ) ) );
                return $this->response->send( );
            }

            if ( $settings['enable_transliteration']->getValue( ) ) {
                $name = File::translate( $name );
            }

            $source       = dirname( $source ) . DS . $name;
            $source_cache = dirname( $source_cache ) . DS . $name;

            if ( File::exists( $source ) ) {
                $this->response->setContent( $language->_( 'text_rename_existing_file' ) );
                return $this->response->send( );
            }

            if ( @file_put_contents( $source, $content ) === false ) {
                $this->response->setContent( $language->_( 'text_file_save_error' ) );
                return $this->response->send( );
            } else {
                File::mode( $source, 0644 );

                $this->response->setContent( $language->_( 'text_file_save_ok' ) );
                return $this->response->send( );
            }

            return $this->view->disable( );

        }

        /**
         * Router Rename File Prefix
         * @Post( "/rename-file", "name" = "file-manager-rename-file" )
         *
         * Set Permission
         * @Acl( "key" = "rename-file", "name" = "Rename File", "description" = "File Manager Rename File." )
         */
        public function renameFileAction ( ) {

            $this->view->setVar( '_', $language = $this->language->load( array(
                'system'    => 'Index',
                'Common',
                'Index',
            )));

            $name         = $this->request->getPost( 'name' );
            $root_dir     = $this->config->directories->public->files->shared->dir;
            $root_path    = $this->config->directories->public->files->shared->path;
            $source       = $root_dir . $this->request->getPost( 'source_path' );
            $source_cache = $root_dir . $this->request->getPost( 'source_cache_path' );
            $settings     = Setting::getAllByGroup( 'file-manager' );

            if ( !isset( $settings['enable_rename_files'] ) || $settings['enable_rename_files']->getValue( ) == false ) {
                $this->response->setContent( 'Permission Denied!' );
                return $this->response->send( );
            }

            if ( empty( $name ) ) {
                $this->response->setContent( $language->_( 'text_empty_name' ) );
                return $this->response->send( );
            }

            if ( strpos( $name, '../' ) !== false ) {
                $this->response->setContent( 'Wrong Name!' );
                return $this->response->send( );
            }

            if ( $settings['enable_transliteration']->getValue( ) ) {
                $name = File::translate( $name );
            }

            $new_source       = dirname( $source ) . DS . $name;
            $new_source_cache = dirname( $source_cache ) . DS . $name;

            if ( File::exists( $new_source ) ) {
                $this->response->setContent( 'File Already Exist!' );
                return $this->response->send( );
            } else {
                File::rename( $source, $new_source );
                File::rename( $source_cache, $new_source_cache  );

                $this->response->setContent( 'File Successfully Renamed!' );
                return $this->response->send( );
            }

            return $this->view->disable( );

        }

        /**
         * Router Duplicate File Prefix
         * @Post( "/duplicate-file", "name" = "file-manager-duplicate-file" )
         *
         * Set Permission
         * @Acl( "key" = "duplicate-file", "name" = "Duplicate File", "description" = "File Manager Duplicate File." )
         */
        public function duplicateFileAction ( ) {

            $this->view->setVar( '_', $language = $this->language->load( array(
                'system'    => 'Index',
                'Common',
                'Index',
            )));

            $name         = $this->request->getPost( 'name' );
            $root_dir     = $this->config->directories->public->files->shared->dir;
            $root_path    = $this->config->directories->public->files->shared->path;
            $source       = $root_dir . $this->request->getPost( 'source_path' );
            $source_cache = $root_dir . $this->request->getPost( 'source_cache_path' );
            $settings     = Setting::getAllByGroup( 'file-manager' );

            if ( !isset( $settings['enable_duplicate_files'] ) || $settings['enable_duplicate_files']->getValue( ) == false ) {
                $this->response->setContent( 'Permission Denied!' );
                return $this->response->send( );
            }

            if ( empty( $name ) ) {
                $this->response->setContent( $language->_( 'text_empty_name' ) );
                return $this->response->send( );
            }

            if ( strpos( $name, '../' ) !== false ) {
                $this->response->setContent( 'Wrong Name!' );
                return $this->response->send( );
            }

            if ( $settings['enable_transliteration']->getValue( ) ) {
                $name = File::translate( $name );
            }

            $new_source       = dirname( $source ) . DS . $name;
            $new_source_cache = dirname( $source_cache ) . DS . $name;

            if ( File::exists( $new_source ) ) {
                $this->response->setContent( 'File Already Exist!' );
                return $this->response->send( );
            } else {
                if ( is_dir( $source ) ) {
                    Directory::copy( $source, $new_source );
                    Directory::copy( $source_cache, $new_source_cache  );
                } else {
                    File::copy( $source, $new_source );
                    File::copy( $source_cache, $new_source_cache  );
                }

                $this->response->setContent( 'File Successfully Duplicate!' );
                return $this->response->send( );
            }

            return $this->view->disable( );

        }

        /**
         * Router Delete File Prefix
         * @Post( "/delete-file", "name" = "file-manager-delete-file" )
         *
         * Set Permission
         * @Acl( "key" = "delete-file", "name" = "Delete File", "description" = "File Manager Delete File." )
         */
        public function deleteFileAction ( ) {

            $this->view->setVar( '_', $language = $this->language->load( array(
                'system'    => 'Index',
                'Common',
                'Index',
            )));

            $name         = $this->request->getPost( 'name' );
            $root_dir     = $this->config->directories->public->files->shared->dir;
            $root_path    = $this->config->directories->public->files->shared->path;
            $source       = $root_dir . $this->request->getPost( 'source_path' );
            $source_cache = $root_dir . $this->request->getPost( 'source_cache_path' );
            $settings     = Setting::getAllByGroup( 'file-manager' );

            if ( !isset( $settings['enable_delete_files'] ) || $settings['enable_delete_files']->getValue( ) == false ) {
                $this->response->setContent( 'Permission Denied!' );
                return $this->response->send( );
            }

            if ( !File::exists( $source ) ) {
                $this->response->setContent( 'File Not Exist!' );
                return $this->response->send( );
            } else {
                File::delete( $source );
                File::delete( $source_cache );

                $this->response->setContent( 'File Successfully Deleted!' );
                return $this->response->send( );
            }

            return $this->view->disable( );

        }

        /**
         * Router Create Folder Prefix
         * @Post( "/create-folder", "name" = "file-manager-create-folder" )
         *
         * Set Permission
         * @Acl( "key" = "create-folder", "name" = "Create Folder", "description" = "File Manager Create Folder." )
         */
        public function createFolderAction ( ) {

            $this->view->setVar( '_', $language = $this->language->load( array(
                'system'    => 'Index',
                'Common',
                'Index',
            )));

            $name         = $this->request->getPost( 'name' );
            $root_dir     = $this->config->directories->public->files->shared->dir;
            $root_path    = $this->config->directories->public->files->shared->path;
            $source       = $root_dir . $this->request->getPost( 'source_path' );
            $source_cache = $root_dir . $this->request->getPost( 'source_cache_path' );
            $settings     = Setting::getAllByGroup( 'file-manager' );

            if ( !isset( $settings['enable_create_folders'] ) || $settings['enable_create_folders']->getValue( ) == false ) {
                $this->response->setContent( 'Permission Denied!' );
                return $this->response->send( );
            }

            if ( empty( $name ) ) {
                $this->response->setContent( $language->_( 'text_empty_name' ) );
                return $this->response->send( );
            }

            if ( strpos( $name, '../' ) !== false ) {
                $this->response->setContent( 'Wrong Name!' );
                return $this->response->send( );
            }

            if ( $settings['enable_transliteration']->getValue( ) ) {
                $name = Directory::translate( $name );
            }

            $source       = dirname( $source ) . DS . $name;
            $source_cache = dirname( $source_cache ) . DS . $name;

            if ( Directory::exists( $source ) ) {
                $this->response->setContent( 'Directory Already Exist!' );
                return $this->response->send( );
            } else {
                Directory::create( $source );
                Directory::create( $source_cache );
                $this->response->setContent( 'Directory Successfully Creaded!' );
                return $this->response->send( );
            }

            return $this->view->disable( );

        }

        /**
         * Router Rename Folder Prefix
         * @Post( "/rename-folder", "name" = "file-manager-rename-folder" )
         *
         * Set Permission
         * @Acl( "key" = "rename-folder", "name" = "Rename Folder", "description" = "File Manager Rename Folder." )
         */
        public function renameFolderAction ( ) {

            $this->view->setVar( '_', $language = $this->language->load( array(
                'system'    => 'Index',
                'Common',
                'Index',
            )));

            $name         = $this->request->getPost( 'name' );
            $root_dir     = $this->config->directories->public->files->shared->dir;
            $root_path    = $this->config->directories->public->files->shared->path;
            $source       = $root_dir . $this->request->getPost( 'source_path' );
            $source_cache = $root_dir . $this->request->getPost( 'source_cache_path' );
            $settings     = Setting::getAllByGroup( 'file-manager' );

            if ( !isset( $settings['enable_rename_folders'] ) || $settings['enable_rename_folders']->getValue( ) == false ) {
                $this->response->setContent( 'Permission Denied!' );
                return $this->response->send( );
            }

            if ( empty( $name ) ) {
                $this->response->setContent( $language->_( 'text_empty_name' ) );
                return $this->response->send( );
            }

            if ( strpos( $name, '../' ) !== false ) {
                $this->response->setContent( 'Wrong Name!' );
                return $this->response->send( );
            }

            if ( $settings['enable_transliteration']->getValue( ) ) {
                $name = Directory::translate( $name );
            }

            $new_source       = dirname( $source ) . DS . $name;
            $new_source_cache = dirname( $source_cache ) . DS . $name;

            if ( Directory::exists( $new_source ) ) {
                $this->response->setContent( 'Directory Already Exist!' );
                return $this->response->send( );
            } else {
                Directory::rename( $source, $new_source );
                Directory::rename( $source_cache, $new_source_cache  );

                $this->response->setContent( 'Directory Successfully Renamed!' );
                return $this->response->send( );
            }

            return $this->view->disable( );

        }

        /**
         * Router Delete Folder Prefix
         * @Post( "/delete-folder", "name" = "file-manager-delete-folder" )
         *
         * Set Permission
         * @Acl( "key" = "delete-folder", "name" = "Delete Folder", "description" = "File Manager Delete Folder." )
         */
        public function deleteFolderAction ( ) {

            $this->view->setVar( '_', $language = $this->language->load( array(
                'system'    => 'Index',
                'Common',
                'Index',
            )));

            $name         = $this->request->getPost( 'name' );
            $root_dir     = $this->config->directories->public->files->shared->dir;
            $root_path    = $this->config->directories->public->files->shared->path;
            $source       = $root_dir . $this->request->getPost( 'source_path' );
            $source_cache = $root_dir . $this->request->getPost( 'source_cache_path' );
            $settings     = Setting::getAllByGroup( 'file-manager' );

            if ( !isset( $settings['enable_delete_folders'] ) || $settings['enable_delete_folders']->getValue( ) == false ) {
                $this->response->setContent( 'Permission Denied!' );
                return $this->response->send( );
            }

            if ( !Directory::exists( $source ) ) {
                $this->response->setContent( 'Directory Not Exist!' );
                return $this->response->send( );
            } else {
                Directory::delete( $source );
                Directory::delete( $source_cache );

                $this->response->setContent( 'Directory Successfully Deleted!' );
                return $this->response->send( );
            }

            return $this->view->disable( );

        }

        /**
         * Router Extract Prefix
         * @Post( "/extract", "name" = "file-manager-extract" )
         *
         * Set Permission
         * @Acl( "key" = "extract", "name" = "Extract", "description" = "File Manager Extract." )
         */
        public function extractAction ( ) {

            $this->view->setVar( '_', $language = $this->language->load( array(
                'system'    => 'Index',
                'Common',
                'Index',
            )));

            $name         = $this->request->getPost( 'name' );
            $root_dir     = $this->config->directories->public->files->shared->dir;
            $root_path    = $this->config->directories->public->files->shared->path;
            $source       = $root_dir . $this->request->getPost( 'source_path' );
            $source_cache = $root_dir . $this->request->getPost( 'source_cache_path' );
            $source_dir   = dirname( $source ) . '/';
            $settings     = Setting::getAllByGroup( 'file-manager' );
            $info         = pathinfo( $source );

            // EXTENSION
            $extensions_image                  = explode( ',', $settings['extensions_image']->getValue( ) );
            $extensions_file                   = explode( ',', $settings['extensions_file']->getValue( ) );
            $extensions_video                  = explode( ',', $settings['extensions_video']->getValue( ) );
            $extensions_audio                  = explode( ',', $settings['extensions_audio']->getValue( ) );
            $extensions_misc                   = explode( ',', $settings['extensions_misc']->getValue( ) );
            $extensions                       = array_merge( $extensions_image, $extensions_file, $extensions_video, $extensions_audio, $extensions_misc );

            if ( File::exists( $source ) ) {
                switch ( $info['extension']) {
                    case 'zip':
                        $zip = new \ZipArchive( );

                        if ( $zip->open( $source ) === true ) {
                            for ( $i = 0; $i < $zip->numFiles; $i++ ) {
                                $only_file_name = $zip->getNameIndex( $i );
                                $full_file_name = $zip->statIndex( $i );

                                if ( substr( $full_file_name['name'], -1, 1 ) == '/' ) {
                                    Directory::create(  $source_dir . $full_file_name['name'] );
                                }
                            }

                            for ( $i = 0; $i < $zip->numFiles; $i++ ) {
                                $only_file_name = $zip->getNameIndex( $i );
                                $full_file_name = $zip->statIndex( $i );

                                if ( !( substr( $full_file_name['name'], -1, 1 ) == '/' ) ) {
                                    $fileinfo = pathinfo( $only_file_name );

                                    if ( in_array( strtolower( $fileinfo['extension'] ), $extensions ) ) {
                                        copy( 'zip://' . $source . '#' . $only_file_name, $source_dir . $full_file_name['name'] );
                                    }
                                }
                            }

                            $zip->close( );
                        } else {
                            $this->response->setContent( $language->_( 'text_zip_no_extract' ) );
                            return $this->response->send( );
                        }

                        break;
                    case 'gz':
                        $p = new \PharData( $source );
                        $p->decompress( );

                        break;
                    case 'tar':
                        $phar = new \PharData( $source );
                        $phar->decompressFiles( );

                        $files = array( );

                        function check_files_extensions_on_phar ( $phar, &$files, $basepath, $extensions ) {
                            foreach ( $phar as $file ) {
                                if ( $file->isFile( ) ) {
                                    if ( in_array( mb_strtolower( $file->getExtension( ) ), $extensions ) ) {
                                        $files[] = $basepath . $file->getFileName( );
                                    }
                                } else {
                                    if ( $file->isDir( ) ) {
                                        $iterator = new DirectoryIterator( $file );
                                        check_files_extensions_on_phar( $iterator, $files, $basepath . $file->getFileName( ) . '/', $extensions );
                                    }
                                }
                            }
                        }

                        check_files_extensions_on_phar( $phar, $files, '', $extensions );

                        $phar->extractTo( $source_dir, $files, true );

                        break;
                    default:
                        $this->response->setContent( $language->_( 'text_zip_invalid' ) );
                        return $this->response->send( );

                        break;
                }
            }

            return $this->view->disable( );

        }

        /**
         * Router Change Mode Prefix
         * @Post( "/chmod", "name" = "file-manager-chmod" )
         *
         * Set Permission
         * @Acl( "key" = "chmod", "name" = "Change Mode", "description" = "File Manager Change Mode." )
         */
        public function chmodAction ( ) {

            $this->view_simple->setVar( '_', $language = $this->language->load( array(
                'system'    => 'Index',
                'Common',
                'Index',
            )));

            $name         = $this->request->getPost( 'name' );
            $root_dir     = $this->config->directories->public->files->shared->dir;
            $root_path    = $this->config->directories->public->files->shared->path;
            $source       = $root_dir . $this->request->getPost( 'source_path' );
            $source_cache = $root_dir . $this->request->getPost( 'source_cache_path' );
            $session      = $this->session->get( 'file-manager' );
            $settings     = Setting::getAllByGroup( 'file-manager' );

            if ( ( is_dir( $source ) && $settings['enable_chmod_folders']->getValue( ) === false)
                || ( is_file( $source ) && $settings['enable_chmod_folders']->getValue( ) === false)
                || ( function_exists( 'chmod' ) === false )
            ) {
                $this->response->setContent( sprintf( $language->_( 'text_file_permission_not_allowed' ), ( is_dir( $source ) ? lcfirst( $language->_( 'text_folders' ) ) : lcfirst( $language->_( 'text_files' ) ) ) ) );
                return $this->response->send( );
            } else {

                $permission       = decoct( fileperms( $source ) & 0777 );
                $permission_user  = substr( $permission, 0, 1 );
                $permission_group = substr( $permission, 1, 1 );
                $permission_all   = substr( $permission, 2, 1 );


                function chmod_logic_helper ( $permission, $val ) {
                    $valid = array(
                        1 => array( 1, 3, 5, 7 ),
                        2 => array( 2, 3, 6, 7 ),
                        4 => array( 4, 5, 6, 7 )
                    );

                    if ( in_array( $permission, $valid[$val] ) ) {
                        return true;
                    } else {
                        return false;
                    }
                }

                $this->view_simple->setVar( 'var_is_folder', false );
                $this->view_simple->setVar( 'var_permission', $permission );

                $this->view_simple->setVar( 'var_permission_user_4', chmod_logic_helper( $permission_user, 4 ) );
                $this->view_simple->setVar( 'var_permission_user_2', chmod_logic_helper( $permission_user, 2 ) );
                $this->view_simple->setVar( 'var_permission_user_1', chmod_logic_helper( $permission_user, 1 ) );

                $this->view_simple->setVar( 'var_permission_group_4', chmod_logic_helper( $permission_group, 4 ) );
                $this->view_simple->setVar( 'var_permission_group_2', chmod_logic_helper( $permission_group, 2 ) );
                $this->view_simple->setVar( 'var_permission_group_1', chmod_logic_helper( $permission_group, 1 ) );

                $this->view_simple->setVar( 'var_permission_all_4', chmod_logic_helper( $permission_all, 4 ) );
                $this->view_simple->setVar( 'var_permission_all_2', chmod_logic_helper( $permission_all, 2 ) );
                $this->view_simple->setVar( 'var_permission_all_1', chmod_logic_helper( $permission_all, 1 ) );

                if ( is_dir( $source ) ) {
                    $this->view_simple->setVar( 'var_is_folder', true );
                }

                $this->response->setContent( $this->view_simple->render( 'Mode' ) );
                return $this->response->send( );
            }

            return $this->view->disable( );

        }

        /**
         * Router Change Mode Prefix
         * @Post( "/change-mode", "name" = "file-manager-change-mode" )
         *
         * Set Permission
         * @Acl( "key" = "change-mode", "name" = "Change Mode", "description" = "File Manager Change Mode." )
         */
        public function changeModeAction ( ) {

            $this->view->setVar( '_', $language = $this->language->load( array(
                'system'    => 'Index',
                'Common',
                'Index',
            )));

            $name         = $this->request->getPost( 'name' );
            $root_dir     = $this->config->directories->public->files->shared->dir;
            $root_path    = $this->config->directories->public->files->shared->path;
            $source       = $root_dir . $this->request->getPost( 'source_path' );
            $source_cache = $root_dir . $this->request->getPost( 'source_cache_path' );
            $settings     = Setting::getAllByGroup( 'file-manager' );



            return $this->view->disable( );

        }

        /**
         * Router Clipboard Copy Prefix
         * @Post( "/clipboard-copy", "name" = "file-manager-clipboard-copy" )
         *
         * Set Permission
         * @Acl( "key" = "clipboard-copy", "name" = "Clipboard Copy", "description" = "File Manager Clipboard Copy." )
         */
        public function clipboardCopyAction ( ) {

            $this->view->setVar( '_', $language = $this->language->load( array(
                'system'    => 'Index',
                'Common',
                'Index',
            )));

            $name         = $this->request->getPost( 'name' );
            $root_dir     = $this->config->directories->public->files->shared->dir;
            $root_path    = $this->config->directories->public->files->shared->path;
            $source       = $root_dir . $this->request->getPost( 'source_path' );
            $source_cache = $root_dir . $this->request->getPost( 'source_cache_path' );
            $session      = $this->session->get( 'file-manager' );
            $settings     = Setting::getAllByGroup( 'file-manager' );

            if ( is_dir( $source ) ) {
                if ( !isset( $settings['enable_copy_cut_folders'] ) || $settings['enable_copy_cut_folders']->getValue( ) == false ) {
                    $this->response->setContent( sprintf( $language->_( 'text_copy_cut_not_allowed' ), lcfirst( $language->_( 'text_copy' ) ), $language->_( 'text_folders' ) ) );
                    return $this->response->send( );
                }

                if ( isset( $settings['copy_cut_max_size'] ) && is_int( $settings['copy_cut_max_size']->getValue( ) ) ) {
                    if ( ( $settings['copy_cut_max_size']->getValue( ) * 1024 * 1024 ) < foldersize( $path ) ) {
                        $this->response->setContent( sprintf( $language->_( 'text_copy_cut_size_limit' ), lcfirst( $language->_( 'text_copy' ), $settings['copy_cut_max_size']->getValue( ) ) ) );
                        return $this->response->send( );
                    }
                }

                if ( isset( $settings['copy_cut_max_count'] ) && is_int( $settings['copy_cut_max_count']->getValue( ) ) ) {
                    if ( ( $settings['copy_cut_max_count']->getValue( ) * 1024 * 1024 ) < foldersize( $path ) ) {
                        $this->response->setContent( sprintf( $language->_( 'text_copy_cut_count_limit' ), lcfirst( $language->_( 'text_copy' ), $settings['copy_cut_max_count']->getValue( ) ) ) );
                        return $this->response->send( );
                    }
                }

            } else {
                if ( !isset( $settings['enable_copy_cut_files'] ) || $settings['enable_copy_cut_files']->getValue( ) == false ) {
                    $this->response->setContent( sprintf( $language->_( 'text_copy_cut_not_allowed' ), lcfirst( $language->_( 'text_copy' ) ), $language->_( 'text_files' ) ) );
                    return $this->response->send( );
                }
            }

            $session['clipboard']['action']            = 'copy';
            $session['clipboard']['source_path']       = $this->request->getPost( 'source_path' );
            $session['clipboard']['source_cache_path'] = $this->request->getPost( 'source_cache_path' );

            $this->session->set( 'file-manager', $session );

            return $this->view->disable( );

        }

        /**
         * Router Clipboard Cut Prefix
         * @Post( "/clipboard-cut", "name" = "file-manager-clipboard-cut" )
         *
         * Set Permission
         * @Acl( "key" = "clipboard-cut", "name" = "Clipboard Cut", "description" = "File Manager Clipboard Cut." )
         */
        public function clipboardCutAction ( ) {

            $this->view->setVar( '_', $language = $this->language->load( array(
                'system'    => 'Index',
                'Common',
                'Index',
            )));

            $name         = $this->request->getPost( 'name' );
            $root_dir     = $this->config->directories->public->files->shared->dir;
            $root_path    = $this->config->directories->public->files->shared->path;
            $source       = $root_dir . $this->request->getPost( 'source_path' );
            $source_cache = $root_dir . $this->request->getPost( 'source_cache_path' );
            $session      = $this->session->get( 'file-manager' );
            $settings     = Setting::getAllByGroup( 'file-manager' );

            if ( is_dir( $source ) ) {
                if ( !isset( $settings['enable_copy_cut_folders'] ) || $settings['enable_copy_cut_folders']->getValue( ) == false ) {
                    $this->response->setContent( sprintf( $language->_( 'text_copy_cut_not_allowed' ), lcfirst( $language->_( 'text_cut' ) ), $language->_( 'text_folders' ) ) );
                    return $this->response->send( );
                }

                if ( isset( $settings['copy_cut_max_size'] ) && is_int( $settings['copy_cut_max_size']->getValue( ) ) ) {
                    if ( ( $settings['copy_cut_max_size']->getValue( ) * 1024 * 1024 ) < foldersize( $path ) ) {
                        $this->response->setContent( sprintf( $language->_( 'text_copy_cut_size_limit' ), lcfirst( $language->_( 'text_cut' ), $settings['copy_cut_max_size']->getValue( ) ) ) );
                        return $this->response->send( );
                    }
                }

                if ( isset( $settings['copy_cut_max_count'] ) && is_int( $settings['copy_cut_max_count']->getValue( ) ) ) {
                    if ( ( $settings['copy_cut_max_count']->getValue( ) * 1024 * 1024 ) < foldersize( $path ) ) {
                        $this->response->setContent( sprintf( $language->_( 'text_copy_cut_count_limit' ), lcfirst( $language->_( 'text_cut' ), $settings['copy_cut_max_count']->getValue( ) ) ) );
                        return $this->response->send( );
                    }
                }

            } else {
                if ( !isset( $settings['enable_copy_cut_files'] ) || $settings['enable_copy_cut_files']->getValue( ) == false ) {
                    $this->response->setContent( sprintf( $language->_( 'text_copy_cut_not_allowed' ), lcfirst( $language->_( 'text_cut' ) ), $language->_( 'text_files' ) ) );
                    return $this->response->send( );
                }
            }

            $session['clipboard']['action']            = 'cut';
            $session['clipboard']['source_path']       = $this->request->getPost( 'source_path' );
            $session['clipboard']['source_cache_path'] = $this->request->getPost( 'source_cache_path' );

            $this->session->set( 'file-manager', $session );

            return $this->view->disable( );

        }

        /**
         * Router Clipboard Paste Prefix
         * @Post( "/clipboard-paste", "name" = "file-manager-clipboard-paste" )
         *
         * Set Permission
         * @Acl( "key" = "clipboard-paste", "name" = "Clipboard Paste", "description" = "File Manager Clipboard Paste." )
         */
        public function clipboardPasteAction ( ) {

            $this->view->setVar( '_', $language = $this->language->load( array(
                'system'    => 'Index',
                'Common',
                'Index',
            )));

            $name               = $this->request->getPost( 'name' );
            $root_dir           = $this->config->directories->public->files->shared->dir;
            $root_path          = $this->config->directories->public->files->shared->path;
            $source_path        = $this->request->getPost( 'source_path' );
            $source_cache_path  = $this->request->getPost( 'source_cache_path' );
            $source             = $root_dir . $source_path;
            $source_cache       = $root_dir . $source_cache_path;
            $session            = $this->session->get( 'file-manager' );
            $settings           = Setting::getAllByGroup( 'file-manager' );

            if ( !isset( $session['clipboard']['action'], $session['clipboard']['source_path'], $session['clipboard']['source_cache_path'] )
                || $session['clipboard']['action'] == ''
                || $session['clipboard']['source_path'] == ''
                || $session['clipboard']['source_cache_path'] == '' ) {
                return $this->response->send( );
            }

            $clipboard_info                 = pathinfo( $session['clipboard']['source_path'] );
            $clipboard_action               = $session['clipboard']['action'];
            $clipboard_source_path          = $session['clipboard']['source_path'];
            $clipboard_source_cache_path    = $session['clipboard']['source_cache_path'];
            $clipboard_source               = $root_dir . $clipboard_source_path;
            $clipboard_source_cache         = $root_dir . $clipboard_source_cache_path;

            if ( $clipboard_info['dirname'] == rtrim( $source_path, DS ) ) {
                return $this->response->send( );
            }

            if ( is_dir( $clipboard_source ) && strpos( $clipboard_source, $source ) !== false ) {
                return $this->response->send( );
            }

            if ( $clipboard_action != 'copy' && $clipboard_action != 'cut' ) {
                $this->response->setContent( $language->_( 'text_no_action' ) );
                return $this->response->send( );
            }

            if ( ( is_dir( $source ) && !Directory::writable( $source ) ) || ( is_dir( $source_cache ) && !Directory::writable( $source_cache ) ) ) {
                $this->response->setContent( $language->_( 'text_dir_no_write' ) . '<br/>' . str_replace( '../', '', $source ) . '<br/>' . str_replace( '../', '', $source_cache ) );
                return $this->response->send( );
            } else if ( ( is_file( $source ) && !File::writable( $source ) ) || is_file( $source_cache ) && !File::writable( $source_cache ) ) {
                $this->response->setContent( $language->_( 'text_dir_no_write' ) . '<br/>' . str_replace( '../', '', $source ) . '<br/>' . str_replace( '../', '', $source_cache ) );
                return $this->response->send( );
            }

            if ( function_exists( ( $clipboard_action == 'copy' ? 'copy' : 'rename' ) ) === false ) {
                $this->response->setContent( sprintf( $language->_( 'text_function_disabled' ), lcfirst( ( $clipboard_action == 'copy' ? $language->_( 'text_copy' ) : $language->_( 'text_cut' ) ) ) ) );
                return $this->response->send( );
            }

            $source         = $source . DS . $clipboard_info['basename'];
            $source_cache   = $source_cache . DS . $clipboard_info['basename'];

            if ( $clipboard_action == 'copy' ) {
                if ( is_dir( $clipboard_source ) ) {
                    Directory::copy( $clipboard_source, $source );
                    if ( Directory::exists( $clipboard_source_cache ) ) {
                        Directory::copy( $clipboard_source_cache, $source_cache );
                    }
                } else {
                    File::copy( $clipboard_source, $source );
                    if ( File::exists( $clipboard_source_cache ) ) {
                        File::copy( $clipboard_source_cache, $source_cache );
                    }
                }
            } else if ( $clipboard_action == 'cut' ) {
                if ( is_dir( $clipboard_source ) ) {
                    if ( Directory::copy( $clipboard_source, $source ) ) {
                        Directory::delete( $clipboard_source );
                    }

                    if ( Directory::exists( $clipboard_source_cache ) ) {
                        if ( Directory::copy( $clipboard_source_cache, $source_cache ) ) {
                            Directory::delete( $clipboard_source_cache );
                        }
                    }
                } else {
                    if ( File::copy( $clipboard_source, $source ) ) {
                        File::delete( $clipboard_source );
                    }

                    if ( File::exists( $clipboard_source_cache ) ) {
                        if ( File::copy( $clipboard_source_cache, $source_cache ) ) {
                            File::delete( $clipboard_source_cache );
                        }
                    }
                }
            }

            $session['clipboard'] = null;

            $this->session->set( 'file-manager', $session );

            return $this->view->disable( );

        }

        /**
         * Router Clipboard Clear Prefix
         * @Post( "/clipboard-clear", "name" = "file-manager-clipboard-clear" )
         *
         * Set Permission
         * @Acl( "key" = "clipboard-clear", "name" = "Clipboard Clear", "description" = "File Manager Clipboard Clear." )
         */
        public function clipboardClearAction ( ) {

            $this->view->setVar( '_', $language = $this->language->load( array(
                'system'    => 'Index',
                'Common',
                'Index',
            )));

            $session    = $this->session->get( 'file-manager' );
            $settings   = Setting::getAllByGroup( 'file-manager' );

            $session['clipboard'] = null;

            $this->session->set( 'file-manager', $session );

            return $this->view->disable( );

        }

    } // END CLASS FILEMANAGERCONTROLLER