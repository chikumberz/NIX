<?php

	namespace Application\Packages\Modules\Page;

	class Index extends \Application\Libraries\Engine\Package\Index {

		public function initialize ( ) {

			$this->navigation->before( array(
				'page' => array(
					'Pages',
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
			), 'package', 'sidebar' );

		}

	} // END CLASS INDEX