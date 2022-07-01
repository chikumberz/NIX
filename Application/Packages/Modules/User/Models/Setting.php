<?php

	namespace Application\Packages\Modules\User\Models;

	class Setting extends \Application\Libraries\Engine\Model\Model {

		public $user_setting_id;
		public $key;
		public $value;
		public $is_serialized;

		public function getSource ( ) {

			return 'mod-user_setting';

		}

		public function setId ( $user_setting_id ) {

			$this->user_setting_id = $user_setting_id;

			return $this;

		}

		public function setKey ( $key ) {

			$this->key = $key;

			return $this;

		}

		public function setValue ( $value ) {

			$this->value = $value;

			return $this;

		}

		public function setIsSerialized ( $is_serialized ) {

			$this->is_serialized = ( int ) $is_serialized;

			return $this;

		}

		public function getId ( ) {

			return $this->user_setting_id;

		}

		public function getKey ( ) {

			return $this->key;
		}

		public function getValue ( ) {

			$value = $this->value;

			if ( $this->isSerialized( ) ) {
				$value = unserialize( $value );
			}

			return $value;

		}

		public function isSerialized ( ) {

			return ( boolean ) $this->is_serialized;

		}

		public static function get ( $key, $parse = true ) {

			if ( !$key ) { return false; }

			$result = self::findFirst( array(
                '[key] = :key:',
                'bind' => array(
                    'key' 	=> $key
                )
            ));

            if ( is_object( $result ) ) {
            	if ( $parse ) {
            		$result = $result->getValue( );
            	}
            }

            return $result;
		}

		public static function getAll ( ) {

			$result = self::find( );

			$_result = array( );
			foreach ( $result as $data ) {
				$_result[$data->key] = $data;
			}

            return $_result;

		}

		public static function set ( $key, $value, $is_serialized = false ) {

			$setting = self::get( $key, false );

			if ( $is_serialized ) {
				$value = serialize( $value );
			}

            if ( is_object( $setting ) ) {
            	$setting->setValue( ( string ) $value );
            	$setting->setIsSerialized( ( int ) $is_serialized );
            } else {
            	$setting = new Setting( );
	        	$setting->setKey( $key );
	        	$setting->setValue( $value );
	        	$setting->setIsSerialized( ( int ) $is_serialized );
            }

        	return $setting->save( );

		}

		public function has ( $key ) {

			return ( boolean ) $this->get( $key );

		}

		public function beforeSave ( ) {

			if ( !$this->getKey( ) ) {
				return false;
			}

			if ( $this->isSerialized( ) ) {
				$this->setIsSerialized( true );
			} else {
				$this->setIsSerialized( false );
			}

		}

	} // END CLASS Setting