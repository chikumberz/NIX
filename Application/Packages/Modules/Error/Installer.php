<?php

	namespace Application\Packages\Modules\Error;

	class Installer implements \Application\Libraries\Engine\Package\InstallerInterface {

		public static function load ( ) {

			return array(
				'title' 		=> 'Error',
				'description'	=> 'Error Manager.',
				'author'		=> 'Benjamin Taluyo',
				'version'		=> '1.0.0',
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