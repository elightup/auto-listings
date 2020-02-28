<?php
namespace AutoListings\Upgrade;

class Manager {
	public function __construct() {
		$this->upgrade();
	}

	public function upgrade() {
		$current_version = get_option( 'auto_listings_version', AUTO_LISTINGS_VERSION );

		$vesions = ['3.0.0'];
		foreach ( $vesions as $version ) {
			if ( version_compare( $current_version, $version, '>=' ) ) {
				continue;
			}
			$class = __NAMESPACE__ . '\Ver' . str_replace( '.', '', $version );
			new $class;
		}

		if ( version_compare( $current_version, end( $vesions ), '<' ) ) {
			update_option( 'auto_listings_version', end( $vesions ) );
		}
	}
}
