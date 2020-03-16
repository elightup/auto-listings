<?php
namespace AutoListings\Upgrade;

class Manager {
	public function __construct() {
		$this->upgrade();
	}

	public function upgrade() {
		$current_version = get_option( 'auto_listings_db_version', '1' );

		$versions = ['2'];
		foreach ( $versions as $version ) {
			if ( version_compare( $current_version, $version, '>=' ) ) {
				continue;
			}
			$class = __NAMESPACE__ . '\Ver' . str_replace( '.', '', $version );
			new $class;
		}

		update_option( 'auto_listings_db_version', AUTO_LISTINGS_DB_VERSION );
	}
}
