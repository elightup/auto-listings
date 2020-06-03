<?php
namespace AutoListings\SearchForm\Shortcode;

class Extras {
	public function __construct() {
		add_shortcode( 'als_total_listings', array( $this, 'render_total' ) );
		add_shortcode( 'als_selected', array( $this, 'render_selected' ) );
		add_shortcode( 'als_toggle_wrapper', array( $this, 'render_toggle_wrapper' ) );
		add_shortcode( 'als_refine', array( $this, 'render_refine_button' ) );
	}

	public function render_total() {
		return auto_listings_available_listings() ? auto_listings_available_listings() : '';
	}

	public function render_selected() {
		return '<div class="als-selected"></div>';
	}

	public function render_toggle_wrapper( $atts, $content = null ) {
		return '<div class="als-toggle-wrapper">' . $content . '</div>';
	}

	public function render_refine_button( $atts, $content = null ) {
		return '<a class="refine">' . $content . '</a>';
	}
}
