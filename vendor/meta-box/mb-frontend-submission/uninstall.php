<?php
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

delete_option( 'mbfs_keys' );
delete_option( 'mbfs_db_version' );