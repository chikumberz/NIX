<?php

	namespace Application\Libraries\Engine\Paginator;

    use \Phalcon\Paginator\AdapterInterface;

	class Paginator extends \Phalcon\Mvc\User\Component {

        protected $adapter          = false;
		protected $adapter_data     = false;
		protected $options 			= array( );

		public function __construct ( $adapter = false, array $options = array( ) ) {

            if ( $adapter instanceof AdapterInterface ) {
    			$this->adapter       = $adapter;
                $this->adapter_data  = $adapter->getPaginate( );
            }

            $defaults = array(
            	'tags'		=> array(
            		'link'			=> array(
						'tag' 			=> 'a',
						'attributes' 	=> array( )
					),
					'text'			=> array(
						'tag' 			=> 'span',
						'attributes' 	=> array( )
					),
            		'wrapper'		=> array(
            			'tag'			=> 'ul',
            			'attributes'	=> array(
            				'class'	=> 'pagination'
            			)
            		),
            		'list'			=> array(
            			'tag'			=> 'li',
            			'attributes'	=> array( )
            		),
            		'hellip'		=> array(
            			'tag'			=> 'span',
            			'value'			=> '&hellip;',
            			'attributes'	=> array(
            				'class'	=> 'hellip'
            			)
            		),
            		'divider'		=> array(
            			'tag'			=> 'span',
            			'value'			=> '|',
            			'attributes'	=> array(
            				'class'	=> 'divider',
            			)
            		),
            		'page_current_input'=> array(
            			'tag'			=> 'div',
            			'value'			=> 'Page <input name = ":page_query_string" value = ":value" class = "current"  size = "1" onkeyup = "var e = window.event, url = \':url\'; if ( e.which == 13 ) window.location = url.replace( \'{page}\', this.value );"/> of :total_pages',
            			'attributes'	=> array(
            				'class'	=> 'current'
            			)
            		),
            		'page_current_text' => array(
            			'tag'			=> 'span',
            			'attributes'	=> array(
            				'class'	=> 'current'
            			)
            		),
            		'page_previous_link'=> array(
            			'tag'			=> 'a',
            			'value'			=> 'Previous',
            			'attributes'	=> array(
            				'class'	=> 'previous'
            			)
            		),
            		'page_previous_text'=> array(
            			'tag'			=> 'span',
            			'value'			=> 'Previous',
            			'attributes'	=> array(
            				'class'	=> 'previous'
            			)
            		),
            		'page_next_link' 	=> array(
            			'tag'			=> 'a',
            			'value'			=> 'Next',
            			'attributes'	=> array(
            				'class'	=> 'next'
            			)
            		),
            		'page_next_text'	=> array(
            			'tag'			=> 'span',
            			'value'			=> 'Next',
            			'attributes'	=> array(
            				'class'	=> 'next'
            			)
            		),
            		'page_first_link' 	=> array(
            			'tag'			=> 'a',
            			'value'			=> 'First',
            			'attributes'	=> array(
            				'class'	=> 'first'
            			)
            		),
            		'page_first_text'	=> array(
            			'tag'			=> 'span',
            			'value'			=> 'First',
            			'attributes'	=> array(
            				'class'	=> 'first'
            			)
            		),
            		'page_last_link' 	=> array(
            			'tag'			=> 'a',
            			'value'			=> 'Last',
            			'attributes'	=> array(
            				'class'	=> 'last'
            			)
            		),
            		'page_last_text'	=> array(
            			'tag'			=> 'span',
            			'value'			=> 'Last',
            			'attributes'	=> array(
            				'class'	=> 'last'
            			)
            		),
            		'page_summary'		=> array(
            			'tag'			=> 'span',
            			'value'			=> 'Showing <span class = "current_page">:current_page</span> <span class = "mdash">&mdash;</span> <span class = "total_pages">:total_pages</span> of <span class = "total_items">:total_items</span> items',
            			'attributes'	=> array(
            				'class'	=> 'summary'
            			)
            		),
            		'show'				=> array(
            			'tag'			=> 'select',
            			'attributes'	=> array(

            			)
            		),
            		'show_option'		=> array(
            			'tag'			=> 'option',
            			'attributes'	=> array( )
            		)
            	),

                'show_enabled'       	=> true,
                'show_position'			=> 'left',
                'show_options'          => array( 10, 20, 30, 40, 50, 100 ),

                'url'                   => '?',
                'page_query_string'     => 'page',
                'show_query_string'     => 'show',
                'style'                 => 'default', 	// classic, digg, extended, punbb, default
            );

			$this->setOptions( array_merge( $defaults, $options ) );
			$this->initialize( );

		}

		public function initialize ( ) {

            $url_query = $this->request->getQuery( );
            $url_query[$this->getOptions( 'page_query_string' )] = $this->getUrlKey( 'page_query_string' );
            $url_query[$this->getOptions( 'show_query_string' )] = $this->getUrlKey( 'show_query_string' );

           $this->setOptions( 'url', $this->getOptions( 'url' ) . $this->parseUrlQueryKey( $url_query ) );

		}

        public function setAdapter ( AdapterInterface $adapter ) {

            $this->adapter       = $adapter;
            $this->adapter_data  = $adapter->getPaginate( );

        }

        public function setOptions ( $options, $value = false ) {

			if ( is_array( $options ) ) {
				$this->options = array_merge( $this->options, $options );
			} else {
				$this->options[$options] = $value;
			}

			return $this;

		}

		public function getOptions ( $key = false ) {

			if ( $key ) {
				if ( isset( $this->options[$key] ) ) {
					$option =  $this->options[$key];
				} else {
					$option = false;
				}
			} else {
				$option =  $this->options;
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

		public function getItems ( ) {

	    	return $this->adapter_data->items;

	    }

	    public function getTotalItems ( ) {

        	return intval( $this->adapter_data->total_items );

    	}

        public function getItemsPerPage ( ) {

            return intval( $this->adapter->getLimit( ) );

        }

    	public function getTotalPages ( ) {

        	return intval( $this->adapter_data->total_pages );

    	}

    	public function hasItems ( ) {

        	return $this->getTotalItems( ) > 0;

    	}

	    public function getCurrentPage ( ) {

	        return $this->adapter->getCurrentPage( );

	    }

        public function getCurrentFirstItem ( ) {

            return ( int ) min( ( ( $this->getCurrentPage( ) - 1 ) * $this->getItemsPerPage( ) ) + 1, $this->getTotalPages( ) );

        }

        public function getCurrentLastItem ( ) {

            return ( int ) min( ( $this->getCurrentFirstItem( ) + $this->getItemsPerPage( ) ) - 1, $this->getTotalPages( ) );

        }

	    public function getFirstPage ( ) {

	        return $this->adapter_data->first;

	    }

	    public function getPreviousPage ( ) {

	        return $this->adapter_data->before;

	    }

	    public function getNextPage ( ) {

	        return $this->adapter_data->next;

	    }

	    public function getLastPage ( ) {

	        return $this->adapter_data->last;

	    }

	    public function getIterator ( ) {

	        if ( !$this->getItems( ) instanceof \Iterator ) {
	            return new \ArrayIterator( $this->getItems( ) );
	        }

	        return $this->getItems( );

	    }

        public function isShowEnabled ( ) {

            return ( boolean ) $this->getOptions( 'show_enabled' );

        }

         public function isShowPosition ( $position ) {

            return ( boolean ) ( $this->getOptions( 'show_position' ) == $position );

        }

        public function getUrl ( ) {

            return $this->getOptions( 'url' );

        }

        public function getUrlKey ( $query_string ) {

        	return '{' . $this->getOptions( $query_string ) . '}';

        }

        public function parseUrlQueryKey ( $url_query ) {

        	return str_replace( array(
                '%7B' . $this->getOptions( 'page_query_string' ) . '%7D',
                '%7B' . $this->getOptions( 'show_query_string' ) . '%7D',
            ), array(
                $this->getUrlKey( 'page_query_string' ),
                $this->getUrlKey( 'show_query_string' ),
            ), http_build_query( $url_query ));

        }

		public function parseUrlQueryString ( $url, $query_string, $value ) {

            return str_replace( $this->getUrlKey( $query_string ), $value, $url );

        }

        public function getPageShowUrl ( $page = false, $show = false, $url = false ) {

        	if ( $page === false )
        		$page = $this->request->getQuery( $this->getOptions( 'page_query_string' ), 'int' );

        	if ( $show === false )
        		$show = $this->request->getQuery( $this->getOptions( 'show_query_string' ), 'int' );

        	if ( $url === false )
        		$url = $this->getUrl( );

        	$url = $this->parseUrlQueryString( $url, 'page_query_string', $page );
        	$url = $this->parseUrlQueryString( $url, 'show_query_string', $show );

        	return $url;

        }

        public function parseWrapperTag ( $content ) {

            return $this->parseTag( 'wrapper', $content );

        }

        public function parseListTag ( $content ) {

            return $this->parseTag( 'list', $content );
        }

        public function parseHellipTag ( ) {

            return $this->parseTag( 'hellip' );

        }

        public function parseDividerTag ( ) {

            return $this->parseTag( 'divider' );

        }

        public function parseShowTag ( $content ) {

            return $this->parseTag( 'show', $content, array(
            	'name' 		=> $this->getOptions( 'show_query_string' ),
            	'onchange'	=> 'window.location = this.value;'
            ));

        }

        public function parseShowOptionTag ( $is_active = false, $content ) {

            if ( $is_active ) {
                $tag = $this->parseTag( 'show_option', $content, array(
                	'value'		=> $this->getPageShowUrl( $this->getFirstPage( ), $content ),
                	'selected' 	=> 'selected',
                ));
            } else {
                $tag = $this->parseTag( 'show_option', $content,array(
                	'value'		=> $this->getPageShowUrl( $this->getFirstPage( ), $content )
                ));
            }

            return $tag;

        }

        public function parseLinkTag ( $value ) {

            return $this->parseTag( 'link', $value, array(
            	'href' => $this->getPageShowUrl( $value )
            ));

        }

        public function parseCurrentTag ( $is_text = false ) {

            if ( $is_text ) {
                $tag = $this->parseTag(  'page_current_text', $this->getCurrentPage( ) );
            } else {
                $tag = str_replace( array(
                	':page_query_string', ':value', ':total_pages', ':url'
                ), array(
                	$this->getOptions( 'page_query_string' ),
                	$this->getCurrentPage( ),
                	$this->getTotalPages( ),
                	$this->getPageShowUrl( $this->getUrlKey( 'page_query_string' ) ),
                ), $this->parseTag( 'page_current_input' ) );
            }

            return $tag;

        }

        public function parseFirstTag ( $is_text = false ) {

            if ( $is_text ) {
                $tag = $this->parseTag(  'page_first_text' );
            } else {
                $tag = $this->parseTag( 'page_first_link', false, array(
	            	'href' => $this->getPageShowUrl( $this->getFirstPage( ) )
	            ));
            }

            return $tag;

        }

        public function parseLastTag ( $is_text = false ) {

            if ( $is_text ) {
                $tag = $this->parseTag(  'page_last_text' );
            } else {
                $tag = $this->parseTag( 'page_last_link', false, array(
	            	'href' => $this->getPageShowUrl( $this->getLastPage( ) )
	            ));
            }

            return $tag;

        }

        public function parseNextTag ( $is_text = false ) {

            if ( $is_text ) {
                $tag = $this->parseTag(  'page_next_text' );
            } else {
                $tag = $this->parseTag( 'page_next_link', false, array(
	            	'href' => $this->getPageShowUrl( $this->getNextPage( ) )
	            ));
            }

            return $tag;

        }

        public function parsePreviousTag ( $is_text = false ) {

            if ( $is_text ) {
                $tag = $this->parseTag(  'page_previous_text' );
            } else {
                $tag = $this->parseTag( 'page_previous_link', false, array(
	            	'href' => $this->getPageShowUrl( $this->getPreviousPage( ) )
	            ));
            }

            return $tag;

        }

        public function parseSummaryTag ( ) {

            return str_replace( array(
                ':current_page',
                ':total_pages',
                ':total_items'
            ), array(
                $this->getCurrentPage( ),
                $this->getTotalPages( ),
                $this->getTotalItems( )
            ), $this->parseTag( 'page_summary' ) );

        }

        public function buildWrapperTag ( $content ) {

            return $this->parseWrapperTag( $content );

        }

        public function buildHellipTag ( ) {

            return $this->parseListTag( $this->parseHellipTag( ) );

        }

        public function buildDividerTag ( ) {

            return $this->parseListTag( $this->parseDividerTag( ) );

        }

        public function buildShowTag ( ) {

            $tag = '';

            foreach ( $this->getOptions( 'show_options' ) as $opt ) {
                if ( $this->getItemsPerPage( ) == $opt ) {
                    $tag .= $this->parseShowOptionTag( true, $opt );
                } else {
                    $tag .= $this->parseShowOptionTag( false, $opt );
                }
            }

            return $this->parseListTag( $this->parseShowTag( $tag ) );

        }

        public function buildLinkTag ( $is_text = false ) {

            return $this->parseListTag( $this->parseLinkTag( $is_text ) );

        }

        public function buildCurrentTag ( $is_text = false ) {

            return $this->parseListTag( $this->parseCurrentTag( $is_text ) );

        }

        public function buildFirstTag ( ) {

            if ( $this->getFirstPage( ) && $this->getCurrentPage( ) != $this->getFirstPage( ) ) {
                $tag = $this->parseFirstTag( );
            } else {
                $tag = $this->parseFirstTag( true );
            }

            return $this->parseListTag( $tag );

        }

        public function buildLastTag ( ) {

            if ( $this->getLastPage( ) && $this->getCurrentPage( ) != $this->getLastPage( ) ) {
                $tag = $this->parseLastTag( );
            } else {
                $tag = $this->parseLastTag( true );
            }

            return $this->parseListTag( $tag );

        }

        public function buildNextTag ( ) {

            if ( $this->getNextPage( ) && $this->getCurrentPage( ) != $this->getLastPage( ) ) {
                $tag = $this->parseNextTag( );
            } else {
                $tag = $this->parseNextTag( true );
            }

            return $this->parseListTag( $tag );
        }

        public function buildPreviousTag ( ) {

            if ( $this->getPreviousPage( ) && $this->getCurrentPage( ) != $this->getFirstPage( ) ) {
                $tag = $this->parsePreviousTag( );
            } else {
                $tag = $this->parsePreviousTag( true );
            }

            return $this->parseListTag( $tag );

        }

        public function buildSummaryTag ( ) {

            return $this->parseListTag( $this->parseSummaryTag( ) );

        }

        public function render ( ) {

            $output = '';

            if ( $this->isShowEnabled( ) && $this->isShowPosition( 'left' ) ) {
                $output .= $this->buildShowTag( );
                $output .= $this->buildDividerTag( );
            }

            switch ( $this->getOptions( 'style' ) ) {

                /* First | Previous | {1} 2 3 | Next | Last */
                case 'classic':

                    $output .= $this->buildFirstTag( );
                    $output .= $this->buildDividerTag( );
                    $output .= $this->buildPreviousTag( );
                    $output .= $this->buildDividerTag( );

                    for ( $i = 1; $i <= $this->getTotalPages( ); $i++ ) {
                        if ( $i == $this->getCurrentPage( ) ) {
                            $output .= $this->buildCurrentTag( true );
                        } else {
                            $output .= $this->buildLinkTag( $i );
                        }
                    }

                    $output .= $this->buildDividerTag( );
                    $output .= $this->buildNextTag( );
                    $output .= $this->buildDividerTag( );
                    $output .= $this->buildLastTag( );

                    break;

                /* Previous | 1 2 … 5 6 7 8 9 10 11 12 13 14 … 25 26 | Next */
                case 'digg':

                    $output .= $this->buildPreviousTag( );
                    $output .= $this->buildDividerTag( );

                    /* Previous | {1} 2 3 4 5 6 7 8 9 10 11 12 | Next */
                    if ( $this->getTotalPages( ) < 13 ) {

                        for ( $i = 1; $i <= $this->getTotalPages( ); $i++ ) {
                            if ( $i == $this->getCurrentPage( ) ) {
                                $output .= $this->buildCurrentTag( true );
                            } else {
                                $output .= $this->buildLinkTag( $i );
                            }
                        }

                    }
                    /* Previous | {1} 2 3 4 5 6 7 8 9 10 … 25 26 | Next */
                    else if ( $this->getCurrentPage( ) < 9 )  {

                        for ( $i = 1; $i <= 10; $i++ ){
                            if ( $i == $this->getCurrentPage( ) ){
                                $output .= $this->buildCurrentTag( true );
                            } else {
                                $output .= $this->buildLinkTag( $i );
                            }
                        }

                        $output .= $this->buildHellipTag( );

                        $output .= $this->buildLinkTag( $this->getTotalPages( ) - 1 );
                        $output .= $this->buildLinkTag( $this->getTotalPages( ) );

                    }
                    /* Previous | {1} 2 … 17 18 19 20 21 22 23 24 25 26 | Next */
                    else if ( $this->getCurrentPage( ) > $this->getTotalPages( ) - 8 )  {

                        $output .= $this->buildLinkTag( 1 );
                        $output .= $this->buildLinkTag( 2 );

                        $output .= $this->buildHellipTag( );

                        for ( $i = $this->getTotalPages( ) - 9; $i <= $this->getTotalPages( ); $i++ ) {
                            if ( $i == $this->getCurrentPage( ) ) {
                                $output .= $this->buildCurrentTag( true );
                            } else {
                                $output .= $this->buildLinkTag( $i );
                            }
                        }

                    }
                    /* Previous | {1} 2 … 5 6 7 8 9 10 11 12 13 14 … 25 26 | Next */
                    else  {

                        $output .= $this->buildLinkTag( 1 );
                        $output .= $this->buildLinkTag( 2 );

                       $output .= $this->buildHellipTag( );

                        for ( $i = $this->getCurrentPage( ) - 5; $i <= $this->getCurrentPage( ) + 5; $i++ ) {
                            if ( $i == $this->getCurrentPage( ) ){
                                $output .= $this->buildCurrentTag( true );
                            } else {
                                $output .= $this->buildLinkTag( $i );
                            }
                        }

                        $output .= $this->buildHellipTag( );

                        $output .= $this->buildLinkTag( $this->getTotalPages( ) - 1 );
                        $output .= $this->buildLinkTag( $this->getTotalPages( ) );
                    }

                    $output .= $this->buildDividerTag( );
                    $output .= $this->buildNextTag( );

                    break;

                // First | Previous | Page 2 of 11 | Showing items 6-10 of 52 | Next | Last
                case 'extended':

                    $output .= $this->buildPreviousTag( );
                    $output .= $this->buildDividerTag( );
                    $output .= $this->buildCurrentTag( );
                    $output .= $this->buildDividerTag( );
                    $output .= $this->buildSummaryTag( );
                    $output .= $this->buildDividerTag( );
                    $output .= $this->buildNextTag( );

                    break;

                // Pages: {1} … 4 5 6 7 8 … 15
                case 'punbb':

                    if ( $this->getCurrentPage( ) > 3 ) {
                        $output .= $this->buildLinkTag( $this->getFirstPage( ) );

                        if ($this->getCurrentPage( ) != 4) {
                            $output .= $this->buildHellipTag( );
                        }
                    }

                    for ( $i = $this->getCurrentPage( ) - 2, $stop = $this->getCurrentPage( ) + 3; $i < $stop; ++$i ) {
                        if ( $i < 1 || $i > $this->getTotalPages( ) )
                            continue;

                        if ( $this->getCurrentPage( ) == $i ) {
                            $output .= $this->buildCurrentTag( true );
                        } else {
                            $output .= $this->buildLinkTag( $i );
                        }
                    }

                    if ( $this->getCurrentPage( ) <= $this->getTotalPages( ) - 3 ) {
                        if ( $this->getCurrentPage( ) != $this->getTotalPages( ) - 3 ) {
                            $output .= $this->buildHellipTag( );
                        }

                        $output .= $this->buildLinkTag( $this->getTotalPages( ) );
                    }

                    break;

                /* First | Previous | Page {1} of 25 | Next | Last */
                default:

                    $output .= $this->buildFirstTag( );
                    $output .= $this->buildDividerTag( );
                    $output .= $this->buildPreviousTag( );
                    $output .= $this->buildDividerTag( );
                    $output .= $this->buildCurrentTag( );
                    $output .= $this->buildDividerTag( );
                    $output .= $this->buildNextTag( );
                    $output .= $this->buildDividerTag( );
                    $output .= $this->buildLastTag( );
                    $output .= $this->buildDividerTag( );
                    $output .= $this->buildSummaryTag( );

                    break;
            }

            if ( $this->isShowEnabled( ) && $this->isShowPosition( 'right' ) ) {
                $output .= $this->buildDividerTag( );
                $output .= $this->buildShowTag( );
            }

            return $this->buildWrapperTag( $output );

        }

        public function getPager ( ) {

        	return $this->render( );

        }

        public function __toString ( ) {

            return $this->render( );

        }

	} // END CLASS PAGINATOR