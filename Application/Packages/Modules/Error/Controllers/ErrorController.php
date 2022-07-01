<?php

	namespace Application\Packages\Modules\Error\Controllers;

	/**
	 * Router Prefix
	 * @RoutePrefix( "/error" )
	 *
	 */
	class ErrorController extends \Phalcon\Mvc\Controller {

		/**
		 * Router Show 404 Prefix
		 * @Get( "/show404", "name" = "error-show404" )
		 *
		 */
		public function show404Action ( ) {

			$this->view->setVar( '_', $language = $this->language->load( array(
				'system' => 'Index',
				'Index',
				'Error/Common',
				'Error/show404',
			)));

			$this->response->setStatusCode( '404', $language->_( 'error' ) );

			$this->view->setMainView( 'Common/Blank' );
			$this->view->setVar( 'link_go_back', '');/*$this->url->get( array(
				'for' 			=> 'admin-controller',
				'folder'		=> 'dashboard',
				'controller'	=> 'dashboard',
			)));*/

			$this->view->pick( 'Show404' );

		}

		/**
		 * Router Show 505 Prefix
		 * @Get( "/show505", "name" = "error-show505" )
		 *
		 */
		public function show505Action ( ) {

			$this->view->setVar( '_', $language = $this->language->load( array(
				'system' => 'Index',
				'Index',
				'Error/Common',
				'Error/show505',
			)));

			$this->response->setStatusCode( '505', $language->_( 'error' ) );

			$this->view->setMainView( 'Common/Blank' );
			$this->view->setVar( 'link_go_back', '');/*$this->url->get( array(
				'for' 			=> 'admin-controller',
				'folder'		=> 'dashboard',
				'controller'	=> 'dashboard',
			)));*/

			$this->view->pick( 'Show505' );

		}

	} // END CLASS ERRORCONTROLLER