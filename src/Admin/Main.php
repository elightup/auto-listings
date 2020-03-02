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
		add_filter( 'ajax_query_attachments_args', [ $this, 'restrict_media_library' ], 999 );
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

	/**
	 * Restrict Media Library for all user except administrator
	 */
	public function restrict_media_library( $query ) {
	    $current_user = wp_get_current_user();
	    if ( ! $current_user || empty( $current_user->roles ) ) {
	    	return $query;
	    }
	    $roles = $current_user->roles;
	    if ( in_array( 'auto_listings_seller', $roles ) || in_array( 'auto_listings_dealer', $roles ) ) {
	        $query['author'] = $current_user->ID;
	    }
	    return $query;
	}
}
