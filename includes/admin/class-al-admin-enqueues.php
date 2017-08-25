<?php

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) )
	exit;

/**
 * Enqueues the required admin scripts.
 *
 */
function auto_listings_load_admin_scripts( $hook ) {
	
	$css_dir = AUTOLISTINGS_PLUGIN_URL . 'includes/admin/assets/css/';
	$js_dir  = AUTOLISTINGS_PLUGIN_URL . 'includes/admin/assets/js/';
	
	// our settings page
	if ( $hook == 'settings_page_auto_listings_options' || ( $hook == 'edit.php' && is_auto_listings_admin() ) ) {
		wp_enqueue_style( 'al-icons', AUTOLISTINGS_PLUGIN_URL . 'assets/css/auto-listings-icons.css', AUTOLISTINGS_VERSION );
	}

	if ( $hook == 'profile.php' || $hook == 'user-edit.php' || is_auto_listings_admin() ) {
		wp_enqueue_style( 'al-admin', $css_dir . 'auto-listings.css', AUTOLISTINGS_VERSION );


		/*	
		 * Google map scripts
		 */
		$api_url = auto_listings_google_maps_url( '&libraries=places' );
		wp_enqueue_script( 'al-google-maps', $api_url, array(), true );
		wp_enqueue_script( 'al-geocomplete', $js_dir . 'jquery.geocomplete.min.js', array( 'al-google-maps' ), AUTOLISTINGS_VERSION, true );

		if( get_post_type() == 'auto-listing' ) { 

			wp_enqueue_script( 'al-carquery', 'http://www.carqueryapi.com/js/carquery.0.3.4.js', array('jquery'), AUTOLISTINGS_VERSION, true );
			wp_enqueue_script( 'al-carquery-setup', $js_dir . 'carquery-setup.js', array('al-carquery'), AUTOLISTINGS_VERSION, true );

		}
		wp_enqueue_script( 'al-admin', $js_dir . 'auto-listings.js', array( 'al-geocomplete' ), AUTOLISTINGS_VERSION, true );
		
	}
	
}
add_action( 'admin_enqueue_scripts', 'auto_listings_load_admin_scripts', 100 );
