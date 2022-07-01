<?php

	namespace Application\Libraries\Engine\Package;


	interface InstallerInterface {

		public static function load ( );

		public static function install ( );

		public static function uninstall ( );

		public static function enable ( );

		public static function disable ( );

	} // END INTERFACE INSTALLER