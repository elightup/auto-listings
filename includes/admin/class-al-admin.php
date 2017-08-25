<?php
/**
 * Auto_Listings Admin
 *
 * @class    Auto_Listings_Admin
 * @author   Auto_Listings
 * @category Admin
 * @package  Auto_Listings/Admin
 * @version  1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Auto_Listings_Admin class.
 */
class Auto_Listings_Admin {

	/**
	 * Constructor.
	 */
	public function __construct() {
		add_action( 'init', array( $this, 'includes' ) );
		add_filter( 'admin_body_class', array( $this, 'admin_body_class' ) );
	}

	/**
	 * Include any classes we need within admin.
	 */
	public function includes() {

		// option pages
		include_once( 'class-al-admin-options.php' );

		include_once( 'class-al-admin-enqueues.php' );
		include_once( 'class-al-admin-listing-menu.php' );
		include_once( 'class-al-admin-listing-columns.php' );
		include_once( 'class-al-admin-enquiry-columns.php' );
		include_once( 'class-al-admin-seller-columns.php' );
	}


	/**
	 * Adds one or more classes to the body tag in the dashboard.
	 *
	 * @param  String $classes Current body classes.
	 * @return String          Altered body classes.
	 */
	public function admin_body_class( $classes ) {
		
		if ( is_auto_listings_admin() ) {
			return "$classes auto-listings";
		}

	}



}

return new Auto_Listings_Admin();