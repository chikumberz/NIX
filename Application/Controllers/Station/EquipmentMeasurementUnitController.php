<?php

	namespace Application\Controllers\Station;

	use \Phalcon\Paginator\Adapter\QueryBuilder as AdapterPaginator;

	use \Phalcon\Validation,
		\Phalcon\Validation\Validator\PresenceOf,
		\Phalcon\Validation\Validator\Email,
		\Phalcon\Validation\Validator\Identical,
		\Phalcon\Validation\Validator\StringLength,
		\Phalcon\Validation\Validator\Confirmation,
		\Phalcon\Validation\Validator\Regex,
		\Phalcon\Validation\Validator\InclusionIn;

	use \Application\Libraries\Engine\Paginator\Paginator;

	use \Application\Models\Station\EquipmentMeasurementUnit;

	/**
	 * Access Control List
	 *
	 * @Acl( "controller" = "EquipmentMeasurementUnit", "description" = "Equipment Measurement Unit Access." )
	 */

	class EquipmentMeasurementUnitController extends \Application\Controllers\BaseController {

		/**
		 * Set Permission
		 *
		 * @Acl( "key" = "index", "name" = "Index", "description" = "Equipment Measurement Unit Index." )
		 */

		public function indexAction ( ) {

			$language 		= $this->language->load( 'system', array( 'Station/Equipment/Measurement/Unit/Common', 'Station/Equipment/Measurement/Unit/Index' ) );
			
			$this->view->setVar( '_', 	$language );

			$__GRID_SESSION_KEY__ 	= 'station-equipment-measurement-unit';

			if ( $this->session->has( $__GRID_SESSION_KEY__ ) ) {
				$__GRID_SESSION__ 	= $this->session->get( $__GRID_SESSION_KEY__ );
			} else {
				$__GRID_SESSION__ 	= array( );
			}
			
			$__SQL_ORDER__ 			= false;
			$__SQL_ORDER_BY__  		= false;
			$__SQL_WHERE__  		= false;
			$__SQL_LIMIT__  		= false;
			$__SQL_PAGE__  			= false;
			$__SQL_COLUMNS__		= $language->_( 'table_grid_structure' );
			$__SQL_QUERY__ 			= $this->modelsManager
				->createBuilder( )
				->addFrom( 'Application\Models\Station\EquipmentMeasurementUnit', 'Unit' );
				
			if ( $this->request->hasQuery( 'orderby' ) && $this->request->hasQuery( 'order' ) && array_key_exists( $this->request->getQuery( 'orderby' ), $__SQL_COLUMNS__ ) ) {
				if ( $this->request->getQuery( 'order' ) == 'asc' ) {
					$__SQL_ORDER__ 		= 'asc';
					$__SQL_ORDER_BY__ 	= $this->request->getQuery( 'orderby', 'string' ); 
					$__GRID_SESSION__[$__GRID_SESSION_KEY__]['order'] 	= $__SQL_ORDER__;
					$__GRID_SESSION__[$__GRID_SESSION_KEY__]['orderby'] = $__SQL_ORDER_BY__;
					$__SQL_QUERY__->orderBy( $__SQL_ORDER_BY__ . ' ' . $__SQL_ORDER__ );
				} else if ( $this->request->getQuery( 'order' ) == 'desc' ) {
					$__SQL_ORDER__ 		= 'desc';
					$__SQL_ORDER_BY__ 	= $this->request->getQuery( 'orderby', 'string' ); 
					$__GRID_SESSION__[$__GRID_SESSION_KEY__]['order'] 	= $__SQL_ORDER__;
					$__GRID_SESSION__[$__GRID_SESSION_KEY__]['orderby'] = $__SQL_ORDER_BY__;
					$__SQL_QUERY__->orderBy( $__SQL_ORDER_BY__ . ' ' . $__SQL_ORDER__ );
				}
			} else if ( isset( $__GRID_SESSION__[$__GRID_SESSION_KEY__]['orderby'] ) && isset( $__GRID_SESSION__[$__GRID_SESSION_KEY__]['order'] ) && $__GRID_SESSION__[$__GRID_SESSION_KEY__]['orderby'] && array_key_exists( $__GRID_SESSION__[$__GRID_SESSION_KEY__]['orderby'], $__SQL_COLUMNS__ ) ) {
				if ( $__GRID_SESSION__[$__GRID_SESSION_KEY__]['order'] == 'asc' ) {
					$__SQL_ORDER__ 		= 'asc';
					$__SQL_ORDER_BY__ 	= $__GRID_SESSION__[$__GRID_SESSION_KEY__]['orderby']; 
					$__SQL_QUERY__->orderBy( $__GRID_SESSION__[$__GRID_SESSION_KEY__]['orderby'] . ' ' . $__SQL_ORDER__  );
				} else if ( $__GRID_SESSION__[$__GRID_SESSION_KEY__]['order'] == 'desc' ) {
					$__SQL_ORDER__ 		= 'desc';
					$__SQL_ORDER_BY__ 	= $__GRID_SESSION__[$__GRID_SESSION_KEY__]['orderby']; 
					$__SQL_QUERY__->orderBy( $__SQL_ORDER_BY__ . ' ' . $__SQL_ORDER__ );
				}
			}

			if ( $this->request->hasQuery( 'search' ) ) {
				$__SQL_WHERE__ = $this->request->getQuery( 'search', 'string' );
				foreach ( $__SQL_COLUMNS__ as $property => $column ) {
					if ( !isset( $column['search'] ) || $column['search'] == true ) {
						$__SQL_QUERY__->orWhere( $property . ' LIKE "%' . $__SQL_WHERE__ . '%" ' );
					}
				}
				$__GRID_SESSION__[$__GRID_SESSION_KEY__]['search'] = $__SQL_WHERE__;
			} else if ( isset( $__GRID_SESSION__[$__GRID_SESSION_KEY__]['search'] ) && $__GRID_SESSION__[$__GRID_SESSION_KEY__]['search'] ) {
				$__SQL_WHERE__ = $__GRID_SESSION__[$__GRID_SESSION_KEY__]['search'];
				foreach ( $__SQL_COLUMNS__ as $property => $column ) {
					if ( !isset( $column['search'] ) || $column['search'] == true ) {
						$__SQL_QUERY__->orWhere( $property . ' LIKE "%' . $__SQL_WHERE__ . '%" ' );
					}
				}
			}

			if ( $this->request->hasQuery( 'show' ) && $this->request->getQuery( 'show', 'int' ) > 0 ) {
				$__SQL_LIMIT__ 	= $this->request->getQuery( 'show', 'int' );
				$__GRID_SESSION__[$__GRID_SESSION_KEY__]['show'] = $__SQL_LIMIT__;
			} else if ( isset( $__GRID_SESSION__[$__GRID_SESSION_KEY__]['show'] ) ) {
				$__SQL_LIMIT__	= $__GRID_SESSION__[$__GRID_SESSION_KEY__]['show'];
			} else {
				$__SQL_LIMIT__ 	= $this->setting->get( 'sys', 'table_show_default' );
			}

			if ( $this->request->hasQuery( 'page' ) ) {
				$__SQL_PAGE__	= $this->request->getQuery( 'page', 'int' );
				$__GRID_SESSION__[$__GRID_SESSION_KEY__]['page'] = $__SQL_PAGE__;
			} else if ( isset( $__GRID_SESSION__[$__GRID_SESSION_KEY__]['page'] ) ) {
				$__SQL_PAGE__	= $__GRID_SESSION__[$__GRID_SESSION_KEY__]['page'];
			} else {
				$__SQL_PAGE__ 	= 1;
			}

			if ( $this->request->hasQuery( 'visible' ) ) {
				$column_visible = $this->request->getQuery( 'visible' );
				$__GRID_SESSION__[$__GRID_SESSION_KEY__]['visible'] = $column_visible;
				foreach ( $__SQL_COLUMNS__ as $property => $column ) {
					if ( in_array( $property, $column_visible ) ) {
						$__SQL_COLUMNS__[$property]['visible']	= true;
					} else {
						$__SQL_COLUMNS__[$property]['visible']	= false;
					}
				}
			} else if ( isset( $__GRID_SESSION__[$__GRID_SESSION_KEY__]['visible'] ) && $__GRID_SESSION__[$__GRID_SESSION_KEY__]['visible'] ) {
				$column_visible = $__GRID_SESSION__[$__GRID_SESSION_KEY__]['visible'];
				foreach ( $__SQL_COLUMNS__ as $property => $column ) {
					if ( in_array( $property, $column_visible ) ) {
						$__SQL_COLUMNS__[$property]['visible']	= true;
					} else {
						$__SQL_COLUMNS__[$property]['visible']	= false;
					}
				}
			}

			$__SQL_DATA__ 	= new Paginator ( new AdapterPaginator ( array(
					'builder' 	=> $__SQL_QUERY__,
					'limit'		=> ( int ) $__SQL_LIMIT__,
					'page'		=> ( int ) $__SQL_PAGE__,
				)), array(
					'style' => 'extended'
				)
			);

			$this->session->set( $__GRID_SESSION_KEY__, 			$__GRID_SESSION__ );
	
			$this->view->setVar( 'var_sql_columns', 				$__SQL_COLUMNS__ );
			$this->view->setVar( 'var_sql_data',  					$__SQL_DATA__ );

			$this->view->setVar( 'var_controller', 					'equipment-measurement-unit' );
			$this->view->setVar( 'var_table_shows',					$this->setting->get( 'sys', 'table_show' ) );
			$this->view->setVar( 'var_token_key',					$this->security->getTokenKey( ) );
			$this->view->setVar( 'var_token', 						$this->security->getToken( ) );

			$this->view->setVar( 'var_breadcrumbs', array(
				'Stations' 		=> $this->url->get( array(
					'for' 			=> 'admin-controller',
					'folder' 		=> 'station',
					'controller' 	=> 'station',
				)),
				'Equipments' 	=> $this->url->get( array(
					'for' 			=> 'admin-controller',
					'folder' 		=> 'station',
					'controller' 	=> 'equipment',
				)),
				'Measurements' 	=> $this->url->get( array(
					'for' 			=> 'admin-controller',
					'folder' 		=> 'station',
					'controller' 	=> 'equipment-measurement',
				)),
				'Units' 	=> $this->url->get( array(
					'for' 			=> 'admin-controller',
					'folder' 		=> 'station',
					'controller' 	=> 'equipment-measurement-unit',
				))
			));

			$this->tag->setDefault( 'search', 						$__SQL_WHERE__ );
			$this->tag->setDefault( 'show', 						$__SQL_LIMIT__ );
			$this->tag->setDefault( 'page', 						$__SQL_PAGE__ );

			$this->view->setVar( 'var_order', 						$__SQL_ORDER__ );
			$this->view->setVar( 'var_order_by', 					$__SQL_ORDER_BY__ );

			if ( $this->request->hasQuery( 'bulk' ) && $this->request->getQuery( 'bulk' ) ) {
				$this->{$this->request->getQuery( 'bulk' )}( );
			}

			$this->view->pick( 'Station/Equipment/Measurement/Unit/Index' );

		}

		/**
		 * Set Permission
		 *
		 * @Acl( "key" = "add", "name" = "Add", "description" = "Equipment Measurement Unit Add." )
		 */

		public function addAction ( ) {
			
			$language = $this->language->load( 'system', array( 'Station/Equipment/Measurement/Unit/Common', 'Station/Equipment/Measurement/Unit/Add' ) );

			$this->view->setVar( '_', 								$language );
			$this->view->setVar( 'var_token_key',					$this->security->getTokenKey( ) );
			$this->view->setVar( 'var_token', 						$this->security->getToken( ) );
			$this->view->setVar( 'var_created_on',					$language->_( 'text_no_available' ) );
			$this->view->setVar( 'var_updated_on',					$language->_( 'text_no_available' ) );

			$this->tag->setDefault( 'sort_order', 					0 );
			
			$this->view->setVar( 'var_breadcrumbs', array(
				'Stations' 		=> $this->url->get( array(
					'for' 			=> 'admin-controller',
					'folder' 		=> 'station',
					'controller' 	=> 'station',
				)),
				'Equipments' 	=> $this->url->get( array(
					'for' 			=> 'admin-controller',
					'folder' 		=> 'station',
					'controller' 	=> 'equipment',
				)),
				'Measurements' 	=> $this->url->get( array(
					'for' 			=> 'admin-controller',
					'folder' 		=> 'station',
					'controller' 	=> 'equipment-measurement',
				)),
				'Units' 	=> $this->url->get( array(
					'for' 			=> 'admin-controller',
					'folder' 		=> 'station',
					'controller' 	=> 'equipment-measurement-unit',
				)),
				'Add' 	=> $this->url->get( array(
					'for' 			=> 'admin-action',
					'folder' 		=> 'station',
					'controller' 	=> 'equipment-measurement-unit',
					'action' 		=> 'add',
				)),
			));

			$this->view->setVar( 'var_form_url', $this->url->get( array(
				'for'			=> 'admin-action',
				'folder'		=> 'station',
				'controller'	=> 'equipment-measurement-unit',
				'action'		=> 'save'
			)));

			$this->view->pick( 'Station/Equipment/Measurement/Unit/Add' );

		}

		/**
		 * Set Permission
		 *
		 * @Acl( "key" = "edit", "name" = "Edit", "description" = "Equipment Measurement Unit Edit." )
		 */

		public function editAction ( $id = false ) {

			$data		= EquipmentMeasurementUnit::findFirst( array(  
				'( is_archived = 0 OR is_archived IS NULL ) AND station_equipment_measurement_unit_id = ?0',
				'bind' => array(
					( int ) $id
				)
			));
			$language = $this->language->load( 'system', array( 'Station/Equipment/Measurement/Unit/Common', 'Station/Equipment/Measurement/Unit/Edit' ) );

			if ( !is_object( $data ) ) {
				$this->flash->error( $language->_( 'not_found_message' ) );
				return $this->response->redirect( array(
					'for' 			=> 'admin-controller',
					'folder'		=> 'station',
					'controller' 	=> 'equipment-measurement-unit',
				));
			}

			$this->view->setVar( '_', 								$language );
			$this->view->setVar( 'var_token_key',					$this->security->getTokenKey( ) );
			$this->view->setVar( 'var_token', 						$this->security->getToken( ) );
			$this->view->setVar( 'var_created_on',					date( $language->_( 'format_date' ), strtotime( $data->created_on ) ) );
			$this->view->setVar( 'var_updated_on',					date( $language->_( 'format_date' ), strtotime( $data->updated_on ) ) );

			$this->tag->setDefault( 'unit', 						$data->unit );
			$this->tag->setDefault( 'value', 						$data->value );
			$this->tag->setDefault( 'symbol_left', 					$data->symbol_left );
			$this->tag->setDefault( 'symbol_right', 				$data->symbol_right );
			$this->tag->setDefault( 'sort_order', 					$data->sort_order );

			$this->view->setVar( 'var_breadcrumbs', array(
				'Stations' 		=> $this->url->get( array(
					'for' 			=> 'admin-controller',
					'folder' 		=> 'station',
					'controller' 	=> 'station',
				)),
				'Equipments' 	=> $this->url->get( array(
					'for' 			=> 'admin-controller',
					'folder' 		=> 'station',
					'controller' 	=> 'equipment',
				)),
				'Measurements' 	=> $this->url->get( array(
					'for' 			=> 'admin-controller',
					'folder' 		=> 'station',
					'controller' 	=> 'equipment-measurement',
				)),
				'Units' 	=> $this->url->get( array(
					'for' 			=> 'admin-controller',
					'folder' 		=> 'station',
					'controller' 	=> 'equipment-measurement-unit',
				)),
				'Edit' 	=> $this->url->get( array(
					'for' 			=> 'admin-action',
					'folder' 		=> 'station',
					'controller' 	=> 'equipment-measurement-unit',
					'action' 		=> 'edit',
				)),
			));

			$this->view->setVar( 'var_form_url', $this->url->get( array(
				'for'			=> 'admin-full',
				'folder'		=> 'station',
				'controller'	=> 'equipment-measurement-unit',
				'action'		=> 'save',
				'params'		=> $data->getId( ),
			)));

			$this->view->pick( 'Station/Equipment/Measurement/Unit/Edit' );

		}

		/**
		 * Set Permission
		 *
		 * @Acl( "key" = "view", "name" = "View", "description" = "Equipment Measurement Unit View." )
		 */

		public function viewAction ( $id = false ) {

			$data		= EquipmentMeasurementUnit::findFirst( array(  
				'( is_archived = 0 OR is_archived IS NULL ) AND station_equipment_measurement_unit_id = ?0',
				'bind' => array(
					( int ) $id
				)
			));
			$language 	= $this->language->load( 'system', array( 'Station/Equipment/Measurement/Unit/Common', 'Station/Equipment/Measurement/Unit/Delete', 'Station/Equipment/Measurement/Unit/View' ) );

			if ( !is_object( $data ) ) {
				$this->flash->error( $language->_( 'not_found_message' ) );
				return $this->response->redirect( array(
					'for' 			=> 'admin-controller',
					'folder'		=> 'station',
					'controller' 	=> 'equipment-measurement-unit',
				));
			}

			$this->view->setVar( '_', 								$language );
			$this->view->setVar( 'unit', 							$data->unit );
			$this->view->setVar( 'value', 							$data->value );
			$this->view->setVar( 'symbol_left', 					$data->symbol_left );
			$this->view->setVar( 'symbol_right', 					$data->symbol_right );
			$this->view->setVar( 'sort_order', 						$data->sort_order );
			$this->view->setVar( 'var_created_on',					date( $language->_( 'format_date' ), strtotime( $data->created_on ) ) );
			$this->view->setVar( 'var_updated_on',					date( $language->_( 'format_date' ), strtotime( $data->updated_on ) ) );

			$this->view->setVar( 'var_breadcrumbs', array(
				'Stations' 		=> $this->url->get( array(
					'for' 			=> 'admin-controller',
					'folder' 		=> 'station',
					'controller' 	=> 'station',
				)),
				'Equipments' 	=> $this->url->get( array(
					'for' 			=> 'admin-controller',
					'folder' 		=> 'station',
					'controller' 	=> 'equipment',
				)),
				'Measurements' 	=> $this->url->get( array(
					'for' 			=> 'admin-controller',
					'folder' 		=> 'station',
					'controller' 	=> 'equipment-measurement',
				)),
				'Units' 	=> $this->url->get( array(
					'for' 			=> 'admin-controller',
					'folder' 		=> 'station',
					'controller' 	=> 'equipment-measurement-unit',
				)),
				'Edit' 	=> $this->url->get( array(
					'for' 			=> 'admin-action',
					'folder' 		=> 'station',
					'controller' 	=> 'equipment-measurement-unit',
					'action' 		=> 'view',
				)),
			));

			$this->view->setVar( 'var_edit_url', $this->url->get( array(
				'for'			=> 'admin-full',
				'folder'		=> 'station',
				'controller'	=> 'equipment-measurement-unit',
				'action'		=> 'edit',
				'params'		=> $data->getId( ),
			)));

			$this->view->setVar( 'var_archive_url', $this->url->get( array(
				'for'			=> 'admin-full',
				'folder'		=> 'station',
				'controller'	=> 'equipment-measurement-unit',
				'action'		=> 'archive',
				'params'		=> $data->getId( ),
			)));

			$this->view->setVar( 'var_delete_url', $this->url->get( array(
				'for'			=> 'admin-full',
				'folder'		=> 'station',
				'controller'	=> 'equipment-measurement-unit',
				'action'		=> 'delete',
				'params'		=> $data->getId( ),
			)));

			$this->view->pick( 'Station/Equipment/Measurement/Unit/View' );

		}

		/**
		 * Set Permission
		 *
		 * @Acl( "key" = "archive", "name" = "Archive", "description" = "Equipment Measurement Unit Archive." )
		 */

		public function archiveAction ( $id = false ) {

			$language 		= $this->language->load( 'system', 'Station/Equipment/Measurement/Unit/Archive' );

			if ( $this->request->hasQuery( 'id' ) == true ) {

				$ids = $this->request->getQuery( 'id' );

				if ( !is_array( $ids ) ) {
					
					$data = $this->_preserve( ( int ) $ids );
					
					if ( $data !== true && !$data->is_preserved ) {
						
						foreach( $data->getMessages( ) as $message ) {
							$this->flash->error( $message->getMessage( ) );
						}
						
						$this->flash->error( $language->_( 'error_message' ) );
						
						return $this->dispatcher->forward( array(
							'for' 			=> 'admin-action',
							'folder'		=> 'station',
							'controller' 	=> 'equipment-measurement-unit',
							'action' 		=> 'index'
						));
					}
				} else {
					foreach ( $ids as $id ) {
						
						$data = $this->_preserve( $id );
						
						if ( $data !== true && !$data->is_preserved ) {
							
							foreach( $data->getMessages( ) as $message ) {
								$this->flash->error( $message->getMessage( ) );
							}
							
							$this->flash->error( $language->_( 'error_message' ) );
							
							return $this->dispatcher->forward( array(
								'for' 			=> 'admin-action',
								'folder'		=> 'station',
								'controller' 	=> 'equipment-measurement-unit',
								'action' 		=> 'index'
							));

							break;

						}
					}
				}
				$this->flash->success( $language->_( 'success_message' ) );
	
			} else if ( is_numeric( $id ) ) {
				
				$data = $this->_preserve( ( int ) $id );
				
				if ( $data !== true && !$data->is_preserved ) {
					
					foreach( $data->getMessages( ) as $message ) {
						$this->flash->error( $message->getMessage( ) );
					}
					
					$this->flash->error( $language->_( 'error_message' ) );
					
					return $this->dispatcher->forward( array(
						'for' 			=> 'admin-action',
						'folder'		=> 'station',
						'controller' 	=> 'equipment-measurement-unit',
						'action' 		=> 'index'
					));

				}

				$this->flash->success( $language->_( 'success_message' ) );

			}

			$this->view->disable( );
			$this->response->redirect( array(
				'for' 			=> 'admin-controller',
				'folder'		=> 'station',
				'controller' 	=> 'equipment-measurement-unit',
			));

			return;

		}

		/**
		 * Set Permission
		 *
		 * @Acl( "key" = "unarchive", "name" = "Unarchive", "description" = "Equipment Measurement Unit Unarchive." )
		 */

		public function unarchiveAction ( $id = false ) {

			$language 	= $this->language->load( 'system', 'Station/Equipment/Measurement/Unit/Unarchive' );

			if ( $this->request->hasQuery( 'id' ) == true ) {

				$ids = $this->request->getQuery( 'id' );

				if ( !is_array( $ids ) ) {
					
					$data = $this->_unpreserve( ( int ) $ids );
					
					if ( $data !== true && !$data->is_unarchived ) {
						
						foreach( $data->getMessages( ) as $message ) {
							$this->flash->error( $message->getMessage( ) );
						}
						
						$this->flash->error( $language->_( 'error_message' ) );
						
						return $this->dispatcher->forward( array(
							'for' 			=> 'admin-action',
							'folder'		=> 'station',
							'controller' 	=> 'equipment-measurement-unit',
							'action' 		=> 'index'
						));
					}
				} else {
					foreach ( $ids as $id ) {
						
						$data = $this->_unpreserve( $id );
						
						if ( $data !== true && !$data->is_unarchived ) {
							
							foreach( $data->getMessages( ) as $message ) {
								$this->flash->error( $message->getMessage( ) );
							}
							
							$this->flash->error( $language->_( 'error_message' ) );
							
							return $this->dispatcher->forward( array(
								'for' 			=> 'admin-action',
								'folder'		=> 'station',
								'controller' 	=> 'equipment-measurement-unit',
								'action' 		=> 'index'
							));

							break;

						}
					}
				}

				$this->flash->success( $language->_( 'success_message' ) );
			} else if ( is_numeric( $id ) ) {
				
				$data = $this->_unpreserve( ( int ) $id );
				
				if ( $data !== true && !$data->is_unarchived ) {
					
					foreach( $data->getMessages( ) as $message ) {
						$this->flash->error( $message->getMessage( ) );
					}
					
					$this->flash->error( $language->_( 'error_message' ) );
					
					return $this->dispatcher->forward( array(
						'for' 			=> 'admin-action',
						'folder'		=> 'station',
						'controller' 	=> 'equipment-measurement-unit',
						'action' 		=> 'index'
					));

				}

				$this->flash->success( $language->_( 'success_message' ) );
			}

			$this->view->disable( );
			$this->response->redirect( array(
				'for' 			=> 'admin-controller',
				'folder'		=> 'station',
				'controller' 	=> 'equipment-measurement-unit',
			));

			return;

		}

		/**
		 * Set Permission
		 *
		 * @Acl( "key" = "delete", "name" = "Delete", "description" = "Equipment Measurement Unit Delete." )
		 */
		
		public function deleteAction ( $id = false ) {

			$language 	= $this->language->load( 'system', 'Station/Equipment/Measurement/Unit/Delete' );

			if ( $this->request->hasQuery( 'id' ) == true ) {

				$ids = $this->request->getQuery( 'id' );

				if ( !is_array( $ids ) ) {
					
					$data = $this->_erase( ( int ) $ids );
					
					if ( $data !== true && !$data->is_deleted ) {
						
						foreach( $data->getMessages( ) as $message ) {
							$this->flash->error( $message->getMessage( ) );
						}
						
						$this->flash->error( $language->_( 'error_message' ) );
						
						return $this->dispatcher->forward( array(
							'for' 			=> 'admin-action',
							'folder'		=> 'station',
							'controller' 	=> 'equipment-measurement-unit',
							'action' 		=> 'index'
						));

					}

				} else {

					foreach ( $ids as $id ) {
						
						$data = $this->_erase( $id );
						
						if ( $data !== true && !$data->is_deleted ) {
							
							foreach( $data->getMessages( ) as $message ) {
								$this->flash->error( $message->getMessage( ) );
							}
							
							$this->flash->error( $language->_( 'error_message' ) );
							
							return $this->dispatcher->forward( array(
								'for' 			=> 'admin-action',
								'folder'		=> 'station',
								'controller' 	=> 'equipment-measurement-unit',
								'action' 		=> 'index'
							));

							break;
						}
					}

				}

				$this->flash->success( $language->_( 'success_message' ) );

			} else if ( is_numeric( $id ) ) {

				$data = $this->_erase( ( int ) $id );

				if ( $data !== true && !$data->is_deleted ) {

					foreach( $data->getMessages( ) as $message ) {
						$this->flash->error( $message->getMessage( ) );
					}
					
					$this->flash->error( $language->_( 'error_message' ) );
					
					return $this->dispatcher->forward( array(
						'for' 			=> 'admin-action',
						'folder'		=> 'station',
						'controller' 	=> 'equipment-measurement-unit',
						'action' 		=> 'index'
					));

				}

				$this->flash->success( $language->_( 'success_message' ) );
			}

			$this->view->disable( );
			$this->response->redirect( array(
				'for' 			=> 'admin-controller',
				'folder'		=> 'station',
				'controller' 	=> 'equipment-measurement-unit',
			));

			return;
		}

		public function saveAction ( $id = false ) {

			if ( $this->request->isPost( ) == true ) {

				$add_language 		= $this->language->load( 'system', 'Station/Equipment/Measurement/Unit/Add' );
				$edit_language 		= $this->language->load( 'system', 'Station/Equipment/Measurement/Unit/Edit' );
				$common_language 	= $this->language->load( 'system', 'Station/Equipment/Measurement/Unit/Common' );
				
				if ( $this->security->checkToken( ) ) {

					$data 				= new \stdClass( );
					
					if ( is_numeric( $id ) ) {
						$data->id = ( int ) $id;
					} 	

					$data->unit 			= $this->request->getPost( 'unit', 'string' );
					$data->value 			= $this->request->getPost( 'value', 'string' );
					$data->symbol_left 		= $this->request->getPost( 'symbol_left', 'string' );
					$data->symbol_right 	= $this->request->getPost( 'symbol_right', 'string' );
					$data->sort_order 		= $this->request->getPost( 'sort_order', 'int' );
					
					$validator = new Validation( );
					$validator->add( 'unit', new PresenceOf( array(
						'cancelOnFail'	=> true,
						'message'		=> $common_language->_( 'validate_unit' ),
					)));

					if ( count( $validator->getMessages( ) ) ) {
						foreach( $validator->getMessages( ) as $message ) {
							$this->flash->error( $message->getMessage( ) );
						}

						if ( $data->id ) {
							$this->dispatcher->forward( array(
								'for' 			=> 'admin-full',
								'folder'		=> 'station',
								'controller' 	=> 'equipment-measurement-unit',
								'action'		=> 'edit',
								'params'		=> array( $data->id )
							));
						} else {
							$this->dispatcher->forward( array(
								'for' 			=> 'admin-action',
								'folder'		=> 'station',
								'controller' 	=> 'equipment-measurement-unit',
								'action' 		=> 'add',
							));
						}
					} else {
						$data = $this->_store( ( object ) $data );

						foreach( $data->messages as $message ) {
							$this->flash->error( $message->getMessage( ) );
						}

						if ( isset( $data->id ) && $data->id > 0 ) {
							if ( $data->is_saved == true ) {
								$this->view->disable( );
								$this->flash->success( $edit_language->_( 'success_message' ) );
								$this->response->redirect( array(
									'for' 			=> 'admin-full',
									'folder'		=> 'station',
									'controller' 	=> 'equipment-measurement-unit',
									'action'		=> 'edit',
									'params'		=> $data->id
								));
							} else {
								$this->flash->error( $edit_language->_( 'error_message' ) );
								$this->dispatcher->forward( array(
									'for' 			=> 'admin-full',
									'folder'		=> 'station',
									'controller' 	=> 'equipment-measurement-unit',
									'action'		=> 'edit',
									'params'		=> array( $data->id )
								));
							}
						} else {
							if ( $data->is_saved == true ) {
								$this->view->disable( );
								$this->flash->success( $add_language->_( 'success_message' ) );
								$this->response->redirect( array(
									'for' 			=> 'admin-controller',
									'folder'		=> 'station',
									'controller' 	=> 'equipment-measurement-unit',
								));
							} else {
								$this->flash->error( $add_language->_( 'error_message' ) );
								$this->dispatcher->forward( array(
									'for' 			=> 'admin-action',
									'folder'		=> 'station',
									'controller' 	=> 'equipment-measurement-unit',
									'action' 		=> 'add',
								));
							}
						}
					}

					return;

				} else {
					$this->flash->error( $common_language->_( 'validate_access_tokken' ) );
				}
			}

			$this->view->disable( );
			$this->response->redirect( array(
				'for' 			=> 'admin-controller',
				'folder'		=> 'station',
				'controller' 	=> 'equipment-measurement-unit',
			));

			return;

		}

		private function _store ( $data ) {

			if ( isset( $data->id ) ) { 
				
				$unit_data = EquipmentMeasurementUnit::findFirst( $data->id );
				
				if ( !is_object( $unit_data ) ) {
					$unit_data = new EquipmentMeasurementUnit( );
				}

			} else {
				$unit_data = new EquipmentMeasurementUnit( );
			}

			$unit_data->unit 				= $data->unit;
			$unit_data->value 				= $data->value;
			$unit_data->symbol_left 		= $data->symbol_left;
			$unit_data->symbol_right 		= $data->symbol_right;
			$unit_data->sort_order 			= $data->sort_order;

			$data->data 					= $unit_data;
			$data->is_saved					= $unit_data->save( );
			$data->messages					= $unit_data->getMessages( );

			return $data;

		}

		private function _preserve ( $id = false ) {

			$data = EquipmentMeasurementUnit::findFirst( $id );

			if ( is_object( $data ) ) {

				$data->is_archived = ( int ) true;

				if ( $data->save( ) == false ) {

					$data->is_archived 	= ( int ) false;	

					return $data;

				}

			}

			return true;

		}

		private function _unpreserve ( $id = false ) {

			$data = EquipmentMeasurementUnit::findFirst( $id );

			if ( is_object( $data ) ) {

				$data->is_archived = ( int ) false;

				if ( $data->save( ) == false ) {

					$data->is_unarchived 	= ( int ) false;		

					return $data;

				}

			}

			return true;

		}

		private function _erase ( $id = false ) {

			$data = EquipmentMeasurementUnit::findFirst( $id );

			if ( is_object( $data ) ) {
					
				if ( $data->delete( ) == false ) {
					
					$data->is_deleted 	= ( int ) false;	
					return $data;

				}

			} 

			return true;

		}

	} // END CLASS EQUIPMENT MEASUREMENT UNIT CONTROLLER