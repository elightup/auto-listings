<?php
 /**
  * Store form configs in a persistent option that can be retrieved on form requests.
  */

namespace MBFS;

class ConfigStorage {
	const OPTION_NAME = 'mbfs_keys';

	public static function get( string $key ) : array {
		$option = get_option( self::OPTION_NAME, [] );
		return $option[ $key ] ?? [];
	}

	public static function delete( $key ) {
		$option = get_option( self::OPTION_NAME, [] );
		unset( $option[ $key ] );
		update_option( self::OPTION_NAME, $option );
	}

	public static function store( array $config ) : string {
		$option         = get_option( self::OPTION_NAME, [] );
		$key            = self::get_key( $config );
		$option[ $key ] = $config;
		update_option( self::OPTION_NAME, $option );

		return $key;
	}

	public static function get_key( array $config ) : string {
		return md5( serialize( $config ) );
	}
}
