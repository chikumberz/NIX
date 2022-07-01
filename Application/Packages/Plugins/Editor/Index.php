<?php

	namespace Application\Packages\Plugins\Editor;

	use \Application\Packages\Modules\Setting\Models\Setting;

	class Index extends \Application\Libraries\Engine\Package\Index {

		public function initialize ( $id, $dir, $path ) {

			$settings = Setting::getAllByGroup( 'editor' );

			$config = array(
				'mode'                     => $settings['mode']->getValue( ),
				'theme'                    => $settings['theme']->getValue( ),
				'toolbar'                  => $settings['toolbar']->getValue( ),
				'plugins'                  => $settings['plugins']->getValue( ),
				'statusbar'                => ( boolean ) $settings['show_statusbar']->getValue( ),
				'menubar'                  => ( boolean ) $settings['show_menubar']->getValue( ),
				'force_p_newlines'         => ( boolean ) $settings['force_p_newlines']->getValue( ),
				'force_br_newlines'        => ( boolean ) $settings['force_br_newlines']->getValue( ),
				'forced_root_block'        => ( boolean ) $settings['forced_root_block']->getValue( ),
				'convert_newlines_to_brs'  => ( boolean ) $settings['convert_newlines_to_brs']->getValue( ),
				'paste_text_linebreaktype' => $settings['paste_text_linebreaktype']->getValue( ),
				'relative_urls'            => ( boolean ) $settings['relative_urls']->getValue( ),
				'external_plugins'		   => array(
					'filemanager' => 'http://localhost/NIX/Application/Packages/Plugins/FileManager/Themes/Javascripts/file-manager.to.editor.plugin.js'
				),
				'filemanager_title'        => $settings['filemanager_title']->getValue( ),
				'filemanager_path'         => $settings['filemanager_path']->getValue( ),
				'filemanager_folder'       => $settings['filemanager_folder']->getValue( ),
				'filemanager_sort_by'      => $settings['filemanager_sort_by']->getValue( ),
				'filemanager_sort_order'   => $settings['filemanager_sort_order']->getValue( ),
				'filemanager_crossdomain'  => ( boolean ) $settings['filemanager_crossdomain']->getValue( ),
			);

			$this->assets->addCSS( $path . 'Themes/Stylesheets/editor.css' );

			$this->assets->addJS( $path . 'Themes/Javascripts/tinymce.min.js' );
			$this->assets->addJS( $path . 'Themes/Javascripts/jquery.tinymce.min.js' );
			$this->assets->addJS( $path . 'Themes/Javascripts/editor.js.php?' . http_build_query( array( 'config' => json_encode( $config ) ) ) );

		}

	} // END CLASS INDEX