<?php

	namespace Application\Libraries\Engine\Grid;

	use \Phalcon\Paginator\Adapter\QueryBuilder as PaginatorAdapterQueryBuilder,
		\Application\Libraries\Engine\Paginator\Paginator;

	class Grid extends \Phalcon\Mvc\User\Component {

		protected $_data 		= false;
		protected $_query 		= false;
		protected $_table 		= false;
		protected $_pagination 	= false;
		protected $_options 	= array( );

		public function __construct ( $options = array( ) ) {

			$defaults = array(
				'url'						=> '?',
				'tags'						=> array(
					'link'			=> array(
						'tag' 			=> 'a',
						'attributes' 	=> array( )
					),
					'text'			=> array(
						'tag' 			=> 'span',
						'attributes' 	=> array( )
					),
					'label'			=> array(
						'tag' 			=> 'label',
						'attributes' 	=> array( )
					),
					'button'		=> array(
						'tag' 			=> 'button',
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
					'table' 		=> array(
						'tag' 			=> 'table',
						'attributes' 	=> array(
							'class'	=> 'ink-table'
						)
					),
					'table_head' 	=> array(
						'tag' 			=> 'thead',
						'attributes' 	=> array( )
					),
					'table_body' 	=> array(
						'tag' 			=> 'tbody',
						'attributes' 	=> array( )
					),
					'table_footer' 	=> array(
						'tag' 			=> 'tfoot',
						'attributes' 	=> array( )
					),
					'table_row' 	=> array(
						'tag' 			=> 'tr',
						'attributes' 	=> array( )
					),
					'table_column' 	=> array(
						'tag' 			=> 'th',
						'attributes' 	=> array( )
					),
					'table_cell' 	=> array(
						'tag' 			=> 'td',
						'attributes' 	=> array( )
					),
					'div' 	=> array(
						'tag' 			=> 'div',
						'attributes' 	=> array( )
					),
				),
				'columns'					=> array(

				),
				'column_sort'				=> true,
				'column_sort_query_string'	=> 'sort',
				'column_order_query_string'	=> 'order',
				'column_order_asc_name'		=> 'ASC',
				'column_order_desc_name'	=> 'DESC',
				'column_order_normal_name'	=> '',
				'column_order_asc_key'		=> 'asc',
				'column_order_desc_key'		=> 'desc',
				'column_selection_name'		=> '',
				'column_action_name'		=> 'Actions',
				'row_tools'	=> array(

				),
				'row_tools_enabled' 					=> true,
				'row_tools_position'					=> 'last',
				'row_selection_enabled'					=> true,
				'row_selection_position'				=> 'first',
				'pagination_enabled'					=> true,
				'pagination_show_query_string'			=> 'show',
				'pagination_page_query_string'			=> 'page',

				'toolbar_layout' 						=> ':tool_list_columns::tool_group_buttons::tool_bulk_actions::tool_search:',
				'toolbar_enabled'						=> true,
				'toolbar_search_id'						=> 'search',
				'toolbar_search_class'					=> '',
				'toolbar_search_query_string'			=> 'search',
				'toolbar_group_buttons_query_string'	=> 'group_button',
				'toolbar_bulk_actions_query_string'		=> 'bulk_action',
				'toolbar_group_buttons' 				=> array(

				),
				'toolbar_bulk_actions' 					=> array(

				),

				'css'	=> array(
					'selections'				=> 'selections',
					'selection'					=> 'selection',
					'list-columns'				=> 'list-columns',
					'column-visible'			=> 'column-visible',
					'button-groups-container'	=> 'button-group',
					'bulk-actions-container'	=> 'bulk-action'
				)
			);

			$this->setOptions( array_merge( $defaults, $options ) );
			$this->initialize( );

		}

		public function initialize ( ) {

			if ( $this->getOptions( 'sql' ) ) {
				$this->setQueryBuilder( $this->getOptions( 'sql' ) );
			} else {
				$this->setQueryBuilder( );
			}

            $url_query = $this->request->getQuery( );
            $url_query[$this->getOptions( 'column_sort_query_string' )] = '{' . $this->getOptions( 'column_sort_query_string' ) . '}';
            $url_query[$this->getOptions( 'column_order_query_string' )] = '{' . $this->getOptions( 'column_order_query_string' ) . '}';
            $url_query[$this->getOptions( 'toolbar_search_query_string' )] = '{' . $this->getOptions( 'toolbar_search_query_string' ) . '}';

            $this->setOptions( 'url', $this->getOptions( 'url' ) . $this->parseUrlQueryKey( $url_query ) );

		}

		public function getData ( ) {

			return $this->_data;

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

		public function getCSS ( $name = false ) {

			$css = $this->getOptions( 'css' );

			if ( $name && array_key_exists( $name, $css ) ) {
				return $css[$name];
			}

			return false;

		}

		public function setColumns ( array $columns ) {

			$this->setOptions( 'columns',  $columns );

			return $this;

		}

		public function getColumns ( $column_key = false ) {

			$columns = $this->getOptions( 'columns' );

			if ( $column_key ) {
				if ( array_key_exists( $column_key, $columns ) ) {
					return $columns[$column_key];
				} else {
					return false;
				}
			}

			return $columns;

		}

		public function hasColumn ( $column_key ) {

			$columns = $this->getColumns( );

			if ( $column_key ) {
				if ( array_key_exists( $column_key, $columns ) ) {
					return true;
				}
			}

			return false;

		}

		public function setPaginate ( $is_paginate = true ) {

			$this->setOptions( 'pagination_enabled', $is_paginate );

			return $this;

		}

		public function isPaginationEnabled (  ) {

			return ( boolean ) ( $this->getOptions( 'pagination_enabled' ) == true );

		}

		public function isToolbarEnabled (  ) {

			return ( boolean ) ( $this->getOptions( 'toolbar_enabled' ) == true );

		}

		public function setQueryBuilder ( $options = array( ) ) {

			$this->_query = new \Phalcon\Mvc\Model\Query\Builder( $options );

			$column_sort		= $this->request->getQuery( $this->getOptions( 'column_sort_query_string' ), 'string' );
			$column_sort_order 	= '';

			if ( $this->hasColumn( $column_sort ) ) {
				$column_order = $this->request->getQuery( $this->getOptions( 'column_order_query_string' ), 'string' );

				if ( $this->getOptions( 'column_order_' . $column_order . '_key' ) ) {
					$column_sort_order = $column_sort . ' ' . strtoupper( $column_order );
				}
			}

			if ( $this->request->hasQuery( $this->getOptions( 'toolbar_search_query_string' ) ) ) {
				$search_query 	= $this->request->getQuery( $this->getOptions( 'toolbar_search_query_string' ), 'string' );

				foreach ( $this->getColumns( ) as $column_key => $column_name ) {
					$this->_query->orWhere(  $column_key . ' LIKE \'' . $search_query . '%\'' );
				}
			}

			$this->_query->orderBy( $column_sort_order );

			return $this->_query;

		}

		public function getQueryBuilder ( ) {

			return $this->_query;

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

		public function getUrl ( ) {

            return $this->getOptions( 'url' );

        }

		public function getUrlKey ( $query_string ) {

        	return '{' . $this->getOptions( $query_string ) . '}';

        }

        public function parseUrlQueryKey ( $url_query ) {

        	return str_replace( array(
                '%7B' . $this->getOptions( 'column_sort_query_string' ) . '%7D',
                '%7B' . $this->getOptions( 'column_order_query_string' ) . '%7D',
                '%7B' . $this->getOptions( 'toolbar_search_query_string' ) . '%7D',
            ), array(
                $this->getUrlKey( 'column_sort_query_string' ),
                $this->getUrlKey( 'column_order_query_string' ),
                $this->getUrlKey( 'toolbar_search_query_string' ),
            ), http_build_query( $url_query ));

        }

        public function parseUrlQueryString ( $url, $query_string, $value ) {

            return str_replace( $this->getUrlKey( $query_string ), $value, $url );

        }

        public function getSortOrderUrl ( $column ) {

        	if ( $this->request->getQuery( $this->getOptions( 'column_sort_query_string', 'string' ) ) === $column ) {
        		if ( $this->request->getQuery( $this->getOptions( 'column_order_query_string', 'string' ) ) === $this->getOptions( 'column_order_asc_key' ) ) {
	        		$url = $this->parseUrlQueryString( $this->getUrl( ), 'column_order_query_string', $this->getOptions( 'column_order_desc_key' ) );
	        	} else  {
	        		$url = $this->parseUrlQueryString( $this->getUrl( ), 'column_order_query_string', $this->getOptions( 'column_order_asc_key' ) );
	        	}
        	} else {
        		$url = $this->parseUrlQueryString( $this->getUrl( ), 'column_order_query_string', $this->getOptions( 'column_order_asc_key' ) );
        	}

        	$url = $this->parseUrlQueryString( $url, 'column_sort_query_string', $column );

        	return $this->parseUrlQueryString( $url, 'toolbar_search_query_string', $this->request->getQuery( $this->getOptions( 'toolbar_search_query_string' ), 'string' ) );

        }

        public function getSearchUrl ( $parse = false ) {

        	$url = $this->parseUrlQueryString( $this->getUrl( ), 'column_sort_query_string', '' );
        	$url = $this->parseUrlQueryString( $url, 'column_order_query_string', '' );
        	$url = $this->_paginate->getPageShowUrl( $this->_paginate->getFirstPage( ), false, $url );

        	if ( $parse )
        		$url = $this->parseUrlQueryString( $url, 'toolbar_search_query_string', $this->request->getQuery( $this->getOptions( 'toolbar_search_query_string', 'string' ) ) );

        	return $url;

        }

        public function columnCount ( ) {

        	$table_row_count = count( $this->getOptions( 'columns' ) );

			if ( $this->getOptions( 'row_tools_enabled' ) ) {
				$table_row_count += 1;
			}

			if ( $this->getOptions( 'row_selection_enabled' ) ) {
				$table_row_count += 1;
			}

			return $table_row_count;

        }

		public function buildData ( ) {

			if ( $this->isPaginationEnabled( ) ) {

				if ( $this->request->hasQuery( $this->getOptions( 'pagination_show_query_string' ) ) && $this->request->getQuery( $this->getOptions( 'pagination_show_query_string' ) ) ) {
					$limit = ( int ) $this->request->getQuery( $this->getOptions( 'pagination_show_query_string' ), 'int' );
				} else {
					$limit = 10;
				}

				if ( $this->request->hasQuery( $this->getOptions( 'pagination_page_query_string' ) ) ) {
					$page = ( int ) $this->request->getQuery( $this->getOptions( 'pagination_page_query_string' ), 'int' );
				} else {
					$page = 1;
				}

				$builder = new PaginatorAdapterQueryBuilder( array(
					'builder' 	=> $this->getQueryBuilder( ),
					'limit'		=> $limit,
					'page'		=> $page ? $page : 1
				));

				$this->_paginate 	= new Paginator ( array(
					'show_query_string' => $this->getOptions( 'pagination_show_query_string' ),
					'page_query_string' => $this->getOptions( 'pagination_page_query_string' ),
				));
				$this->_paginate->setAdapter( $builder );
				$this->_data = $this->_paginate->getItems( );

			} else {
				$this->_data = $this->_query->getQuery( )->execute( );
			}

			return $this->_data;

		}

		public function buildTableHeadToolbar ( ) {

			$table_list_columns = '';
			foreach ( $this->getOptions( 'columns' ) as $column_key => $column_name ) {

				if ( is_array( $column_name ) )
					$_column_name = $column_name['title'];

				$options = array(
					$column_key,
					'name'		=> 'column-visible',
					'value'		=> $column_key,
					'class'		=> $this->getCSS( 'column-visible' ),
					'checked'	=> 'checked',
					'onchange'	=> 'var columns = document.getElementsByClassName( "id-" + this.value ); for ( var i = 0; i < columns.length; i++ ) { ( this.checked ) ? columns[i].removeAttribute( "style" ) : columns[i].setAttribute( "style", "display: none;" ); }'
				);

				if ( isset( $column_name['hidden'] ) && $column_name['hidden'] == true ) {
					unset( $options['checked'] );
				}

				$table_list_columns .= $this->parseTag( 'list', $this->tag->checkField( $options ) . ' ' . $this->parseTag( 'label', $_column_name, array(
					'for'	=> $column_key
				)));

			}

			$table_list_columns = $this->parseTag( 'div', $this->parseTag( 'link', 'Columns', array(
				'href' => '',
			)) . $this->parseTag( 'ul', $table_list_columns, array(
				'class'	=> $this->getCSS( 'list-columns' )
			)));

			$toolbar_group_buttons = '';
			foreach ( $this->getOptions( 'toolbar_group_buttons' ) as $key => $button ) {
				if ( is_callable( $button ) ) {
					$toolbar_group_buttons .= $button(  );
				} else if ( is_array( $button ) ) {
					$toolbar_group_buttons .= $this->parsetag( 'button', $button[0] , $button );
				}
			}
			$toolbar_group_buttons = $this->parseTag( 'div', $toolbar_group_buttons, array(
				'class'	=> $this->getCSS( 'button-groups-container' )
			));

			$toolbar_bulk_actions = $this->tag->selectStatic( array( $this->getOptions( 'toolbar_bulk_actions_query_string' ), $this->getOptions( 'toolbar_bulk_actions' ), 'parameters' => array(
				'class'	=> $this->getCSS( 'bulk-actions-container' )
			)));

			$toolbar_search = $this->tag->textField( array(
				$this->getOptions( 'toolbar_search_query_string' ),
				'value'		=> $this->request->getQuery( $this->getOptions( 'toolbar_search_query_string' ), 'string' ),
				'id'		=> $this->getOptions( 'toolbar_search_id' ),
				'class'		=> $this->getOptions( 'toolbar_search_class' ),
				'onkeyup' 	=> str_replace( ':url', $this->getSearchUrl( ), 'var e = window.event, url = \':url\'; if ( e.which == 13 )window.location = url.replace( \'' . $this->getUrlKey( 'toolbar_search_query_string' ) .  '\', this.value );' )
			));

			$table_head_toolbar = str_replace( array(
				':tool_list_columns:',
				':tool_group_buttons:',
				':tool_bulk_actions:',
				':tool_search:',
			), array(
				$table_list_columns,
				$toolbar_group_buttons,
				$toolbar_bulk_actions,
				$toolbar_search,
			), $this->getOptions( 'toolbar_layout') );

			return $this->parseTag( 'table_row', $this->parseTag( 'table_cell', $table_head_toolbar, array(
				'colspan'	=> $this->columnCount( )
			)));

		}

		public function buildTableHead ( ) {

			$table_column = '';

			if ( $this->getOptions( 'row_selection_enabled' ) && ( $this->getOptions( 'row_selection_position' ) === 'first' || $this->getOptions( 'row_selection_position' ) === 0 ) ) {
				$table_column .= $this->parseTag( 'table_column', $this->tag->checkField( array(
					'selection',
					'value'		=> 1,
					'onchange'	=> 'var selections = document.getElementsByClassName( "selections" ); for ( var i = 0; i < selections.length; i++ ) { selections[i].checked = this.checked; }'
				)));
			}

			if ( $this->getOptions( 'row_tools_enabled' ) && ( $this->getOptions( 'row_tools_position' ) === 'first' || $this->getOptions( 'row_tools_position' ) === 0 ) ) {
				$table_column .= $this->parseTag( 'table_column', $this->getOptions( 'column_action_name' ) );
			}

			$index = 1;
			foreach ( $this->getOptions( 'columns' ) as $column_key => $column_name ) {
				if ( $this->getOptions( 'row_selection_enabled' ) && $this->getOptions( 'row_selection_position' ) === $index ) {
					$table_column .= $this->parseTag( 'table_column', $this->tag->checkField( array(
						'selection',
						'value'		=> 1,
						'onchange'	=> 'var selections = document.getElementsByClassName( "selections" ); for ( var i = 0; i < selections.length; i++ ) { selections[i].checked = this.checked; }'
					)));
				}

				if ( $this->getOptions( 'row_tools_enabled' ) && $this->getOptions( 'row_tools_position' ) === $index ) {
					$table_column .= $this->parseTag( 'table_column', $this->getOptions( 'column_action_name' ) );
				}

				if ( is_array( $column_name ) ) {
					if ( $this->getOptions( 'column_sort' ) ) {
						if ( !isset( $column_name['sort'] ) || $column_name['sort'] == true ) {
							$_column_name = $this->parseTag( 'text', $column_name['title'] );

							if ( $this->request->getQuery( $this->getOptions( 'column_sort_query_string', 'string' ) ) === $column_key ) {
								if ( $this->request->hasQuery( $this->getOptions( 'column_order_query_string', 'string' ) ) && $this->getOptions( 'column_order_' . $this->request->getQuery( $this->getOptions( 'column_order_query_string' ), 'string' ) .  '_name' ) ) {
									$_column_name = $_column_name . $this->parseTag( 'text', $this->getOptions( 'column_order_' . $this->request->getQuery( $this->getOptions( 'column_order_query_string' ), 'string' ) .  '_name' ) );
								} else {
									$_column_name = $_column_name . $this->parseTag( 'text', $this->getOptions( 'column_order_asc_name' ) );
								}
							} else {
								$_column_name = $_column_name . $this->parseTag( 'text', $this->getOptions( 'column_order_normal_name' ) );
							}

							$_column_name = $this->parseTag( 'link', $_column_name, array(
								'href' => $this->getSortOrderUrl( $column_key )
							));
						} else {
							$_column_name =  $this->parseTag( 'text', $column_name['title'] );
						}
					} else {
						$_column_name =  $this->parseTag( 'text', $column_name['title'] );
					}

					$table_column .= $this->parseTag( 'table_column', $_column_name, array(
						'class' => 'id-' . $column_key,
						'style' => ( isset( $column_name['hidden'] ) && $column_name['hidden'] == true ) ? 'display: none' : '',
					));
				} else {
					$table_column .= $this->parseTag( 'table_column', $column_name, array(
						'class' => 'id-' . $column_key,
						'style' => ( isset( $column_name['hidden'] ) && $column_name['hidden'] == true ) ? 'display: none' : '',
					));
				}

				$index++;
			}

			if ( $this->getOptions( 'row_selection_enabled' ) && $this->getOptions( 'row_selection_position' ) === 'last' ) {
				$table_column .= $this->parseTag( 'table_column', $this->tag->checkField( array(
					'selection',
					'value'		=> 1,
					'onchange'	=> 'var selections = document.getElementsByClassName( "selections" ); for ( var i = 0; i < selections.length; i++ ) { selections[i].checked = this.checked; }'
				)));
			}

			if ( $this->getOptions( 'row_tools_enabled' ) && $this->getOptions( 'row_tools_position' ) === 'last' ) {
				$table_column .= $this->parseTag( 'table_column', $this->getOptions( 'column_action_name' ) );
			}

			if ( $this->isToolbarEnabled( ) ) {
				$table_head = $this->buildTableHeadToolbar( ) . $this->parseTag( 'table_row', $table_column );
			} else {
				$table_head = $this->parseTag( 'table_row', $table_column );
			}

			return $this->parseTag( 'table_head', $table_head );

		}

		public function buildTableBody ( ) {

			$table_row = '';

			if ( is_object( $this->getData( ) ) ) {
				foreach ( $this->getData( ) as $index => $model ) {

					$table_cell = '';

					if ( $this->getOptions( 'row_selection_enabled' ) && ( $this->getOptions( 'row_selection_position' ) === 'first' || $this->getOptions( 'row_selection_position' ) === 0 ) ) {
						if ( method_exists( $model, 'getId' ) ) {
							$table_cell .= $this->parseTag( 'table_cell', $this->tag->checkField( array( 'id[]', 'class' => $this->getCSS( 'selections' ), 'value' => $model->getId( ), 'id' => $this->getCSS( 'selection' ) .'-' . $model->getId( ) ) ) );
						}
					}

					if ( $this->getOptions( 'row_tools_enabled' ) && ( $this->getOptions( 'row_tools_position' ) === 'first' || $this->getOptions( 'row_tools_position' ) === 0 ) ) {
						$table_cell .= $this->parseTag( 'table_column', $this->buildTableRowTools( $model ) );
					}

					$index = 1;
					foreach ( $this->getOptions( 'columns' ) as $column_key => $column_name ) {
						if ( $this->getOptions( 'row_selection_enabled' ) && $this->getOptions( 'row_selection_position' ) === $index ) {
							if ( method_exists( $model, 'getId' ) ) {
								$table_cell .= $this->parseTag( 'table_cell', $this->tag->checkField( array( 'id[]', 'class' => $this->getCSS( 'selections' ), 'value' => $model->getId( ), 'id' => $this->getCSS( 'selection' ) . '-' . $model->getId( ) ) ) );
							}
						}

						if ( $this->getOptions( 'row_tools_enabled' ) && $this->getOptions( 'row_tools_position' ) === $index ) {
							$table_cell .= $this->parseTag( 'table_column', $this->buildTableRowTools( $model ) );
						}

						if ( is_array( $column_name ) && array_key_exists( 'column', $column_name ) ) {
							if ( array_key_exists( 'function', $column_name ) ) {
								if ( $column_name['function'] === true ) {
									$_cell .= $model->$column_name['column']( );
								} else {
									$_cell .= $model->$column_name['function']( );
								}
							} else if ( array_key_exists( 'convert', $column_name ) ) {
								$_cell = $column_name['convert']( $model );
							} else if ( array_key_exists( 'column', $column_name ) ) {
								$_cell = $model->$column_name['column'];
							} else {
								$_cell = $model->$column_key;
							}
						} else {
							$_cell = $model->$column_key;
						}

						$table_cell .= $this->parseTag( 'table_cell', $_cell, array(
							'class' => 'id-' . $column_key,
							'style' => ( isset( $column_name['hidden'] ) && $column_name['hidden'] == true ) ? 'display: none' : '',
						));

						$index++;
					}

					if ( $this->getOptions( 'row_selection_enabled' ) && $this->getOptions( 'row_selection_position' ) === 'last' ) {
						if ( method_exists( $model, 'getId' ) ) {
							$table_cell .= $this->parseTag( 'table_cell', $this->tag->checkField( array( 'id[]', 'class' => $this->getCSS( 'selections' ), 'value' => $model->getId( ), 'id' => $this->getCSS( 'selection' ) .'-' . $model->getId( ) ) ) );
						}
					}

					if ( $this->getOptions( 'row_tools_enabled' ) && $this->getOptions( 'row_tools_position' ) === 'last' ) {
						$table_cell .= $this->parseTag( 'table_column', $this->buildTableRowTools( $model ) );
					}

					$table_row .= $this->parseTag( 'table_row', $table_cell );
				}
			} else {
				$table_row_count = $this->columnCount( );

				$table_cell = $this->parseTag( 'table_cell', $this->parseTag( 'text', 'No Records Found!' ));
				$table_row .= $this->parseTag( 'table_row', $table_cell, array(
					'colspan'	=> $table_row_count
				));
			}

			return $this->parseTag( 'table_body', $table_row );

		}

		public function buildTableFooter ( ) {

			$table_row_count = $this->columnCount( );

			$table_cell = $this->parseTag( 'table_cell', $this->buildPagination( ), array(
				'colspan'	=> $table_row_count
			));
			$table_row 	= $this->parseTag( 'table_row', $table_cell );

			return $this->parseTag( 'table_footer', $table_row );

		}

		public function buildPagination ( ) {

			return $this->_paginate;

		}

		public function buildTableRowTools ( $model, $tools = null ) {

			foreach ( $this->getOptions( 'row_tools' ) as $type => $opt ) {
				if ( is_callable( $opt ) ) {
					$tools .= $opt( $model );
				}
			}

			return $tools;

		}

		public function buildTable ( ) {

			$table =  $this->buildTableHead( ) . $this->buildTableBody ( );

			if ( $this->isPaginationEnabled( ) )
				$table .= $this->buildTableFooter( );

			return $this->parseTag( 'table', $table );

		}

		public function prerender ( ) {

			$this->buildData( );

		}

		public function render ( ) {

			$this->prerender( );

			return $this->buildTable( );

		}

		public function __toString ( ) {

			return $this->render( );

		}

	} // END CLASS GRID