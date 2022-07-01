<?php

	return array(
		'directories' 	=> array(
			'path' 		=> '/',
			'dir' 		=> ROOT_PATH,
			'application' 		=> array(
				'path'				=> 'Application/',
				'dir'				=> ROOT_PATH . 'Application/',
				'libraries' 		=> array(
					'path'				=> 'Application/Libraries/',
					'dir'				=> ROOT_PATH . 'Application/Libraries/',
					'engine'			=> array(
						'path'				=> 'Application/Libraries/Engine/',
						'dir'				=> ROOT_PATH . 'Application/Libraries/Engine/',
					),
				),
				'variables' 		=> array(
					'path'				=> 'Application/Variables/',
					'dir'				=> ROOT_PATH . 'Application/Variables/',
					'builds'			=> array(
						'path'				=> 'Application/Variables/Builds/',
						'dir'				=> ROOT_PATH . 'Application/Variables/Builds/',
					),
					'caches'			=> array(
						'path'				=>'Application/Variables/Caches/',
						'dir'				=> ROOT_PATH . 'Application/Variables/Caches/',
					),
					'configurations'	=> array(
						'path'				=> 'Application/Variables/Configurations/',
						'dir'				=> ROOT_PATH . 'Application/Variables/Configurations/',
					),
					'logs'				=> array(
						'path'				=> 'Application/Variables/Logs/',
						'dir'				=> ROOT_PATH . 'Application/Variables/Logs/',
					),
				),
				'controllers' 		=> array(
					'path'				=> 'Application/Controllers/',
					'dir'				=> ROOT_PATH . 'Application/Controllers/',
				),
				'models'			=> array(
					'path'				=> 'Application/Models/',
					'dir'				=> ROOT_PATH . 'Application/Models/',
				),
				'packages'			=> array(
					'path'				=> 'Application/Packages/',
					'dir'				=> ROOT_PATH . 'Application/Packages/',
				),
			),
			'public'		=> array(
				'path'			=> 'Public/',
				'dir'			=> ROOT_PATH . 'Public/',
				'files'			=> array(
					'path'				=> 'Public/Files/',
					'dir'				=> ROOT_PATH . 'Public/Files/',
					'common'			=> array(
						'path'			=> 'Public/Files/Common/',
						'dir'			=> ROOT_PATH . 'Public/Files/Common/',
					),
					'shared'			=> array(
						'path'			=> 'Public/Files/Shared/',
						'dir'			=> ROOT_PATH . 'Public/Files/Shared/',
					),
					'system'			=> array(
						'path'			=> 'Public/Files/System/',
						'dir'			=> ROOT_PATH . 'Public/Files/System/',
					),
				),
				'themes'		=> array(
					'path'				=> 'Public/Themes/',
					'dir'				=> ROOT_PATH . 'Public/Themes/',
					'common'			=> array(
						'path'				=> 'Public/Themes/Common/',
						'dir'				=> ROOT_PATH . 'Public/Themes/Common/',
						'languages'			=> array(
							'path'				=> 'Public/Themes/Common/Languages/',
							'dir'				=> ROOT_PATH . 'Public/Themes/Common/Languages/',
						),
						'images'			=> array(
							'path'				=> 'Public/Themes/Common/Images/',
							'dir'				=> ROOT_PATH . 'Public/Themes/Common/Images/',
						),
						'fonts'			=> array(
							'path'				=> 'Public/Themes/Common/Fonts/',
							'dir'				=> ROOT_PATH . 'Public/Themes/Common/Fonts/',
						),
						'stylesheets'		=> array(
							'path' 				=> 'Public/Themes/Common/Stylesheets/',
							'dir' 				=> ROOT_PATH . 'Public/Themes/Common/Stylesheets/',
						),
						'javascripts'		=> array(
							'path' 				=> 'Public/Themes/Common/Javascripts/',
							'dir' 				=> ROOT_PATH . 'Public/Themes/Common/Javascripts/',
						),
						'plugins'		=> array(
							'path' 				=> 'Public/Themes/Common/Plugins/',
							'dir' 				=> ROOT_PATH . 'Public/Themes/Common/Plugins/',
						),
					),
					'shared'			=> array(
						'path'				=> 'Public/Themes/Shared/',
						'dir'				=> ROOT_PATH . 'Public/Themes/Shared/',
						'languages'			=> array(
							'path'				=> 'Public/Themes/Shared/%s/Languages/',
							'dir'				=> ROOT_PATH . 'Public/Themes/Shared/%s/Languages/',
						),
						'images'			=> array(
							'path'				=> 'Public/Themes/Shared/%s/Images/',
							'dir'				=> ROOT_PATH . 'Public/Themes/Shared/%s/Images/',
						),
						'fonts'			=> array(
							'path'				=> 'Public/Themes/Shared/%s/Fonts/',
							'dir'				=> ROOT_PATH . 'Public/Themes/Shared/%s/Fonts/',
						),
						'stylesheets'		=> array(
							'path' 				=> 'Public/Themes/Shared/%s/Stylesheets/',
							'dir' 				=> ROOT_PATH . 'Public/Themes/Shared/%s/Stylesheets/',
						),
						'javascripts'		=> array(
							'path' 				=> 'Public/Themes/Shared/%s/Javascripts/',
							'dir' 				=> ROOT_PATH . 'Public/Themes/Shared/%s/Javascripts/',
						),
						'plugins'		=> array(
							'path' 				=> 'Public/Themes/Shared/%s/Plugins/',
							'dir' 				=> ROOT_PATH . 'Public/Themes/Shared/%s/Plugins/',
						),
						'templates'		=> array(
							'path' 				=> 'Public/Themes/Shared/%s/Templates/',
							'dir' 				=> ROOT_PATH . 'Public/Themes/Shared/%s/Templates/',
						),
					),
					'system'		=> array(
						'path'				=> 'Public/Themes/System/',
						'dir'				=> ROOT_PATH . 'Public/Themes/System/',
						'languages'			=> array(
							'path'				=> 'Public/Themes/System/%s/Languages/',
							'dir'				=> ROOT_PATH . 'Public/Themes/System/%s/Languages/',
						),
						'images'			=> array(
							'path'				=> 'Public/Themes/System/%s/Images/',
							'dir'				=> ROOT_PATH . 'Public/Themes/System/%s/Images/',
						),
						'fonts'			=> array(
							'path'				=> 'Public/Themes/System/%s/Fonts/',
							'dir'				=> ROOT_PATH . 'Public/Themes/System/%s/Fonts/',
						),
						'stylesheets'		=> array(
							'path' 				=> 'Public/Themes/System/%s/Stylesheets/',
							'dir' 				=> ROOT_PATH . 'Public/Themes/System/%s/Stylesheets/',
						),
						'javascripts'		=> array(
							'path' 				=> 'Public/Themes/System/%s/Javascripts/',
							'dir' 				=> ROOT_PATH . 'Public/Themes/System/%s/Javascripts/',
						),
						'plugins'		=> array(
							'path' 				=> 'Public/Themes/System/%s/Plugins/',
							'dir' 				=> ROOT_PATH . 'Public/Themes/System/%s/Plugins/',
						),
						'templates'		=> array(
							'path' 				=> 'Public/Themes/System/%s/Templates/',
							'dir' 				=> ROOT_PATH . 'Public/Themes/System/%s/Templates/',
						),
					)
				)
			)
		)
	);