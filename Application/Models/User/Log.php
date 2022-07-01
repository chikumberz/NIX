<?php

	namespace Application\Models\User;

	class Log extends \Phalcon\Mvc\Model {

		CONST TYPE_DEFAULT 			= 500;
		CONST TYPE_DEFAULT_ACTIVE 	= 100;
		CONST TYPE_DEFAULT_INACTIVE = 500;

		public $user_log_id;
		public $user_account_id;
		public $ip_address;
		public $user_agent;
		public $type_id;
		public $created_on;

		public static $__TYPES__ = array( 
			'100'	=> 'Success',
			'500'	=> 'Failed'
		);

		public function getSource ( ) {

			return 'sys-user_log';

		}

		public function initialize ( ) {

			$this->belongsTo( 'user_account_id', 'Account', 'user_account_id' );

		}

		public static function getTypes ( ) {

			return self::$__TYPES__;

		}

		public static function getTypeByKey ( $key ) {
			
			$types = self::getTypes( );

			return isset( $types[$key] ) ? $types[$key] : false;
				
		}

		public static function getTypeByValue ( $value ) {

			return array_search( $value, self::getTypes( ) );

		}

		public static function getTypeDefault ( ) {

			$types = self::getTypes( );

			return isset( $types[self::TYPE_DEFAULT] ) ? $types[self::TYPE_DEFAULT] : false;
				
		}

		public function getId ( ) {

			return $this->user_log_id;

		}

		public function getIpAddress ( ) {

			return $this->ip_address;

		}

		public function getUserAgent ( ) {

			return $this->user_agent;

		}

		public function getType ( ) {

			return self::getTypeByKey( $this->type_id );

		}

		public function getCreatedOn ( ) {

			return $this->created_on;

		}

	} // END CLASS LOG