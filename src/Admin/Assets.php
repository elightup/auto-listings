<?php
namespace AutoListings\Admin;

class Assets {
	public function __construct() {
		add_action( 'admin_enqueue_scripts', [ $this, 'enqueue' ], 100 );
	}

	public function enqueue( $hook ) {
		$css_dir = AUTO_LISTINGS_URL . 'assets/admin/css/';
		$js_dir  = AUTO_LISTINGS_URL . 'assets/admin/js/';

		// our settings page
		if ( $hook == 'settings_page_auto_listings_options' || ( $hook == 'edit.php' && is_auto_listings_admin() ) ) {
			wp_enqueue_style( 'al-icons', AUTO_LISTINGS_URL . 'assets/css/auto-listings-icons.css', AUTO_LISTINGS_VERSION );
		}

		if ( $hook == 'profile.php' || $hook == 'user-edit.php' || is_auto_listings_admin() ) {
			wp_enqueue_style( 'al-admin', $css_dir . 'auto-listings.css', AUTO_LISTINGS_VERSION );

			/*
			 * Google map scripts
			 */
			$api_url = auto_listings_google_maps_url( '&libraries=places' );
			wp_enqueue_script( 'al-google-maps', $api_url, [], true );
			wp_enqueue_script( 'al-geocomplete', $js_dir . 'jquery.geocomplete.min.js', [ 'al-google-maps' ], AUTO_LISTINGS_VERSION, true );

			if ( get_post_type() == 'auto-listing' ) {

				wp_enqueue_script( 'al-carquery', 'http://www.carqueryapi.com/js/carquery.0.3.4.js', [ 'jquery' ], AUTO_LISTINGS_VERSION, true );
				wp_enqueue_script( 'al-carquery-setup', $js_dir . 'carquery-setup.js', [ 'al-carquery' ], AUTO_LISTINGS_VERSION, true );

			}
			wp_enqueue_script( 'al-admin', $js_dir . 'auto-listings.js', [ 'al-geocomplete' ], AUTO_LISTINGS_VERSION, true );
		}
	}
}

