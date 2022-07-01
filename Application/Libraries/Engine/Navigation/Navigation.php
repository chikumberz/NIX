<?php

	namespace Application\Libraries\Engine\Navigation;

	class Navigation extends \Phalcon\Mvc\User\Component {

		protected $_options 	= array();
		protected $_navigation 	= array( );

		public function __construct ( $options = array( ) ) {

			$defaults = array(
				'tags'	=> array(
					'link'			=> array(
						'tag' 			=> 'a',
						'attributes' 	=> array( )
					),
					'text'			=> array(
						'tag' 			=> 'span',
						'attributes' 	=> array( )
					),
					'ul'			=> array(
            			'tag'			=> 'ul',
            			'attributes'	=> array( )
            		),
					'list'			=> array(
            			'tag'			=> 'li',
            			'attributes'	=> array( )
            		),
				),
				'css' 	=> array(
					'navigation' 		=> 'navigation',
					'navigation_sub' 	=> 'navigation-sub',
					'active' 			=> 'active',
					'hidden' 			=> 'hidden',
				)
			);

			$this->setOptions( array_merge( $defaults, $options ) );

		}

		public function setOptions ( $options, $value = false ) {

			if ( is_array( $options ) ) {
				$this->_options = array_merge( $this->_options, $options );
			} else {
				$this->_options[$options] = $value;
			}

			return $this;

		}

		public function getOptions ( $key = false ) {

			if ( $key ) {
				if ( isset( $this->_options[$key] ) ) {
					$option =  $this->_options[$key];
				} else {
					$option = false;
				}
			} else {
				$option =  $this->_options;
			}

			return $option;

		}

		public function setTags ( $tags = array( ) ) {

			$tags = array_merge( $this->getOptions( 'tags' ), $tags );

			$this->setOptions( 'tags', $tags );

			return $this;

		}

		public function getTags ( $tag ) {

			$tags = $this->getOptions( 'tags' );

			if ( array_key_exists( $tag, $tags ) )
				return $tags[$tag];

			else
				return false;

			return $tags;

		}

		public function parseTag ( $tag, $value = '', $attributes = array( ) ) {

			$tag 		= $this->getTags( $tag );
			$html_tag 	= '';

			if ( $tag ) {
				$html_tag_name 			= $tag['tag'];
				$html_tag_attributes 	= array_merge( $tag['attributes'], $attributes );

				$html_tag .= $this->tag->tagHtml( $html_tag_name, $html_tag_attributes );

				if ( !$value && isset( $tag['value'] ) ) {
					$html_tag .= $tag['value'];
				} else {
					$html_tag .= $value;
				}

				$html_tag .= $this->tag->tagHtmlClose( $html_tag_name, true );
			}

			return $html_tag;

		}

		public function getCSS ( $name = false ) {

			$css = $this->getOptions( 'css' );

			if ( $name && array_key_exists( $name, $css ) ) {
				return $css[$name];
			}

			return false;

		}

		public function getNavigation ( $key = null, $return = array( ) ) {

			if ( $key != null && array_key_exists( $key, $this->_navigation ) )
				return $this->_navigation[$key];
			else if ( $key != null )
				return $return;

			return $this->_navigation;

		}

		public function has ( $key ) {

			if ( !$this->getNavigation( $key, false ) )
				return false;

			return true;

		}

		public function insert ( array $navigation, $needles = null, $key = null ) {

			if ( $key !== null ){
				if ( !isset( $this->_navigation[$key] ) )
					$this->_navigation[$key] = array( );

				$this->loopInsert( $navigation, $needles, $this->_navigation[$key] );
			} else {
				$this->loopInsert( $navigation, $needles, $this->_navigation );
			}

			return $this;

		}

		private function loopInsert ( array $nav, $needles = null, array &$navigation ) {

			$needles = explode( ':', $needles );
			$needles = array_filter( $needles );

			if ( !empty( $needles ) ) {
				$needle = $needles[0]; unset( $needles[0] );
			} else {
				$needle = null;
			}

			if ( array_key_exists( $needle, $navigation ) ) {
				if ( count( $needles ) == 0 ) {
					if ( !isset( $navigation[$needle]['::'] ) ) $navigation[$needle]['::'] = array( );
						$navigation[$needle]['::'] = array_merge( $navigation[$needle]['::'], $nav );
				} else {
					$needles = implode( ':', $needles );
					if ( isset( $navigation[$needle]['::'] ) ) {
						$this->loopInsert( $nav, $needles, $navigation[$needle]['::'] );
					}
				}
			} else {
				$navigation = array_merge( $navigation, $nav );
			}


		}

		public function before ( array $navigation, $needles = null, $key = null ) {

			if ( $key !== null ){
				if ( !isset( $this->_navigation[$key] ) )
					$this->_navigation[$key] = array( );

				$this->loopBefore( $navigation, $needles, $this->_navigation[$key] );
			} else {
				$this->loopBefore( $navigation, $needles, $this->_navigation );
			}

			return $this;

		}

		private function loopBefore ( array $nav, $needles = null, array &$navigation ) {

			$needles = explode( ':', $needles );
			$needles = array_filter( $needles );

			if ( !empty( $needles ) ) {
				$needle = $needles[0]; unset( $needles[0] );
			} else {
				$needle = null;
			}

			if ( array_key_exists( $needle, $navigation ) ) {
				if ( count( $needles ) == 0 ) {
					$_navigation_index 	= array_search( $needle, array_keys( $navigation ) );
					$_navigation_array 	= array_splice( $navigation, 0, $_navigation_index );
					$_navigation_merge 	= array_merge( $_navigation_array, $nav, $navigation );
					$navigation = $_navigation_merge;
				} else {
					$needles = implode( ':', $needles );
					if ( isset( $navigation[$needle]['::'] ) ) {
						$this->loopBefore( $nav, $needles, $navigation[$needle]['::'] );
					}
				}
			}

		}

		public function after ( array $navigation, $needles = null ) {

			if ( $key !== null ){
				if ( !isset( $this->_navigation[$key] ) )
					$this->_navigation[$key] = array( );

				$this->loopAfter( $navigation, $needles, $this->_navigation[$key] );
			} else {
				$this->loopAfter( $navigation, $needles, $this->_navigation );
			}

			return $this;

		}

		private function loopAfter ( array $nav, $needles = null, array &$navigation ) {

			$needles = explode( ':', $needles );
			$needles = array_filter( $needles );

			if ( !empty( $needles ) ) {
				$needle = $needles[0]; unset( $needles[0] );
			} else {
				$needle = null;
			}

			if ( array_key_exists( $needle, $navigation ) ) {
				if ( count( $needles ) == 0 ) {
					$_navigation_index 	= array_search( $needle, array_keys( $navigation ) );
					$_navigation_array 	= array_splice( $navigation, 0, $_navigation_index + 1 );
					$_navigation_merge 	= array_merge( $_navigation_array, $nav, $navigation );
					$navigation = $_navigation_merge;
				} else {
					$needles = implode( ':', $needles );
					if ( isset( $navigation[$needle]['::'] ) ) {
						$this->loopAfter( $nav, $needles, $navigation[$needle]['::'] );
					}
				}
			}

		}

		public function add ( array $navigation, $key = null ) {

			foreach ( $navigation as $needles => $nav ) {
				$needles = explode( ':', $needles );

				if ( in_array( 'before', $needles ) ) {
					unset( $needles[array_search( 'before', $needles )] );
					$this->before( $nav, implode( ':', array_filter( $needles ) ), $key );
				} else if ( in_array( 'after', $needles ) ) {
					unset( $needles[array_search( 'after', $needles )] );
					$this->after( $nav, implode( ':', array_filter( $needles ) ), $key );
				} else {
					unset( $needles[array_search( 'insert', $needles )] );
					$this->insert( $nav, implode( ':', array_filter( $needles ) ), $key );
				}
			}

			return $this;

		}

		private function prerender ( array $navigation, $attributes = array( ), $apply = null ) {

			$list = '';
			foreach ( $navigation as $id => $nav ) {

				$package = $this->router->getRouteByName( $id );

				if ( !isset( $nav['attributes']['id'] ) ) {
					$nav['attributes']['id'] = $id;
				}

				if ( !isset( $nav['attributes']['class'] ) ) {
					$nav['attributes']['class'] = '';
				}

				if ( !isset( $nav['li-attributes']['class'] ) ) {
					$nav['li-attributes']['class'] = '';
				}

				if ( !isset( $nav['ul-attributes']['class'] ) ) {
					$nav['ul-attributes']['class'] = '';
				}

				if ( is_object( $package ) ) {
					$path 					= $package->getPaths( );
					$nav['module']		 	= $path['module'];
					$nav['controller'] 		= $path['controller'];
					$nav['action']	 		= $path['action'];

					if ( $this->router->getModuleName( ) == $nav['module']
						&& $this->router->getControllerName( ) == $nav['controller']
						&& $this->router->getActionName( ) == $nav['action'] ) {
						$nav['attributes']['class'] 	.= ' ' . $this->getCSS( 'active' );
						$nav['li-attributes']['class'] 	.= ' ' . $this->getCSS( 'active' );
						$nav['ul-attributes']['class'] 	.= ' ' . $this->getCSS( 'active' );
					}

					if ( !isset( $nav['attributes']['href'] ) ) {
						if ( !isset( $nav['url'] ) ) {
							$nav['url'] = array( 'for' => $id );
						} else {
							$nav['url'] = array_merge( array( 'for' => $id ), $nav['url'] );
						}

						$nav['attributes']['href'] = $this->url->get( $nav['url'] );
					}
				} else if ( isset( $nav['module'] ) && isset( $nav['controller'] ) && isset( $nav['action'] ) ) {
					if ( $this->router->getModuleName( ) == $path['module']
						&& $this->router->getControllerName( ) == $path['controller']
						&& $this->router->getActionName( ) == $path['action'] ) {
						$nav['attributes']['class'] 	.= ' ' . $this->getCSS( 'active' );
						$nav['li-attributes']['class'] 	.= ' ' . $this->getCSS( 'active' );
						$nav['ul-attributes']['class'] 	.= ' ' . $this->getCSS( 'active' );
					}
				}

				$list_content = $this->parseTag(
					( isset( $nav['tag'] ) ? $nav['tag'] : 'link' ),
					( isset( $nav[0] ) ? $nav[0] : null ),
					$nav['attributes']
				);

				if ( isset( $nav['::'] ) ) {
					$sub_nav_attributes 			= isset( $nav['ul-attributes'] ) ? $nav['ul-attributes'] : array( );
					$sub_nav_attributes['class'] 	= isset( $sub_nav_attributes['class'] ) ? $sub_nav_attributes['class'] . ' ' . $this->getCSS( 'navigation_sub' ) : $this->getCSS( 'navigation_sub' );

					if ( isset( $nav['function'] ) && is_callable( $nav['function'] ) ) {
						$list_content .= $this->prerender( $nav['::'], $sub_nav_attributes, $nav['function'] );
					} else {
						$list_content .= $this->prerender( $nav['::'], $sub_nav_attributes, $apply );
					}
				}

				if ( isset( $nav['function'] ) && is_callable( $nav['function'] ) ) {
					$list .= $nav['function']( $this, $nav, $list_content );
				} else if ( is_callable( $apply ) ) {
					$list .= $apply( $this, $nav, $list_content );
				} else {
					$list .= $this->parseTag( 'list', $list_content, ( isset( $nav['li-attributes'] ) ? $nav['li-attributes'] : array( ) ) );
				}
			}

			if ( !isset( $attributes['class'] )) {
				$attributes['class'] = $this->getCSS( 'navigation' );
			}

			return $this->parseTag( 'ul', $list, $attributes );

		}

		public function render ( $key = null, $attributes = array( ) ) {

			return $this->prerender( $this->getNavigation( $key ), $attributes );

		}


	} // END CLASS NAVIGATION