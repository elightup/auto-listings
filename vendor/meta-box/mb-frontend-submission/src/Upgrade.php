<?php
namespace MBFS;

class Upgrade {
	public function __construct() {
		$db_version = (int) get_option( 'mbfs_db_version', 1 );
		if ( $db_version >= MBFS_DB_VER ) {
			return;
		}

		delete_option( 'mbfs_keys' );

		// Always update the DB version to the plugin version.
		update_option( 'mbfs_db_version', MBFS_DB_VER );
	}
}
