<?php

	define( 'VERSION', 	'0.1.0' );
	define( 'DS', 		DIRECTORY_SEPARATOR );
	define( 'PS', 		'/' );

	if ( !defined( 'PUBLIC_PATH' ) ) {
	    define( 'PUBLIC_PATH', dirname( __FILE__ ) );
	}

	if ( !defined( 'ROOT_PATH' ) ) {
		define(	'ROOT_PATH', dirname( dirname( __FILE__ ) ) . DS );
	}

	require_once( ROOT_PATH . 'Application/Libraries/Engine/Application.php' );

	$application = new \Application\Libraries\Engine\Application( );
	$application->run( );
	echo $application->getOutput( );