<?php

	namespace Application\Libraries\Engine\Event;

	class Dispatcher extends \Phalcon\Mvc\User\Component {

		public function beforeDispatchLoop ( \Phalcon\Events\Event $event, \Phalcon\Mvc\Dispatcher $dispatcher ) {

		}

		public function beforeException ( \Phalcon\Events\Event $event, \Phalcon\Mvc\Dispatcher $dispatcher, $exception ) {

			if ( $exception instanceof \Phalcon\Mvc\Dispatcher\Exception ) {
				return $dispatcher->forward( array(
					'for' => 'error-show404'
				));
			}

			if ( $event->getType( ) == 'beforeException' ) {

				switch ( $exception->getCode( ) ) {
					case \Phalcon\Mvc\Dispatcher::EXCEPTION_HANDLER_NOT_FOUND:
					case \Phalcon\Mvc\Dispatcher::EXCEPTION_ACTION_NOT_FOUND:
						return $dispatcher->forward( array(
							'for' => 'error-show404'
						));
				}

			}

		}

		public function beforeExecuteRoute ( \Phalcon\Events\Event $event, \Phalcon\Mvc\Dispatcher $dispatcher ) {

			$annotations = $this->annotations->getMethod(
				$dispatcher->getActiveController( ),
				$dispatcher->getActiveMethod( )
			);

			if ( $annotations->has( 'Cache' ) ) {

				$annnotation 	= $annotations->get( 'Cache' );

				$cache_options 	= array(
					'lifetime' => $annotation->getNamedParameter( 'lifetime' )
				);

				if ( $annotation->hasNamedParameter( 'key' ) ) {
					$cache_options['key'] = $annotation->getNamedParameter( 'key' );
				}

				$this->view->cache( $cache_options );
			}

		}

	} // END CLASS DISPATCHER