<?php

	return array(
		'loads'	=> array(
			'use'			=> 'namespaces',
			'namespaces'	=> array(
				'Application\Models' 				=> $config->directories->application->models->dir,
				'Application\Packages' 				=> $config->directories->application->packages->dir,
				'Application\Libraries\Engine' 		=> $config->directories->application->libraries->engine->dir,
			)
		)
	);