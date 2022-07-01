<?php
	namespace Application\Controllers;

	class BaseController extends \Phalcon\Mvc\Controller {
		
		public function initialize ( ) {

			$this->tag->setTitle( $this->setting->get( 'sys', 'title' ) );
			$this->auth->load( );
			
			$auth =  $this->auth->getIdentity( );
			
			if ( file_exists( $this->config->directories->public->files->dir . 'Images/System/Avatar/' . $auth['avatar']  ) ) {
				$auth['avatar'] = $this->url->get( array( 'for' => 'file-public', 'folder' => 'Images/System/Avatar/Thumb', 'file' => $auth['avatar'] ) );
			} else {
				$auth['avatar'] = $this->url->get( array( 'for' => 'file-public', 'folder' => 'Images/System/Avatar', 'file' => 'default-avatar.jpg' ) );
			}
			
			$this->view->setVar( 'auth', $auth );

		}

	} // END CLASS BASECONTROLLER