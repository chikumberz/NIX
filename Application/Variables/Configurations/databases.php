<?php

	return array(
		'databases'	=> array(
			'use'		=> 'default',
			'default' 	=> array(
				'system' 	=> array(
					/* === LOCAL === */
					'adapter' 		=> 'MySQL',
					'host'			=> 'localhost',
					'port'			=> '3306',
					'username'		=> 'root',
					'password'		=> '',
					'name'			=> 'www_ss_nix',

					'tbl_prefix'	=> '',
					'options'		=> array(

					),
					'persistent'	=> false,
					'metadata' 		=> array(
						'adapter'	=> false,
						'options'	=> array(
							'lifetime'	=> 86400,
							'prefix'	=> ''
						)
					),
					'cache' 		=> array(
						'adapter'	=> 'File',
						'dir'		=> $config->directories->application->variables->caches->dir . 'Databases' . DS,
						'options'	=> array(
							'lifetime'	=> 86400,
							'prefix'	=> '',
						)
					),
				)
			)
		)
	);