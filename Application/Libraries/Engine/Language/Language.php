<?php

	namespace Application\Libraries\Engine\Language;

	class Language extends \Phalcon\Mvc\User\Component {

		private $location 			= array( );
		private $directory 	 		= array( );
		private $data 				= array( );
		private $default_location 	= "/";
		private $default_directory 	= "English";
		private $default_file		= "Index";

		public function get ( $key ) {

			return ( isset( $this->data[$key] ) ? $this->data[$key] : $key );

		}

		public function getData ( ) {

			return $this->data;

		}

		public function setDefaultLocation ( $location ) {

			$this->default_location = $location;

			return $this;

		}

		public function setDefaultDirectory ( $directory ) {

			$this->default_directory = $directory;

			return $this;

		}

		public function setDefaultFile ( $file ) {

			$this->default_file = $file;

			return $this;

		}

		public function setDirectory ( $key, $directory ) {

			$this->directory[$key] = $directory;

			return $this;

		}

		public function setLocation ( $key, $location ) {

			$this->location[$key] = $location;

			return $this;

		}

		protected function _preload ( $file ) {

			if ( file_exists( $file ) ) {
				$_ = array( );

				require ( $file );

				return $this->data = array_merge( $this->data, $_ );
			}

			return false;

		}

		public function load ( $_filenames = array( ) ) {

			if ( is_array( $_filenames ) ) {
				foreach ( $_filenames as $location_key => $_filename ) {

					if ( !isset( $this->location[$location_key] ) ) {

						$file =  $this->default_location . DS . $this->default_directory . DS . $_filename . '.php';

						if ( file_exists( $file ) ) {
							$this->_preload( $file );
						}

					} else if ( isset( $this->location[$location_key] ) && is_array( $_filename ) ) {

						foreach ( $_filename as $filename ) {

							$file =  $this->location[$location_key] . DS . $this->directory[$location_key] . DS . $filename . '.php';

							if ( file_exists( $file ) ) {
								$this->_preload( $file );
							} else {
								$file = $this->location[$location_key] . DS . $this->default_directory . DS . $filename . '.php';
								$this->_preload( $file );
							}
						}

					} else if ( isset( $this->location[$location_key] ) ) {

						$file =  $this->location[$location_key] . DS . $this->directory[$location_key] . DS . $_filename . '.php';

						if ( file_exists( $file ) ) {
							$this->_preload( $file );
						} else {
							$file = $this->location[$location_key] . DS . $this->default_directory . DS . $_filename . '.php';

							if ( file_exists( $file ) ) {
								$this->_preload( $file );
							}
						}
					}
				}

			}

			return new \Phalcon\Translate\Adapter\NativeArray( array(
				'content' => $this->data
			));

		}

	} // END CLASS LANGUAGE