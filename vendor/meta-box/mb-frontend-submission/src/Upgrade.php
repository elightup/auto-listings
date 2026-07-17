<?php
namespace MBFS;

class Upgrade {
	public function __construct() {
		$db_version = (int) get_option( 'mbfs_db_version', 1 );
		if ( $db_version >= MBFS_DB_VER ) {
			return;
		}

		if ( $db_version < 2 ) {
			delete_option( 'mbfs_keys' );
		}

		if ( $db_version < 3 ) {
			$this->disable_config_options_autoload();
		}

		// Always update the DB version to the plugin version.
		update_option( 'mbfs_db_version', MBFS_DB_VER );
	}

	/**
	 * Config options are only read on form submit; keep them out of alloptions.
	 */
	private function disable_config_options_autoload(): void {
		global $wpdb;

		// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching
		$option_names = $wpdb->get_col( $wpdb->prepare(
			"SELECT option_name FROM {$wpdb->options} WHERE option_name LIKE %s",
			ConfigStorage::PREFIX . 'option_%'
		) );

		if ( empty( $option_names ) ) {
			return;
		}

		wp_set_options_autoload( $option_names, false );
	}
}
