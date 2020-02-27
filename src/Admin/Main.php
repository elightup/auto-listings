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
	    $user_id = get_current_user_id();
	    if ( $user_id && ! current_user_can( 'administrator' ) ) {
	        $query['author'] = $user_id;
	    }
	    return $query;
	}
}
