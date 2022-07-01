<?php

	namespace Application\Packages\Modules\User\Models;

	class Group extends \Application\Libraries\Engine\Model\Model {

		public $user_group_id;
		public $group;
		public $description;
		public $permissions;
		public $sort_order;
		public $is_archived;
		public $is_trashed;
		public $created_on;
		public $updated_on;
		public $created_by_id;
		public $updated_by_id;

		public function initialize ( ) {

			$this->hasOne( 'created_by_id', 'Application\Packages\Modules\User\Models\Account', 'user_account_id', array(
				'alias' 	=> 'CreatedBy'
			));

			$this->hasOne( 'updated_by_id', 'Application\Packages\Modules\User\Models\Account', 'user_account_id', array(
				'alias' 	=> 'UpdatedBy'
			));

			$this->useDynamicUpdate( true );

			$this->skipAttributesOnCreate( array(
				'update_on',
				'updated_by_id'
			));

			$this->skipAttributesOnUpdate( array(
				'created_on',
				'created_by_id'
			));

		}

		public function getSource ( ) {

			return 'mod-user_group';

		}

		public function beforeValidationOnCreate ( ) {

			$this->beforeCreate( );

		}

		public function beforeValidationOnUpdate ( ) {

			$this->beforeUpdate( );

		}

		public function beforeCreate ( ) {

			$auth = $this->getDI( )->get( 'auth' )->getIdentity( );

			$this->created_on 		= date( 'Y-m-d H:i:s' );
			$this->created_by_id 	= ( int ) $auth['id'];

		}

		public function beforeUpdate ( ) {

			$auth = $this->getDI( )->get( 'auth' )->getIdentity( );

			$this->updated_on 		= date( 'Y-m-d H:i:s' );
			$this->updated_by_id 	= ( int ) $auth['id'];

		}

		public function getId ( ) {

			return $this->user_group_id;

		}

		public function getGroup ( ) {

			return $this->group;

		}

		public function getPermissions (  ) {

			return $this->permissions ? unserialize( $this->permissions ) : array( );

		}

	} // END CLASS GROUP
