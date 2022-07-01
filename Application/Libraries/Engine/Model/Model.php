<?php

	namespace Application\Libraries\Engine\Model;

	class Model extends \Phalcon\Mvc\Model {

		public function getDI ( ) {

	        return \Phalcon\DI\FactoryDefault::getDefault( );

	    }

	} // END CLASS MODEL