<?php

	namespace Application\Packages\Modules\Page\Models;

	class Filter extends \Application\Libraries\Engine\Model\Model {

		public static function getAll ( ) {

			$package = parent::getDI( )->get( 'package' );
			$plugins = $package->getAll( 'plugins' );
			$filters = array( );

			foreach ( $plugins as $id => $plugin  ) {
				if ( $plugin['type'] == 'filter' ) {
					$filters[$id] = $plugin['infos']['title'];
				}
			}

			return $filters;

		}

	} // END CLASS FILTER