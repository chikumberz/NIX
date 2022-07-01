<?php

	namespace Application\Controllers\Page;

	/**
	 * Access Control List
	 *
	 * @Acl( "controller" = "Page", "description" = "This is a Sample Description" )
	 */
	class PageController extends \Application\Controllers\BaseController {

		/**
		 * Set Permission
		 *
		 * @Acl( "key" = "index", "name" = "Index", "description" = "This is a Sample Description" )
		 */
		public function indexAction ( ) {

			echo "Page Index Action!";

		}

		/**
		 * Set Permission
		 *
		 * @Acl( "key" = "add", "name" = "Add", "description" = "This is a Sample Description" )
		 */
		public function addAction ( ) {

			echo "Page Add Action!";

		}

		public function notfoundAction ( ) {

			echo 'Page Not Found!!!';

		}

	} // END CLASS PAGECONTROLLER