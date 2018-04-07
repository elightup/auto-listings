<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Get the id af any item (used only to localize address for shortcodes)
 */
function auto_listings_get_ID() {
	$post_id = null;

	if( ! $post_id )
		$post_id = auto_listings_shortcode_att( 'id', 'auto_listings_listing' );

	if( ! $post_id )
		$post_id = auto_listings_shortcode_att( 'id', 'auto_listings_seller' );

	if( ! $post_id )
		$post_id = get_the_ID();

	return $post_id;
}

/**
 * Return an attribute value from any shortcode
 */
function auto_listings_shortcode_att( $attribute, $shortcode ) {
	
	global $post;

	if( ! $post )
		return;

	if( ! $attribute && ! $shortcode )
		return;

	if( has_shortcode( $post->post_content, $shortcode ) ) {
			
	    $pattern = get_shortcode_regex();
	    if ( preg_match_all( '/'. $pattern .'/s', $post->post_content, $matches )
	        && array_key_exists( 2, $matches )
	        && in_array( $shortcode, $matches[2] ) )
	    {
	        
	        $key = array_search( $shortcode, $matches[2], true );

	        if( $matches[3][$key] ) {
	        	$att = str_replace( $attribute . '="', "", trim( $matches[3][$key] ) );
	    		$att = str_replace( '"', '', $att );
	    		
	    		if ( isset ( $att ) ) {
		            return $att;
	    		}

	        }

	    }
	}

}

/**
 * Get the meta af any item
 */
function auto_listings_meta( $meta, $post_id = 0 ) {
	if( ! $post_id )
		$post_id = get_the_ID();
	$meta_key = '_al_listing_' . $meta;
	$data = get_post_meta( $post_id, $meta_key, true );
	return $data;
}

/**
 * Get any option
 */
function auto_listings_option( $option ) {
	$options = get_option( 'auto_listings_options' );
	$return = isset( $options[$option] ) ? $options[$option] : false;
	return $return;
}

/**
 * Get the columns
 */
function auto_listings_columns() {
	$columns = auto_listings_option( 'grid_columns' );
	$columns = $columns ? $columns : '3';
	return $columns;
}


/*
 * Are we hiding an item
 */
function auto_listings_hide_item( $item ) {
	$hide = auto_listings_meta( 'hide' );
	if( ! $hide ) {
		return false;
	}
	return in_array( $item, $hide );
}


add_action( 'init', 'auto_listings_add_new_image_sizes', 11 );

function auto_listings_add_new_image_sizes() {
	add_theme_support( 'post-thumbnails' );
    add_image_size( 'al-lge', 1200, 750, array( 'center', 'center' ) ); //main
    add_image_size( 'al-sml', 400, 250, array( 'center', 'center' ) ); //thumb
    //pp( get_intermediate_image_sizes() );
}


/*
 * Build Google maps URL
 */
function auto_listings_google_maps_url( $query_var = null ) {
	$api_url 	= 'https://maps.googleapis.com/maps/api/js?v=3.exp';
	$key 		= auto_listings_option( 'maps_api_key' );
	if( empty( $key ) )
		return;

	$api_url = $api_url . '&key=' . $key;

	if( ! empty( $query_var ) ) {
		$api_url = $api_url . $query_var;
	}

	return $api_url;
}

/*
 * Build Google maps Geocode URL
 */
function auto_listings_google_geocode_maps_url( $address ) {
	$api_url 	= "https://maps.google.com/maps/api/geocode/json?address={$address}";
	$key 		= auto_listings_option( 'maps_api_key' );
	$country 	= auto_listings_search_country();
	if( ! empty( $key ) ) {
		$api_url = $api_url . '&key=' . $key;
	}
	if( ! empty( $country ) ) {
		$api_url = $api_url . '&components=country:' . $country;
	}
	return apply_filters( 'auto_listings_google_geocode_maps_url', $api_url );
}


/*
 * Map height
 */
function auto_listings_map_height() {
	$height = auto_listings_option( 'map_height' ) ? auto_listings_option( 'map_height' ) : '300';
	return apply_filters( 'auto_listings_map_height', $height );
}

/*
 * Get search country
 */
function auto_listings_search_country() {
	$country = auto_listings_option( 'search_country' ) ? auto_listings_option( 'search_country' ) : '';
	return apply_filters( 'auto_listings_search_country', $country );
}

/*
 * Get price min max search values
 */
function auto_listings_search_price_min_max() {

	$options = apply_filters( 'auto_listings_search_price_min_max', array(
		'3000' => auto_listings_raw_price( '3000' ),
		'5000' => auto_listings_raw_price( '5000' ),
		'10000' => auto_listings_raw_price( '10000' ),
		'15000' => auto_listings_raw_price( '15000' ),
		'20000' => auto_listings_raw_price( '20000' ),
		'25000' => auto_listings_raw_price( '25000' ),
		'30000' => auto_listings_raw_price( '30000' ),
		'35000' => auto_listings_raw_price( '35000' ),
		'40000' => auto_listings_raw_price( '40000' ),
		'45000' => auto_listings_raw_price( '45000' ),
		'50000' => auto_listings_raw_price( '50000' ),
		'60000' => auto_listings_raw_price( '60000' ),
		'80000' => auto_listings_raw_price( '80000' ),
		'100000' => auto_listings_raw_price( '100000' ),
		'125000' => auto_listings_raw_price( '125000' ),
		'150000' => auto_listings_raw_price( '150000' ),
	) );

	return $options;

}

/*
 * Get max search mileage
 */
function auto_listings_search_mileage_max() {
	$miles_kms = auto_listings_miles_kms_label_short();
	$numbers = array(
		'10000',
		'20000',
		'30000',
		'40000',
		'50000',
		'75000',
		'100000',
		'150000',
		'200000',
	);

	foreach ( $numbers as $val ) {
		$options[$val] = sprintf( __( '%1s %2s or less', 'auto-listings' ), number_format_i18n( $val ), strtolower( $miles_kms ) );
	}

	return apply_filters( 'auto_listings_search_mileage_max', $options );

}

/*
 * Get search within radius
 */
function auto_listings_search_within_radius() {
	$miles_kms = auto_listings_miles_kms_label_short();
	$numbers = array(
		'10',
		'20',
		'30',
		'40',
		'50',
		'100',
		'150',
		'250',
		'500',
	);

	foreach ( $numbers as $val ) {
		$options[$val] = sprintf( __( '%1s %2s of', 'auto-listings' ), $val, strtolower( $miles_kms ) );
	}

	return apply_filters( 'auto_listings_search_within_radius', $options );

}



/*
 * Get vehicles in the database to populate search fields
 */
function auto_listings_search_get_vehicle_data() {

	$args = apply_filters( 'auto_listings_search_get_vehicle_data_args', array(
		'post_type' 	=> 'auto-listing', 
		'numberposts' 	=> -1, 
		'post_status' 	=> array( 'publish' ), 
		'fields' 		=> 'ids'
	) );

	$items = get_posts( $args );

	$data = array();

	if ( $items ) {

		foreach ( $items as $id ) {

			$data['year'][] = get_post_meta( $id, '_al_listing_model_year', true );
			$data['make'][] = get_post_meta( $id, '_al_listing_make_display', true );
			$data['model'][] = get_post_meta( $id, '_al_listing_model_name', true );

		}

	}

	// remove empties and make unique
	foreach ($data as $key => $value) {
		$data[$key] = array_filter( $data[$key] );
		$data[$key] = array_unique( $data[$key] );
	}
	
	return $data;

}