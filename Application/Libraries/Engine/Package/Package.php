<?php

	namespace Application\Libraries\Engine\Package;

	class Package extends \Phalcon\Mvc\User\Component {

		public $packages 				= array( );
		public $packages_load			= array( );
		public $packages_installed		= array( );

		public function __construct ( ) {

			$this->packages 			= $this->config->packages->toArray( );
			$this->packages_installed 	= $this->setting->get( 'packages' );

			foreach ( $this->packages as $type => $package ) {
				foreach ( $package as $name => $info ) {

					$package_infos = $info['classes']['installer']['class']::load( );

					if ( !is_array( $package_infos ) )
						continue;

					if ( array_key_exists( 'type', $package_infos ) )
						$this->packages[$type][$name]['type'] = $package_infos['type'];

					$this->packages[$type][$name]['infos'] 	= $package_infos;

					if ( $this->isInstalled( $info['id'] ) && $this->isEnabled( $info['id'] ) ) {
						$this->packages_load[$info['id']] =  array(
							'dir'		=> $info['dir'],
							'path'		=> $info['path'],
							'index' 	=> array(
								'path'		=> $info['classes']['index']['path'],
								'className' => $info['classes']['index']['class']
							)
						);
					}
				}
			}

		}

		public function initialize ( ) {

			foreach ( $this->packages_load as $id => $class ) {
				$index = new $class['index']['className']( );
				$index->initialize( $id, $class['dir'], $class['path'] );
			}

		}

		public function load ( ) {

			$classes = array( );

			foreach ( $this->packages_load as $id => $package ) {
				$classes[$id] = $package['index'];
			}

			return $classes;

		}

		public function getAll ( $type = null, $return_default = array( ) ) {

			if ( $type !== null ) {
				if ( isset( $this->packages[$type] ) )
					return $this->packages[$type];
				else
					return $return_default;
			}

			return $this->packages;

		}

		public function getAllInstalled ( ) {

			return $this->packages_installed;

		}

		public function isInstalled ( $id ) {

			if ( array_key_exists( $id, $this->packages_installed ) )
				return true;

			return false;

		}

		public function isEnabled ( $id ) {

			if ( !array_key_exists( $id, $this->packages_installed ) )
				return false;

			if ( $this->packages_installed[$id] )
				return true;

			return false;

		}

		public function exist ( $type, $name ) {

			if ( isset( $this->packages[$type] ) )
				return false;

			if ( isset( $this->packages[$type][$name] ) )
				return false;

			return true;

		}

		public function install ( $type, $name ) {

			if ( $this->exist( $type, $name ) )
				return false;

			$this->packages_installed[$this->packages[$type][$name]['id']] = true;

			if ( !$this->setting->set( $this->config->settings->key, 'packages', $this->packages_installed, true ) )
				return false;

			$installer_class = $this->packages[$type][$name]['classes']['installer']['class'];

			if ( method_exists( $installer_class, 'install' ) ) {
				$installer_class::install( );
			}

			return true;

		}

		public function uninstall ( $type, $name ) {

			if ( $this->exist( $type, $name ) )
				return false;

			unset( $this->packages_installed[$this->packages[$type][$name]['id']] );

			if ( !$this->setting->set( $this->config->settings->key, 'packages', $this->packages_installed, true ) )
				return false;

			$installer_class = $this->packages[$type][$name]['classes']['installer']['class'];

			if ( method_exists( $installer_class, 'uninstall' ) ) {
				$installer_class::uninstall( );
			}

			return true;

		}

		public function enable ( $type, $name ) {

			if ( $this->exist( $type, $name ) )
				return false;

			$this->packages_installed[$this->packages[$type][$name]['id']] = true;

			if ( !$this->setting->set( $this->config->settings->key, 'packages', $this->packages_installed, true ) )
				return false;

			$installer_class = $this->packages[$type][$name]['classes']['installer']['class'];

			if ( method_exists( $installer_class, 'enable' ) ) {
				$installer_class::enable( );
			}

			return true;

		}

		public function disable ( $type, $name ) {

			if ( $this->exist( $type, $name ) )
				return false;

			$this->packages_installed[$this->packages[$type][$name]['id']] = false;

			if ( !$this->setting->set( $this->config->settings->key, 'packages', $this->packages_installed, true ) )
				return false;

			$installer_class = $this->packages[$type][$name]['classes']['installer']['class'];

			if ( method_exists( $installer_class, 'disable' ) ) {
				$installer_class::disable( );
			}

			return true;

		}

	} // END CLASS PACKAGE