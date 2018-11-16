<?php
/**
 * Register meta boxes for single Enquiry.
 *
 * @package Auto Listings.
 */

namespace AutoListings\Enquiry;

/**
 * Class Enquiry Fields.
 */
class Fields {
	/**
	 * Add hooks when module is loaded.
	 */
	public function __construct() {
		add_filter( 'rwmb_meta_boxes', [ $this, 'register_meta_boxes' ] );
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
}
