<?php
namespace AutoListings\Widgets;

class Features extends \WP_Widget {

	public function __construct() {
		parent::__construct( 'auto-listings-features', esc_html__( '[Auto Listings] Features', 'auto-listings' ), [
			'classname' => 'auto-listings-features',
			'description' => esc_html__( 'Display listing features', 'auto-listings' ),
		] );
	}

	public function widget( $args, $instance ) {
		auto_listings_template_single_at_a_glance();
	}
}
