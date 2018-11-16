<?php
/**
 * Add class to admin body.
 *
 * @package Auto Listings.
 */

namespace AutoListings\Admin;

/**
 * Main class.
 */
class Main {
	/**
	 * Add hooks when module is loaded.
	 */
	public function __construct() {
		add_filter( 'admin_body_class', [ $this, 'admin_body_class' ] );
	}

	/**
	 * Add class to admin body.
	 *
	 * @param string $classes admin body classes.
	 */
	public function admin_body_class( $classes ) {
		if ( is_auto_listings_admin() ) {
			$classes .= ' auto-listings';
		}
		return $classes;
	}
}
