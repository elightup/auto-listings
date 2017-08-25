<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;


class Auto_Listings_Search_Query {
	
	/**
	 * Get things going
	 *
	 */
	public function __construct() {
		add_action( 'pre_get_posts', array( $this, 'pre_get_posts' ), 999 );
	}

	/**
	 * Build a custom query based on several conditions
	 * The pre_get_posts action gives developers access to the $query object by reference
	 * any changes you make to $query are made directly to the original object - no return value is requested
	 *
	 * @link https://codex.wordpress.org/Plugin_API/Action_Reference/pre_get_posts
	 *
	 */
	public function pre_get_posts( $q ) {
		
		// check if the user is requesting an admin page 
		if ( is_admin() || ! $q->is_main_query() )
			return;

		if ( ! is_post_type_archive( 'auto-listing' ) )
			return;

		if ( ! is_search() )
			return;

		$meta_query = array();

		$year_query[] 		= $this->year_query();
		$make_query[] 		= $this->make_query();
		$model_query[] 		= $this->model_query();
		$condition_query[] 	= $this->condition_query();
		$odometer_query[] 	= $this->odometer_query();
		$price_query[] 		= $this->price_meta_query();
		$body_type_query 	= $this->body_type_query();
		$radius_query[] 	= $this->radius_query( $q );

		$query_1 = array_merge( $year_query, $make_query, $model_query, $condition_query, $price_query, $odometer_query );

		// if our rasius query fails, fall back to keyword searching
		// will fail with no map API key
		if( empty( $radius_query[0] ) || ! $radius_query[0] ) {
			$keyword_query[] = $this->keyword_query( $q );
			$query_2 = $keyword_query;
		} else {
			$query_2 = $radius_query;
		}

		// if no keyword
		if ( empty( $_GET['s'] ) ) {
			$query_1['relation'] = 'AND';
			$meta_query[] = $query_1;
		}

		// if keyword
		if ( ! empty( $_GET['s'] ) ) {
			$query_2['relation'] = 'OR';
			$meta_query[] = $query_1;
			$meta_query[] = $query_2;
			$meta_query['relation'] = 'AND';
		}

		$q->set( 'meta_query', $meta_query );

		$q->set( 'tax_query', $body_type_query ); 

		$q->set( 'post_type', 'auto-listing' ); 
	}

	/**
	 * Return a meta query for filtering by year.
	 * @return array
	 */
	private function year_query() {
		if ( isset( $_GET['the_year'] ) && ! empty( $_GET['the_year'] ) ) {
			$data = array_map( 'sanitize_text_field', wp_unslash( $_GET['the_year'] ) );
			return array(
				'key' 		=> '_al_listing_model_year', 
				'value' 	=> $data, 
				'compare' 	=> 'IN',
				//'type'      => 'NUMERIC',
			);
		}
		return array();
	}
	/**
	 * Return a meta query for filtering by make.
	 * @return array
	 */
	private function make_query() {
		if ( isset( $_GET['make'] ) && ! empty( $_GET['make'] ) ) {
			$data = array_map( 'sanitize_text_field', wp_unslash( $_GET['make'] ) );
			return array(
				'key' 		=> '_al_listing_make_display', 
				'value' 	=> $data, 
				'compare' 	=> 'IN'
			);
		}
		return array();
	}
	/**
	 * Return a meta query for filtering by model.
	 * @return array
	 */
	private function model_query() {
		if ( isset( $_GET['model'] ) && ! empty( $_GET['model'] ) ) {
			$data = array_map( 'sanitize_text_field', wp_unslash( $_GET['model'] ) );
			return array(
				'key' 		=> '_al_listing_model_name', 
				'value' 	=> $data, 
				'compare' 	=> 'IN'
			);
		}
		return array();
	}
	/**
	 * Return a meta query for filtering by condition.
	 * @return array
	 */
	private function condition_query() {
		if ( isset( $_GET['condition'] ) && ! empty( $_GET['condition'] ) ) {
			return array(
				'key' 		=> '_al_listing_condition', 
				'value' 	=> sanitize_text_field( $_GET['condition'] ), 
				'compare' 	=> 'IN'
			);
		}
		return array();
	}

	/**
	 * Return a meta query for filtering by odometer.
	 * @return array
	 */
	private function odometer_query() {
		if ( isset( $_GET['odometer'] ) && ! empty( $_GET['odometer'] ) ) {
			
			$min = 0;
			$max = floatval( $_GET['odometer'] );

			return array(
				'key' 			=> '_al_listing_odometer', 
				'value'     	=> array( $min, $max ),
				'compare'      	=> 'BETWEEN',
				'type'         	=> 'NUMERIC',
			);
		}
		return array();
	}

	/**
	 * Return a taxonomy query for filtering by body type.
	 * @return array
	 */
	private function body_type_query() {
		if ( isset( $_GET['body_type'] ) && ! empty( $_GET['body_type'] ) ) {
			$tax_query[] = array(
                'taxonomy' => 'body-type',
                'field'    => 'slug',
                'terms'    =>  sanitize_text_field( $_GET['body_type'] ),
            );
			return $tax_query;
		}
		return null;
	}

	/**
	 * Return a meta query for filtering by price.
	 * @return array
	 */
	private function price_meta_query() {
		if ( isset( $_GET['max_price'] ) && ! empty( $_GET['max_price'] ) || isset( $_GET['min_price'] ) && ! empty( $_GET['min_price'] ) ) {
			$min = floatval( $_GET['min_price'] );
			$max = floatval( $_GET['max_price'] );

			return array(
				'key'          => '_al_listing_price',
				'value'        => array( $min, $max ),
				'compare'      => 'BETWEEN',
				'type'         => 'DECIMAL',
				'price_filter' => true,
			);
		}
		return array();
	}

	/**
	 * Run the radius query
	 *
	 * @access public
	 * @return array
	 */
	public function radius_query( $q ) {
		
		if ( isset( $_GET['s'] ) && ! empty( $_GET['s'] ) ) {

			$searchterm = isset( $q->query_vars['s'] ) ? sanitize_text_field( $q->query_vars['s'] ) : '';

		    // we have to remove the "s" parameter from the query, because it will prevent the posts from being found
		    $q->query_vars['s'] = '';

		    if ( $searchterm != '' ) {

				$search_radius = $this->geocode( $searchterm );

				if( ! $search_radius )
					return false;

				$lat = $search_radius['lat']; // get the lat of the requested address
				$lng = $search_radius['lng']; // get the lng of the requested address

				// we'll want everything within, say, 30km distance
				$distance = isset( $_GET['within'] ) && ! empty( $_GET['within'] ) ? floatval( $_GET['within'] ) : 50;

				// earth's radius in km = ~6371
				$radius = auto_listings_metric() == 'yes' ? 6371 : 3950;

				// latitude boundaries
				$maxlat = $lat + rad2deg($distance / $radius);
				$minlat = $lat - rad2deg($distance / $radius);

				// longitude boundaries (longitude gets smaller when latitude increases)
				$maxlng = $lng + rad2deg($distance / $radius / cos(deg2rad($lat)));
				$minlng = $lng - rad2deg($distance / $radius / cos(deg2rad($lat)));

				// build the meta query array
				$radius_array = array( 
					'relation' => 'AND',
				);
				
				$radius_array[] = array(
					'key'     => '_al_listing_lat',
					'value'   => array( $minlat, $maxlat ),
					'type'    => 'DECIMAL(10,5)',
					'compare' => 'BETWEEN',
				);
				$radius_array[] = array(
					'key'     => '_al_listing_lng',
					'value'   => array( $minlng, $maxlng ),
					'type'    => 'DECIMAL(10,5)',
					'compare' => 'BETWEEN',
				);

				return apply_filters( 'auto_listings_search_radius_args', $radius_array );

			}

		}

	}


	// function to geocode address, it will return false if unable to geocode address
	private function geocode( $address ){
		return false;
	    // url encode the address
	    $address = urlencode( esc_html( $address ) );
	     
	    // google map geocode api url
	    $url = auto_listings_google_geocode_maps_url( $address );
	 	
	 	$arrContextOptions = array(
		    "ssl" => array(
		        "verify_peer" => false,
		        "verify_peer_name" => false,
		    ),
		); 

	    // get the json response
	    $resp_json = file_get_contents( $url, false, stream_context_create($arrContextOptions) );
	     
	    // decode the json
	    $resp = json_decode( $resp_json, true );

	    //pp( $resp );

	    // response status will be 'OK', if able to geocode given address 
	    if( $resp['status'] == 'OK' ){
	 
	        // get the lat and lng
	        $lat = $resp['results'][0]['geometry']['location']['lat'];
	        $lng = $resp['results'][0]['geometry']['location']['lng'];
	         
	        // verify if data is complete
	        if( $lat && $lng ){
	         
	            return array(
	            	'lat' => $lat,
	            	'lng' => $lng,
	            );
	             
	        } else {
	            return false;
	        }
	         
	    } else {
	        return false;
	    }

	}


	/**
	 * Searches through our custom fields using a keyword match
	 * @return array
	 */
	private function keyword_query( $q ) {
		if ( isset( $_GET['s'] ) && ! empty( $_GET['s'] ) ) {
			
			$custom_fields = apply_filters( 'auto_listings_keyword_search_fields', array(
		        // put all the meta fields you want to search for here
		        '_al_listing_city',
		        '_al_listing_zip',
		        '_al_listing_state',
		        '_al_listing_route',
		        '_al_listing_displayed_address',
		    ) );
		    $searchterm = sanitize_text_field( $_GET['s'] );

		    // we have to remove the "s" parameter from the query, because it will prevent the posts from being found
		    $q->query_vars['s'] = '';

		    if ( $searchterm != '' ) {

		        $meta_query = array('relation' => 'OR');
		        foreach($custom_fields as $cf) {
		            array_push( $meta_query, array(
		                'key' 		=> $cf,
		                'value' 	=> $searchterm,
		                'compare' 	=> 'LIKE'
		            ));
		        }
		        return $meta_query;
		    };
		}
		return array();
	}

}

return new Auto_Listings_Search_Query();