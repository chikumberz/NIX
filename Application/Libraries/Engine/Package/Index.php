<?php

	namespace Application\Libraries\Engine\Package;


	abstract class Index extends \Phalcon\Mvc\User\Component {

		protected $_package;
		protected $_package_name;
		protected $_package_type;

		public function initialize ( ) {

		}

		public function registerAutoloaders ( ) {


		}

		public function registerServices ( $di ) {

			$config 						= $di->get( 'config' );
			$package 						= $di->get( 'router' )->getModuleName( );
			$package_explode				= explode( '\\', $package );

			if ( count( $package_explode ) > 1 ) {
				$this->_package 		= $package;
				$this->_package_name 	= $package_explode[1];
				$this->_package_type 	= $package_explode[0];
			}

			$di->set( 'language', function ( ) use ( $di, $config ) {

				$theme				= $di->get( 'setting' )->get( 'theme' );
				$use_language		= $di->get( 'setting' )->get( 'language' );
				$default_language 	= $config->languages->default;
				$key_language 		= strtolower( $this->getPackageName( ) );

				$language =  new \Application\Libraries\Engine\Language\Language( );
				$language->setDefaultDirectory( $default_language );
				$language->setDefaultLocation( $this->getLanguageDirectory( ) );

				$language->setDirectory( $key_language, $use_language );
				$language->setLocation( $key_language, $this->getLanguageDirectory( ) );

				foreach ( $config->languages->locations->toArray( ) as $key => $location ) {
					$language->setDirectory( $key, $use_language );
					$language->setLocation( $key, sprintf( $location['dir'], $theme ) );
				}

				return $language;

			});

			$di->set( 'view', function ( ) use ( $di, $config ) {

				$view = new \Application\Libraries\Engine\View\View( );

				$view->setViewsDir( $this->getViewDirectory( ) );
				$view->setThemeDir( $this->getThemeDirectory( ) );
				$view->setLayoutsDir( 'Layout/' );
				$view->setPartialsDir( 'Partial/' );
				$view->setMainView( 'Common/Index' );
				$view->setLayout( 'Index' );

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

			});

			$di->set( 'view_simple', function ( ) use ( $di, $config ) {

				$view = new \Application\Libraries\Engine\View\ViewSimple( );

				$view->setViewsDir( $this->getViewDirectory( ) );

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

			});

		}

		public function getPackage ( ) {

			return $this->_package;

		}

		public function getPackageName ( ) {

			return $this->_package_name;

		}

		public function getPackageType ( ) {

			return $this->_package_type;

		}

		public function validPackage ( ) {

			if ( !$this->getPackageType( ) ||  !$this->getPackageName( ) )
				return false;

			if ( !isset( $this->config->packages->{strtolower( $this->getPackageType( ) )}->{strtolower( $this->getPackageName( ) )}->dir ) )
				return false;

			return true;

		}

		public function getViewDirectory ( ) {

			if ( !$this->validPackage( ) )
				return DS;

			return $this->config->packages->{strtolower( $this->getPackageType( ) )}->{strtolower( $this->getPackageName( ) )}->dir . DS . 'Views' . DS;

		}

		public function getLanguageDirectory ( ) {

			if ( !$this->validPackage( ) )
				return DS;

			return $this->config->packages->{strtolower( $this->getPackageType( ) )}->{strtolower( $this->getPackageName( ) )}->dir . DS . 'Languages' . DS;

		}

		public function getThemeDirectory ( ) {

			$view_theme		= $this->setting->get( 'theme' );
			$view_directory	= sprintf( $this->config->directories->public->themes->system->templates->dir, $view_theme );

			if ( !is_dir( $view_directory ) )
				return;

			return $view_directory;

		}

	} // END CLASS INDEX
