<?php

	namespace Application\Packages\Modules\User\Controllers;

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

	use \Application\Packages\Modules\User\Models\Account,
		\Application\Packages\Modules\User\Models\Profile,
		\Application\Packages\Modules\User\Models\Group,
		\Application\Packages\Modules\User\Models\Status,
		\Application\Packages\Modules\User\Models\Setting;

	/**
	 * Router Prefix
	 * @RoutePrefix( "/:admin/user/account" )
	 *
	 * Access Control List
	 *
	 * @Acl( "controller" = "Modules\User\Controllers\Account", name = "User Acount", "description" = "Account Access." )
	 */
	class AccountController extends \Phalcon\Mvc\Controller {

		/**
		 * Router Index Prefix
		 * @Route( "/", "name" = "user-account" )
		 * @Route( "/index" )
		 *
		 * Set Permission
		 * @Acl( "key" = "index", "name" = "Index", "description" = "Account Index." )
		 */
		public function indexAction ( ) {

			$this->view->setVar( '_', $language = $this->language->load( array(
				'system' => 'Index',
				'Index',
				'Account/Common',
				'Account/Index',
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
								'for' 	=> 'user-account-view',
								'id'	=> $model->getId( )
							)),
							$language->_( 'text_view' )
						));
					},
					'edit' => function ( $model ) use ( $language ) {
						return $this->tag->linkTo( array(
							$this->url->get( array(
								'for' 	=> 'user-account-edit',
								'id'	=> $model->getId( )
							)),
							$language->_( 'text_edit' )
						));
					},
					'delete' => function ( $model ) use ( $language ) {
						return $this->tag->linkTo( array(
							$this->url->get( array(
								'for' 	=> 'user-account-delete',
								'id'	=> $model->getId( )
							)),
							$language->_( 'text_delete' )
						));
					},
					'archive' => function ( $model ) use ( $language ) {
						return $this->tag->linkTo( array(
							$this->url->get( array(
								'for' 	=> 'user-account-archive',
								'id'	=> $model->getId( )
							)),
							$language->_( 'text_archive' )
						));
					},
				)
			));
			$__GRID__->setColumns( array(
				'[UserAccount].[user_account_id]' 	=> array(
					'title' 	=> $language->_( 'text_id' ),
					'column'	=> 'user_account_id'
				),
				'[UserAccount].[avatar]' 	=> array(
					'title' 	=> $language->_( 'text_avatar' ),
					'column'	=> 'avatar',
					'sort'		=> false,
					'convert'	=> function ( $model ) {
						return '<img src = "' . $model->getAvatar( true ) . '" style = "width: 50px; height: 50px;"/>';
					}
				),
				'[UserAccount].[username]' 			=> array(
					'title' 	=> $language->_( 'text_username' ),
					'column'	=> 'username'
				),
				'[UserProfile].[first_name]' 		=> array(
					'title' 	=> $language->_( 'text_first_name' ),
					'column'	=> 'first_name',
					'convert'	=> function ( $model ) {
						$data = $model->getUserProfile( );
						if ( $data )
							return $data->getFirstName( );
					}
				),
				'[UserProfile].[last_name]' 		=> array(
					'title' 	=> $language->_( 'text_last_name' ),
					'column'	=> 'last_name',
					'convert'	=> function ( $model ) {
						$data = $model->getUserProfile( );
						if ( $data )
							return $data->getLastName( );
					}
				),
				'[UserAccount].[email]' 			=> array(
					'title' 	=> $language->_( 'text_email' ),
					'column'	=> 'email'
				),
				'[UserAccount].[created_on]' 		=> array(
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
				'[UserAccount].[updated_on]' 		=> array(
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
				->addFrom( 'Application\Packages\Modules\User\Models\Account', 'UserAccount' )
				->leftJoin( 'Application\Packages\Modules\User\Models\Status', '[UserStatus].user_status_id = [UserAccount].user_status_id', 'UserStatus' )
				->leftJoin( 'Application\Packages\Modules\User\Models\Group', '[UserGroup].user_group_id = [UserAccount].user_group_id', 'UserGroup' )
				->leftJoin( 'Application\Packages\Modules\User\Models\Profile', '[UserProfile].user_account_id = [UserAccount].user_account_id', 'UserProfile' )
				->leftJoin( 'Application\Packages\Modules\User\Models\Account', '[CreatedBy].user_account_id = [UserStatus].created_by_id', 'CreatedBy' )
				->leftJoin( 'Application\Packages\Modules\User\Models\Account', '[UpdatedBy].user_account_id = [UserStatus].updated_by_id', 'UpdatedBy' )
				->andWhere( '( [UserAccount].is_archived = 0 OR [UserAccount].is_archived IS NULL ) AND ( [UserAccount].is_trashed = 0 OR [UserAccount].is_trashed IS NULL )' );

			$this->view->setVar( '__GRID__', $__GRID__->render( ) );

			$this->view->setVar( 'var_breadcrumbs', array(
				$language->_( 'text_users' ) 	=> $this->url->get( array(
					'for' => 'user-account',
				))
			));

			$this->view->setVar( 'var_index_url', array(
				'for' => 'user-account',
			));

			if ( $this->request->hasQuery( 'bulk' ) && $this->request->getQuery( 'bulk' ) ) {
				$this->{$this->request->getQuery( 'bulk' )}( );
			}

			$this->view->pick( 'Account/Index' );

		}

		/**
		 * Router Add Prefix
		 * @Get( "/add", "name" = "user-account-add" )
		 *
		 * Set Permission
		 * @Acl( "key" = "add", "name" = "Add", "description" = "Account Add." )
		 */
		public function addAction ( ) {

			$this->view->setVar( '_', $language = $this->language->load( array(
				'system' => 'Index',
				'Index',
				'Account/Common',
				'Account/Add',
			)));

			if ( $this->package->isInstalled( 'Modules\Country' ) && $this->package->isEnabled( 'Modules\Country' ) ) {
				$this->view->setVar( 'var_countries',  			Country::find( array(
					'( is_archived = 0 OR is_archived IS NULL ) AND ( is_trashed = 0 OR is_trashed IS NULL )'
				)));
			}
			$this->view->setVar( 'var_groups',  			Group::find( array(
				'( is_archived = 0 OR is_archived IS NULL ) AND ( is_trashed = 0 OR is_trashed IS NULL )'
			)));
			$this->view->setVar( 'var_status',  			Status::find( array(
				'( is_archived = 0 OR is_archived IS NULL ) AND ( is_trashed = 0 OR is_trashed IS NULL )'
			)));

			$this->view->setVar( 'var_breadcrumbs', array(
				$language->_( 'text_users' ) 		=> $this->url->get( array(
					'for' 	=> 'user-account',
				)),
				$language->_( 'text_accounts' ) 	=> $this->url->get( array(
					'for' 	=> 'user-account',
				)),
				$language->_( 'text_add' ) 	=> $this->url->get( array(
					'for' 	=> 'user-account-add',
				)),
			));

			$this->view->setVar( 'var_save_url', $this->url->get( array(
				'for' 	=> 'user-account-save',
			)));

			$this->view->pick( 'Account/Add' );

		}

		/**
		 * Router Edit Prefix
		 * @Get( "/edit/{id:[0-9]+}", "name" = "user-account-edit" )
		 *
		 * Set Permission
		 * @Acl( "key" = "edit", "name" = "Edit", "description" = "Account Edit." )
		 */
		public function editAction ( $id = false ) {

			$this->view->setVar( '_', $language = $this->language->load( array(
				'system' => 'Index',
				'Index',
				'Account/Common',
				'Account/Edit',
			)));

			$data = Account::findFirst( array(
				'( is_archived = 0 OR is_archived IS NULL ) AND ( is_trashed = 0 OR is_trashed IS NULL ) AND user_account_id = ?0',
				'bind' => array(
					( int ) $id
				)
			));

			if ( !is_object( $data ) ) {
				$this->flicker->error( $language->_( 'not_found_message' ) );
				return $this->response->redirect( array(
					'for' 	=> 'user-account'
				));
			}

			if ( $this->package->isInstalled( 'Modules\Country' ) && $this->package->isEnabled( 'Modules\Country' ) ) {
				$this->view->setVar( 'var_countries',  			Country::find( array(
					'( is_archived = 0 OR is_archived IS NULL ) AND ( is_trashed = 0 OR is_trashed IS NULL )'
				)));
			}
			$this->view->setVar( 'var_groups',  			Group::find( array(
				'( is_archived = 0 OR is_archived IS NULL ) AND ( is_trashed = 0 OR is_trashed IS NULL )'
			)));
			$this->view->setVar( 'var_status',  			Status::find( array(
				'( is_archived = 0 OR is_archived IS NULL ) AND ( is_trashed = 0 OR is_trashed IS NULL )'
			)));

			$this->tag->setDefault( 'first_name', 			$data->UserProfile->first_name );
			$this->tag->setDefault( 'middle_name',			$data->UserProfile->middle_name );
			$this->tag->setDefault( 'last_name',			$data->UserProfile->last_name );
			$this->tag->setDefault( 'gender', 				$data->UserProfile->gender );
			$this->tag->setDefault( 'birth_date',			$data->UserProfile->birth_date );
			$this->tag->setDefault( 'birth_place',			$data->UserProfile->birth_place );
			$this->tag->setDefault( 'mobile_no',			$data->UserProfile->mobile_no );
			$this->tag->setDefault( 'telephone_no',			$data->UserProfile->telephone_no );
			$this->tag->setDefault( 'fax_no',				$data->UserProfile->fax_no );
			$this->tag->setDefault( 'address',				$data->UserProfile->address );
			$this->tag->setDefault( 'city',					$data->UserProfile->city );
			$this->tag->setDefault( 'state',				$data->UserProfile->state );
			$this->tag->setDefault( 'zip',					$data->UserProfile->zip );
			$this->tag->setDefault( 'country_id',			$data->UserProfile->country_id );
			$this->tag->setDefault( 'email',				$data->email );
			$this->tag->setDefault( 'username',				$data->username );
			$this->tag->setDefault( 'status_id',			$data->user_status_id );
			$this->tag->setDefault( 'group_id',				$data->user_group_id );

			$this->view->setVar( 'varavartar',				$data->getAvatar( ) );
			$this->view->setVar( 'var_created_on',			date( $language->_( 'format_date' ), strtotime( $data->created_on ) ) );
			$this->view->setVar( 'var_updated_on',			date( $language->_( 'format_date' ), strtotime( $data->updated_on ) ) );
			$this->view->setVar( 'var_created_by', 			( $data->getCreatedBy( ) ? $data->getCreatedBy( )->getUsername( ) : '' ) );
			$this->view->setVar( 'var_updated_by', 			( $data->getUpdatedBy( ) ? $data->getUpdatedBy( )->getUsername( ) : '' ) );


			$this->view->setVar( 'var_breadcrumbs', array(
				$language->_( 'text_users' ) 		=> $this->url->get( array(
					'for' 	=> 'user-account',
				)),
				$language->_( 'text_accounts' ) 	=> $this->url->get( array(
					'for' 	=> 'user-account',
				)),
				$language->_( 'text_edit' ) 	=> $this->url->get( array(
					'for' 	=> 'user-account-edit',
					'id'	=> $data->getId( ),
				)),
			));

			$this->view->setVar( 'var_save_url', $this->url->get( array(
				'for' 	=> 'user-account-save',
				'id'	=> $data->getId( ),
			)));

			$this->view->pick( 'Account/Edit' );

		}

		/**
		 * Router View Prefix
		 * @Get( "/view/{id:[0-9]+}", "name" = "user-account-view" )
		 *
		 * Set Permission
		 * @Acl( "key" = "view", "name" = "View", "description" = "Account View." )
		 */
		public function viewAction ( $id = false ) {

			$this->view->setVar( '_', $language = $this->language->load( array(
				'system' => 'Index',
				'Index',
				'Account/Common',
				'Account/View',
			)));

			$data = Account::findFirst( array(
				'( is_archived = 0 OR is_archived IS NULL ) AND ( is_trashed = 0 OR is_trashed IS NULL ) AND user_account_id = ?0',
				'bind' => array(
					( int ) $id
				)
			));

			if ( !is_object( $data ) ) {
				$this->flicker->error( $language->_( 'not_found_message' ) );
				return $this->response->redirect( array(
					'for' 	=> 'user-account',
				));
			}

			$this->view->setVar( 'first_name', 				$data->UserProfile->first_name );
			$this->view->setVar( 'middle_name',				$data->UserProfile->middle_name );
			$this->view->setVar( 'last_name',				$data->UserProfile->last_name );
			$this->view->setVar( 'gender', 					$data->UserProfile->gender );
			$this->view->setVar( 'birth_date',				$data->UserProfile->birth_date );
			$this->view->setVar( 'birth_place',				$data->UserProfile->birth_place );
			$this->view->setVar( 'mobile_no',				$data->UserProfile->mobile_no );
			$this->view->setVar( 'telephone_no',			$data->UserProfile->telephone_no );
			$this->view->setVar( 'fax_no',					$data->UserProfile->fax_no );
			$this->view->setVar( 'address',					$data->UserProfile->address );
			$this->view->setVar( 'city',					$data->UserProfile->city );
			$this->view->setVar( 'state',					$data->UserProfile->state );
			$this->view->setVar( 'zip',						$data->UserProfile->zip );
			$this->view->setVar( 'country_id',				$data->UserProfile->country_id );

			if ( $this->package->isInstalled( 'Modules\Country' ) && $this->package->isEnabled( 'Modules\Country' ) ) {
				$this->view->setVar( 'country',					$data->UserProfile->Country->country );
			}

			$this->view->setVar( 'avartar',					$data->getAvatar( ) );
			$this->view->setVar( 'email',					$data->email );
			$this->view->setVar( 'username',				$data->username );
			$this->view->setVar( 'status_id',				$data->user_status_id );
			$this->view->setVar( 'status',					$data->UserStatus->status );
			$this->view->setVar( 'group_id',				$data->user_group_id );
			$this->view->setVar( 'group',					$data->UserGroup->group );

			$this->view->setVar( 'var_created_on',			date( $language->_( 'format_date' ), strtotime( $data->created_on ) ) );
			$this->view->setVar( 'var_updated_on',			date( $language->_( 'format_date' ), strtotime( $data->updated_on ) ) );
			$this->view->setVar( 'var_created_by', 			( $data->getCreatedBy( ) ? $data->getCreatedBy( )->getUsername( ) : '' ) );
			$this->view->setVar( 'var_updated_by', 			( $data->getUpdatedBy( ) ? $data->getUpdatedBy( )->getUsername( ) : '' ) );

			$this->view->setVar( 'var_breadcrumbs', array(
				$language->_( 'text_users' ) 		=> $this->url->get( array(
					'for' 	=> 'user-account',
				)),
				$language->_( 'text_accounts' ) 	=> $this->url->get( array(
					'for' 	=> 'user-account',
				)),
				$language->_( 'text_view' ) 	=> $this->url->get( array(
					'for' 	=> 'user-account-view',
					'id'	=> $data->getId( ),
				)),
			));

			$this->view->setVar( 'var_edit_url', $this->url->get( array(
				'for' 	=> 'user-account-edit',
				'id'	=> $data->getId( ),
			)));

			$this->view->setVar( 'var_archive_url', $this->url->get( array(
				'for' 	=> 'user-account-archive',
				'id'	=> $data->getId( ),
			)));

			$this->view->setVar( 'var_delete_url', $this->url->get( array(
				'for' 	=> 'user-account-delete',
				'id'	=> $data->getId( ),
			)));

			$this->view->pick( 'Account/View' );

		}

		/**
		 * Router Archive Prefix
		 * @Get( "/archive/{id:[0-9]+}", "name" = "user-account-archive" )
		 *
		 * Set Permission
		 * @Acl( "key" = "archive", "name" = "Archive", "description" = "Account Archive." )
		 */
		public function archiveAction ( $id = false ) {

			$language = $this->language->load( array(
				'system' => 'Index',
				'Index',
				'Account/Common',
				'Account/Archive',
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
							'for' 	=> 'user-account',
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
								'for' 	=> 'user-account',
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
						'for' 	=> 'user-account',
					));

				}

				$this->flicker->success( $language->_( 'success_message' ) );

			}

			$this->view->disable( );
			$this->response->redirect( array(
				'for' 	=> 'user-account',
			));

			return;

		}

		/**
		 * Router Unarchive Prefix
		 * @Get( "/unarchive/{id:[0-9]+}", "name" = "user-account-unarchive" )
		 *
		 * Set Permission
		 * @Acl( "key" = "unarchive", "name" = "Unarchive", "description" = "Account Unarchive." )
		 */
		public function unarchiveAction ( $id = false ) {

			$language = $this->language->load( array(
				'system' => 'Index',
				'Index',
				'Account/Common',
				'Account/Unarchive',
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
							'for' 	=> 'user-account',
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
								'for' 	=> 'user-account',
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
						'for' 	=> 'user-account',
					));

				}

				$this->flicker->success( $language->_( 'success_message' ) );
			}

			$this->view->disable( );
			$this->response->redirect( array(
				'for' 	=> 'user-account',
			));

			return;

		}

		/**
		 * Router Delete Prefix
		 * @Get( "/delete/{id:[0-9]+}", "name" = "user-account-delete" )
		 *
		 * Set Permission
		 * @Acl( "key" = "delete", "name" = "Delete", "description" = "Account Delete." )
		 */
		public function deleteAction ( $id = false ) {

			$language = $this->language->load( array(
				'system' => 'Index',
				'Index',
				'Account/Common',
				'Account/Delete',
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
							'for' 	=> 'user-account',
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
								'for' 	=> 'user-account',
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
						'for' 	=> 'user-account',
					));

				}

				$this->flicker->success( $language->_( 'success_message' ) );
			}

			$this->view->disable( );
			$this->response->redirect( array(
				'for' 	=> 'user-account',
			));

			return;
		}

		/**
		 * Router Save Prefix
		 * @Post( "/save" )
		 * @Post( "/save/{id:[0-9]+}", "name" = "user-account-save" )
		 */
		public function saveAction ( $id = false ) {

			if ( $this->request->isPost( ) == true ) {

				$add_language 		= $this->language->load( array(
					'system' => 'Index',
					'Index',
					'Account/Add',
				));
				$edit_language 		= $this->language->load( array(
					'system' => 'Index',
					'Index',
					'Account/Edit',
				));
				$common_language 	= $this->language->load( array(
					'system' => 'Index',
					'Index',
					'Account/Common',
				));

				if ( $this->security->checkToken( ) ) {

					$data = new \stdClass( );

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

					$list_countries 	= array( );
					$list_countries_id 	= array( );
					$list_groups_id 	= array( );
					$list_status_id 	= array( );

					if ( $this->package->isInstalled( 'Modules\Country' ) && $this->package->isEnabled( 'Modules\Country' ) ) {
						$list_countries = Country::find( array(
							'( is_archived = 0 OR is_archived IS NULL )'
						));
					}

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

					if ( $this->package->isInstalled( 'Modules\Country' ) && $this->package->isEnabled( 'Modules\Country' ) ) {
						$validator->add( 'country_id', new InclusionIn( array(
							'cancelOnFail'	=> true,
							'domain'		=> $list_countries_id,
							'message'		=> $common_language->_( 'validate_country' )
						)));
					}

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
							$this->flicker->error( $message->getMessage( ) );
						}

						if ( $data->id ) {
							$this->dispatcher->forward( array(
								'for' 	=> 'user-account-edit',
								'id'	=> array( $data->id )
							));
						} else {
							$this->dispatcher->forward( array(
								'for' 	=> 'user-account-add'
							));
						}
					} else {

						if ( $this->request->hasFiles( ) ) {
							foreach ( $this->request->getUploadedFiles( ) as $file ) {
								if ( $file->getKey( ) == 'avatar' ) {
									$key 		= Setting::get( 'avatar_key' );
									$dir 		= Setting::get( 'avatar_dir' );
									$tmb_dir 	= Setting::get( 'avatar_tmb_dir' );
									$filename   = $file->getName( );
									$x          = explode( '.', $filename );
									$_name      = $x[0];
									$_extension = $x[1];

									$data->avatar 			= $key . '-' . time( ) . '.' . $_extension;
									$filename_original 		= $this->config->directories->public->files->system->dir . $dir . $data->avatar;
									$filename_thumbnail 	= $this->config->directories->public->files->system->dir . $dir . $tmb_dir . $data->avatar;
									$file->moveTo( $filename_original );

									$image 	= new \Phalcon\Image\Adapter\GD( $filename_original );
									$image->resize( Setting::get( 'avatar_tmb_width' ), Setting::get( 'avatar_tmb_height' ) );
									$image->save( $filename_thumbnail );
								}
							}
						}

						$data = $this->_store( ( object ) $data );

						foreach( $data->messages as $message ) {
							$this->flicker->error( $message->getMessage( ) );
						}

						if ( isset( $data->id ) && $data->id > 0 ) {
							if ( $data->is_saved == true ) {
								$this->view->disable( );
								$this->flicker->success( $edit_language->_( 'success_message' ) );
								$this->response->redirect( array(
									'for' 	=> 'user-account-edit',
									'id'	=> $data->id
								));
							} else {
								$this->flicker->error( $edit_language->_( 'error_message' ) );
								$this->dispatcher->forward( array(
									'for' 	=> 'user-account-edit',
									'id'	=> $data->id
								));
							}
						} else {
							if ( $data->is_saved == true ) {
								$this->view->disable( );
								$this->flicker->success( $add_language->_( 'success_message' ) );
								$this->response->redirect( array(
									'for' 	=> 'user-account-add'
								));
							} else {
								$this->flicker->error( $add_language->_( 'error_message' ) );
								$this->dispatcher->forward( array(
									'for' 	=> 'user-account-add'
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
				'for' 	=> 'user-account'
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
				unlink( $this->config->directories->public->files->dir . Setting::get( 'avatar_dir' ) . $account_data->avatar );
				$account_data->avatar 		= $data->avatar;
			}

			if ( $data->password ) {
				$account_data->password 	= $this->security->hash( $data->password );
			}

			$account_data->user_group_id 	= $data->group_id;
			$account_data->user_status_id 	= $data->status_id;
			$account_data->UserProfile 		= $account_profile;

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

				$data->is_trashed = ( int ) true;

				if ( $data->save( ) == false ) {

					$data->is_trashed 	= ( int ) false;

					return $data;

				}

			}

			return true;

		}

	} // END CLASS ACCOUNT CONTROLLER