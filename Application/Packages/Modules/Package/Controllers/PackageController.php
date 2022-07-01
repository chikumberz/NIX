<?php

	namespace Application\Packages\Modules\Package\Controllers;

	/**
	 * Router Prefix
	 * @RoutePrefix( "/:admin/package" )
	 *
	 * Access Control List
	 * @Acl( "controller" = "Modules\Package\Controllers\Package", name = "Package", "description" = "Package Access." )
	 */

	class PackageController extends \Phalcon\Mvc\Controller {

		/**
		 * Router Index Prefix
		 * @Get( "/" )
		 * @Get( "/index", name = "package" )
		 *
		 * Set Permission
		 * @Acl( "key" = "index", "name" = "Index", "description" = "Package Index." )
		 */

		public function indexAction ( ) {

			$this->view->setVar( '_', $language = $this->language->load( array(
				'system' 	=> 'Index',
				'Index',
				'Package/Index'
			)));

			$packages = $this->package->getAll( );

			foreach ( $packages as $package_type => $_packages ) {
				foreach ( $_packages as $package_name => $info ) {
					if ( $this->package->isEnabled( $info['id'] ) ) {
						$this->tag->setDefault( 'enabled[' . $info['id'] . ']', $info['id'] );
					}
				}
			}

			$this->view->setVar( 'var_packages', 	$packages );
			$this->view->setVar( 'var_breadcrumbs', array(
				$language->_('text_packages') => $this->url->get( array(
					'for' 			=> 'package'
				))
			));

			$this->view->pick( 'Index' );

		}

		/**
		 * Router Install Prefix
		 * @Get( "/install/{type:[a-zA-z]+}/{name:[a-zA-z]+}", name = "package-install" )
		 *
		 * Set Permission
		 * @Acl( "key" = "install", "name" = "Install", "description" = "Install Package." )
		 */
		public function installAction ( $type, $name ) {

			$language = $this->language->load( array(
				'system' 	=> 'Index',
				'Index',
				'Package/Install'
			));

			if ( $this->package->install( $type, $name ) ) {
				$this->flicker->message( 'success', $language->_( 'success_message' ) );
			} else {
				$this->flicker->message( 'error', $language->_( 'error_message' ) );
			}

			return $this->response->redirect( array(
				'for' => 'package'
			));

		}

		/**
		 * Router Uninstall Prefix
		 * @Get( "/uninstall/{type:[a-zA-z]+}/{name:[a-zA-z]+}", name = "package-uninstall" )
		 *
		 * Set Permission
		 * @Acl( "key" = "uninstall", "name" = "Uninstall", "description" = "Uninstall Package." )
		 */
		public function uninstallAction ( $type, $name ) {

			$language = $this->language->load( array(
				'system' 	=> 'Index',
				'Index',
				'Package/Uninstall'
			));

			if ( $this->package->uninstall( $type, $name ) ) {
				$this->flicker->message( 'success', $language->_( 'success_message' ) );
			} else {
				$this->flicker->message( 'error', $language->_( 'error_message' ) );
			}

			return $this->response->redirect( array(
				'for' => 'package'
			));

		}

		/**
		 * Router Enable Prefix
		 * @Get( "/enable/{type:[a-zA-z]+}/{name:[a-zA-z]+}", name = "package-enable" )
		 *
		 * Set Permission
		 * @Acl( "key" = "enable", "name" = "Enable", "description" = "Enable Package." )
		 */
		public function enableAction ( $type, $name ) {

			$language = $this->language->load( array(
				'system' 	=> 'Index',
				'Index',
				'Package/Enable'
			));

			if ( $this->package->enable( $type, $name ) ) {
				$this->flicker->message( 'success', $language->_( 'success_message' ) );
			} else {
				$this->flicker->message( 'error', $language->_( 'error_message' ) );
			}

			return $this->response->redirect( array(
				'for' => 'package'
			));

		}

		/**
		 * Router Disable Prefix
		 * @Get( "/disable/{type:[a-zA-z]+}/{name:[a-zA-z]+}", name = "package-disable" )
		 *
		 * Set Permission
		 * @Acl( "key" = "disable", "name" = "Disable", "description" = "Disable Package." )
		 */
		public function disableAction ( $type, $name ) {

			$language = $this->language->load( array(
				'system' 	=> 'Index',
				'Index',
				'Package/Disable'
			));

			if ( $this->package->disable( $type, $name ) ) {
				$this->flicker->message( 'success', $language->_( 'success_message' ) );
			} else {
				$this->flicker->message( 'error', $language->_( 'error_message' ) );
			}

			return $this->response->redirect( array(
				'for' => 'package'
			));

		}

	} // END CLASS PACKAGE CONTROLLER