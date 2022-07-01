<?php

	namespace Application\Packages\Plugins\FileManager;

	class Index extends \Application\Libraries\Engine\Package\Index {

		public function initialize ( $id, $dir, $path ) {

			$this->assets->collection( 'file-manager-css' )
				->setPrefix( $path )
				->addCSS( 'Themes/Stylesheets/file-manager.css' )
				->addCSS( 'Themes/Plugins/JPlayer/skin/blue.monday/jplayer.blue.monday.css' );

			$this->assets->collection( 'file-manager-js' )
				->setPrefix( $path )
				->addJS( 'Themes/Plugins/Aviary/Javascripts/aviary.js' )
				->addJS( 'Themes/Javascripts/file-manager.plugin.js' )
				->addJS( 'Themes/Javascripts/file-manager.js' )
				->addJS( 'Themes/Plugins/JPlayer/jquery.jplayer/jquery.jplayer.js' );

		}

	} // END CLASS INDEX