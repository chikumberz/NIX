<?php

	namespace Application\Packages\Modules\Package;

	class Index extends \Application\Libraries\Engine\Package\Index {

		public function initialize ( ) {

			$this->navigation->insert( array(
				'package' => array(
					'Pakages',
					'function' =>  function ( $navigation, $nav, $content ) {
						if ( $navigation->di->has( 'auth' ) ) {
							if ( $navigation->auth->hasPermission( $nav['module'] . '\\Controllers\\' . $nav['controller'], $nav['action'] ) ) {
								return $navigation->parseTag( 'list', $content );
							}
						} else{
							return $navigation->parseTag( 'list', $content );
						}
					}
				)
			), null,'sidebar' );

		}

	} // END CLASS INDEX