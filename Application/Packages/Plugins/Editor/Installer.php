<?php

	namespace Application\Packages\Plugins\Editor;

	class Installer implements \Application\Libraries\Engine\Package\InstallerInterface {

		public static function load ( ) {

			return array(
				'title' 		=> 'Editor',
				'description'	=> 'Content Editor.',
				'author'		=> 'Benjamin Taluyo',
				'version'		=> '1.0.0',
				'type'			=> 'filter',
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