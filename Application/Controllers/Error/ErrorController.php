<?php

	namespace Application\Controllers\Error;

	class ErrorController extends \Application\Controllers\BaseController {

		public function show404Action ( ) {
			
			$language = $this->language->load( 'system', array( 'Index', 'Error/Common', 'Error/Show404') );

			$this->view->setMainView( 'Common/Blank' );

			$this->response->setStatusCode( '404', $language->_( 'error' ) );

			$this->view->setVar( '_', $language );
			$this->view->setVar( 'link_go_back', $this->url->get( array(
				'for' 			=> 'admin-controller',
				'folder'		=> 'dashboard',
				'controller'	=> 'dashboard',
			)));

			$this->view->pick( 'Error/Show404' );

		}

		public function show505Action ( ) {

			$language = $this->language->load( 'system', array( 'Index', 'Error/Common', 'Error/Show505') );

			$this->view->setMainView( 'Common/Blank' );

			$this->response->setStatusCode( '505', $language->_( 'error' ) );

			$this->view->setVar( '_', $language );
			$this->view->setVar( 'link_go_back', $this->url->get( array(
				'for' 			=> 'admin-controller',
				'folder'		=> 'dashboard',
				'controller'	=> 'dashboard',
			)));

			$this->view->pick( 'Error/Show505' );

		}

	} // END CLASS ERRORCONTROLLER