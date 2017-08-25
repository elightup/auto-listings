<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists( 'Auto_Listings_Admin_Metaboxes' ) ) :

/**
 * CMB2 Theme Options
 * @version 0.1.0
 */
class Auto_Listings_Admin_Metaboxes {

	/**
	 * Constructor
	 * @since 0.1.0
	 */
	public function __construct() {
		add_action( 'cmb2_admin_init', array( $this, 'register_metaboxes' ) );
	}

	/**
	 * Add the options metabox to the array of metaboxes
	 * @since  0.1.0
	 */
	public function register_metaboxes() {
		
		/**
		 * Load the metaboxes for listing post type
		 */
		$listing_metaboxes = new Auto_Listings_Metaboxes_Listings();
		$listing_metaboxes->get_instance();
		
		/**
		 * Load the metaboxes for listing enquiry post type
		 */
		$enquiry_metaboxes = new Auto_Listings_Metaboxes_Listing_Enquiry();
		$enquiry_metaboxes->get_instance();

	}

}

new Auto_Listings_Admin_Metaboxes();

endif;