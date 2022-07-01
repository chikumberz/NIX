<?php

	namespace Application\Packages\Modules\Setting;

	class Index extends \Application\Libraries\Engine\Package\Index {

		public function initialize ( ) {

			$this->navigation->add( array(
				array(
					'setting' => array(
						'Settings',
						'function' =>  function ( $navigation, $nav, $content ) {
							if ( $navigation->di->has( 'auth' ) ) {
								if ( $navigation->auth->hasPermission( $nav['module'] . '\\Controllers\\' . $nav['controller'], $nav['action'] ) ) {
									return $navigation->parseTag( 'list', $content );
								}
							} else{
								return $navigation->parseTag( 'list', $content );
							}
						}
					),
				)
			), 'sidebar' );

		}

	} // END CLASS INDEX