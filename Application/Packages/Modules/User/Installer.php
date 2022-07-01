<?php

	namespace Application\Packages\Modules\User;

	class Installer implements \Application\Libraries\Engine\Package\InstallerInterface {

		public static function load ( ) {

			return array(
				'title' 		=> 'User',
				'description'	=> 'User Manager.',
				'author'		=> 'Benjamin Taluyo',
				'version'		=> '1.0.0'
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