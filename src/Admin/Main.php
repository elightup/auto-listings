<?php
namespace AutoListings\Admin;

class Main {
	public function __construct() {
		add_filter( 'admin_body_class', [ $this, 'admin_body_class' ] );
	}

	public function admin_body_class( $classes ) {
		if ( is_auto_listings_admin() ) {
			$classes .= ' auto-listings';
		}
		return $classes;
	}
}
