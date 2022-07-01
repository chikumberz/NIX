<?php

	namespace Application\Models\User;

	class Token extends \Phalcon\Mvc\Model {

		public $user_token_id;
		public $user_account_id;
		public $ip_address;
		public $user_agent;
		public $created_on;

		public function getSource ( ) {

			return 'sys-user_token';

		}

		public function initialize ( ) {

			$this->belongsTo( 'user_account_id', 'Account', 'user_account_id' );

		}

	} // END CLASS TOKEN