<?php

	namespace Application\Libraries\Engine\Setting;

	class setting extends \Phalcon\Mvc\User\Component {

		protected $_class 	= false;
		protected $_data 	= array( );

		public function __construct ( ) {

			$class = $this->config->settings->class;

			if ( class_exists( $class ) ) {

				$settings = $class::find( array(
	                '[group] = :group:',
	                'bind' => array(
	                    'group' => $this->config->settings->key
	                ),
	                'cache' => array(
	                	'key' => $this->config->settings->cache
	                )
	            ));

	            $_settings = array( );

	            foreach ( $settings as $setting ) {
	            	$_settings[$setting->key] = $setting;
	            }

	            $settings = $_settings;

			} else {

				$settings = $this->config->settings->defaults->toArray( );

			}

			$this->_data 	= $settings;
			$this->_class 	= $class;

		}


		public function get ( $key ) {

			if ( array_key_exists( $key, $this->_data ) ) {
				if ( $this->_data[$key] instanceof $this->_class ) {
					return $this->_data[$key]->getValue( );
				} else {
					return $this->_data[$key];
				}
			}

			return false;

		}

		public function set ( $group, $key, $value, $is_serialized = false ) {

			$class = $this->_class;

			if ( !$class )
				return false;

			$this->modelsCache->delete( $this->config->settings->cache );

			return $class::set( $group, $key, $value, $is_serialized );

		}


	} // END CLASS SETTING