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

		$class  = 'reset' === $atts['type'] ? ' als-reset' : '';
		$output = sprintf( '<button class="als-submit%s" type="submit">%s</button>', esc_html( $class ), esc_html( $atts['label'] ), 'auto-listings' );

		return $output;
	}
}
