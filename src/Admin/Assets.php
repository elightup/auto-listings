<?php
namespace AutoListings\Admin;

class Assets {
	public function __construct() {
		add_action( 'admin_enqueue_scripts', [ $this, 'enqueue' ], 100 );
	}

	public function enqueue( $hook ) {
		$css_dir = AUTO_LISTINGS_URL . 'assets/admin/css/';
		$js_dir  = AUTO_LISTINGS_URL . 'assets/admin/js/';

		if ( $hook !== 'profile.php' && $hook !== 'user-edit.php' && ! is_auto_listings_admin() ) {
			return;
		}

		wp_enqueue_style( 'al-admin', $css_dir . 'auto-listings.css', AUTO_LISTINGS_VERSION );

		if ( get_post_type() !== 'auto-listing' ) {
			return;
		}
		wp_enqueue_script( 'carquery', 'http://www.carqueryapi.com/js/carquery.0.3.4.js', [ 'jquery' ], '0.3.4', true );
		wp_enqueue_script( 'al-carquery', $js_dir . 'carquery.js', [ 'carquery' ], AUTO_LISTINGS_VERSION, true );
		wp_localize_script( 'al-carquery', 'AlCarQuery', [
			'errorNoSelected' => __( 'Please select a year, make and model.', 'auto-listings' ),
			'errorNoData'     => __( 'Cannot retrieve data. Please try again later.', 'auto-listings' ),
		] );
	}
}

