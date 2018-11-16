<?php
/**
 * Enqueue Admin style and scripts.
 *
 * @package Auto Listings.
 */

namespace AutoListings\Admin;

/**
 * Enqueue class.
 */
class Assets {
	/**
	 * Add hooks when module is loaded.
	 */
	public function __construct() {
		add_action( 'admin_enqueue_scripts', [ $this, 'enqueue' ], 100 );
	}

	/**
	 * Enqueue script.
	 *
	 * @param string $hook name of the page.
	 */
	public function enqueue( $hook ) {
		$css_dir = AUTO_LISTINGS_URL . 'assets/admin/css/';

		if ( 'profile.php' !== $hook && 'user-edit.php' !== $hook && 'auto-listing_page_auto-listings' !== $hook && ! is_auto_listings_admin() ) {
			return;
		}
		if ( 'auto-listing_page_auto-listings' === $hook ) {
			wp_enqueue_style( 'al-admin-extensions', $css_dir . 'extensions.css', '', AUTO_LISTINGS_VERSION );
		}
		wp_enqueue_style( 'al-admin', $css_dir . 'auto-listings.css', '', AUTO_LISTINGS_VERSION );
	}
}

