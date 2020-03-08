<?php
namespace AutoListings\Frontend;

class Main {
	public function __construct() {
		add_action( 'body_class', [ $this, 'add_body_class' ] );
		add_action( 'wp_head', [ $this, 'add_head_comment' ] );
	}

	public function add_body_class( $classes ) {
		if ( is_auto_listings() ) {
			$classes[] = 'auto-listings';
		}
		return $classes;
	}

	public function add_head_comment() {
		echo "\n<!-- This site is using Auto Listings plugin - https://wpautolistings.com/ -->\n";
	}
}
