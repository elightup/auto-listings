<?php
/**
 * Listings search query.
 *
 * @package Auto Listings.
 */

namespace AutoListings;

/**
 * Class SearchQuery.
 */
class SearchQuery {
	/**
	 * Add hooks when module is loaded.
	 */
	public function __construct() {
		add_action( 'pre_get_posts', [ $this, 'pre_get_posts' ] );
	}

	/**
	 * Customize the search query.
	 *
	 * @param WP_Query $query Query object.
	 */
	public function pre_get_posts( \WP_Query $query ) {
		if ( is_admin() || ! $query->is_main_query() || ! $query->is_post_type_archive( 'auto-listing' ) || ! $query->is_search() ) {
			return;
		}

		$meta_query = [];

		$year_query[]         = $this->year_query();
		$make_query[]         = $this->make_query();
		$model_query[]        = $this->model_query();
		$condition_query[]    = $this->condition_query();
		$odometer_query[]     = $this->odometer_query();
		$transmission_query[] = $this->transmission_query();
		$engine_query[]       = $this->engine_query();
		$fuel_type_query[]    = $this->fuel_type_query();
		$model_drive_query[]  = $this->model_drive_query();
		$price_query[]        = $this->price_meta_query();
		$body_type_query      = $this->body_type_query();
		$radius_query[]       = $this->radius_query( $query );

		$query_1 = array_merge( $year_query, $make_query, $model_query, $condition_query, $price_query, $odometer_query, $transmission_query, $engine_query, $fuel_type_query, $model_drive_query );
		$query_1 = apply_filters( 'auto_listings_search_query', $query_1 );

		// If our radius query fails, fall back to keyword searching. Will fail with no map API key.
		$query_2 = $radius_query;
		if ( empty( $radius_query[0] ) || ! $radius_query[0] ) {
			$keyword_query[] = $this->keyword_query( $query );
			$query_2         = $keyword_query;
		}

		if ( empty( $_GET['s'] ) ) {
			$query_1['relation'] = 'AND';
			$meta_query[]        = $query_1;
		}

		if ( ! empty( $_GET['s'] ) ) {
			$query_2['relation']    = 'OR';
			$meta_query[]           = $query_1;

			global $wpdb;
			$title = sanitize_text_field( strtolower( $_GET['s'] ) );
			$ids = $wpdb->get_col( "SELECT ID FROM $wpdb->posts WHERE LOWER(post_title) LIKE '%$title%' AND post_type='auto-listing' AND post_status='publish'" );

			if ( $ids ) {
				$query->set( 'post__in', $ids );
			} else {
				$meta_query[]           = $query_2;
			}

			$meta_query['relation'] = 'AND';
		}


		$query->set( 'meta_query', $meta_query );
		$query->set( 'tax_query', $body_type_query );
		$query->set( 'post_type', 'auto-listing' );
		do_action( 'auto_listings_search_query_all', $query );
	}

	/**
	 * Return a meta query for filtering by year.
	 *
	 * @return array
	 */
	private function year_query() {
		if ( isset( $_GET['the_year'] ) && ! empty( $_GET['the_year'] ) ) {
			$data = array_map( 'sanitize_text_field', wp_unslash( (array) $_GET['the_year'] ) );
			return [
				'key'     => '_al_listing_model_year',
				'value'   => $data,
				'compare' => 'IN',
			];
		}
		return [];
	}

	/**
	 * Return a meta query for filtering by make.
	 *
	 * @return array
	 */
	private function make_query() {
		if ( isset( $_GET['make'] ) && ! empty( $_GET['make'] ) ) {
			$data = array_map( 'sanitize_text_field', wp_unslash( (array) $_GET['make'] ) );
			return [
				'key'     => '_al_listing_make_display',
				'value'   => $data,
				'compare' => 'IN',
			];
		}
		return [];
	}

	/**
	 * Return a meta query for filtering by model.
	 *
	 * @return array
	 */
	private function model_query() {
		if ( isset( $_GET['model'] ) && ! empty( $_GET['model'] ) ) {
			$data = array_map( 'sanitize_text_field', wp_unslash( (array) $_GET['model'] ) );
			return [
				'key'     => '_al_listing_model_name',
				'value'   => $data,
				'compare' => 'IN',
			];
		}
		return [];
	}

	/**
	 * Return a meta query for filtering by condition.
	 *
	 * @return array
	 */
	private function condition_query() {
		if ( isset( $_GET['condition'] ) && ! empty( $_GET['condition'] ) ) {
			$data = array_map( 'sanitize_text_field', wp_unslash( (array) $_GET['condition'] ) );
			return [
				'key'     => '_al_listing_condition',
				'value'   => $data,
				'compare' => 'IN',
			];
		}
		return [];
	}

	/**
	 * Return a meta query for filtering by odometer.
	 *
	 * @return array
	 */
	private function odometer_query() {
		if ( isset( $_GET['odometer'] ) && ! empty( $_GET['odometer'] ) ) {
			$min = 0;
			$max = floatval( $_GET['odometer'] );

			return [
				'key'     => '_al_listing_odometer',
				'value'   => [ $min, $max ],
				'compare' => 'BETWEEN',
				'type'    => 'NUMERIC',
			];
		}
		return [];
	}

	/**
	 * Return a meta query for filtering by transmission.
	 *
	 * @return array
	 */
	private function transmission_query() {
		if ( isset( $_GET['transmission'] ) && ! empty( $_GET['transmission'] ) ) {
			$data = array_map( 'sanitize_text_field', wp_unslash( (array) $_GET['transmission'] ) );
			return [
				'key'     => '_al_listing_model_transmission_type',
				'value'   => $data,
				'compare' => 'IN',
			];
		}
		return [];
	}

	/**
	 * Return a meta query for filtering by engine.
	 *
	 * @return array
	 */
	private function engine_query() {
		if ( isset( $_GET['engine'] ) && ! empty( $_GET['engine'] ) ) {
			$data = array_map( 'sanitize_text_field', wp_unslash( (array) $_GET['engine'] ) );
			return [
				'key'     => '_al_listing_model_engine_type',
				'value'   => $data,
				'compare' => 'IN',
			];
		}
		return [];
	}

	/**
	 * Return a meta query for filtering by fuel type.
	 *
	 * @return array
	 */
	private function model_drive_query() {
		if ( isset( $_GET['model_drive'] ) && ! empty( $_GET['model_drive'] ) ) {
			$data = array_map( 'sanitize_text_field', wp_unslash( (array) $_GET['model_drive'] ) );
			return [
				'key'     => '_al_listing_model_drive',
				'value'   => $data,
				'compare' => 'IN',
			];
		}
		return [];
	}

	/**
	 * Return a meta query for filtering by fuel type.
	 *
	 * @return array
	 */
	private function fuel_type_query() {
		if ( isset( $_GET['fuel_type'] ) && ! empty( $_GET['fuel_type'] ) ) {
			$data = array_map( 'sanitize_text_field', wp_unslash( (array) $_GET['fuel_type'] ) );
			return [
				'key'     => '_al_listing_model_engine_fuel',
				'value'   => $data,
				'compare' => 'IN',
			];
		}
		return [];
	}

	/**
	 * Return a taxonomy query for filtering by body type.
	 *
	 * @return array
	 */
	private function body_type_query() {
		if ( isset( $_GET['body_type'] ) && ! empty( $_GET['body_type'] ) ) {
			$tax_query[] = [
				'taxonomy' => 'body-type',
				'field'    => 'slug',
				'terms'    => array_map( 'sanitize_text_field', wp_unslash( (array) $_GET['body_type'] ) ),
			];
			return $tax_query;
		}
		return null;
	}

	/**
	 * Return a meta query for filtering by price.
	 *
	 * @return array
	 */
	private function price_meta_query() {
		if ( empty( $_GET['max_price'] ) && empty( $_GET['min_price'] ) ) {
			return [];
		}
		if ( ! empty( $_GET['max_price'] ) && empty( $_GET['min_price'] ) ) {
			$value   = floatval( $_GET['max_price'] );
			$compare = '<=';
		} elseif ( empty( $_GET['max_price'] ) && ! empty( $_GET['min_price'] ) ) {
			$value   = floatval( $_GET['min_price'] );
			$compare = '>=';
		} else {
			$min     = floatval( $_GET['min_price'] );
			$max     = floatval( $_GET['max_price'] );
			$value   = [ $min, $max ];
			$compare = 'BETWEEN';
		}
		return [
			'key'          => '_al_listing_price',
			'value'        => $value,
			'compare'      => $compare,
			'type'         => 'DECIMAL',
			'price_filter' => true,
		];

	}

	/**
	 * Return a meta query for filtering by location.
	 *
	 * @param WP_Query $query Query object.
	 */
	public function radius_query( \WP_Query $query ) {
		if ( empty( $_GET['s'] ) ) {
			return false;
		}
		$search_term = isset( $query->query_vars['s'] ) ? sanitize_text_field( $query->query_vars['s'] ) : '';

		if ( ! $search_term ) {
			return false;
		}

		// We have to remove the "s" parameter from the query, because it will prevent the posts from being found.
		$query->query_vars['s'] = '';

		$search_radius = $this->geocode( $search_term );

		if ( ! $search_radius ) {
			return false;
		}

		$lat = $search_radius['lat']; // get the lat of the requested address.
		$lng = $search_radius['lng']; // get the lng of the requested address.

		// we'll want everything within, say, 30km distance.
		$distance = isset( $_GET['within'] ) && ! empty( $_GET['within'] ) ? floatval( $_GET['within'] ) : 50;

		// earth's radius in km = ~6371.
		$radius = auto_listings_metric() === 'yes' ? 6371 : 3950;

		// latitude boundaries.
		$maxlat = $lat + rad2deg( $distance / $radius );
		$minlat = $lat - rad2deg( $distance / $radius );

		// longitude boundaries (longitude gets smaller when latitude increases).
		$maxlng = $lng + rad2deg( $distance / $radius / cos( deg2rad( $lat ) ) );
		$minlng = $lng - rad2deg( $distance / $radius / cos( deg2rad( $lat ) ) );

		// build the meta query array.
		$radius_array = [
			'relation' => 'AND',
		];

		$radius_array[] = [
			'key'     => '_al_listing_lat',
			'value'   => [ $minlat, $maxlat ],
			'type'    => 'DECIMAL(10,5)',
			'compare' => 'BETWEEN',
		];
		$radius_array[] = [
			'key'     => '_al_listing_lng',
			'value'   => [ $minlng, $maxlng ],
			'type'    => 'DECIMAL(10,5)',
			'compare' => 'BETWEEN',
		];

		return apply_filters( 'auto_listings_search_radius_args', $radius_array );
	}

	/**
	 * Function to geocode address, it will return false if unable to geocode address.
	 *
	 * @param string $address Listing address.
	 */
	private function geocode( $address ) {
		if ( empty( $address ) ) {
			return false;
		}
		// url encode the address.
		$address = urlencode( esc_html( $address ) );

		// google map geocode api url.
		$url = auto_listings_google_geocode_maps_url( $address );

		$arr_context_options = [
			'ssl' => [
				'verify_peer'      => false,
				'verify_peer_name' => false,
			],
		];

		// get the json response.
		$resp_json = file_get_contents( $url, false, stream_context_create( $arr_context_options ) );

		// decode the json.
		$resp = json_decode( $resp_json, true );

		// response status will be 'OK', if able to geocode given address.
		if ( 'OK' !== $resp['status'] ) {
			return false;
		}

		// get the lat and lng.
		$lat = $resp['results'][0]['geometry']['location']['lat'];
		$lng = $resp['results'][0]['geometry']['location']['lng'];

		// verify if data is complete.
		if ( ! $lat || ! $lng ) {
			return false;
		}

		return [
			'lat' => $lat,
			'lng' => $lng,
		];
	}


	/**
	 * Searches listing through keyword
	 *
	 * @param WP_Query $q Query object.
	 */
	private function keyword_query( $q ) {
		if ( empty( $_GET['s'] ) ) {
			return [];
		}

		$custom_fields = apply_filters(
			'auto_listings_keyword_search_fields',
			[
				// put all the meta fields you want to search for here.
				'_al_listing_city',
				'_al_listing_zip',
				'_al_listing_state',
				'_al_listing_route',
				'_al_listing_displayed_address',
			]
		);

		$searchterm = sanitize_text_field( $_GET['s'] );

		// we have to remove the "s" parameter from the query, because it will prevent the posts from being found.
		$q->query_vars['s'] = '';

		if ( ! $searchterm ) {
			return [];
		}

		$meta_query = [ 'relation' => 'OR' ];
		foreach ( $custom_fields as $cf ) {
			array_push(
				$meta_query,
				[
					'key'     => $cf,
					'value'   => $searchterm,
					'compare' => 'LIKE',
				]
			);
		}
		return $meta_query;
	}
}
