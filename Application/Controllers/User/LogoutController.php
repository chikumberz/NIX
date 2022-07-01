<?php

	namespace Application\Controllers\User;

	class LogoutController extends \Application\Controllers\BaseController {
		
		public function indexAction ( ) {

			$this->auth->remove( );

			return $this->response->redirect( array(
				'for'	=> 'admin',
			));

		}

	} // END CLASS LOGOUT CONTROLLER