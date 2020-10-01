<?php
namespace AutoListings\Widgets;

class Location extends \WP_Widget {

	public function __construct() {
		parent::__construct( 'auto-listings-location', esc_html__( '[Auto Listings] Location', 'auto-listings' ), [
			'classname' => 'auto-listings-location',
			'description' => esc_html__( 'Display listing location', 'auto-listings' ),
		] );
	}

	public function widget( $args, $instance ) {
		auto_listings_template_single_address();
		auto_listings_template_single_map();
	}
}
