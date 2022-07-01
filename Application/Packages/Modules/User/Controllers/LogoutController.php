<?php

	namespace Application\Packages\Modules\User\Controllers;

	/**
	 * Router Prefix
	 * @RoutePrefix( "/:admin/logout" )
	 */

	class LogoutController extends \Phalcon\Mvc\Controller {

		/**
		 * Router Index Prefix
		 * @Get( "/", "name" = "logout" )
		 * @Get( "/index" )
		 */

		public function indexAction ( ) {

			$this->auth->remove( );

			return $this->response->redirect( array(
				'for'	=> 'user-login',
			));

		}

	} // END CLASS LOGOUT CONTROLLER