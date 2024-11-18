<?php
namespace AutoListings\SearchForm\Shortcode;

class Extras {
	public function __construct() {
		add_shortcode( 'als_total_listings', [ $this, 'render_total' ] );
		add_shortcode( 'als_selected', [ $this, 'render_selected' ] );
		add_shortcode( 'als_toggle_wrapper', [ $this, 'render_toggle_wrapper' ] );
		add_shortcode( 'als_keyword', [ $this, 'render_search_keyword' ] );
	}

	public function render_total() {
		return auto_listings_search_get_vehicle_data()['total'];
	}

	public function render_selected() {
		return '<div class="als-selected"></div>';
	}

	public function render_toggle_wrapper( $atts, $content = null ) {
		$atts = shortcode_atts(
			[
				'label' => __( 'Advanced Search', 'auto-listings' ),
			],
			$atts
		);

		return '<div class="als-toggle-wrapper">' . do_shortcode( $content ) . '</div>';
	}

	public function render_search_keyword( $atts ) {
		$id   = uniqid();
		$atts = shortcode_atts(
			[
				'label'       => __( 'Location', 'auto-listings' ),
				'placeholder' => __( 'Town, city or postcode', 'auto-listings' ),
			],
			$atts
		);

		$label = $atts['label'] ? '<label class="als-field__label" for="' . esc_attr( $id ) . '">' . $atts['label'] . '</label>' : '';

		$output  = '<div class="als-field als-field--keyword ">';
		$output .= sprintf( '%1s<input id="%2s" type="text" name="s" placeholder="%3s" />', $label, esc_attr( $id ), esc_attr( $atts['placeholder'] ) );
		$output .= '</div>';

		return $output;
	}
}
