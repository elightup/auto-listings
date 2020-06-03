<?php
namespace AutoListings\SearchForm\Shortcode;

class Extras {
	public function __construct() {
		add_shortcode( 'als_total_listings', array( $this, 'render_total' ) );
		add_shortcode( 'als_selected', array( $this, 'render_selected' ) );
	}

	public function render_total() {
		return auto_listings_available_listings() ? auto_listings_available_listings() : '';
	}

	public function render_selected() {
		return '<div class="als-selected"></div>';
	}
}
