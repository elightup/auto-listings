<?php
namespace AutoListings\Admin;

class Assets {
	public function __construct() {
		add_action( 'admin_enqueue_scripts', [ $this, 'enqueue' ], 100 );
	}

	public function enqueue( $hook ) {
		$css_dir = AUTO_LISTINGS_URL . 'assets/admin/css/';

		if ( $hook !== 'profile.php' && $hook !== 'user-edit.php' && ! is_auto_listings_admin() ) {
			return;
		}

		wp_enqueue_style( 'al-admin', $css_dir . 'auto-listings.css', AUTO_LISTINGS_VERSION );
	}
}

