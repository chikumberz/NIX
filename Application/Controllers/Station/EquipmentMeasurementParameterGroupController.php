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

	use \Application\Models\Station\EquipmentMeasurementParameter,
		\Application\Models\Station\EquipmentMeasurementParameterGroup,
		\Application\Models\Station\EquipmentMeasurementParameterGroupLink,
		\Application\Models\Station\Equipment,
		\Application\Models\User\Group;

	/**
	 * Access Control List
	 *
	 * @Acl( "controller" = "EquipmentMeasurementParameterGroup", "description" = "Equipment Measurement Parameter Group Access." )
	 */

	class EquipmentMeasurementParameterGroupController extends \Application\Controllers\BaseController {

		/**
		 * Set Permission
		 *
		 * @Acl( "key" = "index", "name" = "Index", "description" = "Equipment Measurement Parameter Group Index." )
		 */

		public function indexAction ( ) {

			$language 	= $this->language->load( 'system', array( 'Station/Equipment/Measurement/Parameter/Group/Common', 'Station/Equipment/Measurement/Parameter/Group/Index' ) );
			
			$this->view->setVar( '_', 	$language );

			$__GRID_SESSION_KEY__ 	= 'station-equipment-measurement-parameter-group';

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
				->addFrom( 'Application\Models\Station\EquipmentMeasurementParameterGroup', 'EquipmentMeasurementParameterGroup' );

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

			$this->view->setVar( 'var_controller', 					'equipment-measurement-parameter-group' );
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
				'Parameters' 	=> $this->url->get( array(
					'for' 			=> 'admin-controller',
					'folder' 		=> 'station',
					'controller' 	=> 'equipment-measurement-parameter',
				)),
				'Groups' 	=> $this->url->get( array(
					'for' 			=> 'admin-controller',
					'folder' 		=> 'station',
					'controller' 	=> 'equipment-measurement-parameter-group',
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

			$this->view->pick( 'Station/Equipment/Measurement/Parameter/Group/Index' );

		}

		/**
		 * Set Permission
		 *
		 * @Acl( "key" = "add", "name" = "Add", "description" = "Equipment Measurement Parameter Group Add." )
		 */

		public function addAction ( ) {
			
			$language = $this->language->load( 'system', array( 'Station/Equipment/Measurement/Parameter/Group/Common', 'Station/Equipment/Measurement/Parameter/Group/Add' ) );

			$this->view->setVar( '_', 						$language );
			$this->view->setVar( 'var_token_key',			$this->security->getTokenKey( ) );
			$this->view->setVar( 'var_token', 				$this->security->getToken( ) );
			$this->view->setVar( 'var_equipments', 			Equipment::find( array(  
				'( is_archived = 0 OR is_archived IS NULL )'
			)));
			$this->view->setVar( 'var_created_on',			$language->_( 'text_no_available' ) );
			$this->view->setVar( 'var_updated_on',			$language->_( 'text_no_available' ) );

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
				'Parameters' 	=> $this->url->get( array(
					'for' 			=> 'admin-controller',
					'folder' 		=> 'station',
					'controller' 	=> 'equipment-measurement-parameter',
				)),
				'Groups' 	=> $this->url->get( array(
					'for' 			=> 'admin-controller',
					'folder' 		=> 'station',
					'controller' 	=> 'equipment-measurement-parameter-group',
				)),
				'Add' 	=> $this->url->get( array(
					'for' 			=> 'admin-action',
					'folder' 		=> 'station',
					'controller' 	=> 'measurement-parameter-group-group',
					'action' 		=> 'add',
				)),
			));

			$this->view->setVar( 'var_form_url', $this->url->get( array(
				'for'			=> 'admin-action',
				'folder'		=> 'station',
				'controller'	=> 'equipment-measurement-parameter-group',
				'action'		=> 'save'
			)));

			$this->tag->setDefault( 'sort_order', 0 );

			$this->view->pick( 'Station/Equipment/Measurement/Parameter/Group/Add' );

		}

		/**
		 * Set Permission
		 *
		 * @Acl( "key" = "edit", "name" = "Edit", "description" = "Equipment Measurement Parameter Group Edit." )
		 */

		public function editAction ( $id = false ) {

			$data 		= EquipmentMeasurementParameterGroup::findFirst( array(  
				'( is_archived = 0 OR is_archived IS NULL ) AND station_equipment_measurement_parameter_group_id = ?0',
				'bind' => array(
					( int ) $id
				)
			));
			$language 	= $this->language->load( 'system', array( 'Station/Equipment/Measurement/Parameter/Group/Common', 'Station/Equipment/Measurement/Parameter/Group/Edit' ) );

			if ( !is_object( $data ) ) {
				$this->flash->error( $this->view->getVar( '_' )->_( 'not_found_message' ) );
				return $this->response->redirect( array(
					'for' 			=> 'admin-controller',
					'folder'		=> 'station',
					'controller' 	=> 'equipment-measurement-parameter-group',
				));
			}

			$this->view->setVar( '_', 						$language );
			$this->view->setVar( 'var_token_key',			$this->security->getTokenKey( ) );
			$this->view->setVar( 'var_token', 				$this->security->getToken( ) );
			$this->view->setVar( 'var_equipments', 			Equipment::find( array(  
				'( is_archived = 0 OR is_archived IS NULL )'
			)));
			$this->view->setVar( 'var_created_on',			date( $language->_( 'format_date' ), strtotime( $data->created_on ) ) );
			$this->view->setVar( 'var_updated_on',			date( $language->_( 'format_date' ), strtotime( $data->updated_on ) ) );

			$this->tag->setDefault( 'title', 				$data->title );
			$this->tag->setDefault( 'description', 			$data->description );
			$this->tag->setDefault( 'sort_order', 			$data->sort_order );

			foreach ( $data->getEquipmentMeasurementParameterGroupLink( ) as $parameter ) {
				$this->tag->setDefault( "parameter[{$parameter->station_equipment_measurement_parameter_id}]", $parameter->station_equipment_measurement_parameter_id );
			}

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
				'Parameters' 	=> $this->url->get( array(
					'for' 			=> 'admin-controller',
					'folder' 		=> 'station',
					'controller' 	=> 'equipment-measurement-parameter',
				)),
				'Groups' 	=> $this->url->get( array(
					'for' 			=> 'admin-controller',
					'folder' 		=> 'station',
					'controller' 	=> 'equipment-measurement-parameter-group',
				)),
				'Edit' 	=> $this->url->get( array(
					'for' 			=> 'admin-action',
					'folder' 		=> 'station',
					'controller' 	=> 'equipment-measurement-parameter-group',
					'action' 		=> 'edit',
				)),
			));

			$this->view->setVar( 'var_form_url', $this->url->get( array(
				'for'			=> 'admin-full',
				'folder'		=> 'station',
				'controller'	=> 'equipment-measurement-parameter-group',
				'action'		=> 'save',
				'params'		=> $data->getId( ),
			)));

			$this->view->pick( 'Station/Equipment/Measurement/Parameter/Group/Edit' );

		}

		/**
		 * Set Permission
		 *
		 * @Acl( "key" = "view", "name" = "View", "description" = "Equipment Measurement Parameter Group View." )
		 */

		public function viewAction ( $id = false ) {

			$data 		= EquipmentMeasurementParameterGroup::findFirst( array(  
				'( is_archived = 0 OR is_archived IS NULL ) AND station_equipment_measurement_parameter_group_id = ?0',
				'bind' => array(
					( int ) $id
				)
			));
			$language 	= $this->language->load( 'system', array( 'Station/Equipment/Measurement/Parameter/Group/Common', 'Station/Equipment/Measurement/Parameter/Group/Delete', 'Station/Equipment/Measurement/Parameter/Group/View' ) );

			if ( !is_object( $data ) ) {
				$this->flash->error( $this->view->getVar( '_' )->_( 'not_found_message' ) );
				return $this->response->redirect( array(
					'for' 			=> 'admin-controller',
					'folder'		=> 'station',
					'controller' 	=> 'equipment-measurement-parameter-group',
				));
			}

			$this->view->setVar( '_', 						$language );
			$this->view->setVar( 'var_token_key',			$this->security->getTokenKey( ) );
			$this->view->setVar( 'var_token', 				$this->security->getToken( ) );
			$this->view->setVar( 'var_equipments', 			Equipment::find( array(  
				'( is_archived = 0 OR is_archived IS NULL )'
			)));

			$this->view->setVar( 'title', 			$data->title );
			$this->view->setVar( 'description', 	$data->description );
			$this->view->setVar( 'sort_order', 		$data->sort_order );
			$this->view->setVar( 'var_created_on',	date( $language->_( 'format_date' ), strtotime( $data->created_on ) ) );
			$this->view->setVar( 'var_updated_on',	date( $language->_( 'format_date' ), strtotime( $data->updated_on ) ) );

			foreach ( $data->getEquipmentMeasurementParameterGroupLink( ) as $parameter ) {
				$this->tag->setDefault( "parameter[{$parameter->station_equipment_measurement_parameter_id}]", $parameter->station_equipment_measurement_parameter_id );
			}

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
				'Parameters' 	=> $this->url->get( array(
					'for' 			=> 'admin-controller',
					'folder' 		=> 'station',
					'controller' 	=> 'equipment-measurement-parameter',
				)),
				'Groups' 	=> $this->url->get( array(
					'for' 			=> 'admin-controller',
					'folder' 		=> 'station',
					'controller' 	=> 'equipment-measurement-parameter-group',
				)),
				'View' 	=> $this->url->get( array(
					'for' 			=> 'admin-action',
					'folder' 		=> 'station',
					'controller' 	=> 'equipment-measurement-parameter-group',
					'action' 		=> 'view',
				)),
			));

			$this->view->setVar( 'var_edit_url', $this->url->get( array(
				'for'			=> 'admin-full',
				'folder'		=> 'station',
				'controller'	=> 'equipment-measurement-parameter-group',
				'action'		=> 'edit',
				'params'		=> $data->getId( ),
			)));

			$this->view->setVar( 'var_archive_url', $this->url->get( array(
				'for'			=> 'admin-full',
				'folder'		=> 'station',
				'controller'	=> 'equipment-measurement-parameter-group',
				'action'		=> 'archive',
				'params'		=> $data->getId( ),
			)));

			$this->view->setVar( 'var_delete_url', $this->url->get( array(
				'for'			=> 'admin-full',
				'folder'		=> 'station',
				'controller'	=> 'equipment-measurement-parameter-group',
				'action'		=> 'delete',
				'params'		=> $data->getId( ),
			)));

			$this->view->pick( 'Station/Equipment/Measurement/Parameter/Group/View' );

		}

		/**
		 * Set Permission
		 *
		 * @Acl( "key" = "archive", "name" = "Archive", "description" = "Equipment Measurement Parameter Group Archive." )
		 */

		public function archiveAction ( $id = false ) {

			$language = $this->language->load( 'system', 'Station/Equipment/Measurement/Parameter/Group/Archive' );

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
							'controller' 	=> 'equipment-measurement-parameter-group',
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
								'controller' 	=> 'equipment-measurement-parameter-group',
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
						'controller' 	=> 'equipment-measurement-parameter-group',
						'action' 		=> 'index'
					));

				}

				$this->flash->success( $language->_( 'success_message' ) );

			}

			$this->view->disable( );
			$this->response->redirect( array(
				'for' 			=> 'admin-controller',
				'folder'		=> 'station',
				'controller' 	=> 'equipment-measurement-parameter-group',
			));

			return;

		}

		/**
		 * Set Permission
		 *
		 * @Acl( "key" = "unarchive", "name" = "Unarchive", "description" = "Equipment Measurement Parameter Group Unarchive." )
		 */

		public function unarchiveAction ( $id = false ) {

			$language 	= $this->language->load( 'system', 'Station/Equipment/Measurement/Parameter/Group/Unarchive' );

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
							'controller' 	=> 'equipment-measurement-parameter-group',
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
								'controller' 	=> 'equipment-measurement-parameter-group',
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
						'controller' 	=> 'equipment-measurement-parameter-group',
						'action' 		=> 'index'
					));

				}

				$this->flash->success( $language->_( 'success_message' ) );
			}

			$this->view->disable( );
			$this->response->redirect( array(
				'for' 			=> 'admin-controller',
				'folder'		=> 'station',
				'controller' 	=> 'equipment-measurement-parameter-group',
			));

			return;

		}

		/**
		 * Set Permission
		 *
		 * @Acl( "key" = "delete", "name" = "Delete", "description" = "Equipment Measurement Parameter Group Delete." )
		 */
		
		public function deleteAction ( $id = false ) {

			$language 	= $this->language->load( 'system', 'Station/Equipment/Measurement/Parameter/Group/Delete' );

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
							'controller' 	=> 'equipment-measurement-parameter-group',
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
								'controller' 	=> 'equipment-measurement-parameter-group',
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
						'controller' 	=> 'equipment-measurement-parameter-group',
						'action' 		=> 'index'
					));

				}

				$this->flash->success( $language->_( 'success_message' ) );
			}

			$this->view->disable( );
			$this->response->redirect( array(
				'for' 			=> 'admin-controller',
				'folder'		=> 'station',
				'controller' 	=> 'equipment-measurement-parameter-group',
			));

			return;
		}

		public function saveAction ( $id = false ) {

			if ( $this->request->isPost( ) == true ) {

				$add_language 		= $this->language->load( 'system', 'Station/Equipment/Measurement/Parameter/Group/Add' );
				$edit_language 		= $this->language->load( 'system', 'Station/Equipment/Measurement/Parameter/Group/Edit' );
				$common_language 	= $this->language->load( 'system', 'Station/Equipment/Measurement/Parameter/Group/Common' );
				
				if ( $this->security->checkToken( ) ) {

					$data 				= new \stdClass( );
					
					if ( is_numeric( $id ) ) {
						$data->id = ( int ) $id;
					} 	

					$data->title       = $this->request->getPost( 'title', 'string' );
					$data->description = $this->request->getPost( 'description', 'string' );
					$data->parameter   = $this->request->getPost( 'parameter' );
					$data->sort_order  = $this->request->getPost( 'sort_order', 'int' );
					
					$validator = new Validation( );
					$validator->add( 'title', new PresenceOf( array(
						'cancelOnFail'	=> true,
						'message'		=> $common_language->_( 'validate_title' ),
					)));

					if ( count( $validator->getMessages( ) ) ) {
						foreach( $validator->getMessages( ) as $message ) {
							$this->flash->error( $message->getMessage( ) );
						}

						if ( $data->id ) {
							$this->dispatcher->forward( array(
								'for' 			=> 'admin-full',
								'folder'		=> 'station',
								'controller' 	=> 'equipment-measurement-parameter-group',
								'action'		=> 'edit',
								'params'		=> array( $data->id )
							));
						} else {
							$this->dispatcher->forward( array(
								'for' 			=> 'admin-action',
								'folder'		=> 'station',
								'controller' 	=> 'equipment-measurement-parameter-group',
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
									'controller' 	=> 'equipment-measurement-parameter-group',
									'action'		=> 'edit',
									'params'		=> $data->id
								));
							} else {
								$this->flash->error( $edit_language->_( 'error_message' ) );
								$this->dispatcher->forward( array(
									'for' 			=> 'admin-full',
									'folder'		=> 'station',
									'controller' 	=> 'equipment-measurement-parameter-group',
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
									'controller' 	=> 'equipment-measurement-parameter-group',
								));
							} else {
								$this->flash->error( $add_language->_( 'error_message' ) );
								$this->dispatcher->forward( array(
									'for' 			=> 'admin-action',
									'folder'		=> 'station',
									'controller' 	=> 'equipment-measurement-parameter-group',
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
				'controller' 	=> 'equipment-measurement-parameter-group',
			));

			return;

		}

		private function _store ( $data ) {

			if ( isset( $data->id ) ) { 
				
				$parameter_group_data = EquipmentMeasurementParameterGroup::findFirst( $data->id );
				
				if ( !is_object( $parameter_group_data ) ) {
					$parameter_group_data = new EquipmentMeasurementParameterGroup( );
				}

			} else {
				$parameter_group_data = new EquipmentMeasurementParameterGroup( );
			}

			$parameter_group_data->title       = $data->title;
			$parameter_group_data->description = $data->description;
			$parameter_group_data->sort_order  = $data->sort_order;
			
			$data->data                      = $parameter_group_data;
			$data->is_saved                  = $parameter_group_data->save( );
			$data->messages                  = $parameter_group_data->getMessages( );

			if ( $data->is_saved ) {	
				$parameter_group_data->getEquipmentMeasurementParameterGroupLink( )->delete( );
				foreach ( $data->parameter as $parameter_id ) {
					$parameter_group_relation                                                   = new EquipmentMeasurementParameterGroupLink( );
					$parameter_group_relation->station_equipment_measurement_parameter_group_id = $parameter_group_data->getId( );
					$parameter_group_relation->station_equipment_measurement_parameter_id       = $parameter_id;
					$parameter_group_relation->save( );
				}
			}

			return $data;

		}

		private function _preserve ( $id = false ) {

			$data = EquipmentMeasurementParameterGroup::findFirst( $id );

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

			$data = EquipmentMeasurementParameterGroup::findFirst( $id );

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

			$data = EquipmentMeasurementParameterGroup::findFirst( $id );

			if ( is_object( $data ) ) {
					
				if ( $data->delete( ) == false ) {
					
					$data->is_deleted 	= ( int ) false;	
					return $data;

				}

			} 

			return true;

		}

	} // END CLASS EQUIPMENT MEASUREMENT PARAMETER GROUP CONTROLLER