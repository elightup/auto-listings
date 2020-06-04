<?php
namespace AutoListings\SearchForm\Shortcode;

class Extras {
	public function __construct() {
		add_shortcode( 'als_total_listings', array( $this, 'render_total' ) );
		add_shortcode( 'als_selected', array( $this, 'render_selected' ) );
		add_shortcode( 'als_toggle_wrapper', array( $this, 'render_toggle_wrapper' ) );
	}

	public function render_total() {
		return auto_listings_available_listings() ? auto_listings_available_listings() : '';
	}

	public function render_selected() {
		return '<div class="als-selected"></div>';
	}

	public function render_toggle_wrapper( $atts, $content = null ) {
		$atts = shortcode_atts(
			array(
				'toggle_button_label' => __( 'Advance Search', 'auto-listings' ),
			),
			$atts
		);

		return '<a class="als-toggle-btn">' . $atts['toggle_button_label'] . '</a><div class="als-toggle-wrapper">' . do_shortcode( $content ) . '</div>';
	}
}
