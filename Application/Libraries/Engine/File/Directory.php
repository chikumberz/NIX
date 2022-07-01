<?php

	namespace Application\Libraries\Engine\File;

	class Directory extends \Phalcon\Mvc\User\Component {

		public static function create ( $source, $permission = 0755, $recursive = true ) {

			$is_created = false;
			$old_umask 	= umask( 0 );

			if ( !self::exists( $source ) )
				$is_created = mkdir( $source, $permission, $recursive );

			umask( $old_umask );

			return $is_created;

		}

		public static function rename ( $source, $destination ) {

			if ( self::exists( $source ) )
				return rename( $source, $destination );

			return false;

		}

		public static function exists ( $source ) {

			return is_dir( $source );

		}

		public static function delete ( $source ) {

			if ( self::exists( $source ) ) {

				$objects = scandir( $source );

				foreach ( $objects as $file ) {
					$source_file 		= rtrim( $source, DS ) . DS . $file;

					if ( !is_readable( $source_file ) ) continue;

					if ( $file != '.' && $file != '..' ) {
						if ( self::exists( $source_file ) ) {
							self::delete( $source_file );
						} else {
							File::delete( $source_file );
						}
					}
				}

				reset( $objects );
     			return rmdir( $source );
			}

			return false;

		}

		public static function copy ( $source, $destination ) {

			$copied  = false;

			if ( self::exists( $source ) ) {

				if ( !self::exists( $destination ) ) {
					self::create( $destination );
				}

				$copied  = true;
				$objects = scandir( $source );

				foreach ( scandir( $source ) as $file ) {

					$source_file 		= rtrim( $source, DS ) . DS . $file;
					$destination_file 	= rtrim( $destination, DS ) . DS . $file;

					if ( !is_readable( $source_file ) ) continue;

					if ( $file != '.' && $file != '..' ) {
						if ( self::exists( $source_file ) ) {
							if ( !file_exists( $destination_file ) ) {
								self::create( $destination_file );
							}
							$copied = self::copy( $source_file, $destination_file );
						} else {
							$copied = File::copy( $source_file, $destination_file );
						}
					}

					if ( !$copied )
						return false;

				}
			}

			return $copied;

		}

		public static function move ( $source, $destination ) {

			if ( self::copy( $source, $destination ) )
				return self::delete( $source );

			return false;

		}

		public static function scan ( $source ) {

			if ( self::exists( $source ) )
				return scandir( $source );

			return false;

		}

		public static function time ( $source ) {

			return filemtime( $source );

		}

		public static function size ( $source ) {

			$size 		= 0;
			$files 		= self::scan( $source );
			$clean_path = rtrim( $source, '/' ) . '/';

			foreach ( $files as $file ) {
				if ( $file !=  '.' && $file !== '..' ) {
					$source = $clean_path . $file;
					if ( is_dir( $source ) ) {
						$size += self::size( $source );
					} else {
						$size += File::size( $source );
					}
				}
			}

			return $size;

			$units = array( 'B', 'KB', 'MB', 'GB', 'TB' );
			$unit = 0;

			while ( ( round($size / 1024) > 0 ) && ( $unit < 4 ) ) {
				$size = $size / 1024;
				$unit++;
			}

			return ( number_format( $size, 0 ) . ' ' . $units[$unit] );

		}

		public static function parseSize ( $size ) {

			$units = array( 'B', 'KB', 'MB', 'GB', 'TB' );
			$unit = 0;

			while ( ( round($size / 1024) > 0 ) && ( $unit < 4 ) ) {
				$size = $size / 1024;
				$unit++;
			}

			return ( number_format( $size, 0 ) . ' ' . $units[$unit] );

		}

		public static function writable ( $source ) {

			$source = rtrim( $source, '/' );

			if ( DIRECTORY_SEPARATOR  == '/' && @ini_get( 'safe_mode' ) == false ) {
				return is_writable( $source );
			}

			$source = $source . '/' . md5( mt_rand( 1, 1000 ) . mt_rand( 1, 1000 ) );

			if ( ( $fp = @fopen( $source, 'ab' ) ) === false ) {
				return false;
			}

			fclose( $fp );
			@chmod( $source, 0755 );
			@unlink( $source );

			return true;

		}

		public static function translate ( $name, $convert_spaces = false, $replace_with = '_' ) {

			if ( $convert_spaces ) {
				$name = str_replace( ' ', $replace_with, $name );
			}

			if ( function_exists( 'transliterator_transliterate' ) ) {
				$name = transliterator_transliterate( 'Accents-Any', utf8_encode( $name ) );
			} else {
				$name = iconv( 'UTF-8', 'ASCII//TRANSLIT//IGNORE', $name );
			}

			$name = preg_replace( "/[^a-zA-Z0-9\.\[\]_| -]/", '', $name );
			$name = str_replace( array( '"', "'", "/", "\\" ), "", $name );
			$name = strip_tags( $name );

			if ( strpos( $name, '.' ) === 0 ) {
				$name = 'folder' . $name;
			}

			return trim( $name );

		}


	} // END CLASS DIRECTORY