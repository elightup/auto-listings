<?php
namespace AutoListings\SearchForm\Shortcode;

class Total {
	public function __construct() {
		add_shortcode( 'als_total_listings', array( $this, 'render' ) );
	}

	public function render() {
		return auto_listings_available_listings() ? auto_listings_available_listings() : '';
	}
}
