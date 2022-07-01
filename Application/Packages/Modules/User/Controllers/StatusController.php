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

	use \Application\Packages\Modules\User\Models\Status;

	/**
	 * Router Prefix
	 * @RoutePrefix( "/:admin/user/status" )
	 *
	 * Access Control List
	 *
	 * @Acl( "controller" = "Modules\User\Controllers\Status", name = "User Status", "description" = "Status Access." )
	 */

	class StatusController extends \Phalcon\Mvc\Controller {

		/**
		 * Router Index Prefix
		 * @Route( "/", "name" = "user-status" )
		 * @Route( "/index" )
		 *
		 * Set Permission
		 * @Acl( "key" = "index", "name" = "Index", "description" = "Status Index." )
		 */
		public function indexAction ( ) {

			$this->view->setVar( '_', $language = $this->language->load( array(
				'system' => 'Index',
				'Index',
				'Status/Common',
				'Status/Index',
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
								'for' 	=> 'user-status-view',
								'id'	=> $model->getId( )
							)),
							$language->_( 'text_view' )
						));
					},
					'edit' => function ( $model ) use ( $language ) {
						return $this->tag->linkTo( array(
							$this->url->get( array(
								'for' 	=> 'user-status-view',
								'id'	=> $model->getId( )
							)),
							$language->_( 'text_edit' )
						));
					},
					'delete' => function ( $model ) use ( $language ) {
						return $this->tag->linkTo( array(
							$this->url->get( array(
								'for' 	=> 'user-status-delete',
								'id'	=> $model->getId( )
							)),
							$language->_( 'text_delete' )
						));
					},
					'archive' => function ( $model ) use ( $language ) {
						return $this->tag->linkTo( array(
							$this->url->get( array(
								'for' 	=> 'user-status-view',
								'id'	=> $model->getId( )
							)),
							$language->_( 'text_archive' )
						));
					},
				)
			));
			$__GRID__->setColumns( array(
				'[UserStatus].[user_status_id]' 	=> array(
					'title' 	=> $language->_( 'text_id' ),
					'column'	=> 'user_status_id'
				),
				'[UserStatus].[status]' 			=> array(
					'title' 	=> $language->_( 'text_status' ),
					'column'	=> 'status'
				),
				'[UserStatus].[description]' 		=> array(
					'title' 	=> $language->_( 'text_description' ),
					'column'	=> 'description'
				),
				'[UserStatus].[created_on]' 		=> array(
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
				'[UserStatus].[updated_on]' 		=> array(
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
				->addFrom( 'Application\Packages\Modules\User\Models\Status', 'UserStatus' )
				->leftJoin( 'Application\Packages\Modules\User\Models\Account', '[CreatedBy].user_account_id = [UserStatus].created_by_id', 'CreatedBy' )
				->leftJoin( 'Application\Packages\Modules\User\Models\Account', '[UpdatedBy].user_account_id = [UserStatus].updated_by_id', 'UpdatedBy' )
				->andWhere( '( [UserStatus].is_archived = 0 OR [UserStatus].is_archived IS NULL ) AND ( [UserStatus].is_trashed = 0 OR [UserStatus].is_trashed IS NULL )' );

			$this->view->setVar( '__GRID__', $__GRID__->render( ) );

			$this->view->setVar( 'var_breadcrumbs', array(
				$language->_( 'text_users' ) 	=> $this->url->get( array(
					'for' => 'user-account',
				)),
				$language->_( 'text_status' ) 	=> $this->url->get( array(
					'for' => 'user-status',
				))
			));

			$this->view->setVar( 'var_index_url', array(
				'for'	=> 'user-status',
			));

			if ( $this->request->hasQuery( 'bulk' ) && $this->request->getQuery( 'bulk' ) ) {
				$this->{$this->request->getQuery( 'bulk' )}( );
			}

			$this->view->pick( 'Status/Index' );

		}

		/**
		 * Router Add Prefix
		 * @Get( "/add", "name" = "user-status-add" )
		 *
		 * Set Permission
		 * @Acl( "key" = "add", "name" = "Add", "description" = "Status Add." )
		 */
		public function addAction ( ) {

			$this->view->setVar( '_', $language = $this->language->load( array(
				'system' => 'Index',
				'Index',
				'Status/Common',
				'Status/Add',
			)));

			$this->tag->setDefault( 'sort_order', 0 );

			$this->view->setVar( 'var_breadcrumbs', array(
				'Users' 		=> $this->url->get( array(
					'for' => 'user-account',
				)),
				'Status' 	=> $this->url->get( array(
					'for' => 'user-status'
				)),
				'Add' 	=> $this->url->get( array(
					'for' => 'user-status-add'
				)),
			));

			$this->view->setVar( 'var_save_url', $this->url->get( array(
				'for' => 'user-status-save'
			)));

			$this->view->pick( 'Status/Add' );

		}

		/**
		 * Router Edit Prefix
		 * @Get( "/edit/{id:[0-9]+}", "name" = "user-status-edit" )
		 *
		 * Set Permission
		 * @Acl( "key" = "edit", "name" = "Edit", "description" = "Status Edit." )
		 */
		public function editAction ( $id = false ) {

			$this->view->setVar( '_', $language = $this->language->load( array(
				'system' => 'Index',
				'Index',
				'Status/Common',
				'Status/Edit',
			)));

			$data = Status::findFirst( array(
				'( is_archived = 0 OR is_archived IS NULL ) AND ( is_trashed = 0 OR is_trashed IS NULL ) AND user_status_id = ?0',
				'bind' => array(
					( int ) $id
				)
			));

			if ( !is_object( $data ) ) {
				$this->flicker->error( $language->_( 'not_found_message' ) );
				return $this->response->redirect( array(
					'for' => 'user-status'
				));
			}

			$this->tag->setDefault( 'status', 				$data->status );
			$this->tag->setDefault( 'description', 			$data->description );
			$this->tag->setDefault( 'sort_order', 			$data->sort_order );

			$this->view->setVar( 'var_created_on',			date( $language->_( 'format_date' ), strtotime( $data->created_on ) ) );
			$this->view->setVar( 'var_updated_on',			date( $language->_( 'format_date' ), strtotime( $data->updated_on ) ) );
			$this->view->setVar( 'var_created_by', 			( $data->getCreatedBy( ) ? $data->getCreatedBy( )->getUsername( ) : '' ) );
			$this->view->setVar( 'var_updated_by', 			( $data->getUpdatedBy( ) ? $data->getUpdatedBy( )->getUsername( ) : '' ) );

			$this->view->setVar( 'var_breadcrumbs', array(
				$language->_( 'text_users' ) 	=> $this->url->get( array(
					'for' 	=> 'user-account',
				)),
				$language->_( 'text_status' ) 	=> $this->url->get( array(
					'for' 	=> 'user-status',
				)),
				$language->_( 'text_edit' ) 		=> $this->url->get( array(
					'for' 	=> 'user-status-edit',
					'id'	=> $data->getId( ),
				)),
			));

			$this->view->setVar( 'var_save_url', $this->url->get( array(
				'for' 	=> 'user-status-save',
				'id'	=> $data->getId( ),
			)));

			$this->view->pick( 'Status/Edit' );

		}

		/**
		 * Router View Prefix
		 * @Get( "/view/{id:[0-9]+}", "name" = "user-status-view" )
		 *
		 * Set Permission
		 * @Acl( "key" = "view", "name" = "View", "description" = "Status View." )
		 */
		public function viewAction ( $id = false ) {

			$this->view->setVar( '_', $language = $this->language->load( array(
				'system' => 'Index',
				'Index',
				'Status/Common',
				'Status/View',
			)));

			$data = Status::findFirst( array(
				'( is_archived = 0 OR is_archived IS NULL ) AND ( is_trashed = 0 OR is_trashed IS NULL ) AND user_status_id = ?0',
				'bind' => array(
					( int ) $id
				)
			));

			if ( !is_object( $data ) ) {
				$this->flicker->error( $language->_( 'not_found_message' ) );
				return $this->response->redirect( array(
					'for' 	=> 'user-status',
				));
			}

			$this->view->setVar( 'status', 					$data->status );
			$this->view->setVar( 'description', 			$data->description );
			$this->view->setVar( 'sort_order', 				$data->sort_order );

			$this->view->setVar( 'var_created_on',			date( $language->_( 'format_date' ), strtotime( $data->created_on ) ) );
			$this->view->setVar( 'var_updated_on',			date( $language->_( 'format_date' ), strtotime( $data->updated_on ) ) );
			$this->view->setVar( 'var_created_by', 			( $data->getCreatedBy( ) ? $data->getCreatedBy( )->getUsername( ) : '' ) );
			$this->view->setVar( 'var_updated_by', 			( $data->getUpdatedBy( ) ? $data->getUpdatedBy( )->getUsername( ) : '' ) );

			$this->view->setVar( 'var_breadcrumbs', array(
				$language->_( 'text_users' ) 	=> $this->url->get( array(
					'for' 	=> 'user-account',
				)),
				$language->_( 'text_status' ) 	=> $this->url->get( array(
					'for' 	=> 'user-status',
				)),
				$language->_( 'text_view' ) 		=> $this->url->get( array(
					'for' 	=> 'user-status-view',
				)),
			));

			$this->view->setVar( 'var_edit_url', $this->url->get( array(
				'for' 	=> 'user-status-edit',
				'id'	=> $data->getId( ),
			)));

			$this->view->setVar( 'var_archive_url', $this->url->get( array(
				'for' 	=> 'user-status-archive',
				'id'	=> $data->getId( ),
			)));

			$this->view->setVar( 'var_delete_url', $this->url->get( array(
				'for' 	=> 'user-status-delete',
				'id'	=> $data->getId( ),
			)));

			$this->view->pick( 'Status/View' );

		}

		/**
		 * Router Archive Prefix
		 * @Get( "/archive/{id:[0-9]+}", "name" = "user-status-archive" )
		 *
		 * Set Permission
		 * @Acl( "key" = "archive", "name" = "Archive", "description" = "Status Archive." )
		 */
		public function archiveAction ( $id = false ) {

			$this->view->setVar( '_', $language = $this->language->load( array(
				'system' => 'Index',
				'Index',
				'Status/Common',
				'Status/Archive',
			)));

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
							'for' => 'user-status'
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
								'for' => 'user-status'
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
						'for' => 'user-status'
					));

				}

				$this->flicker->success( $language->_( 'success_message' ) );

			}

			$this->view->disable( );
			$this->response->redirect( array(
				'for' => 'user-status'
			));

			return;

		}

		/**
		 * Router Unarchive Prefix
		 * @Get( "/unarchive/{id:[0-9]+}", "name" = "user-status-unarchive" )
		 *
		 * Set Permission
		 * @Acl( "key" = "unarchive", "name" = "Unarchive", "description" = "Status Unarchive." )
		 */
		public function unarchiveAction ( $id = false ) {

			$this->view->setVar( '_', $language = $this->language->load( array(
				'system' => 'Index',
				'Index',
				'Status/Common',
				'Status/Unarchive',
			)));

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
							'for' => 'user-status'
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
								'for' => 'user-status'
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
						'for' => 'user-status'
					));

				}

				$this->flicker->success( $language->_( 'success_message' ) );
			}

			$this->view->disable( );
			$this->response->redirect( array(
				'for' => 'user-status'
			));

			return;

		}

		/**
		 * Router Delete Prefix
		 * @Get( "/delete/{id:[0-9]+}", "name" = "user-status-delete" )
		 *
		 * Set Permission
		 * @Acl( "key" = "delete", "name" = "Delete", "description" = "Status Delete." )
		 */
		public function deleteAction ( $id = false ) {

			$this->view->setVar( '_', $language = $this->language->load( array(
				'system' => 'Index',
				'Index',
				'Status/Common',
				'Status/Delete',
			)));

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
							'for' => 'user-status'
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
								'for' => 'user-status'
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
						'for' => 'user-status'
					));

				}

				$this->flicker->success( $language->_( 'success_message' ) );
			}

			$this->view->disable( );
			$this->response->redirect( array(
				'for' => 'user-status'
			));

			return;
		}

		/**
		 * Router Save Prefix
		 * @Post( "/save" )
		 * @Post( "/save/{id:[0-9]+}", "name" = "user-status-save" )
		 */
		public function saveAction ( $id = false ) {

			if ( $this->request->isPost( ) == true ) {

				$add_language 		= $this->language->load( array(
					'system' => 'Index',
					'Index',
					'Status/Add',
				));
				$edit_language 		= $this->language->load( array(
					'system' => 'Index',
					'Index',
					'Status/Edit',
				));
				$common_language 	= $this->language->load( array(
					'system' => 'Index',
					'Index',
					'Status/Common',
				));

				if ( $this->security->checkToken( ) ) {

					$data = new \stdClass( );

					if ( is_numeric( $id ) ) {
						$data->id = ( int ) $id;
					}

					$data->status 		= $this->request->getPost( 'status', 'string' );
					$data->description 	= $this->request->getPost( 'description', 'string' );
					$data->sort_order 	= $this->request->getPost( 'sort_order', 'int' );

					$validator = new Validation( );
					$validator->add( 'status', new PresenceOf( array(
						'cancelOnFail'	=> true,
						'message'		=> $common_language->_( 'validate_status' ),
					)));

					if ( count( $validator->getMessages( ) ) ) {
						foreach( $validator->getMessages( ) as $message ) {
							$this->flicker->error( $message->getMessage( ) );
						}

						if ( $data->id ) {
							$this->dispatcher->forward( array(
								'for' 	=> 'user-status-edit',
								'id'	=> $data->getId( )
							));
						} else {
							$this->dispatcher->forward( array(
								'for' 	=> 'user-status-add',
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
									'for' 	=> 'user-status-edit',
									'id'	=> $data->id
								));
							} else {
								$this->flicker->error( $edit_language->_( 'error_message' ) );
								$this->dispatcher->forward( array(
									'for' 	=> 'user-status-edit',
									'id'	=> $data->id
								));
							}
						} else {
							if ( $data->is_saved == true ) {
								$this->view->disable( );
								$this->flicker->success( $add_language->_( 'success_message' ) );
								$this->response->redirect( array(
									'for' 	=> 'user-status',
								));
							} else {
								$this->flicker->error( $add_language->_( 'error_message' ) );
								$this->dispatcher->forward( array(
									'for' 	=> 'user-status-add',
								));
							}
						}
					}

					return;

				} else {
					$this->flicker->error( $common_language->_( 'validate_access_tokken' ) );
				}
			}

			$this->view->disable( );
			$this->response->redirect( array(
				'for' 	=> 'user-status',
			));

			return;

		}

		private function _store ( $data ) {

			if ( isset( $data->id ) ) {

				$status_data = Status::findFirst( $data->id );

				if ( !is_object( $status_data ) ) {
					$status_data = new Status( );
				}

			} else {
				$status_data = new Status( );
			}

			$status_data->status 			= $data->status;
			$status_data->description 		= $data->description;
			$status_data->sort_order 		= $data->sort_order;

			$data->data 					= $status_data;
			$data->is_saved					= $status_data->save( );
			$data->messages					= $status_data->getMessages( );

			return $data;

		}

		private function _preserve ( $id = false ) {

			$data = Status::findFirst( $id );

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

			$data = Status::findFirst( $id );

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

			$data = Status::findFirst( $id );

			if ( is_object( $data ) ) {

				$data->is_trashed = ( int ) true;

				if ( $data->save( ) == false ) {

					$data->is_trashed 	= ( int ) false;

					return $data;

				}

			}

			return true;

		}

	} // END CLASS STATUSCONTROLLER