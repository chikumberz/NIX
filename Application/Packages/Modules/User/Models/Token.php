<?php

	namespace Application\Packages\Modules\User\Models;

	class Token extends \Application\Libraries\Engine\Model\Model {

		public $user_token_id;
		public $user_account_id;
		public $ip_address;
		public $user_agent;
		public $created_on;

		public function getSource ( ) {

			return 'mod-user_token';

		}

		public function initialize ( ) {

			$this->belongsTo( 'user_account_id', 'Application\Packages\Modules\User\Models\Account', 'user_account_id' );

		}

	} // END CLASS TOKEN