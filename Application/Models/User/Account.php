<?php

	namespace Application\Models\User;

	class Account extends \Phalcon\Mvc\Model {

		public $user_account_id;
		public $user_group_id;
		public $user_status_id;
		public $avatar;
		public $email;
		public $username;
		public $password;
		public $forgot_password;
		public $is_login;
		public $is_archived;
		public $last_login;
		public $last_active;
		public $created_on;
		public $updated_on;
		public $created_by_id;
		public $updated_by_id;

		public function getSource ( ) {

			return 'sys-user_account';

		}

		public function initialize ( ) {

			$this->hasOne( 'user_account_id', 'Application\Models\User\Profile', 'user_account_id', array( 
				'foreignKey'	=> array(
					'action' => \Phalcon\Mvc\Model\Relation::ACTION_CASCADE
				),
				'alias' 		=> 'Profile' 
			));
			$this->belongsTo( 'user_group_id', 'Application\Models\User\Group', 'user_group_id', array( 
				'foreignKey'	=> array(
					'action' => \Phalcon\Mvc\Model\Relation::ACTION_CASCADE
				),
				'alias' 		=> 'Group' 
			));
			$this->belongsTo( 'user_status_id', 'Application\Models\User\Status', 'user_status_id', array( 
				'foreignKey'	=> array(
					'action' => \Phalcon\Mvc\Model\Relation::ACTION_CASCADE
				),
				'alias' 		=> 'Status' 
			));
			$this->hasMany( 'user_account_id', 'Application\Models\User\Log', 'user_account_id', array( 
				'foreignKey'	=> array(
					'action' => \Phalcon\Mvc\Model\Relation::ACTION_CASCADE
				),
				'alias' => 'Log' 
			));
			$this->hasMany( 'user_account_id', 'Application\Models\User\Token', 'user_account_id', array( 
				'foreignKey'	=> array(
					'action' => \Phalcon\Mvc\Model\Relation::ACTION_CASCADE
				),
				'alias' => 'Token' 
			));

			$this->useDynamicUpdate( true );

			$this->skipAttributesOnCreate( array(
				'forgot_password',
				'forgot_password_salt',
				'is_login',
				'last_login',
				'last_active',
				'update_on',
				'updated_by_id'
			));

			$this->skipAttributesOnUpdate( array(
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

			$auth = \Phalcon\DI\FactoryDefault::getDefault( )->get( 'auth' )->getIdentity( );

			$this->created_on 		= date( 'Y-m-d H:i:s' );
			$this->created_by_id 	= ( int ) $auth['id'];

		}

		public function beforeUpdate ( ) {

			$auth = \Phalcon\DI\FactoryDefault::getDefault( )->get( 'auth' )->getIdentity( );

			$this->updated_on 		= date( 'Y-m-d H:i:s' );
			$this->updated_by_id 	= ( int ) $auth['id'];

		}

		public function getId ( ) {

			return $this->user_account_id;

		}

		public function getUsername( ) {

			return $this->username;

		}

		public function getPassword ( ) {

			return $this->password;

		}

		public function getAvatar ( ) {

			return $this->avatar;

		}

	} // END CLASS USERACCOUNT
