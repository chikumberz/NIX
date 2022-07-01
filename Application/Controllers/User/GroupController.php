<?php

	namespace Application\Controllers\User;

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

	use \Application\Models\User\Group;

	/**
	 * Access Control List
	 *
	 * @Acl( "controller" = "Group", "description" = "Group Access." )
	 */

	class GroupController extends \Application\Controllers\BaseController {

		/**
		 * Set Permission
		 *
		 * @Acl( "key" = "index", "name" = "Index", "description" = "Group Index." )
		 */

		public function indexAction ( ) {

			$language 		= $this->language->load( 'system', array( 'User/Group/Common', 'User/Group/Index' ) );
			
			$this->view->setVar( '_', 	$language );

			$__GRID_SESSION_KEY__ 	= 'user-group';

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
				->addFrom( 'Application\Models\User\Group', 'Group' );
				
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

			$this->view->setVar( 'var_controller', 					'group' );
			$this->view->setVar( 'var_table_shows',					$this->setting->get( 'sys', 'table_show' ) );
			$this->view->setVar( 'var_token_key',					$this->security->getTokenKey( ) );
			$this->view->setVar( 'var_token', 						$this->security->getToken( ) );

			$this->view->setVar( 'var_breadcrumbs', array(
				'Users' 		=> $this->url->get( array(
					'for' 			=> 'admin-controller',
					'folder' 		=> 'user',
					'controller' 	=> 'account',
				)),
				'Groups' 		=> $this->url->get( array(
					'for' 			=> 'admin-controller',
					'folder' 		=> 'user',
					'controller' 	=> 'group',
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

			$this->view->pick( 'User/Group/Index' );

		}

		/**
		 * Set Permission
		 *
		 * @Acl( "key" = "add", "name" = "Add", "description" = "Group Add." )
		 */

		public function addAction ( ) {

			$this->acl->clear( ); 
			
			$language = $this->language->load( 'system', array( 'User/Group/Common', 'User/Group/Add' ) );

			$this->view->setVar( '_', 						$language );
			$this->view->setVar( 'var_token_key',			$this->security->getTokenKey( ) );
			$this->view->setVar( 'var_token', 				$this->security->getToken( ) );
			$this->view->setVar( 'var_permissions', 		$this->acl->getResources( ) );
			$this->view->setVar( 'var_created_on',			$language->_( 'text_no_available' ) );
			$this->view->setVar( 'var_updated_on',			$language->_( 'text_no_available' ) );

			if ( $this->request->isPost( ) && $this->request->hasPost( 'permissions' ) ) {
				$permissions = $this->request->getPost( 'permissions' );
				foreach ( $permissions as $index => $permission ) {
					foreach ( $permission as $key => $access ) {
						$this->tag->setDefault( "permissions[{$index}][{$key}]", $access );
					}
				}
			}

			$this->tag->setDefault( 'sort_order', 			0 );

			$this->view->setVar( 'var_breadcrumbs', array(
				'Users' 		=> $this->url->get( array(
					'for' 			=> 'admin-controller',
					'folder' 		=> 'user',
					'controller' 	=> 'account',
				)),
				'Groups' 	=> $this->url->get( array(
					'for' 			=> 'admin-controller',
					'folder' 		=> 'user',
					'controller' 	=> 'group',
				)),
				'Add' 	=> $this->url->get( array(
					'for' 			=> 'admin-action',
					'folder' 		=> 'user',
					'controller' 	=> 'group',
					'action' 		=> 'add',
				)),
			));

			$this->view->setVar( 'var_form_url', $this->url->get( array(
				'for'			=> 'admin-action',
				'folder'		=> 'user',
				'controller'	=> 'group',
				'action'		=> 'save'
			)));

			$this->view->pick( 'User/Group/Add' );

		}

		/**
		 * Set Permission
		 *
		 * @Acl( "key" = "edit", "name" = "Edit", "description" = "Group Edit." )
		 */

		public function editAction ( $id = false ) {

			$data		= Group::findFirst( array(  
				'( is_archived = 0 OR is_archived IS NULL ) AND user_group_id = ?0',
				'bind' => array(
					( int ) $id
				)
			));
			$language 	= $this->language->load( 'system', array( 'User/Group/Common', 'User/Group/Edit' ) );

			if ( !is_object( $data ) ) {
				$this->flash->error( $language->_( 'not_found_message' ) );
				return $this->response->redirect( array(
					'for' 			=> 'admin-controller',
					'folder'		=> 'user',
					'controller' 	=> 'group'
				));
			}

			$this->acl->clear( );

			$this->view->setVar( '_', 						$language );
			$this->view->setVar( 'var_token_key',			$this->security->getTokenKey( ) );
			$this->view->setVar( 'var_token', 				$this->security->getToken( ) );
			$this->view->setVar( 'var_permissions', 		$this->acl->getResources( ) );
			$this->view->setVar( 'var_created_on',			date( $language->_( 'format_date' ), strtotime( $data->created_on ) ) );
			$this->view->setVar( 'var_updated_on',			date( $language->_( 'format_date' ), strtotime( $data->updated_on ) ) );

			$this->tag->setDefault( 'group', 				$data->group );
			$this->tag->setDefault( 'description', 			$data->description );
			$this->tag->setDefault( 'sort_order', 			$data->sort_order );

			if ( $this->request->isPost( ) && $this->request->hasPost( 'permissions' ) ) {
				$permissions = $this->request->getPost( 'permissions' );
				foreach ( $permissions as $index => $permission ) {
					foreach ( $permission as $key => $access ) {
						$this->tag->setDefault( "permissions[{$index}][{$key}]", $access );
					}
				}
			} else {
				$permissions = $data->getPermissions( );
				foreach ( $permissions as $index => $permission ) {
					foreach ( $permission as $key => $access ) {
						$this->tag->setDefault( "permissions[{$index}][{$key}]", $access );
					}
				}
			}
			
			$this->view->setVar( 'var_breadcrumbs', array(
				'Users' 		=> $this->url->get( array(
					'for' 			=> 'admin-controller',
					'folder' 		=> 'user',
					'controller' 	=> 'account',
				)),
				'Groups' 	=> $this->url->get( array(
					'for' 			=> 'admin-controller',
					'folder' 		=> 'user',
					'controller' 	=> 'group',
				)),
				'Edit' 	=> $this->url->get( array(
					'for' 			=> 'admin-action',
					'folder' 		=> 'user',
					'controller' 	=> 'group',
					'action' 		=> 'edit',
				)),
			));

			$this->view->setVar( 'var_form_url', $this->url->get( array(
				'for'			=> 'admin-full',
				'folder'		=> 'user',
				'controller'	=> 'group',
				'action'		=> 'save',
				'params'		=> $data->getId( ),
			)));

			$this->view->pick( 'User/Group/Edit' );

		}

		/**
		 * Set Permission
		 *
		 * @Acl( "key" = "view", "name" = "View", "description" = "Group View." )
		 */

		public function viewAction ( $id = false ) {

			$data		= Group::findFirst( array(  
				'( is_archived = 0 OR is_archived IS NULL ) AND user_group_id = ?0',
				'bind' => array(
					( int ) $id
				)
			));
			$language 	= $this->language->load( 'system', array( 'User/Group/Common', 'User/Group/Delete', 'User/Group/View' ) );

			if ( !is_object( $data ) ) {
				$this->flash->error( $language->_( 'not_found_message' ) );
				return $this->response->redirect( array(
					'for' 			=> 'admin-controller',
					'folder'		=> 'user',
					'controller' 	=> 'group'
				));
			}

			$this->acl->clear( );
			
			$this->view->setVar( '_', 						$language );
			
			$this->view->setVar( 'group', 							$data->group );
			$this->view->setVar( 'description', 					$data->description );
			$this->view->setVar( 'permissions', 					$data->getPermissions( ) );
			$this->view->setVar( 'sort_order', 						$data->sort_order );

			$this->view->setVar( 'var_permissions', 				$this->acl->getResources( ) );
			$this->view->setVar( 'var_created_on',					date( $language->_( 'format_date' ), strtotime( $data->created_on ) ) );
			$this->view->setVar( 'var_updated_on',					date( $language->_( 'format_date' ), strtotime( $data->updated_on ) ) );

			$permissions = $data->getPermissions( );
			foreach ( $permissions as $index => $permission ) {
				foreach ( $permission as $key => $access ) {
					$this->tag->setDefault( "permissions[{$index}][{$key}]", $access );
				}
			}

			$this->view->setVar( 'var_breadcrumbs', array(
				'Users' 		=> $this->url->get( array(
					'for' 			=> 'admin-controller',
					'folder' 		=> 'user',
					'controller' 	=> 'account',
				)),
				'Groups' 	=> $this->url->get( array(
					'for' 			=> 'admin-controller',
					'folder' 		=> 'user',
					'controller' 	=> 'group',
				)),
				'Edit' 	=> $this->url->get( array(
					'for' 			=> 'admin-action',
					'folder' 		=> 'user',
					'controller' 	=> 'group',
					'action' 		=> 'view',
				)),
			));

			$this->view->setVar( 'var_edit_url', $this->url->get( array(
				'for'			=> 'admin-full',
				'folder'		=> 'user',
				'controller'	=> 'group',
				'action'		=> 'edit',
				'params'		=> $data->getId( ),
			)));

			$this->view->setVar( 'var_archive_url', $this->url->get( array(
				'for'			=> 'admin-full',
				'folder'		=> 'user',
				'controller'	=> 'group',
				'action'		=> 'archive',
				'params'		=> $data->getId( ),
			)));

			$this->view->setVar( 'var_delete_url', $this->url->get( array(
				'for'			=> 'admin-full',
				'folder'		=> 'user',
				'controller'	=> 'group',
				'action'		=> 'delete',
				'params'		=> $data->getId( ),
			)));

			$this->view->pick( 'User/Group/View' );

		}

		/**
		 * Set Permission
		 *
		 * @Acl( "key" = "archive", "name" = "Archive", "description" = "Group Archive." )
		 */

		public function archiveAction ( $id = false ) {

			$language 		= $this->language->load( 'system', 'User/Group/Archive' );

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
							'folder'		=> 'user',
							'controller' 	=> 'group',
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
								'folder'		=> 'user',
								'controller' 	=> 'group',
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
						'folder'		=> 'user',
						'controller' 	=> 'group',
						'action' 		=> 'index'
					));

				}

				$this->flash->success( $language->_( 'success_message' ) );

			}

			$this->view->disable( );
			$this->response->redirect( array(
				'for' 			=> 'admin-controller',
				'folder'		=> 'user',
				'controller' 	=> 'group'
			));

			return;

		}

		/**
		 * Set Permission
		 *
		 * @Acl( "key" = "unarchive", "name" = "Unarchive", "description" = "Group Unarchive." )
		 */

		public function unarchiveAction ( $id = false ) {

			$language 	= $this->language->load( 'system', 'User/Group/Unarchive' );

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
							'folder'		=> 'user',
							'controller' 	=> 'group',
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
								'folder'		=> 'user',
								'controller' 	=> 'group',
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
						'folder'		=> 'user',
						'controller' 	=> 'group',
						'action' 		=> 'index'
					));

				}

				$this->flash->success( $language->_( 'success_message' ) );
			}

			$this->view->disable( );
			$this->response->redirect( array(
				'for' 			=> 'admin-controller',
				'folder'		=> 'user',
				'controller' 	=> 'group'
			));

			return;

		}

		/**
		 * Set Permission
		 *
		 * @Acl( "key" = "delete", "name" = "Delete", "description" = "Group Delete." )
		 */

		public function deleteAction ( $id = false ) {

			$language 	= $this->language->load( 'system', 'User/Group/Delete' );

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
							'folder'		=> 'user',
							'controller' 	=> 'group',
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
								'folder'		=> 'user',
								'controller' 	=> 'group',
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
						'folder'		=> 'user',
						'controller' 	=> 'group',
						'action' 		=> 'index'
					));

				}

				$this->flash->success( $language->_( 'success_message' ) );
			}

			$this->view->disable( );
			$this->response->redirect( array(
				'for' 			=> 'admin-controller',
				'folder'		=> 'user',
				'controller' 	=> 'group'
			));

			return;
		}

		public function saveAction ( $id = false ) {

			if ( $this->request->isPost( ) == true ) {

				$add_language 		= $this->language->load( 'system', 'User/Group/Add' );
				$edit_language 		= $this->language->load( 'system', 'User/Group/Edit' );
				$common_language 	= $this->language->load( 'system', 'User/Group/Common' );
				
				if ( $this->security->checkToken( ) ) {

					$data 				= new \stdClass( );
					
					if ( is_numeric( $id ) ) {
						$data->id = ( int ) $id;
					} 	

					$data->group 		= $this->request->getPost( 'group', 'string' );
					$data->description 	= $this->request->getPost( 'description', 'string' );
					$data->permissions 	= serialize( $this->request->getPost( 'permissions' ) );
					$data->sort_order 	= $this->request->getPost( 'sort_order', 'int' );
					
					$validator = new Validation( );
					$validator->add( 'group', new PresenceOf( array(
						'cancelOnFail'	=> true,
						'message'		=> $common_language->_( 'validate_group' ),
					)));

					if ( count( $validator->getMessages( ) ) ) {
						foreach( $validator->getMessages( ) as $message ) {
							$this->flash->error( $message->getMessage( ) );
						}

						if ( $data->id ) {
							$this->dispatcher->forward( array(
								'for' 			=> 'admin-full',
								'folder'		=> 'user',
								'controller' 	=> 'group',
								'action'		=> 'edit',
								'params'		=> array( $data->id )
							));
						} else {
							$this->dispatcher->forward( array(
								'for' 			=> 'admin-action',
								'folder'		=> 'user',
								'controller' 	=> 'group',
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
									'folder'		=> 'user',
									'controller' 	=> 'group',
									'action'		=> 'edit',
									'params'		=> $data->id
								));
							} else {
								$this->flash->error( $edit_language->_( 'error_message' ) );
								$this->dispatcher->forward( array(
									'for' 			=> 'admin-full',
									'folder'		=> 'user',
									'controller' 	=> 'group',
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
									'folder'		=> 'user',
									'controller' 	=> 'group'
								));
							} else {
								$this->flash->error( $add_language->_( 'error_message' ) );
								$this->dispatcher->forward( array(
									'for' 			=> 'admin-action',
									'folder'		=> 'user',
									'controller' 	=> 'group',
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
				'folder'		=> 'user',
				'controller' 	=> 'group'
			));

			return;

		}

		private function _store ( $data ) {

			if ( isset( $data->id ) ) { 
				
				$group_data = Group::findFirst( $data->id );
				
				if ( !is_object( $group_data ) ) {
					$group_data = new Group( );
				}

			} else {
				$group_data = new Group( );
			}

			
			$group_data->group 				= $data->group;
			$group_data->description 		= $data->description;
			$group_data->permissions 		= $data->permissions;
			$group_data->sort_order 		= $data->sort_order;

			$data->data 					= $group_data;
			$data->is_saved					= $group_data->save( );
			$data->messages					= $group_data->getMessages( );

			return $data;

		}

		private function _preserve ( $id = false ) {

			$data = Group::findFirst( $id );

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

			$data = Group::findFirst( $id );

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

			$data = Group::findFirst( $id );

			if ( is_object( $data ) ) {
					
				if ( $data->delete( ) == false ) {
					
					$data->is_deleted 	= ( int ) false;	
					return $data;

				}

			} 

			return true;

		}

	} // END CLASS GROUP CONTROLLER