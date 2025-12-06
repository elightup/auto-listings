<?php
/**
 * Store form configs in a persistent option that can be retrieved on form requests.
 */

namespace MBFS;

class ConfigStorage {
	const PREFIX = 'mbfs_config_';

	public static function get( string $key ): array {
		$config = self::get_from_transient( $key );

		if ( empty( $config ) ) {
			$config = self::get_from_option( $key );
		}

		return is_array( $config ) ? $config : [];
	}

	public static function store( array $config ): string {
		$key = self::get_key( $config );

		self::store_in_transient( $key, $config );
		self::store_in_option( $key, $config );

		return $key;
	}

	public static function get_key( array $config ): string {
		// phpcs:ignore WordPress.PHP.DiscouragedPHPFunctions.serialize_serialize
		return md5( serialize( $config ) );
	}

	private static function store_in_transient( string $key, array $config ): void {
		set_transient( self::PREFIX . $key, $config, DAY_IN_SECONDS );
	}

	private static function get_from_transient( string $key ): array {
		$config = get_transient( self::PREFIX . $key );

		return is_array( $config ) ? $config : [];
	}

	private static function store_in_option( string $key, array $config ): void {
		$option_key                               = self::PREFIX . 'option_' . $key;
		$config_with_timestamp                    = $config;
		$config_with_timestamp['_mbfs_timestamp'] = time();

		update_option( $option_key, $config_with_timestamp );

		self::cleanup_old_options();
	}

	private static function get_from_option( string $key ): array {
		$option_key = self::PREFIX . 'option_' . $key;
		$config     = get_option( $option_key, [] );

		if ( ! is_array( $config ) ) {
			return [];
		}

		unset( $config['_mbfs_timestamp'] );

		return $config;
	}

	private static function cleanup_old_options(): void {
		global $wpdb;

		// Get all options with their values to check timestamps
		// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching
		$options = $wpdb->get_results( $wpdb->prepare(
			"SELECT option_name, option_value FROM {$wpdb->options} WHERE option_name LIKE %s",
			self::PREFIX . 'option_%'
		) );

		$expired_options = [];
		$current_time    = time();

		foreach ( $options as $option ) {
			$config = maybe_unserialize( $option->option_value );

			// Check if config is expired (older than DAY_IN_SECONDS)
			if ( is_array( $config ) &&
				isset( $config['_mbfs_timestamp'] ) &&
				( $current_time - $config['_mbfs_timestamp'] ) > DAY_IN_SECONDS ) {
				$expired_options[] = $option->option_name;
			}
		}

		// Batch delete expired options
		if ( empty( $expired_options ) ) {
			return;
		}

		$placeholders = implode( ',', array_fill( 0, count( $expired_options ), '%s' ) );

		// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching
		$wpdb->query( $wpdb->prepare(
			"DELETE FROM {$wpdb->options} WHERE option_name IN ($placeholders)",
			...$expired_options
		) );
	}
}
