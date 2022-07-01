<?php

	namespace Application\Libraries\Engine;

	class Application {

		private $_di;
		private $_app;
		private $_config;


		public function __construct ( ) {

			$di 	= new \Phalcon\DI\FactoryDefault( );
			$app 	= new \Phalcon\Mvc\Application( );
			$config = new \Phalcon\Config( include_once( __DIR__ . '/../../Variables/Configurations/directories.php' ) );
			$config->merge( new \Phalcon\Config( include_once( $config->directories->application->variables->configurations->dir . 'loads.php' ) ) );
			$config->merge( new \Phalcon\Config( include_once( $config->directories->application->variables->configurations->dir . 'sessions.php' ) ) );
			$config->merge( new \Phalcon\Config( include_once( $config->directories->application->variables->configurations->dir . 'caches.php' ) ) );
			$config->merge( new \Phalcon\Config( include_once( $config->directories->application->variables->configurations->dir . 'logs.php' ) ) );
			$config->merge( new \Phalcon\Config( include_once( $config->directories->application->variables->configurations->dir . 'databases.php' ) ) );
			$config->merge( new \Phalcon\Config( include_once( $config->directories->application->variables->configurations->dir . 'urls.php' ) ) );
			$config->merge( new \Phalcon\Config( include_once( $config->directories->application->variables->configurations->dir . 'languages.php' ) ) );
			$config->merge( new \Phalcon\Config( include_once( $config->directories->application->variables->configurations->dir . 'builds.php' ) ) );
			$config->merge( new \Phalcon\Config( include_once( $config->directories->application->variables->configurations->dir . 'settings.php' ) ) );
			$config->merge( new \Phalcon\Config( include_once( $config->directories->application->variables->configurations->dir . 'acls.php' ) ) );

			$this->_di		= $di;
			$this->_app 	= $app;
			$this->_config	= $config;

			$this->_di->setShared( 'config', $this->_config );

		} // END CONSTRUCT

		public function run ( ) {

			$initialize = array(
				'cache',
				'logger',
				'session',
				'security',
				'crypt',
				'loader',
				'profiler',
				'database',
				'setting',
				'flash',
				'url',
				'asset',
				'language',
				'router',
				'dispatcher',
				'view',
				'event',
				'navigation',
				'package',
				'environment',
				'engine'
			);

			foreach ( $initialize as $init ) {
				$this->{'init' . ucfirst( $init )}( $this->_app, $this->_di, $this->_config );
			}

			$this->_app->setDI( $this->_di );

		} // END RUN ENGINE

		public function getOutput ( ) {

			$app 			= $this->_app;
			$request_uri 	= '/';
			$source_uri 	= $app->request->get( $app->config->urls->source_uri );

			if ( $source_uri ) {
				$request_uri = parse_url( $source_uri, PHP_URL_PATH );
			}

			unset( $_GET[$app->config->urls->source_uri] );

			$request_uri = preg_replace( '/\.' . $this->_config->urls->extension . '$/', '', $request_uri );

			return $app->handle( $request_uri )->getContent( );

		} // END GETTING OUTPUT

		public function initCache ( $app, $di, $config ) {

			$di->set( 'cache', function ( $frontend = false, $backend = false ) use ( $app, $di, $config ) {

				if ( is_array( $frontend ) && array_key_exists( 'adapter', $frontend ) ) {
					$frontend_adapter = $frontend['adapter'];
					$frontend_options = ( array_key_exists( 'options', $frontend ) ) ? $frontend['options'] : array( );
				} else if ( $frontend != false ) {
					$frontend_adapter = $frontend;
					$frontend_options = $config->caches->defaults->toArray( );
				} else {
					$frontend_adapter = $config->caches->use_frontend;
					$frontend_options = array_merge(
						$config->caches->defaults->toArray( ),
						$config->caches->adapters->frontend->{$config->caches->use_frontend}->toArray( )
					);
				}

				$frontend_adapter 	= '\Phalcon\Cache\Frontend\\' . ucfirst( $frontend_adapter );
				$frontend 			=  new $frontend_adapter( $frontend_options );

				if ( is_array( $backend ) && array_key_exists( 'adapter', $backend ) ) {
					$backend_adapter = $backend['adapter'];
					$backend_options = ( array_key_exists( 'options', $backend ) ) ? $backend['options'] : array( );
				} else if ( $backend != false ) {
					$backend_adapter = $backend;
					$backend_options = $config->caches->defaults->toArray( );
				} else {
					$backend_adapter = $config->caches->use_backend;
					$backend_options = array_merge(
						$config->caches->defaults->toArray( ),
						$config->caches->adapters->backend->{$config->caches->use_backend}->toArray( )
					);
				}

				$backend_adapter 	= '\Phalcon\Cache\Backend\\' . ucfirst( $backend_adapter );
				$backend 			= new $backend_adapter( $frontend, $backend_options );

				$cache 				= $backend;

				return $cache;

			});

		} // END INITIALIZE CACHE

		public function initLogger ( $app, $di, $config ) {

			$di->set( 'logger', function ( $file, $format = false ) use ( $app, $di, $config ) {

				$logger = new \Phalcon\Logger\Adapter\File( $config->directories->application->variables->logs->dir . $file );
                $logger->setFormatter( new \Phalcon\Logger\Formatter\Line( ( $format ) ? $format : $config->logs->format ) );

                return $logger;

			});

		} // END INITIALIZE LOGGER

		public function initSession ( $app, $di, $config ) {

			$di->set( 'session', function ( ) use ( $app, $di, $config ) {

				if ( 'file' == $config->sessions->use ) {

					$session = new \Phalcon\Session\Adapter\Files( array_merge(
						$config->sessions->defaults->toArray( ),
						$config->sessions->adapters->{$config->sessions->use}->toArray( )
					));

				} else if ( 'database' == $config->sessions->use ) {

			        $session = new \Phalcon\Session\Adapter\Database( array_merge(
						$config->sessions->defaults->toArray( ),
						$config->sessions->adapters->{$config->sessions->use}->toArray( )
					));

				} else if ( 'memcache' == $config->sessions->use ) {

					$session = new \Phalcon\Session\Adapter\Memcache( array_merge(
						$config->sessions->defaults->toArray( ),
						$config->sessions->adapters->{$config->sessions->use}->toArray( )
					));

				} else if ( 'mongo' == $config->sessions->use ) {

					$mongo 		= new Mongo( );
					$session 	= new \Phalcon\Session\Adapter\Mongo( array_merge(
						$config->sessions->defaults->toArray( ),
						$config->sessions->adapters->{$config->sessions->use}->toArray( )
					));

				} else if ( 'redis' == $config->sessions->use ) {

					$session 	= new \Phalcon\Session\Adapter\Redis( array_merge(
						$config->sessions->defaults->toArray( ),
						$config->sessions->adapters->{$config->sessions->use}->toArray( )
					));

				} else if ( 'handler_socket' == $config->sessions->use ) {

					$session = new \Phalcon\Session\Adapter\HandlerSocket( array_merge(
						$config->sessions->defaults->toArray( ),
						$config->sessions->adapters->{$config->sessions->use}->toArray( )
					));

				} else {

					$session = new \Phalcon\Session\Adapter\Files( );

				}

				$session->start( );

				return $session;

			}, true );

		} // END INITIALIZE SESSION

		public function initSecurity ( $app, $di, $config ) {

			$di->set( 'security', function ( ) use ( $app, $di, $config ) {

				$security = new \Phalcon\Security( );
				$security->setWorkFactor( 12 );

				return $security;

			}, true );

			$di->set( 'crypt', function ( ) use ( $app, $di, $config ) {

			    $crypt = new \Phalcon\Crypt( );
			    $crypt->setKey( 'NIX' );

			    return $crypt;

			});

		} // END INITIALIZE SECURITY

		public function initCrypt ( $app, $di, $config ) {

			$di->set( 'crypt', function ( ) use ( $app, $di, $config ) {

			    $crypt = new \Phalcon\Crypt( );
			    $crypt->setKey( 'NIX' );

			    return $crypt;

			});

		} // END INITIALIZE CRYPT

		public function initLoader ( $app, $di, $config ) {

			$loader = new \Phalcon\Loader( );
			$loader->registerNamespaces( $config->loads->{$config->loads->use}->toArray( ) );

			$packages_dir 			= scandir( $config->directories->application->packages->dir );
			$packages_dir_list 		= array( );
			$packages_namespaces 	= array( );

			foreach ( $packages_dir as $package_dir_name ) {

				if ( $package_dir_name == '.' || $package_dir_name == '..' ) {
					continue;
				}

				$packages 		= scandir( $config->directories->application->packages->dir . $package_dir_name );
				$packages_list 	= array( );

				foreach ( $packages as $package_name ) {

					if ( $package_name == '.' || $package_name == '..' ) {
						continue;
					}

					$package_dir 		= $config->directories->application->packages->dir . $package_dir_name . DS . $package_name . DS;
					$package_path 		= $config->urls->base_uri . $config->directories->application->packages->path . $package_dir_name . PS . $package_name . PS;
					$package_dir_index 	= $package_dir . DS . 'Index.php';

					if ( file_exists( $package_dir_index ) ) {

						$package_namespace 	= 'Application\Packages\\' . $package_dir_name . '\\' . $package_name;

						$package_id 				= $package_dir_name . '\\' . $package_name;
						$package_index 				= $package_namespace . '\Index';
						$package_index_dir 			= $package_dir . 'Index.php';
						$package_installer 			= $package_namespace . '\Installer';
						$package_installer_dir 		= $package_dir . 'Installer.php';

						$packages_list[strtolower( $package_name )] 	= array(
							'id'			=> $package_id,
							'namespace' 	=> $package_namespace,
							'dir' 			=> $package_dir,
							'path' 			=> $package_path,
							'classes' 		=> array(
								'index' 		=> array(
									'class' 	=> $package_index,
									'path'		=> $package_index_dir,
								),
								'installer' 	=> array(
									'class' 	=> $package_installer,
									'path'		=> $package_installer_dir,
								)
							)
						);

						$package_namespaces[$package_namespace] = $package_dir;

					}
				}

				$packages_dir_list['packages'][strtolower( $package_dir_name )] = $packages_list;
			}

			$config->merge( new \Phalcon\Config( $packages_dir_list ) );

			$loader->registerNamespaces( $package_namespaces, true );
			$loader->register( );

			$di->set( 'loader', $loader );

		} // END INITIALIZE LOADER

		public function initProfiler ( $app, $di, $config ) {

			$di->set( 'profiler', function ( ) use ( $app, $di, $config ) {

				$profiler = new \Phalcon\Db\Profiler( );

				return $profiler;

			}, true );

		} // END INITIALIZE PROFILER

		public function initDatabase ( $app, $di, $config ) {

			$di->set( 'db', function ( ) use ( $app, $di, $config ) {

				$options = array(
					'host' 			=> $config->databases->{$config->databases->use}->system->host,
					'port' 			=> $config->databases->{$config->databases->use}->system->port,
	                'username' 		=> $config->databases->{$config->databases->use}->system->username,
	                'password' 		=> $config->databases->{$config->databases->use}->system->password,
	                'dbname' 		=> $config->databases->{$config->databases->use}->system->name,
	                'options'		=> ( array ) $config->databases->{$config->databases->use}->system->options,
	                'persistent'	=> ( boolean ) $config->databases->{$config->databases->use}->system->persistent
				);

				if ( 'MySQL' == $config->databases->{$config->databases->use}->system->adapter ) {
					$connection = new \Phalcon\Db\Adapter\Pdo\MySQL( $options );
				} else if ( 'PostgreSQL' == $config->databases->{$config->databases->use}->system->adapter ) {
					$connection = new \Phalcon\Db\Adapter\Pdo\Postgresql( $options );
				} else if ( 'SQLite' == $config->databases->{$config->databases->use}->system->adapter ) {
					$connection = new \Phalcon\Db\Adapter\Pdo\Sqlite( $options );
				} else if ( 'Oracle' == $config->databases->{$config->databases->use}->system->adapter ) {
					$connection = new \Phalcon\Db\Adapter\Pdo\Oracle( $options );
				} else {
					throw new \Phalcon\Session\Exception( "The parameter 'adapter' is required" );
				}

				return $connection;

			}, true );

			$di->set( 'modelsMetadata', function ( ) use ( $di, $config  ) {

				$metadata_adapter = $config->databases->{$config->databases->use}->system->metadata->adapter;
				$metadata_options = $config->databases->{$config->databases->use}->system->metadata->options->toArray( );

				if ( $metadata_adapter ) {
					$metadata = '\Phalcon\Mvc\Model\Metadata\\' . $metadata_adapter;
					$metadata = new $metadata( $metadata_options );
				} else {
					$metadata = new \Phalcon\Mvc\Model\Metadata\Memory( );
				}

				return $metadata;

			}, true );

			$di->set( 'modelsCache', function ( ) use ( $di, $config  ) {

				$cache_adapter = $config->databases->{$config->databases->use}->system->cache->adapter;
				$cache_options = $config->databases->{$config->databases->use}->system->cache->options->toArray( );

				$front_cache = new \Phalcon\Cache\Frontend\Data( $cache_options );

			    if ( $cache_adapter ) {
					$models_cache = '\Phalcon\Cache\Backend\\' . $cache_adapter;
					$models_cache = new $models_cache( $front_cache, array(
				        'host' 		=> $config->databases->{$config->databases->use}->system->host,
				        'port' 		=> $config->databases->{$config->databases->use}->system->port,
				        'cacheDir' 	=> $config->databases->{$config->databases->use}->system->cache->dir
				    ));
				} else {
					$models_cache = new \Phalcon\Cache\Backend\File( $front_cache, array(
				        'host' 		=> $config->databases->{$config->databases->use}->system->host,
				        'port'		=> $config->databases->{$config->databases->use}->system->port,
				        'cacheDir' 	=> $config->databases->{$config->databases->use}->system->cache->dir
				    ));
				}

				return $models_cache;

			});

		} // END INITIALIZE DATABASE

		public function initSetting ( $app, $di, $config ) {

			$di->set( 'setting', function ( ) use ( $app, $di, $config ) {

				$setting = new Setting\Setting( );

				return $setting;

			}, true );

		} // END INITIALIZE SETTING

		public function initFlash ( $app, $di, $config ) {

			$flash_data = array(
	            'success' 	=> 'alert alert-success',
	            'error' 	=> 'alert alert-danger',
	            'notice' 	=> 'alert alert-info',
	            'warning' 	=> 'alert alert-warning'
	        );

	        $di->set( 'flash', function ( ) use ( $di, $config, $flash_data ) {
				$flash = new \Phalcon\Flash\Direct( $flash_data );

				return $flash;
			});

			$di->set( 'flicker', function ( ) use ( $di, $config, $flash_data ) {
				$flash = new \Phalcon\Flash\Session( $flash_data );

				return $flash;
			});

		} // END INITIALIZE FLASH

		public function initUrl ( $app, $di, $config ) {

			$di->set( 'url', function ( ) use ( $app, $di, $config ) {

				$url = new \Phalcon\Mvc\Url( );
				$url->setBaseUri( $config->urls->base_uri );

				return $url;

			}, true );

		} // END INITIALIZE URL

		public function initAsset ( $app, $di, $config ) {

			$di->set( 'assets', function ( ) {
				return new \Phalcon\Assets\Manager( );
			}, true );

		} // END INITIALIZE ASSET


		public function initLanguage ( $app, $di, $config ) {

			/*$di->set( 'language', function ( ) use ( $app, $di, $config ) {

				$frontend_theme			= $di->get( 'setting' )->get( 'frontend_theme' );
				$backend_theme			= $di->get( 'setting' )->get( 'backend_theme' );
				$frontend_language 		= $di->get( 'setting' )->get( 'frontend_language' );
				$backend_language 		= $di->get( 'setting' )->get( 'backend_language' );
				$default_language 		= $config->languages->default;

				$language =  new Language\Language( );
				$language->setDefaultDirectory( $default_language );

				foreach ( $config->languages->locations->toArray( ) as $key => $location ) {
					if ( $location['theme'] == 'frontend' ) {
						$language->setDirectory( $key, $frontend_language );
						$language->setLocation( $key, sprintf( $location['dir'], $frontend_theme ) );
					} else if ( $location['theme'] == 'backend' ) {
						$language->setDirectory( $key, $backend_language );
						$language->setLocation( $key, sprintf( $location['dir'], $backend_theme ) );
					} else {
						$language->setDirectory( $key, $default_language );
						$language->setLocation( $key, $location['dir'] );
					}
				}

				return $language;

			}, true );*/

		} // END INITIALIZE LANGUAGE

		public function initRouter ( $app, $di, $config ) {

			$di->set( 'router', function ( ) use ( $app, $di, $config ) {

				$router = new Router\Annotations( false );

				$use_theme = $di->get( 'setting' )->get( 'theme' );

				foreach ( $config->urls->themes->toArray( ) as $theme => $location ) {

					if ( $theme == 'system' ) {
						$location = sprintf( $location, $use_theme, ':folder', ':file' );
					} else if ( $theme == 'common' ) {
						$location = sprintf( $location, ':folder', ':file' );
					}

					$router->add( '/' . $location, array(
						'folder' => 1,
						'file' => 2
					))->setName( 'theme-' . strtolower( str_replace( ' ', '-', $theme ) ) );

				}

				foreach ( $config->urls->files->toArray( ) as $theme => $location ) {

					$location = sprintf( $location, ':folder', ':file' );

					$router->add( '/' . $location, array(
						'folder' => 1,
						'file' => 2
					))->setName( 'file-' . strtolower( str_replace( ' ', '-', $theme ) ) );

				}

				foreach ( $config->packages->toArray( ) as $package_dir_name => $package ) {
					foreach ( $package as $package_name => $info ) {
						if ( $di->get( 'package' )->isInstalled( $info['id'] ) && $di->get( 'package' )->isEnabled( $info['id'] ) ) {

							$controllers_files = scandir( $info['dir'] . DS . 'Controllers' );

							foreach ( $controllers_files as $controller_file ) {
								if ( $controller_file == '.' || $controller_file == '..' || strpos( $controller_file, 'Controller.php' ) === false ) {
									continue;
								}

								$controller = $info['namespace'] . '\Controllers\\' . str_replace( 'Controller.php', '', $controller_file );

								$router->addModuleResource( $info['id'], $controller );
							}
						}
					}
				}

				/*
				// TODO: Fix
				$backend_url 		= $di->get( 'setting' )->get( 'backend_url' );
				$backend_theme 		= $di->get( 'setting' )->get( 'backend_theme' );
				$frontend_theme 	= $di->get( 'setting' )->get( 'frontend_theme' );

				$router = new \Phalcon\Mvc\Router\Annotations( false );
				$router->removeExtraSlashes( true );
				$router->setDefaultNamespace( 'Application\Controllers\\' );
				$router->setDefaultController( 'Index' );
				$router->setDefaultAction( 'index' );

				foreach ( $config->urls->themes->toArray( ) as $theme => $location ) {

					if ( $theme == 'shared' ) {
						$location = sprintf( $location, $frontend_theme, ':folder', ':file' );
					} else if ( $theme == 'system' ) {
						$location = sprintf( $location, $backend_theme, ':folder', ':file' );
					} else {
						$location = sprintf( $location, ':folder', ':file' );
					}

					$router->add( '/' . $location, array(
						'folder' => 1,
						'file' => 2
					))->setName( 'theme-' . strtolower( str_replace( ' ', '-', $theme ) ) );

				}

				foreach ( $config->urls->files->toArray( ) as $theme => $location ) {

					if ( $theme == 'shared' ) {
						$location = sprintf( $location, $frontend_theme, ':folder', ':file' );
					} else if ( $theme == 'system' ) {
						$location = sprintf( $location, $backend_theme, ':folder', ':file' );
					} else {
						$location = sprintf( $location, ':folder', ':file' );
					}

					$router->add( '/' . $location, array(
						'folder' => 1,
						'file' => 2
					))->setName( 'file-' . strtolower( str_replace( ' ', '-', $theme ) ) );

				}

				$router->add( '/' . $backend_url . '/{folder:[a-zA-Z0-9_-]+}/:controller', array(
					'folder' 		=> 1,
					'controller' 	=> 2
				))->setName( 'admin-controller' )->convert( 'folder', function ( $folder ) {

					$folder = str_replace( array( '_', '-' ), '\\', $folder );;
					$folder = explode( '\\', $folder );

					foreach ( $folder as $key => $name ) {
						$folder[$key] = ucfirst( $name );
					}

					$folder = implode( '\\', $folder );

					return $folder;

				});

				$router->add( '/' . $backend_url . '/{folder:[a-zA-Z0-9_-]+}/:controller/:action', array(
					'folder' 		=> 1,
					'controller' 	=> 2,
					'action' 		=> 3
				))->setName( 'admin-action' )->convert( 'folder', function ( $folder ) {

					$folder = str_replace( array( '_', '-' ), '\\', $folder );;
					$folder = explode( '\\', $folder );

					foreach ( $folder as $key => $name ) {
						$folder[$key] = ucwords( $name );
					}

					$folder = implode( '\\', $folder );

					return $folder;

				});

				$router->add( '/' . $backend_url . '/{folder:[a-zA-Z0-9_-]+}/:controller/:action/:params', array(
					'folder' 		=> 1,
					'controller' 	=> 2,
					'action' 		=> 3,
					'params'		=> 4
				))->setName( 'admin-full' )->convert( 'folder', function ( $folder ) {

					$folder = str_replace( array( '_', '-' ), '\\', $folder );;
					$folder = explode( '\\', $folder );

					foreach ( $folder as $key => $name ) {
						$folder[$key] = ucwords( $name );
					}

					$folder = implode( '\\', $folder );

					return $folder;

				});

				$router->add( '/' . $backend_url, array(
					'folder'		=> 'User',
					'controller' 	=> 'Login',
					'action' 		=> 'index'
				))->setName( 'admin' );
				*/

				return $router;

			}, true );

		} // END INITIALIZE ROUTER

		public function initDispatcher ( $app, $di, $config ) {

			$di->set( 'dispatcher', function ( ) use ( $app, $di, $config ) {

				$dispatcher = new \Phalcon\Mvc\Dispatcher( );

				return $dispatcher;

			}, true );

		} // END INITIALIZE DISPATCHER

		public function initView ( $app, $di, $config ) {

			/*$di->set( 'view', function ( ) use ( $app, $di, $config ) {

				$view_theme		= $di->get( 'setting' )->get( 'theme' );
				$view_directory = sprintf( $config->directories->public->themes->system->templates->dir, $view_theme );

				if ( !is_dir( $view_directory ) ) {
					throw new \Phalcon\Session\Exception( "The theme directory does not exist." );
				}

				$view = new \Phalcon\Mvc\View( );
				$view->setViewsDir(  $view_directory );
				$view->setLayoutsDir( 'Common/Layout/' );
				$view->setPartialsDir( 'Common/Partial/' );
				$view->setMainView( 'Common/Index' );
				$view->setLayout( 'Common/Layout/Index' );

				$view->registerEngines( array(
					'.volt' => function ( $view, \Phalcon\DiInterface $di ) use ( $config ) {

						$volt = new \Phalcon\Mvc\View\Engine\Volt( $view, $di );
						$volt->setOptions( array(
							'compiledPath' 		=> $config->builds->path,
							'compiledExtension'	=> $config->builds->extension,
							'compiledSeparator' => '_',
							'compiledAlways'	=> $config->builds->always
						));

						return $volt;

					},
					'.phtml'	=> '\Phalcon\Mvc\View\Engine\Php'
				));

				return $view;

			});*/

		} // END INITIALIZE VIEW

		public function initEvent ( $app, $di, $config ) {

			if ( $di->get( 'setting' )->get( 'class_log' ) ) {

				$events_manager = new \Phalcon\Events\Manager( );
				$events_manager->attach( 'loader', function ( $event, $loader ) use ( $di, $config, $setting ) {

					$logger = $di->get( 'logger', array( 'Classes/' . $di->get( 'setting' )->get( 'class_log_file' ) ) );

					if ( $event->getType( ) == 'beforeCheckPath' ) {
						$logger->log( $loader->getCheckedPath( ), \Phalcon\Logger::INFO );
					}

				});
				$di->get( 'loader' )->setEventsManager( $events_manager );

			}

			if ( $di->get( 'setting' )->get( 'sql_log' ) ) {

				$events_manager = new \Phalcon\Events\Manager( );
				$events_manager->attach( 'db', function ( $event, $connection ) use ( $di, $config, $setting ) {

					$profiler 	= $di->get( 'profiler' );
					$logger 	= $di->get( 'logger', array( 'Databases/' . $di->get( 'setting' )->get( 'sql_log_file' ) ) );

					if ( $event->getType( ) == 'beforeQuery' ) {
						$sql_statement =  $connection->getSqlStatement( );
						$logger->log( $sql_statement, \Phalcon\Logger::INFO );
						$profiler->startProfile( $sql_statement );
					}

					if ( $event->getType( ) == 'afterQuery' ) {
						$profiler->stopProfile( );
					}

				});

				$di->get( 'db' )->setEventsManager( $events_manager );

			}

			// NO SETTING REQUIRED

			$events_manager = new \Phalcon\Events\Manager( );
			$events_manager->attach( 'dispatch', new Event\Dispatcher( ) );

			$di->get( 'dispatcher' )->setEventsManager( $events_manager );

		} // END INITIALIZE EVENT

		public function initPackage ( $app, $di, $config ) {

			$package = new Package\Package( );

			$app->registerModules( $package->load( ) );

			$di->set( 'package', $package );
			$di->get( 'package' )->initialize( );

		} // END INITIALIZE PACKAGE

		public function initNavigation ( $app, $di, $config ) {

			$navigation = new Navigation\navigation( );

			$di->set( 'navigation', $navigation );

		} // END INITIALIZE NAVIGATION

		public function initEnvironment ( $app, $di, $config ) {

			if ( $di->get( 'setting' )->get( 'error_display' ) ) {

				error_reporting( E_ALL );
				ini_set( 'disply_errors', 'On' );
				//( new Debug\Debug( ) )->listen( true, true );

			} else {

				error_reporting( 0 );
				ini_set( 'disply_errors', 'Off' );

			}

			if ( $di->get( 'setting' )->get( 'error_log' ) ) {

				ini_set( 'error_log', $config->directories->application->variables->logs->dir . 'Systems/' . $di->get( 'setting' )->get( 'error_log_file' ) );

			}

		} // END INITIALIZE ENVIRONMENT

		public function initEngine ( $app, $di, $config ) {



		} // END INITIALIZE ENGINE

	} // END CLASS APPLICATION