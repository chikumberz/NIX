<?php

	return array(
		'settings'	=> array(
			'key'		=> 'sys',
			'cache' 	=> 'SYSTEM-CONFIGURATION',
			'class' 	=> 'Application\Packages\Modules\Setting\Models\Setting',
			'defaults' 	=> array(
				'title' 				=> 'NIX',
				'description' 			=> '',
				'keywords' 				=> '',
				'error_display' 		=> true,
				'error_log' 			=> true,
				'error_log_file'		=> 'system.log',
				'maintenance' 			=> false,
				'seo_url' 				=> true,
				'sql_log' 				=> true,
				'sql_log_file' 			=> 'sql.log',
				'class_log' 			=> true,
				'class_log_file' 		=> 'class.log',
				'theme' 				=> 'Default',
				'language' 				=> 'English',
				'table_show' 			=> array(
					10 	=> 10,
					20	=> 20,
					30	=> 30,
					40 	=> 40,
					50 	=> 50,
					100 => 100,
					500 => 500
				),
				'table_show_default' 	=> 20,
				'packages'				=> array(
					'Modules\Setting' => true,
					'Modules\Package' => true
				)
			)
		)
	);

