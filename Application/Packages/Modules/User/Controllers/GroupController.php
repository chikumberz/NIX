<?php

	namespace Application\Packages\Modules\User\Controllers;

	use \Phalcon\Validation,
		\Phalcon\Validation\Validator\PresenceOf,
		\Phalcon\Validation\Validator\Email,
		\Phalcon\Validation\Validator\Identical,
		\Phalcon\Validation\Validator\StringLength,
		\Phalcon\Validation\Validator\Confirmation,
		\Phalcon\Validation\Validator\Regex,
		\Phalcon\Validation\Validator\InclusionIn;

	use \Application\Packages\Modules\User\Models\Group;

	/**
	 * Router Prefix
	 * @RoutePrefix( "/:admin/user/group" )
	 *
	 * Access Control List
	 * @Acl( "controller" = "Modules\User\Controllers\Group", name = "User Group", description = "User Group Access." )
	 */

	class GroupController extends \Phalcon\Mvc\Controller {

		/**
		 * Router Index Prefix
		 * @Route( "/", "name" = "user-group" )
		 * @Route( "/index" )
		 *
		 * Set Permission
		 * @Acl( "key" = "index", "name" = "Index", "description" = "Group Index." )
		 */
		public function indexAction ( ) {

			$this->view->setVar( '_', $language = $this->language->load( array(
				'system' => 'Index',
				'Index',
				'Group/Common',
				'Group/Index',
			)));

			$__GRID__ = new \Application\Libraries\Engine\Grid\Grid(array(
				'toolbar_bulk_actions'	=> array(
					''					=> '',
					'archiveAction'		=> $language->_( 'text_archive_selected' ),
					'unarchiveAction'	=> $language->_( 'text_unarchive_selected' ),
					'deleteAction'		=> $language->_( 'text_delete_selected' ),
				),
				'row_tools'	=> array(
					'view' => function ( $model ) use ( $language ) {
						return $this->tag->linkTo( array(
							$this->url->get( array(
								'for' 	=> 'user-group-view',
								'id'	=> $model->getId( )
							)),
							$language->_( 'text_view' )
						));
					},
					'edit' => function ( $model ) use ( $language ) {
						return $this->tag->linkTo( array(
							$this->url->get( array(
								'for' 	=> 'user-group-view',
								'id'	=> $model->getId( )
							)),
							$language->_( 'text_edit' )
						));
					},
					'delete' => function ( $model ) use ( $language ) {
						return $this->tag->linkTo( array(
							$this->url->get( array(
								'for' 	=> 'user-group-delete',
								'id'	=> $model->getId( )
							)),
							$language->_( 'text_delete' )
						));
					},
					'archive' => function ( $model ) use ( $language ) {
						return $this->tag->linkTo( array(
							$this->url->get( array(
								'for' 	=> 'user-group-view',
								'id'	=> $model->getId( )
							)),
							$language->_( 'text_archive' )
						));
					},
				)
			));
			$__GRID__->setColumns( array(
				'[UserGroup].[user_group_id]' 	=> array(
					'title' 	=> $language->_( 'text_id' ),
					'column'	=> 'user_group_id'
				),
				'[UserGroup].[group]' 			=> array(
					'title' 	=> $language->_( 'text_group' ),
					'column'	=> 'group'
				),
				'[UserGroup].[description]' 	=> array(
					'title' 	=> $language->_( 'text_description' ),
					'column'	=> 'description'
				),
				'[UserGroup].[created_on]' 		=> array(
					'title' 	=> $language->_( 'text_created_on' ),
					'column'	=> 'created_on',
					'hidden'	=> true
				),
				'[CreatedBy].[username]' 	=> array(
					'title' 	=> $language->_( 'text_created_by' ),
					'column'	=> 'username',
					'convert'	=> function ( $model ) {
						$data = $model->getCreatedBy( );
						if ( $data )
							return $data->getUsername( );
					},
					'hidden'	=> true
				),
				'[UserGroup].[updated_on]' 		=> array(
					'title' 	=> $language->_( 'text_updated_on' ),
					'column'	=> 'updated_on',
					'hidden'	=> true
				),
				'[UpdatedBy].[username]' 	=> array(
					'title' 	=> $language->_( 'text_updated_by' ),
					'column'	=> 'username',
					'convert'	=> function ( $model ) {
						$data = $model->getUpdatedBy( );
						if ( $data )
							return $data->getUsername( );
					},
					'hidden'	=> true
				)
			));
			$__GRID__->setQueryBuilder( )
				->addFrom( 'Application\Packages\Modules\User\Models\Group', 'UserGroup' )
				->leftJoin( 'Application\Packages\Modules\User\Models\Account', '[CreatedBy].user_account_id = [UserGroup].created_by_id', 'CreatedBy' )
				->leftJoin( 'Application\Packages\Modules\User\Models\Account', '[UpdatedBy].user_account_id = [UserGroup].updated_by_id', 'UpdatedBy' )
				->andWhere( '( [UserGroup].is_archived = 0 OR [UserGroup].is_archived IS NULL ) AND ( [UserGroup].is_trashed = 0 OR [UserGroup].is_trashed IS NULL )' );

			$this->view->setVar( '__GRID__', $__GRID__->render( ) );

			$this->view->setVar( 'var_breadcrumbs', array(
				$language->_( 'text_users' ) 	=> $this->url->get( array(
					'for' => 'user-account',
				)),
				$language->_( 'text_groups' ) 	=> $this->url->get( array(
					'for' => 'user-group',
				))
			));

			$this->view->setVar( 'var_index_url', array(
				'for'	=> 'user-group',
			));

			if ( $this->request->hasQuery( 'bulk' ) && $this->request->getQuery( 'bulk' ) ) {
				$this->{$this->request->getQuery( 'bulk' )}( );
			}

			$this->view->pick( 'Group/Index' );

		}

		/**
		 * Router Add Prefix
		 * @Get( "/add", "name" = "user-group-add" )
		 *
		 * Set Permission
		 * @Acl( "key" = "add", "name" = "Add", "description" = "Group Add." )
		 */
		public function addAction ( ) {

			$this->acl->clear( );

			$this->view->setVar( '_', $language = $this->language->load( array(
				'system' => 'Index',
				'Index',
				'Group/Common',
				'Group/Add',
			)));

			$this->view->setVar( 'var_permissions', $this->acl->getResources( ) );

			if ( $this->request->isPost( ) && $this->request->hasPost( 'permissions' ) ) {
				$permissions = $this->request->getPost( 'permissions' );
				foreach ( $permissions as $index => $permission ) {
					foreach ( $permission as $key => $access ) {
						$this->tag->setDefault( "permissions[{$index}][{$key}]", $access );
					}
				}
			}

			$this->tag->setDefault( 'sort_order', 0 );

			$this->view->setVar( 'var_breadcrumbs', array(
				$language->_( 'text_users' ) 	=> $this->url->get( array(
					'for' => 'user-account',
				)),
				$language->_( 'text_groups' ) 	=> $this->url->get( array(
					'for' => 'user-group'
				)),
				$language->_( 'text_add' ) 		=> $this->url->get( array(
					'for' => 'user-group-add'
				)),
			));

			$this->view->setVar( 'var_save_url', array(
				'for'	 => 'user-group-save'
			));

			$this->view->pick( 'Group/Add' );

		}

		/**
		 * Router Edit Prefix
		 * @Get( "/edit/{id:[0-9]+}", "name" = "user-group-edit" )
		 *
		 * Set Permission
		 * @Acl( "key" = "edit", "name" = "Edit", "description" = "Group Edit." )
		 */
		public function editAction ( $id = false ) {

			$this->view->setVar( '_', $language = $this->language->load( array(
				'system' => 'Index',
				'Index',
				'Group/Common',
				'Group/Add',
			)));

			$data = Group::findFirst( array(
				'( is_archived = 0 OR is_archived IS NULL ) AND ( is_trashed = 0 OR is_trashed IS NULL ) AND user_group_id = ?0',
				'bind' => array(
					( int ) $id
				)
			));

			if ( !is_object( $data ) ) {
				$this->flicker->error( $language->_( 'not_found_message' ) );
				return $this->response->redirect( array(
					'for' => 'user-group',
				));
			}

			$this->acl->clear( );

			$this->tag->setDefault( 'group', 				$data->group );
			$this->tag->setDefault( 'description', 			$data->description );
			$this->tag->setDefault( 'sort_order', 			$data->sort_order );

			$this->view->setVar( 'var_permissions', 		$this->acl->getResources( ) );
			$this->view->setVar( 'var_created_on',			date( $language->_( 'format_date' ), strtotime( $data->created_on ) ) );
			$this->view->setVar( 'var_updated_on',			date( $language->_( 'format_date' ), strtotime( $data->updated_on ) ) );
			$this->view->setVar( 'var_created_by', 			( $data->getCreatedBy( ) ? $data->getCreatedBy( )->getUsername( ) : '' ) );
			$this->view->setVar( 'var_updated_by', 			( $data->getUpdatedBy( ) ? $data->getUpdatedBy( )->getUsername( ) : '' ) );

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
				$language->_( 'text_users' ) 	=> $this->url->get( array(
					'for' => 'user-account',
				)),
				$language->_( 'text_groups' ) 	=> $this->url->get( array(
					'for' => 'user-group'
				)),
				$language->_( 'text_edit' ) 	=> $this->url->get( array(
					'for' 	=> 'user-group-edit',
					'id'	=> $data->getId( ),
				)),
			));

			$this->view->setVar( 'var_save_url', array(
				'for'	=> 'user-group-save',
				'id' 	=> $data->getId( ),
			));

			$this->view->pick( 'Group/Edit' );

		}

		/**
		 * Router View Prefix
		 * @Get( "/view/{id:[0-9]+}", "name" = "user-group-view" )
		 *
		 * Set Permission
		 * @Acl( "key" = "view", "name" = "View", "description" = "Group View." )
		 */
		public function viewAction ( $id = false ) {

			$this->view->setVar( '_', $language = $this->language->load( array(
				'system' => 'Index',
				'Index',
				'Group/Common',
				'Group/View',
			)));

			$data = Group::findFirst( array(
				'( is_archived = 0 OR is_archived IS NULL ) AND ( is_trashed = 0 OR is_trashed IS NULL ) AND user_group_id = ?0',
				'bind' => array(
					( int ) $id
				)
			));

			if ( !is_object( $data ) ) {
				$this->flicker->error( $language->_( 'not_found_message' ) );
				return $this->response->redirect( array(
					'for' => 'user-group',
				));
			}

			$this->acl->clear( );

			$this->view->setVar( 'id', 					$data->getId( ) );
			$this->view->setVar( 'group', 				$data->group );
			$this->view->setVar( 'description', 		$data->description );
			$this->view->setVar( 'permissions', 		$data->getPermissions( ) );
			$this->view->setVar( 'sort_order', 			$data->sort_order );

			$this->view->setVar( 'var_permissions', 	$this->acl->getResources( ) );
			$this->view->setVar( 'var_created_on',		date( $language->_( 'format_date' ), strtotime( $data->created_on ) ) );
			$this->view->setVar( 'var_updated_on',		date( $language->_( 'format_date' ), strtotime( $data->updated_on ) ) );
			$this->view->setVar( 'var_created_by', 		( $data->getCreatedBy( ) ? $data->getCreatedBy( )->getUsername( ) : '' ) );
			$this->view->setVar( 'var_updated_by', 		( $data->getUpdatedBy( ) ? $data->getUpdatedBy( )->getUsername( ) : '' ) );

			$permissions = $data->getPermissions( );
			foreach ( $permissions as $index => $permission ) {
				foreach ( $permission as $key => $access ) {
					$this->tag->setDefault( "permissions[{$index}][{$key}]", $access );
				}
			}

			$this->view->setVar( 'var_breadcrumbs', array(
				$language->_( 'text_users' ) 	=> $this->url->get( array(
					'for' => 'user-account',
				)),
				$language->_( 'text_groups' ) 	=> $this->url->get( array(
					'for' => 'user-group'
				)),
				$language->_( 'text_view' ) 	=> $this->url->get( array(
					'for'	=> 'user-group-view',
					'id'	=> $data->getId( ),
				)),
			));

			$this->view->setVar( 'var_edit_url', $this->url->get( array(
				'for'	=> 'user-group-edit',
				'id'	=> $data->getId( ),
			)));

			$this->view->setVar( 'var_archive_url', $this->url->get( array(
				'for'	=> 'user-group-archive',
				'id'	=> $data->getId( ),
			)));

			$this->view->setVar( 'var_delete_url', $this->url->get( array(
				'for'	=> 'user-group-delete',
				'id'	=> $data->getId( ),
			)));

			$this->view->pick( 'Group/View' );

		}

		/**
		 * Router Archive Prefix
		 * @Get( "/archive/{id:[0-9]+}", "name" = "user-group-archive" )
		 *
		 * Set Permission
		 * @Acl( "key" = "archive", "name" = "Archive", "description" = "Group Archive." )
		 */

		public function archiveAction ( $id = false ) {

			$language = $this->language->load( array(
				'system' => 'Index',
				'Index',
				'Group/Common',
				'Group/Archive',
			));

			if ( $this->request->hasQuery( 'id' ) == true ) {

				$ids = $this->request->getQuery( 'id' );

				if ( !is_array( $ids ) ) {

					$data = $this->_preserve( ( int ) $ids );

					if ( $data !== true && !$data->is_preserved ) {

						foreach( $data->getMessages( ) as $message ) {
							$this->flicker->error( $message->getMessage( ) );
						}

						$this->flicker->error( $language->_( 'error_message' ) );

						return $this->dispatcher->forward( array(
							'for' => 'user-group',
						));
					}
				} else {
					foreach ( $ids as $id ) {

						$data = $this->_preserve( $id );

						if ( $data !== true && !$data->is_preserved ) {

							foreach( $data->getMessages( ) as $message ) {
								$this->flicker->error( $message->getMessage( ) );
							}

							$this->flicker->error( $language->_( 'error_message' ) );

							return $this->dispatcher->forward( array(
								'for' => 'user-group',
							));

							break;

						}
					}
				}
				$this->flicker->success( $language->_( 'success_message' ) );

			} else if ( is_numeric( $id ) ) {

				$data = $this->_preserve( ( int ) $id );

				if ( $data !== true && !$data->is_preserved ) {

					foreach( $data->getMessages( ) as $message ) {
						$this->flicker->error( $message->getMessage( ) );
					}

					$this->flicker->error( $language->_( 'error_message' ) );

					return $this->dispatcher->forward( array(
						'for' => 'user-group',
					));

				}

				$this->flicker->success( $language->_( 'success_message' ) );

			}

			$this->view->disable( );
			$this->response->redirect( array(
				'for' => 'user-group',
			));

			return;

		}

		/**
		 * Router Unarchive Prefix
		 * @Get( "/unarchive/{id:[0-9]+}", "name" = "user-group-unarchive" )
		 *
		 * Set Permission
		 * @Acl( "key" = "unarchive", "name" = "Unarchive", "description" = "Group Unarchive." )
		 */

		public function unarchiveAction ( $id = false ) {

			$language = $this->language->load( array(
				'system' 	=> 'Index',
				'Index',
				'Group/Common',
				'Group/Unarchive',
			));

			if ( $this->request->hasQuery( 'id' ) == true ) {

				$ids = $this->request->getQuery( 'id' );

				if ( !is_array( $ids ) ) {

					$data = $this->_unpreserve( ( int ) $ids );

					if ( $data !== true && !$data->is_unarchived ) {

						foreach( $data->getMessages( ) as $message ) {
							$this->flicker->error( $message->getMessage( ) );
						}

						$this->flicker->error( $language->_( 'error_message' ) );

						return $this->dispatcher->forward( array(
							'for' => 'user-group',
						));
					}
				} else {
					foreach ( $ids as $id ) {

						$data = $this->_unpreserve( $id );

						if ( $data !== true && !$data->is_unarchived ) {

							foreach( $data->getMessages( ) as $message ) {
								$this->flicker->error( $message->getMessage( ) );
							}

							$this->flicker->error( $language->_( 'error_message' ) );

							return $this->dispatcher->forward( array(
								'for' => 'user-group',
							));

							break;

						}
					}
				}

				$this->flicker->success( $language->_( 'success_message' ) );
			} else if ( is_numeric( $id ) ) {

				$data = $this->_unpreserve( ( int ) $id );

				if ( $data !== true && !$data->is_unarchived ) {

					foreach( $data->getMessages( ) as $message ) {
						$this->flicker->error( $message->getMessage( ) );
					}

					$this->flicker->error( $language->_( 'error_message' ) );

					return $this->dispatcher->forward( array(
						'for' => 'user-group',
					));

				}

				$this->flicker->success( $language->_( 'success_message' ) );
			}

			$this->view->disable( );
			$this->response->redirect( array(
				'for' => 'user-group',
			));

			return;

		}

		/**
		 * Router Delete Prefix
		 * @Get( "/delete/{id:[0-9]+}", "name" = "user-group-delete" )
		 *
		 * Set Permission
		 * @Acl( "key" = "delete", "name" = "Delete", "description" = "Group Delete." )
		 */

		public function deleteAction ( $id = false ) {

			$language = $this->language->load( array(
				'system' 	=> 'Index',
				'Index',
				'Group/Common',
				'Group/Delete',
			));

			if ( $this->request->hasQuery( 'id' ) == true ) {

				$ids = $this->request->getQuery( 'id' );

				if ( !is_array( $ids ) ) {

					$data = $this->_erase( ( int ) $ids );

					if ( $data !== true && !$data->is_deleted ) {

						foreach( $data->getMessages( ) as $message ) {
							$this->flicker->error( $message->getMessage( ) );
						}

						$this->flicker->error( $language->_( 'error_message' ) );

						return $this->dispatcher->forward( array(
							'for' => 'user-group',
						));

					}

				} else {

					foreach ( $ids as $id ) {

						$data = $this->_erase( $id );

						if ( $data !== true && !$data->is_deleted ) {

							foreach( $data->getMessages( ) as $message ) {
								$this->flicker->error( $message->getMessage( ) );
							}

							$this->flicker->error( $language->_( 'error_message' ) );

							return $this->dispatcher->forward( array(
								'for' => 'user-group',
							));

							break;
						}
					}

				}

				$this->flicker->success( $language->_( 'success_message' ) );

			} else if ( is_numeric( $id ) ) {

				$data = $this->_erase( ( int ) $id );

				if ( $data !== true && !$data->is_deleted ) {

					foreach( $data->getMessages( ) as $message ) {
						$this->flicker->error( $message->getMessage( ) );
					}

					$this->flicker->error( $language->_( 'error_message' ) );

					return $this->dispatcher->forward( array(
						'for' => 'user-group',
					));

				}

				$this->flicker->success( $language->_( 'success_message' ) );
			}

			$this->view->disable( );
			$this->response->redirect( array(
				'for' => 'user-group',
			));

			return;
		}

		/**
		 * Router Save Prefix
		 * @Post( "/save" )
		 * @Post( "/save/{id:[0-9]+}", "name" = "user-group-save" )
		 */
		public function saveAction ( $id = false ) {

			$add_language 		= $language = $this->language->load( array(
				'system' 	=> 'Index',
				'Group/Add',
			));
			$edit_language 		= $language = $this->language->load( array(
				'system' 	=> 'Index',
				'Group/Edit',
			));
			$common_language 	= $language = $this->language->load( array(
				'system' 	=> 'Index',
				'Index',
				'Group/Common'
			));

			if ( $this->security->checkToken( ) ) {

				$data = new \stdClass( );

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
						$this->flicker->error( $message->getMessage( ) );
					}

					if ( $data->id ) {
						$this->dispatcher->forward( array(
							'for' 	=> 'user-group-edit',
							'id'	=> $data->id
						));
					} else {
						$this->dispatcher->forward( array(
							'for' 	=> 'user-group-add',
						));
					}
				} else {
					$data = $this->_store( ( object ) $data );

					foreach( $data->messages as $message ) {
						$this->flicker->error( $message->getMessage( ) );
					}

					if ( isset( $data->id ) && $data->id > 0 ) {
						if ( $data->is_saved == true ) {
							$this->view->disable( );
							$this->flicker->success( $edit_language->_( 'success_message' ) );
							$this->response->redirect( array(
								'for' 	=> 'user-group-edit',
								'id'	=> $data->id
							));
						} else {
							$this->flicker->error( $edit_language->_( 'error_message' ) );
							$this->dispatcher->forward( array(
								'for' 	=> 'user-group-edit',
								'id'	=> $data->id
							));
						}
					} else {
						if ( $data->is_saved == true ) {
							$this->view->disable( );
							$this->flicker->success( $add_language->_( 'success_message' ) );
							$this->response->redirect( array(
								'for' 	=> 'user-group',
							));
						} else {
							$this->flicker->error( $add_language->_( 'error_message' ) );
							$this->dispatcher->forward( array(
								'for' 	=> 'user-group-add',
							));
						}
					}
				}

				return;

			} else {
				$this->flicker->error( $common_language->_( 'validate_access_tokken' ) );
			}

			$this->view->disable( );
			$this->response->redirect( array(
				'for' 	=> 'user-group',
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

				$data->is_trashed = ( int ) true;

				if ( $data->save( ) == false ) {

					$data->is_trashed 	= ( int ) false;

					return $data;

				}

			}

			return true;

		}

	} // END CLASS GROUP CONTROLLER