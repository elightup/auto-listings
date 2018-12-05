<?php
/**
 * Add class to body class.
 *
 * @package Auto Listings.
 */

namespace AutoListings\Frontend;

/**
 * Class Main
 */
class Main {

	/**
	 * Add hooks when module is loaded.
	 */
	public function __construct() {
		add_action( 'body_class', [ $this, 'body_class' ] );
		add_action( 'wp_head', [ $this, 'head_comment' ] );
	}

	/**
	 * Add body classes for our pages.
	 *
	 * @param  array $classes body class.
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

	/**
	 * Add comment to <head> tag
	 */
	public function head_comment() {
		echo '<!-- This site is using Auto Listings plugin - https://wpautolistings.com/ -->';
	}

}
