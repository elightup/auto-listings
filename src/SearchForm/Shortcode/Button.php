<?php
namespace AutoListings\SearchForm\Shortcode;

class Button {
	public function __construct() {
		add_shortcode( 'als_button', array( $this, 'render' ) );
	}

	public function render( $atts ) {
		$atts = shortcode_atts(
			array(
				'type'  => 'submit',
				'label' => __( 'Submit', 'auto-listings' ),
			),
			$atts
		);

		$type   = $atts['type'] === 'submit' ? 'submit' : 'button';
		$output = sprintf( '<button class="als-%s" type="%s">%s</button>', esc_attr( $atts['type'] ), $type, esc_html( $atts['label'] ), 'auto-listings' );

		return $output;
	}
}
