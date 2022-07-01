<?php

	namespace Application\Packages\Modules\Setting\Models;

	class Setting extends \Application\Libraries\Engine\Model\Model {

		public $setting_id;
		public $group;
		public $key;
		public $value;
		public $is_serialized;

		public function getSource ( ) {

			return 'sys-setting';

		}

		public function setId ( $setting_id ) {

			$this->setting_id = $setting_id;

			return $this;

		}

		public function setGroup ( $group ) {

			$this->group = $group;

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

			return $this->setting_id;

		}

		public function getGroup ( ) {

			return $this->group;

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

		public static function get ( $group, $key, $parse = true ) {

			if ( !$group || !$key ) { return false; }

			$result = self::findFirst( array(
                '[group] = :group: AND [key] = :key:',
                'bind' => array(
                    'group' => $group,
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

		public static function getAllByGroup ( $group, $parse = true ) {

			if ( !$group ) { return false; }

			$results = self::find( array(
                '[group] = :group:',
                'bind' => array(
                    'group' => $group
                )
            ));

			if ( $parse ) {
				$_results = array( );

	            foreach ( $results as $result ) {
	            	$_results[$result->key] = $result;
	            }

	            $results = $_results;
			}

            return $results;

		}

		public static function getAll ( ) {

			$result = self::find( );

            return $result;

		}

		public static function set ( $group, $key, $value, $is_serialized = false ) {

			$setting = self::get( $group, $key, false );

			if ( $is_serialized ) {
				$value = serialize( $value );
			}

            if ( is_object( $setting ) ) {
            	$setting->setGroup( $group );
            	$setting->setValue( ( string ) $value );
            	$setting->setIsSerialized( ( int ) $is_serialized );
            } else {
            	$setting = new Setting( );
            	$setting->setGroup( $group );
	        	$setting->setKey( $key );
	        	$setting->setValue( $value );
	        	$setting->setIsSerialized( ( int ) $is_serialized );
            }

        	return $setting->save( );

		}

		public function has ( $group, $key ) {

			return ( boolean ) $this->get( $group, $key );

		}

		public function beforeSave ( ) {

			if ( !$this->getGroup( ) ) {
				return false;
			}

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