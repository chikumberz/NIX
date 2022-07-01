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

	use \Application\Models\User\Account,
		\Application\Models\User\Profile,
		\Application\Models\User\Group,
		\Application\Models\User\Status,
		\Application\Models\Country\Country;

	/**
	 * Access Control List
	 *
	 * @Acl( "controller" = "Account", "description" = "Account Access." )
	 */

	class AccountController extends \Application\Controllers\BaseController {

		/**
		 * Set Permission
		 *
		 * @Acl( "key" = "index", "name" = "Index", "description" = "Account Index." )
		 */

		public function indexAction ( ) {

			$language 		= $this->language->load( 'system', array( 'User/Account/Common', 'User/Account/Index' ) );
			
			$this->view->setVar( '_', 	$language );

			$__GRID_SESSION_KEY__ 	= 'user-account';

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
				->addFrom( 'Application\Models\User\Account', 'Account' )
				->leftJoin( 'Application\Models\User\Status', '[Account].user_status_id = [Status].user_status_id', 'Status' )
				->leftJoin( 'Application\Models\User\Group', '[Account].user_group_id = [Group].user_group_id', 'Group' )
				->leftJoin( 'Application\Models\User\Profile', '[Account].user_account_id = [Profile].user_account_id', 'Profile' )
				->leftJoin( 'Application\Models\Country\Country', '[Profile].country_id = [Country].country_id', 'Country' );
				
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

			$this->view->setVar( 'var_controller', 					'account' );
			$this->view->setVar( 'var_table_shows',					$this->setting->get( 'sys', 'table_show' ) );
			$this->view->setVar( 'var_token_key',					$this->security->getTokenKey( ) );
			$this->view->setVar( 'var_token', 						$this->security->getToken( ) );

			$this->view->setVar( 'var_breadcrumbs', array(
				'Users' 		=> $this->url->get( array(
					'for' 			=> 'admin-controller',
					'folder' 		=> 'country',
					'controller' 	=> 'country',
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

			$this->view->pick( 'User/Account/Index' );

		}

		/**
		 * Set Permission
		 *
		 * @Acl( "key" = "add", "name" = "Add", "description" = "Account Add." )
		 */

		public function addAction ( ) {
			
			$language 	= $this->language->load( 'system', array( 'User/Account/Common', 'User/Account/Add' ) );

			$this->view->setVar( '_', 						$language );

			$this->view->setVar( 'var_token_key',			$this->security->getTokenKey( ) );
			$this->view->setVar( 'var_token', 				$this->security->getToken( ) );
			$this->view->setVar( 'var_countries',  			Country::find( array(  
				'( is_archived = 0 OR is_archived IS NULL )'
			)));
			$this->view->setVar( 'var_groups',  			Group::find( array(  
				'( is_archived = 0 OR is_archived IS NULL )'
			)));
			$this->view->setVar( 'var_status',  			Status::find( array(  
				'( is_archived = 0 OR is_archived IS NULL )'
			)));
			$this->view->setVar( 'var_created_on',			$language->_( 'text_no_available' ) );
			$this->view->setVar( 'var_updated_on',			$language->_( 'text_no_available' ) );

			$this->view->setVar( 'var_breadcrumbs', array(
				'Users' 		=> $this->url->get( array(
					'for' 			=> 'admin-controller',
					'folder' 		=> 'user',
					'controller' 	=> 'account',
				)),
				'Accounts' 	=> $this->url->get( array(
					'for' 			=> 'admin-controller',
					'folder' 		=> 'user',
					'controller' 	=> 'account',
				)),
				'Add' 	=> $this->url->get( array(
					'for' 			=> 'admin-action',
					'folder' 		=> 'user',
					'controller' 	=> 'account',
					'action' 		=> 'add',
				)),
			));

			$this->view->setVar( 'var_form_url', $this->url->get( array(
				'for'			=> 'admin-action',
				'folder'		=> 'user',
				'controller'	=> 'account',
				'action'		=> 'save'
			)));

			$this->view->pick( 'User/Account/Add' );

		}

		/**
		 * Set Permission
		 *
		 * @Acl( "key" = "edit", "name" = "Edit", "description" = "Account Edit." )
		 */

		public function editAction ( $id = false ) {

			$data		= Account::findFirst( array(  
				'( is_archived = 0 OR is_archived IS NULL ) AND user_account_id = ?0',
				'bind' => array(
					( int ) $id
				)
			));
			$language 	= $this->language->load( 'system', array( 'User/Account/Common', 'User/Account/Edit' ) );

			if ( !is_object( $data ) ) {
				$this->flash->error( $language->_( 'not_found_message' ) );
				return $this->response->redirect( array(
					'for' 			=> 'admin-controller',
					'folder'		=> 'user',
					'controller' 	=> 'account'
				));
			}

			$this->view->setVar( '_', 								$language );
			$this->view->setVar( 'var_token_key',					$this->security->getTokenKey( ) );
			$this->view->setVar( 'var_token', 						$this->security->getToken( ) );
			$this->view->setVar( 'var_countries',  					Country::find( array(  
				'( is_archived = 0 OR is_archived IS NULL )'
			)));
			$this->view->setVar( 'var_groups',  					Group::find( array(  
				'( is_archived = 0 OR is_archived IS NULL )'
			)));
			$this->view->setVar( 'var_status',  					Status::find( array(  
				'( is_archived = 0 OR is_archived IS NULL )'
			)));

			$this->tag->setDefault( 'first_name', 					$data->profile->first_name );
			$this->tag->setDefault( 'middle_name',					$data->profile->middle_name );
			$this->tag->setDefault( 'last_name',					$data->profile->last_name );
			$this->tag->setDefault( 'gender', 						$data->profile->gender );
			$this->tag->setDefault( 'birth_date',					$data->profile->birth_date );
			$this->tag->setDefault( 'birth_place',					$data->profile->birth_place );
			$this->tag->setDefault( 'mobile_no',					$data->profile->mobile_no );
			$this->tag->setDefault( 'telephone_no',					$data->profile->telephone_no );
			$this->tag->setDefault( 'fax_no',						$data->profile->fax_no );
			$this->tag->setDefault( 'address',						$data->profile->address );
			$this->tag->setDefault( 'city',							$data->profile->city );
			$this->tag->setDefault( 'state',						$data->profile->state );
			$this->tag->setDefault( 'zip',							$data->profile->zip );
			$this->tag->setDefault( 'country_id',					$data->profile->country_id );
			$this->tag->setDefault( 'email',						$data->email );
			$this->tag->setDefault( 'username',						$data->username );
			$this->tag->setDefault( 'status_id',					$data->user_status_id );
			$this->tag->setDefault( 'group_id',						$data->user_group_id );

			$this->view->setVar( 'var_created_on',					date( $language->_( 'format_date' ), strtotime( $data->created_on ) ) );
			$this->view->setVar( 'var_updated_on',					date( $language->_( 'format_date' ), strtotime( $data->updated_on ) ) );

			if ( file_exists( $this->config->directories->public->files->dir . 'Images/System/Avatar/' . $data->avatar ) ) {
				$this->view->setVar( 'var_avatar', 						$this->url->get( array( 
					'for'    => 'file-public', 
					'folder' => 'Images/System/Avatar/Thumb', 
					'file'   => $data->avatar 
				)));
			} else {
				$this->view->setVar( 'var_avatar', 						$this->url->get( array( 
					'for'    => 'file-public', 
					'folder' => 'Images/System/Avatar', 
					'file'   => 'default-avatar.jpg'
				)));
			}

			$this->view->setVar( 'var_breadcrumbs', array(
				'Users' 		=> $this->url->get( array(
					'for' 			=> 'admin-controller',
					'folder' 		=> 'user',
					'controller' 	=> 'account',
				)),
				'Accounts' 	=> $this->url->get( array(
					'for' 			=> 'admin-controller',
					'folder' 		=> 'user',
					'controller' 	=> 'account',
				)),
				'Edit' 	=> $this->url->get( array(
					'for' 			=> 'admin-action',
					'folder' 		=> 'user',
					'controller' 	=> 'account',
					'action' 		=> 'edit',
				)),
			));

			$this->view->setVar( 'var_form_url', $this->url->get( array(
				'for'			=> 'admin-full',
				'folder'		=> 'user',
				'controller'	=> 'account',
				'action'		=> 'save',
				'params'		=> $data->getId( ),
			)));

			$this->view->pick( 'User/Account/Edit' );

		}

		/**
		 * Set Permission
		 *
		 * @Acl( "key" = "view", "name" = "View", "description" = "Account View." )
		 */

		public function viewAction ( $id = false ) {

			$data		= Account::findFirst( array(  
				'( is_archived = 0 OR is_archived IS NULL ) AND user_account_id = ?0',
				'bind' => array(
					( int ) $id
				)
			));
			$language 	= $this->language->load( 'system', array( 'User/Account/Common', 'User/Account/Delete', 'User/Account/View' ) );

			if ( !is_object( $data ) ) {
				$this->flash->error( $language->_( 'not_found_message' ) );
				return $this->response->redirect( array(
					'for' 			=> 'admin-controller',
					'folder'		=> 'user',
					'controller' 	=> 'account'
				));
			}

			$this->view->setVar( '_', 								$language );

			$this->view->setVar( 'first_name', 						$data->profile->first_name );
			$this->view->setVar( 'middle_name',						$data->profile->middle_name );
			$this->view->setVar( 'last_name',						$data->profile->last_name );
			$this->view->setVar( 'gender', 							$data->profile->gender );
			$this->view->setVar( 'birth_date',						$data->profile->birth_date );
			$this->view->setVar( 'birth_place',						$data->profile->birth_place );
			$this->view->setVar( 'mobile_no',						$data->profile->mobile_no );
			$this->view->setVar( 'telephone_no',					$data->profile->telephone_no );
			$this->view->setVar( 'fax_no',							$data->profile->fax_no );
			$this->view->setVar( 'address',							$data->profile->address );
			$this->view->setVar( 'city',							$data->profile->city );
			$this->view->setVar( 'state',							$data->profile->state );
			$this->view->setVar( 'zip',								$data->profile->zip );
			$this->view->setVar( 'country_id',						$data->profile->country_id );
			$this->view->setVar( 'country',							$data->profile->country->country );
			$this->view->setVar( 'email',							$data->email );
			$this->view->setVar( 'username',						$data->username );
			$this->view->setVar( 'status_id',						$data->user_status_id );
			$this->view->setVar( 'status',							$data->status->status );
			$this->view->setVar( 'group_id',						$data->user_group_id );
			$this->view->setVar( 'group',							$data->group->group );

			$this->view->setVar( 'var_created_on',					date( $language->_( 'format_date' ), strtotime( $data->created_on ) ) );
			$this->view->setVar( 'var_updated_on',					date( $language->_( 'format_date' ), strtotime( $data->updated_on ) ) );

			if ( file_exists( $this->config->directories->public->files->dir . 'Images/System/Avatar/' . $data->avatar ) ) {
				$this->view->setVar( 'var_avatar', 						$this->url->get( array( 
					'for'    => 'file-public', 
					'folder' => 'Images/System/Avatar/Thumb', 
					'file'   => $data->avatar 
				)));
			} else {
				$this->view->setVar( 'var_avatar', 						$this->url->get( array( 
					'for'    => 'file-public', 
					'folder' => 'Images/System/Avatar', 
					'file'   => 'default-avatar.jpg'
				)));
			}

			$this->view->setVar( 'var_breadcrumbs', array(
				'Users' 		=> $this->url->get( array(
					'for' 			=> 'admin-controller',
					'folder' 		=> 'user',
					'controller' 	=> 'account',
				)),
				'Accounts' 	=> $this->url->get( array(
					'for' 			=> 'admin-controller',
					'folder' 		=> 'user',
					'controller' 	=> 'account',
				)),
				'Edit' 	=> $this->url->get( array(
					'for' 			=> 'admin-action',
					'folder' 		=> 'user',
					'controller' 	=> 'account',
					'action' 		=> 'view',
				)),
			));

			$this->view->setVar( 'var_edit_url', $this->url->get( array(
				'for'			=> 'admin-full',
				'folder'		=> 'user',
				'controller'	=> 'account',
				'action'		=> 'edit',
				'params'		=> $data->getId( ),
			)));

			$this->view->setVar( 'var_archive_url', $this->url->get( array(
				'for'			=> 'admin-full',
				'folder'		=> 'user',
				'controller'	=> 'account',
				'action'		=> 'archive',
				'params'		=> $data->getId( ),
			)));

			$this->view->setVar( 'var_delete_url', $this->url->get( array(
				'for'			=> 'admin-full',
				'folder'		=> 'user',
				'controller'	=> 'account',
				'action'		=> 'delete',
				'params'		=> $data->getId( ),
			)));

			$this->view->pick( 'User/Account/View' );

		}

		/**
		 * Set Permission
		 *
		 * @Acl( "key" = "archive", "name" = "Archive", "description" = "Account Archive." )
		 */

		public function archiveAction ( $id = false ) {

			$language 		= $this->language->load( 'system', 'User/Account/Archive' );

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
							'controller' 	=> 'account',
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
								'controller' 	=> 'account',
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
						'controller' 	=> 'account',
						'action' 		=> 'index'
					));

				}

				$this->flash->success( $language->_( 'success_message' ) );

			}

			$this->view->disable( );
			$this->response->redirect( array(
				'for' 			=> 'admin-controller',
				'folder'		=> 'user',
				'controller' 	=> 'account'
			));

			return;

		}

		/**
		 * Set Permission
		 *
		 * @Acl( "key" = "unarchive", "name" = "Unarchive", "description" = "Account Unarchive." )
		 */

		public function unarchiveAction ( $id = false ) {

			$language 	= $this->language->load( 'system', 'User/Account/Unarchive' );

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
							'controller' 	=> 'account',
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
								'controller' 	=> 'account',
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
						'controller' 	=> 'account',
						'action' 		=> 'index'
					));

				}

				$this->flash->success( $language->_( 'success_message' ) );
			}

			$this->view->disable( );
			$this->response->redirect( array(
				'for' 			=> 'admin-controller',
				'folder'		=> 'user',
				'controller' 	=> 'account'
			));

			return;

		}

		/**
		 * Set Permission
		 *
		 * @Acl( "key" = "delete", "name" = "Delete", "description" = "Account Delete." )
		 */

		public function deleteAction ( $id = false ) {

			$language 	= $this->language->load( 'system', 'User/Account/Delete' );

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
							'controller' 	=> 'account',
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
								'controller' 	=> 'account',
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
						'controller' 	=> 'account',
						'action' 		=> 'index'
					));

				}

				$this->flash->success( $language->_( 'success_message' ) );
			}

			$this->view->disable( );
			$this->response->redirect( array(
				'for' 			=> 'admin-controller',
				'folder'		=> 'user',
				'controller' 	=> 'account'
			));

			return;
		}

		public function saveAction ( $id = false ) {

			if ( $this->request->isPost( ) == true ) {

				$add_language 		= $this->language->load( 'system', 'User/Account/Add' );
				$edit_language 		= $this->language->load( 'system', 'User/Account/Edit' );
				$common_language 	= $this->language->load( 'system', 'User/Account/Common' );
				
				if ( $this->security->checkToken( ) ) {

					$data 				= new \stdClass( );
					
					if ( is_numeric( $id ) ) {
						$data->id = ( int ) $id;
					} 	

					$data->username 				= $this->request->getPost( 'username', 			'string' );
					$data->password 				= $this->request->getPost( 'password', 			'string' );
					$data->password_confirm 		= $this->request->getPost( 'password_confirm', 	'string' );
					$data->group_id 				= $this->request->getPost( 'group_id', 			'int' );
					$data->status_id 				= $this->request->getPost( 'status_id', 		'int' );
					$data->first_name 				= $this->request->getPost( 'first_name', 		'string' );
					$data->middle_name 				= $this->request->getPost( 'middle_name', 		'string' );
					$data->last_name 				= $this->request->getPost( 'last_name', 		'string' );
					$data->gender 					= $this->request->getPost( 'gender', 			'string' );
					$data->birth_date 				= $this->request->getPost( 'birth_date', 		'string' );
					$data->birth_place 				= $this->request->getPost( 'birth_place', 		'string' );
					$data->mobile_no 				= $this->request->getPost( 'mobile_no', 		'string' );
					$data->telephone_no 			= $this->request->getPost( 'telephone_no', 		'string' );
					$data->fax_no 					= $this->request->getPost( 'fax_no', 			'string' );
					$data->email 					= $this->request->getPost( 'email', 			'email' );
					$data->address 					= $this->request->getPost( 'address', 			'string' );
					$data->city 					= $this->request->getPost( 'city', 				'string' );
					$data->state 					= $this->request->getPost( 'state', 			'string' );
					$data->zip 						= $this->request->getPost( 'zip', 				'string' );
					$data->country_id 				= $this->request->getPost( 'country_id', 		'int' );
					
					$list_countries_id 	= array( );
					$list_groups_id 	= array( );
					$list_status_id 	= array( );

					$list_countries 	= Country::find( array(  
						'( is_archived = 0 OR is_archived IS NULL )'
					));
					$list_groups 		= Group::find( array(  
						'( is_archived = 0 OR is_archived IS NULL )'
					));
					$list_status 		= Status::find( array(  
						'( is_archived = 0 OR is_archived IS NULL )'
					));

					foreach ( $list_countries as $country ) {
						$list_countries_id[] = $country->country_id;
					}

					foreach ( $list_groups as $group ) {
						$list_groups_id[] = $group->user_group_id;
					}

					foreach ( $list_status as $status ) {
						$list_status_id[] = $status->user_status_id;
					}

					$validator = new Validation( );
					$validator->add( 'username', new PresenceOf( array(
						'cancelOnFail'	=> true,
						'message'		=> $common_language->_( 'validate_username' ),
					)));
					$validator->add( 'username', new StringLength( array(
						'cancelOnFail'		=> true,
						'min'				=> 5,
						'max'				=> 30,
						'messageMinimum'	=> $common_language->_( 'validate_username_min_length', array( 
												'username_length' => 6
											)),
						'messageMaximum'	=> $common_language->_( 'validate_username_max_length', array( 
												'username_length' => 6
											))
					)));

					if ( !isset( $data->id ) || $data->password ) {

						$validator->add( 'password', new PresenceOf( array(
							'cancelOnFail'	=> true,
							'message'		=> $common_language->_( 'validate_password' ),
						)));
						$validator->add( 'password', new StringLength( array(
							'cancelOnFail'		=> true,
							'min'				=> 5,
							'max'				=> 30,
							'messageMinimum'	=> $common_language->_( 'validate_password_min_length', array( 
													'password_length' => 6
												)),
							'messageMaximum'	=> $common_language->_( 'validate_password_max_length', array( 
													'password_length' => 6
												))
						)));
						$validator->add( 'password', new Confirmation( array(
							'cancelOnFail'	=> true,
							'with'			=> 'password_confirm',
							'message'		=> $common_language->_( 'validate_password_not_match' )
						)));
					}

					$validator->add( 'email', new Email( array(
						'cancelOnFail'	=> true,
						'message'		=> $common_language->_( 'validate_email' )
					)));
					$validator->add( 'country_id', new InclusionIn( array(
						'cancelOnFail'	=> true,
						'domain'		=> $list_countries_id,
						'message'		=> $common_language->_( 'validate_country' )
					)));
					$validator->add( 'group_id', new InclusionIn( array(
						'cancelOnFail'	=> true,
						'domain'		=> $list_groups_id,
						'message'		=> $common_language->_( 'validate_group' )
					)));
					$validator->add( 'status_id', new InclusionIn( array(
						'cancelOnFail'	=> true,
						'domain'		=> $list_status_id,
						'message'		=> $common_language->_( 'validate_status' )
					)));
					$validated = $validator->validate( $data );

					if ( count( $validator->getMessages( ) ) ) {
						foreach( $validator->getMessages( ) as $message ) {
							$this->flash->error( $message->getMessage( ) );
						}

						if ( $data->id ) {
							$this->dispatcher->forward( array(
								'for' 			=> 'admin-full',
								'folder'		=> 'user',
								'controller' 	=> 'account',
								'action'		=> 'edit',
								'params'		=> array( $data->id )
							));
						} else {
							$this->dispatcher->forward( array(
								'for' 			=> 'admin-action',
								'folder'		=> 'user',
								'controller' 	=> 'account',
								'action' 		=> 'add',
							));
						}
					} else {

						if ( $this->request->hasFiles( ) ) {
							foreach ( $this->request->getUploadedFiles( ) as $file ) {
								if ( $file->getKey( ) == 'avatar' ) {
									$filename   = $file->getName( );
									$x          = explode( '.', $filename );
									$_name      = $x[0];
									$_extension = $x[1];
									
									$data->avatar 	= 'avatar-' . time( ) . '.' . $_extension;
									$filename_original 		= $this->config->directories->public->files->dir . 'Images/System/Avatar/' . $data->avatar;
									$filename_thumbnail 	= $this->config->directories->public->files->dir . 'Images/System/Avatar/Thumb/' . $data->avatar;
									$file->moveTo( $filename_original );

									$image 	= new \Phalcon\Image\Adapter\GD( $filename_original );
									$thumbnaml_size = $this->setting->get( 'avatar_size' );

									if ( $thumbnaml_size ) {
										$thumbnaml_size = explode( 'x', $thumbnaml_size );
										if ( count( $thumbnaml_size ) == 2 ) {
											$image->resize( $thumbnaml_size[0], $thumbnaml_size[1] );
										} else {
											$image->resize( 200, 300 );
										}
									} else {
										$image->resize( 200, 300 );
									}
									
									$image->save( $filename_thumbnail );
								}
							}
						}

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
									'controller' 	=> 'account',
									'action'		=> 'edit',
									'params'		=> $data->id
								));
							} else {
								$this->flash->error( $edit_language->_( 'error_message' ) );
								$this->dispatcher->forward( array(
									'for' 			=> 'admin-full',
									'folder'		=> 'user',
									'controller' 	=> 'account',
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
									'controller' 	=> 'account'
								));
							} else {
								$this->flash->error( $add_language->_( 'error_message' ) );
								$this->dispatcher->forward( array(
									'for' 			=> 'admin-action',
									'folder'		=> 'user',
									'controller' 	=> 'account',
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
				'controller' 	=> 'account'
			));

			return;

		}

		private function _store ( $data ) {

			if ( isset( $data->id ) ) { 
				
				$account_data = Account::findFirst( $data->id );
				
				if ( !is_object( $account_data ) ) {
					$account_data = new Account( );
				}

			} else {
				$account_data = new Account( );
			}

			$account_profile 				= new Profile( );
			$account_profile->first_name 	= $data->first_name;
			$account_profile->middle_name 	= $data->middle_name;
			$account_profile->last_name 	= $data->last_name;
			$account_profile->gender 		= $data->gender;
			$account_profile->birth_date 	= $data->birth_date;
			$account_profile->birth_place 	= $data->birth_place;
			$account_profile->mobile_no 	= $data->mobile_no;
			$account_profile->telephone_no 	= $data->telephone_no;
			$account_profile->fax_no 		= $data->fax_no;
			$account_profile->address 		= $data->address;
			$account_profile->city 			= $data->city;
			$account_profile->state 		= $data->state;
			$account_profile->zip 			= $data->zip;
			$account_profile->country_id 	= $data->country_id;

			$account_data->email 			= $data->email;
			$account_data->username 		= $data->username;

			if ( $data->avatar ) {
				unlink( $this->config->directories->public->files->dir . 'Images/System/Avatar/' . $account_data->avatar );
				$account_data->avatar 			= $data->avatar;
			}

			if ( $data->password ) {
				$account_data->password 	= $this->security->hash( $data->password );
			}

			$account_data->user_group_id 	= $data->group_id;
			$account_data->user_status_id 	= $data->status_id;
			$account_data->profile 			= $account_profile;

			$data->data 					= $account_data;
			$data->is_saved					= $account_data->save( );
			$data->messages					= $account_data->getMessages( );

			return $data;

		}

		private function _preserve ( $id = false ) {

			$data = Account::findFirst( $id );

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

			$data = Account::findFirst( $id );

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

			$data = Account::findFirst( $id );

			if ( is_object( $data ) ) {

				$avatar =  $data->avatar;
					
				if ( $data->delete( ) == false ) {
					
					$data->is_deleted 	= ( int ) false;	
					return $data;

				}

				unlink( $this->config->directories->public->files->dir . 'Images/System/Avatar/' . $avatar );

			} 

			return true;

		}

	} // END CLASS ACCOUNT CONTROLLER