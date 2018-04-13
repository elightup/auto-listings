<?php
namespace AutoListings\Enquiry;

class Fields {
	public function __construct() {
		add_filter( 'rwmb_meta_boxes', [ $this, 'register_meta_boxes' ] );
	}

	public function register_meta_boxes( $meta_boxes ) {
		$files = glob( __DIR__ . '/fields/*.php' );
		foreach ( $files as $file ) {
			$meta_boxes[] = include $file;
		}

		return $meta_boxes;
	}
}
