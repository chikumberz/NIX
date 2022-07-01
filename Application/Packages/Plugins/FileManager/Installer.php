<?php

	namespace Application\Packages\Plugins\FileManager;

	class Installer implements \Application\Libraries\Engine\Package\InstallerInterface {

		public static function load ( ) {

			return array(
				'title' 		=> 'File Manager',
				'description'	=> 'File Manager.',
				'author'		=> 'Benjamin Taluyo',
				'version'		=> '1.0.0',
				'type'			=> 'filemanager',
				'website'		=> 'http://localhost/'
			);

		}

		public static function install ( ) {

		}

		public static function uninstall ( ) {

		}

		public static function enable ( ) {

		}

		public static function disable ( ) {

		}

	} // END CLASS INSTALLER