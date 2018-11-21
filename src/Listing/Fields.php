<?php
/**
 * Register meta boxes for single Listing.
 *
 * @package Auto Listings.
 */

namespace AutoListings\Listing;

/**
 * Class Listing Fields.
 */
class Fields {
	/**
	 * Add hooks when module is loaded.
	 */
	public function __construct() {
		add_filter( 'rwmb_meta_boxes', [ $this, 'register_meta_boxes' ] );
		add_action( 'rwmb_enqueue_scripts', [ $this, 'enqueue' ] );
	}

	/**
	 * Register meta boxes.
	 *
	 * @param array $meta_boxes Meta Box array.
	 */
	public function register_meta_boxes( $meta_boxes ) {
		$files = glob( __DIR__ . '/fields/*.php' );
		foreach ( $files as $file ) {
			$meta_boxes[] = include $file;
		}

		return $meta_boxes;
	}

	/**
	 * Enqueue script.
	 *
	 * @param Object $meta_box Meta Box object.
	 */
	public function enqueue( $meta_box ) {
		if ( ! $this->is_screen() || '_al_listing_select' !== $meta_box->id ) {
			return;
		}

		$css_dir = AUTO_LISTINGS_URL . 'assets/admin/css/';
		$js_dir  = AUTO_LISTINGS_URL . 'assets/admin/js/';

		wp_enqueue_script( 'carquery', 'https://www.carqueryapi.com/js/carquery.0.3.4.js', [ 'jquery' ], '0.3.4', true );
		wp_enqueue_script( 'al-carquery', $js_dir . 'carquery.js', [ 'carquery' ], AUTO_LISTINGS_VERSION, true );
		wp_localize_script(
			'al-carquery',
			'AlCarQuery',
			[
				'errorNoSelected' => __( 'Please select a year, make and model.', 'auto-listings' ),
				'errorNoData'     => __( 'Cannot retrieve data. Please try again later.', 'auto-listings' ),
			]
		);
	}

	/**
	 * Return if current screen is auto listing page in admin.
	 */
	public function is_screen() {
		if ( ! is_admin() ) {
			return true;
		}
		return 'auto-listing' === get_current_screen()->post_type;
	}
}
