<?php

	return array(
		'sessions' => array( 
			'use'		=> 'file',
			'defaults'	=> array(
				'prefix'	=> 'cms-security-session-',
				'lifetime' 	=> 1440,
			),
			'adapters' 	=> array(
				'file'			=> array(
					'lifetime'			=> 8600,
					'uniqueId'			=> 'cms-security-session-',
				),
				// TODO: Add Phalcon\Session\Adapter ( Incubator )
				'database' 		=> array(
					'db'				=> '',
					'table'				=> 'session_data',
					'lifetime'			=> 8600,
					'prefix'			=> 'cms-security-session-',
				),
				'memcache' 		=> array(
					'host'				=> '127.0.0.1',
					'post'				=> 11211,
					'lifetime'			=> 8600,
					'prefix'			=> 'cms-security-session-',
					'persistent'		=> false
				),
				'mongo'				=> array(
					'db_name'			=> '',
					'db_table'			=> ''
				),
				'redis'				=> array(
					'path'				=> 'tcp://127.0.0.1:6379?weight=1'
				),
				'handler_socket' 	=> array(
					'cookie_path'		=> '/',
					'cookie_domain'		=> '',
					'lifetime'			=> 8600,
					'server'			=> array(
						'host'				=> '127.0.0.1',
						'post'				=> 11211,
						'dbname'			=> '',
						'dbtable'			=> ''
					)
				)
			) 
		)
	);