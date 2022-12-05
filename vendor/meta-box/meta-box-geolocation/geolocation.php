<?php
class MB_Geolocation {
	public $is_google_maps_enqueued;

	/**
	 * Contains data to set to [data-geo="JSON"]
	 *
	 * @var array|string
	 */
	public $data_geo;

	public function __construct() {
		add_action( 'rwmb_enqueue_scripts', array( $this, 'enqueue' ) );
		add_filter( 'rwmb_google_maps_url', array( $this, 'google_maps_url' ) );

		add_action( 'rwmb_before', array( $this, 'output_geo_data' ) );
		add_action( 'rwmb_after', array( $this, 'reset_geo_data' ) );
		add_filter( 'rwmb_wrapper_html', array( $this, 'insert_field_geo_binding' ), 10, 2 );
	}

	/**
	 * Enqueue Geo Location JS and allows users set custom query string for Gmap API URL.
	 *
	 * @param RW_Meta_Box $meta_box Meta Box object.
	 */
	public function enqueue( $meta_box ) {
		if ( ! $meta_box->geo ) {
			return;
		}
		$dependencies = [ 'jquery', 'underscore' ];
		if ( isset( $meta_box->geo['api_key'] ) || $this->has_google_maps( $meta_box->meta_box ) ) {
			$this->register_google_maps_scripts( $meta_box->geo );
			$dependencies[] = 'google-maps';
		}
		list( , $url ) = RWMB_Loader::get_path( __DIR__ );
		wp_enqueue_script( 'mb-geolocation', $url . 'geolocation.js', $dependencies, filemtime( __DIR__ . '/geolocation.js' ), true );
	}

	public function register_google_maps_scripts( $geo ) {
		if ( $this->is_google_maps_enqueued ) {
			return;
		}
		$params = array( 'libraries' => 'places' );
		if ( isset( $geo['api_key'] ) ) {
			$params['key'] = $geo['api_key'];
		}
		$google_maps_url = add_query_arg(
			$params,
			'https://maps.googleapis.com/maps/api/js'
		);
		/**
		 * Allows developers load more libraries via a filter.
		 * Use the same filter as 'map' field.
		 * @link https://developers.google.com/maps/documentation/javascript/libraries
		 */
		$google_maps_url = apply_filters( 'rwmb_google_maps_url', $google_maps_url );

		wp_register_script( 'google-maps', esc_url_raw( $google_maps_url ), array(), '', true );
	}

	public function google_maps_url( $url ) {
		$this->is_google_maps_enqueued = true;
		return add_query_arg( 'libraries', 'places', $url );
	}

	/**
	 * Output [data-geo] element which stores geo configuration for current Meta Box
	 *
	 * @param RW_Meta_Box $meta_box Meta Box object.
	 */
	public function output_geo_data( $meta_box ) {
		if ( ! $meta_box->geo ) {
			return;
		}
		$this->data_geo = $meta_box->geo;
		if ( ! is_array( $this->data_geo ) ) {
			$this->data_geo = array();
		}
		if ( empty( $this->data_geo['types'] ) ) {
			$this->data_geo['types'] = array();
		}
		echo '<script type="html/template" class="data-geo" data-geo="' . esc_attr( wp_json_encode( $this->data_geo ) ) .
			'"></script>';
	}

	public function reset_geo_data() {
		$this->data_geo = null;
	}

	/**
	 * Create div[data-binding] element which stores which address component to bind to current field
	 *
	 * @param string $begin Field begin HTML.
	 * @param array  $field  Field settings.
	 * @return string
	 */
	public function insert_field_geo_binding( $begin, $field ) {
		// Don't add binding data if geolocation is not enabled and if field is a map fields.
		if ( ! $this->data_geo || in_array( $field['type'], [ 'osm', 'map' ], true ) ) {
			return $begin;
		}
		$binding       = isset( $field['binding'] ) ? $field['binding'] : $this->guess_binding_field( $field['id'] );
		$bind_if_empty = isset( $field['bind_if_empty'] ) ? $field['bind_if_empty'] : 1;
		$address_field = isset( $field['address_field'] ) ? $field['address_field'] : '';

		if ( $binding ) {
			$begin .= '<script type="html/template" class="rwmb-geo-binding" data-binding="' . esc_attr( $binding )
			. '" data-bind_if_empty="' . esc_attr( $bind_if_empty )
			. '" data-address_field="' . esc_attr( $address_field ) . '"></script>';
		}

		return $begin;
	}

	private function guess_binding_field( $field_id ) {
		$available_fields = array(
			// Google Maps.
			'street_address',
			'route',
			'intersection',
			'political',
			'country',
			'administrative_area_level_1',
			'administrative_area_level_2',
			'administrative_area_level_3',
			'colloquial_area',
			'locality',
			'sublocality',
			'neighborhood',
			'premise',
			'subpremise',
			'postal_code',
			'natural_feature',
			'airport',
			'park',
			'point_of_interest',
			'post_box',
			'street_number',
			'floor',
			'room',
			'lat',
			'lng',
			'viewport',
			'location',
			'formatted_address',
			'location_type',
			'bounds',
			'id',
			'name',
			'place_id',
			'reference',
			'url',
			'vicinity',
			'geometry',
			'website',
			'formatted_phone_number',
			'international_phone_number',
			'opening_hours',
			'rating',
			'user_ratings_total',

			// OSM.
			'building',
			'house_number',
			'aeroway',
			'road',
			'neighbourhood',
			'suburb',
			'village',
			'town',
			'city',
			'county',
			'state',
			'postcode',
			'country',
			'country_code',
		);

		foreach ( $available_fields as $available_field ) {
			if ( $field_id === $available_field . '_short' ) {
				return 'short:' . $available_field;
			}
			if ( $field_id === $available_field ) {
				return $field_id;
			}
		}

		return null;
	}

	/**
	 * Check if a meta box as a Google map field type.
	 *
	 * @param array $settings The meta box or field settings array.
	 * @return bool
	 */
	private function has_google_maps( $settings ) {
		foreach ( $settings['fields'] as $field ) {
			if ( $field['type'] === 'map' ) {
				return true;
			}

			// Recursively check groups.
			if ( isset( $field['fields'] ) && $this->has_google_maps( $field ) ) {
				return true;
			}
		}

		return false;
	}
}
