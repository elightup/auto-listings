<?php
namespace AutoListings\Listing;

class Fields {
	public function __construct() {
		add_filter( 'rwmb_meta_boxes', [ $this, 'register_meta_boxes' ] );
		add_filter( 'gmap_api_params', [ $this, 'geolocation_params' ] );
	}

	public function register_meta_boxes( $meta_boxes ) {
		$files = glob( __DIR__ . '/fields/*.php' );
		foreach ( $files as $file ) {
			$meta_boxes[] = include $file;
		}

		return $meta_boxes;
	}

	public function geolocation_params( $params ) {
		$params['key'] = auto_listings_option( 'maps_api_key' );
		return $params;
	}
}
