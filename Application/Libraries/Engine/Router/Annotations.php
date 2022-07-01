<?php

	namespace Application\Libraries\Engine\Router;

	class Annotations extends \Phalcon\Mvc\Router\Annotations {

		public function processControllerAnnotation ( $handler, $annotation ) {

			$expr_arguments = $annotation->getExprArguments( );

			$url_prefixes  	= $this->getDI( )->get( 'config' )->urls->prefixes->toArray( );
			$url_searchs 	= array( );
			$url_values 	= array( );

			foreach ( $url_prefixes as $url_search => $url_value ) {
				$url_searchs[] 	= $url_search;
				$url_values[] 	= $url_value;
			}

			foreach ( $expr_arguments as $key => $expr_argument ) {
				if ( isset( $expr_argument['expr']['value'] ) ) {
					$expr_arguments[$key]['expr']['value'] = str_replace( $url_searchs, $url_values,  $expr_argument['expr']['value'] );
				}
			}

			$annotation = new \Phalcon\Annotations\Annotation( array(
				'name' => $annotation->getName( ),
				'arguments' => $expr_arguments
			));

			return parent::processControllerAnnotation ( $handler, $annotation );

		}

	} // END CLASS ANNOTATIONS