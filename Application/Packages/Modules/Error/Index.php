<?php

	namespace Application\Packages\Modules\Error;

	class Index extends \Application\Libraries\Engine\Package\Index {

		public function initialize ( ) {

			$this->router->notFound( array(
				'module'		=> 'Modules\Error',
				'namespace'		=> $this->config->packages->modules->error->namespace,
				'controller' 	=> 'Controllers\Error',
				'action'	 	=> 'show404'
			));

		}

	} // END CLASS INDEX