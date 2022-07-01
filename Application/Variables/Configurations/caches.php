<?php

	return array(
		'caches'	=> array( 
			'use_frontend'	=> 'none',
			'use_backend' 	=> 'file',
			'defaults'	=> array(
				'lifetime'	=> 86400,
			), 
			'adapters' 	=> array(
				'frontend' 	=> array(
					'output'	=> array(
						'lifetime' => 86400,	
					),
					'data'	=> array(
						'lifetime' => 86400,	
					),
					'none' 	=> array( )
				),
				'backend'	=> array(
					'file' 		=> array( 
						'lifetime'		=> 172800,
						'cacheDir'		=> $config->directories->application->variables->caches->dir
					),
					'memcache' 	=> array(
						'lifetime' 		=> 86400,
					    'host' 			=> '127.0.0.1',
					    'port' 			=> '11211',
					    'persistent' 	=> NULL
					),
					'apc'		=> array (
						'prefix'		=> 'app-data'
					)
				)
			)
		)
	);