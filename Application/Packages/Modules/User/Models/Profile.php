<?php

	namespace Application\Packages\Modules\User\Models;

	class Profile extends \Application\Libraries\Engine\Model\Model {

		public $user_account_id;
		public $first_name;
		public $middle_name;
		public $last_name;
		public $gender;
		public $birth_date;
		public $birth_place;
		public $mobile_no;
		public $telephone_no;
		public $fax_no;
		public $address;
		public $city;
		public $state;
		public $country_id;

		public function getSource ( ) {

			return 'mod-user_profile';

		}

		public function initialize ( ) {

			$this->belongsTo( 'user_account_id', 'Application\Packages\Modules\User\Models\Account', 'user_account_id', array(
				'alias' => 'UserAccount'
			));

			$this->belongsTo( 'country_id', 'Application\Packages\Modules\Country\Models\Country', 'country_id', array(
				'alias' => 'Country'
			));

			$this->useDynamicUpdate( true );

		}

		public function getFirstName ( ) {

			return $this->first_name;

		}

		public function getMiddleName ( ) {

			return $this->middle_name;

		}

		public function getLastName ( ) {

			return $this->last_name;

		}


	} // END CLASS PROFILE
