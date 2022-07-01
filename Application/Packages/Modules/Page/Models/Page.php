<?php

	namespace Application\Packages\Modules\Page\Models;

	class Page extends \Application\Libraries\Engine\Model\Model {

		public $page_id;
		public $page_parent_id;
		public $page_layout_id;
		public $page_behavior_id;
		public $page_status_id;
		public $title;
		public $slug;
		public $keywords;
		public $description;
		public $sort_order;
		public $is_archived;
		public $is_trashed;
		public $published_on;
		public $valid_until;
		public $created_on;
		public $updated_on;
		public $created_by_id;
		public $updated_by_id;

		public function getSource ( ) {

			return 'mod-page';

		}

		public function initialize ( ) {

			$this->hasMany( 'page_id', 'Application\Packages\Modules\Page\Models\PagePart', 'page_id', array(
				'foreignKey'	=> array(
					'action' => \Phalcon\Mvc\Model\Relation::ACTION_CASCADE
				),
				'alias' 		=> 'PagePart'
			));

			$this->hasOne( 'created_by_id', 'Application\Packages\Modules\User\Models\Account', 'user_account_id', array(
				'alias' 	=> 'CreatedBy'
			));

			$this->hasOne( 'updated_by_id', 'Application\Packages\Modules\User\Models\Account', 'user_account_id', array(
				'alias' 	=> 'UpdatedBy'
			));

			$this->useDynamicUpdate( true );

			$this->skipAttributesOnCreate( array(
				'valid_until',
				'update_on',
				'updated_by_id'
			));

			$this->skipAttributesOnUpdate( array(
				'valid_until',
				'created_on',
				'created_by_id'
			));

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

			return $this->page_id;

		}

		public function getTitle( ) {

			return $this->title;

		}

	} // END CLASS PAGE
