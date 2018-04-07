<?php
namespace AutoListings\Frontend;

class Main {
	public function __construct() {
		add_action( 'body_class', [ $this, 'body_class' ] );
	}

	/**
	 * Add body classes for our pages.
	 *
	 * @param  array $classes
	 *
	 * @return array
	 */
	public function body_class( $classes ) {
		$classes = (array) $classes;

		if ( is_auto_listings() ) {
			$classes[] = 'auto-listings';
		}

		return array_unique( $classes );
	}
}
