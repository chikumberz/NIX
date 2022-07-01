<?php

	return array(
		'urls'	=> array(
			'base_uri' 		=> 'http://localhost/NIX/',
			'source_uri'	=> '_url',
			'extension'		=> 'html',
			'cache_key'		=> 'ROUTER_URLS',
			'prefixes'		=> array(
				':admin'	=> 'admin',
				':frontend'	=> 'admin'
			),
			'themes'		=> array(
				'common' 		=> 'Themes/Common/%s/%s',
				'system' 		=> 'Themes/System/%s/%s/%s',
				'shared' 		=> 'Themes/Shared/%s/%s/%s',
			),
			'files'			=> array(
				'common' 			=> 'Files/Common/%s/%s',
				'system' 			=> 'Files/System/%s/%s',
				'shared' 			=> 'Files/Shared/%s/%s'
			)
		)
	);