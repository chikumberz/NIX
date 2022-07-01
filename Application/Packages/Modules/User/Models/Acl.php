<?php

	namespace Application\Packages\Modules\User\Models;

	class Acl extends \Phalcon\Mvc\User\Component {

		private $acl;
		private $resources;

		public function isPrivate ( $controller, $action ) {

			$resources = $this->getResources( );

			if ( isset( $resources[$controller] ) ) {
				$permissions = $resources[$controller]->actions;

				if ( in_array( $action, $permissions ) ) {
					return true;
				}
			}

			return false;

		}

		public function isAllowed ( $group, $controller, $action ) {

			return $this->getAcl( )->isAllowed( $group, $controller, $action );

		}

		public function hasAcl ( ) {

			if ( is_object( $this->acl ) ) {
				return $this->acl;
			}

			if ( function_exists( 'apc_fetch' ) ) {

				$acl = $this->di->get( 'cache', array(
					array(
						'adapter'	=> 'data',
						'options'	=> array(
							'lifetime'	=> 2592000
						)
					),
					'apc'
				))->get( $this->config->acls->cache->file );

				if ( is_object( $acl ) ) {
					return $acl;
				}
			}

			$acl = $this->di->get( 'cache', array(
				array(
					'adapter'	=> 'data',
					'options'	=> array(
						'lifetime'	=> 2592000
					)
				)
			))->get( $this->config->acls->cache->file );

			if ( is_object( $acl ) ) {
				return $acl;
			}

			return false;

		}

		public function getAcl ( ) {

			$acl = $this->hasAcl( );

			if ( !$acl ) {
				return $this->acl = $this->build( );
			}

			$this->acl = $acl;

			if ( function_exists( 'apc_store' ) ) {
				$this->di->get( 'cache', array(
					array(
						'adapter'	=> 'data',
						'options'	=> array(
							'lifetime'	=> 2592000
						)
					),
					'apc'
				))->save( $this->config->acls->cache->file, $this->acl );
			}

			return $this->acl;

		}

		public function getResources ( ) {

			if ( !$this->resources ) {

				$resources 	= array( );

				foreach ( $this->package->getAll( ) as $package_type => $package ) {
					foreach ( $package as $package_name => $info ) {

						$files = scandir( $info['dir'] . DS . 'Controllers' );

						foreach ( $files as $file ) {

							if ( $file == '.' || $file == '..' || strpos( $file, 'Controller.php' ) == false )
								continue;

							$class 	= $info['namespace'] . '\\' . 'Controllers' . '\\' . ucfirst( str_replace( '.php', '', $file ) );
							$object = $this->getAccessList( $class );

			 				if ( $object == null ) continue;

							$resources[$object->controller] = $object;

						}
					}
				}

				$this->resources = $resources;

			}

			return $this->resources;

		}

		public function getAccessList ( $class, $return_default = null ) {

			$object 				= new \stdClass( );
			$reader 				= new \Phalcon\Annotations\Adapter\Memory( );
			$reflector 				= $reader->get( $class );
			$class_annotations 		= $reflector->getClassAnnotations( );
			$methods_annotations 	= $reflector->getMethodsAnnotations( );

			if ( $class_annotations && $class_annotations->has( 'Acl' ) ) {

				$class_annotation = $class_annotations->get( 'Acl' );

				if ( $class_annotation->hasNamedArgument( 'controller' ) ) {

					$object->controller 	= $class_annotation->getNamedArgument( 'controller' );
					$object->name 			= $class_annotation->getNamedArgument( 'name' );
					$object->description 	= $class_annotation->getNamedArgument( 'description' );

				} else {
					return $return_default;
				}

				if ( $methods_annotations ) {

					$object->actions 		= array( );
					$object->permissions 	= array( );

					foreach ( $methods_annotations as $annotation ) {

						if ( $annotation->has( 'Acl' ) ) {

							$methods_annotation = $annotation->getAll( 'Acl' );

							foreach ( $methods_annotation as $arguments ) {

								$object->actions[] 		= $arguments->getNamedArgument( 'key' );
								$object->permissions[] 	= $arguments->getArguments( );

							}

						}

					}

				}

				return $object;
			}

			return $return_default;

		}

		public function build ( ) {

			$acl = new \Phalcon\Acl\Adapter\Memory( );

			$acl->setDefaultAction( \Phalcon\Acl::DENY );

			$groups = Group::find( '( is_archived = 0 OR is_archived IS NULL ) AND ( is_trashed = 0 OR is_trashed IS NULL )' );

			foreach ( $groups as $group ) {
				$acl->addRole( new \Phalcon\Acl\Role( $group->group ) );
			}

			foreach ( $this->getResources( ) as $resource => $controller  ) {
				$acl->addResource( new \Phalcon\Acl\Resource( $resource ), $controller->actions );
			}

			foreach ( $groups as $group ) {
				foreach ( $group->getPermissions( ) as $controller => $actions ) {
					$acl->allow( $group->group, $controller, $actions );
				}
			}

			$this->di->get( 'cache', array(
				array(
					'adapter'	=> 'data',
					'options'	=> array(
						'lifetime'	=> 2592000
					)
				)
			))->save( $this->config->acls->cache->file, $acl );

			if ( function_exists( 'apc_store' ) ) {
				$this->di->get( 'cache', array(
					array(
						'adapter'	=> 'data',
						'options'	=> array(
							'lifetime'	=> 2592000
						)
					),
					'apc'
				))->save( $this->config->acls->cache->file, $acl );
			}

			return $acl;

		}

		public function clear ( ) {

			$this->di->get( 'cache', array(
				array(
					'adapter'	=> 'data',
					'options'	=> array(
						'lifetime'	=> 2592000
					)
				)
			))->delete( $this->config->acls->cache->file );

			if ( function_exists( 'apc_remove' ) ) {
				$this->di->get( 'cache', array(
					array(
						'adapter'	=> 'data',
						'options'	=> array(
							'lifetime'	=> 2592000
						)
					),
					'apc'
				))->delete( $this->config->acls->cache->file );
			}

		}

	} // END CLASS ACL