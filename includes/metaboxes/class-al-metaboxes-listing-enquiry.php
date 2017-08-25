<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists( 'Auto_Listings_Metaboxes_Listing_Enquiry' ) ) :


/**
 * CMB2 Theme Options
 * @version 0.1.0
 */
class Auto_Listings_Metaboxes_Listing_Enquiry {

	/**
	 * Post type
	 * @var string
	 */
	public $type = 'listing-enquiry';

	/**
	 * Metabox prefix
	 * @var string
	 */
	public $pre = '_al_enquiry_';

	public $enquiry_label = '';

	/**
	 * Holds an instance of the object
	 *
	 * @var Myprefix_Admin
	 **/
	public static $instance = null;

	public function __construct() {
		$this->enquiry_label = __( 'Enquiry', 'auto-listings' );
	}

	/**
	 * Returns the running object
	 *
	 * @return Myprefix_Admin
	 **/
	public static function get_instance() {
		if( is_null( self::$instance ) ) {
			self::$instance = new self();
			
			self::$instance->settings();
		}
		return self::$instance;
	}

/* ======================================================================================
										Listing Settings
   ====================================================================================== */
	public function settings() {

		$box = new_cmb2_box( array(
			'id'            => $this->pre . 'settings',
			'title'         => '<span class="dashicons dashicons-admin-settings"></span> ' . sprintf( __( "%s Settings", 'auto-listings' ), $this->enquiry_label ),
			'object_types'  => array( $this->type ), 
			'context'       => 'side',
		) );

		$fields = array();

		$fields[10] = array(
	        'name'          => __( '', 'auto-listings' ),
	        'desc'    		=> '',
	        'id'            => '',
	        'type'          => 'title',
	        'after_row'    	=> 'auto_listings_admin_listing_status_area',
	    );

	    // filter the fields
        $fields = apply_filters( 'auto_listings_enquiry_metabox_settings', $fields );

        // sort numerically
        ksort( $fields );

        // loop through ordered fields and add them to the metabox
        if( $fields ) {
        	foreach ($fields as $key => $value) {
        		$fields[$key] = $box->add_field( $value );
        	}
        }

	}


}

endif;
