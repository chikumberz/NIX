<?php

	namespace Application\Packages\Modules\User;

	class Index extends \Application\Libraries\Engine\Package\Index {

		public function initialize ( ) {

			$this->di->set( 'acl', function ( ) use ( $app, $di, $config ) {

				$acl = new Models\Acl( );

				return $acl;

			}, true );

			$this->di->set( 'auth', function ( ) use ( $app, $di, $config ) {

				$auth = new Models\Auth( );

				return $auth;

			}, true );

			$events_manager = new \Phalcon\Events\Manager( );
			$events_manager->attach( 'dispatch:beforeDispatch', function ( \Phalcon\Events\Event $event, \Phalcon\Mvc\Dispatcher $dispatcher ) {

				$action 	= $dispatcher->getActionName( );
				$controller = $dispatcher->getModuleName( ) . '\Controllers\\' . $dispatcher->getControllerName( );

				if ( $this->acl->isPrivate( $controller, $action ) ) {

					$identity = $this->auth->getIdentity( );

					if ( is_array( $identity ) ) {
						if ( !$this->acl->isAllowed( $identity['group'], $controller, $action ) ) {
							return  $this->response->redirect( array(
								'for' => 'error-show505'
							));
						}
					} else {
						return $this->response->redirect( array(
							'for' => 'user-login'
						));
					}
				}

			});

			$this->dispatcher->setEventsManager( $events_manager );

			$auth  = $this->auth->getIdentity( );
			$html  = $this->tag->tagHtml( 'span', array( 'class' => 'avatar' ) ) . $this->tag->tagHtml( 'img', array( 'src' => $auth['avatar_tmb'], 'class' => 'round' ), true ) . $this->tag->tagHtmlClose( 'span', true );
			$html .= $this->tag->tagHtml( 'span', array( 'class' => 'name hide-small hide-tiny' ) ) . $auth['full_name_reverse'] . $this->tag->tagHtmlClose( 'span', true );
			$html .= $this->tag->tagHtml( 'span', array( 'class' => 'caret fa fa-caret-down' ) ) . $this->tag->tagHtmlClose( 'span', true );

			$this->navigation->add( array(
				array(
					'user-account' => array(
						$html,
						'attributes' => array(
							'href'	=> 'javascript:void(0);',
						),
						'li-attributes' => array(
							'class'			=> 'user ink-dropdown red',
							'data-target' 	=> '#user-setting-sub'
						),
						'ul-attributes' => array(
							'id'	=> 'user-setting-sub',
							'class' => 'dropdown-menu unstyled no-margin hide-all'
						),
						'::' => array(
							'user-account-view'	=> array(
								'<i class = "fa fa-user quarter-right-space"></i>My Account',
								'url' => array(
									'id' => $auth['id']
								)
							),
							'setting'	=> array(
								'<i class = "fa fa-gear quarter-right-space"></i>Setting'
							),
							'logout' => array(
								'<i class = "fa fa-sign-in quarter-right-space"></i> Logout',
								'li-attributes' => array(
									'class' => 'active separator-above'
								)
							)
						)
					)
				)
			), 'top-nav-right' );

			$this->navigation->before( array(
				'user-account' => array(
					'Users',
					'function' =>  function ( $navigation, $nav, $content ) {
						if ( $navigation->di->has( 'auth' ) ) {
							if ( $navigation->auth->hasPermission( $nav['module'] . '\\Controllers\\' . $nav['controller'], $nav['action'] ) ) {
								return $navigation->parseTag( 'list', $content );
							}
						} else{
							return $navigation->parseTag( 'list', $content );
						}
					},
					'::' => array(
						'user-group' => array(
							'Groups',
						),
						'user-status' => array(
							'Status'
						),
						'user-setting' => array(
							'Setting'
						)
					)
				)
			), 'package', 'sidebar' );
		}

	} // END CLASS INDEX