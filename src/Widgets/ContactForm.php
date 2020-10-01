<?php
namespace AutoListings\Widgets;

class ContactForm extends \WP_Widget {

	public function __construct() {
		parent::__construct( 'auto-listings-contact-form', esc_html__( '[Auto Listings] Contact Form', 'auto-listings' ), [
			'classname' => 'auto-listings-contact-form',
			'description' => esc_html__( 'Display contact form', 'auto-listings' ),
		] );
	}

	public function widget( $args, $instance ) {
		auto_listings_template_single_contact_form();
	}
}
