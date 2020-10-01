<?php
/**
 * Plugin general functions.
 *
 * @package Auto Listings.
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Get the id af any item (used only to localize address for shortcodes)
 */
function auto_listings_get_ID() {
	$post_id = null;

	if ( ! $post_id ) {
		$post_id = auto_listings_shortcode_att( 'id', 'auto_listings_listing' );
	}

	if ( ! $post_id ) {
		$post_id = auto_listings_shortcode_att( 'id', 'auto_listings_seller' );
	}

	if ( ! $post_id ) {
		$post_id = get_the_ID();
	}

	return $post_id;
}

/**
 * Return an attribute value from any shortcode
 *
 * @param array  $attribute shortcode attribute array.
 * @param string $shortcode shortcode name.
 */
function auto_listings_shortcode_att( $attribute, $shortcode ) {

	global $post;

	if ( ! $post ) {
		return;
	}

	if ( ! $attribute && ! $shortcode ) {
		return;
	}

	if ( has_shortcode( $post->post_content, $shortcode ) ) {

		$pattern = get_shortcode_regex();
		if ( preg_match_all( '/' . $pattern . '/s', $post->post_content, $matches )
			&& array_key_exists( 2, $matches )
			&& in_array( $shortcode, $matches[2], true ) ) {

			$key = array_search( $shortcode, $matches[2], true );

			if ( $matches[3][ $key ] ) {
				$att = str_replace( $attribute . '="', '', trim( $matches[3][ $key ] ) );
				$att = str_replace( '"', '', $att );

				if ( isset( $att ) ) {
					return $att;
				}
			}
		}
	}

}

/**
 * Get auto listings seller id
 */
function auto_listings_seller_ID() {
	$id = auto_listings_meta( 'seller' );
	if ( $id ) {
		return $id;
	}

	// Gets the author when on single seller page.
	$current_author = get_query_var( 'author_name' )
		? get_user_by( 'slug', get_query_var( 'author_name' ) )
		: get_userdata( get_query_var( 'author' ) );
	if ( $current_author ) {
		return $current_author->ID;
	}

	// If nothing above, then check for shortcode.
	return auto_listings_shortcode_att( 'id', 'auto_listings_seller' );
}

/**
 * Get the meta af any item
 *
 * @param string $meta    listing meta key.
 * @param int    $post_id listing ID.
 * @param bool   $single  return value in key or array.
 */
function auto_listings_meta( $meta, $post_id = 0, $single = true ) {
	if ( ! $post_id ) {
		$post_id = get_the_ID();
	}
	$meta_key = '_al_listing_' . $meta;
	$data     = get_post_meta( $post_id, $meta_key, $single );
	return apply_filters( 'auto_listings_meta', $data, $meta, $post_id );
}

/**
 * Get any option
 *
 * @param string $option option key.
 */
function auto_listings_option( $option ) {
	$options = get_option( 'auto_listings_options' );
	$return  = isset( $options[ $option ] ) ? $options[ $option ] : false;
	return $return;
}

/**
 * Get the columns
 */
function auto_listings_columns() {
	$columns = auto_listings_option( 'grid_columns' );
	$columns = $columns ? $columns : '3';
	return apply_filters( 'auto_listings_columns', $columns );
}


/**
 * Are we hiding an item
 *
 * @param string $item Listing item to hide.
 */
function auto_listings_hide_item( $item ) {
	$hide = auto_listings_meta( 'hide', '', false );
	if ( ! $hide ) {
		return false;
	}
	return in_array( $item, $hide, true );
}


add_action( 'init', 'auto_listings_add_new_image_sizes', 11 );

/**
 * Plugin image sizes.
 */
function auto_listings_add_new_image_sizes() {
	add_theme_support( 'post-thumbnails' );
	add_image_size( 'al-lge', 1200, 750, array( 'center', 'center' ) ); // main.
	add_image_size( 'al-sml', 400, 250, array( 'center', 'center' ) ); // thumb.
}


/**
 * Build Google maps URL
 *
 * @param string $query_var Query variable.
 */
function auto_listings_google_maps_url( $query_var = null ) {
	$api_url = 'https://maps.googleapis.com/maps/api/js?v=3.exp';
	$key     = auto_listings_option( 'maps_api_key' );
	if ( empty( $key ) ) {
		return;
	}

	$api_url = $api_url . '&key=' . $key;

	if ( ! empty( $query_var ) ) {
		$api_url = $api_url . $query_var;
	}

	return $api_url;
}

/**
 * Build Google maps Geocode URL
 *
 * @param string $address Listing address.
 */
function auto_listings_google_geocode_maps_url( $address ) {
	$api_url = "https://maps.google.com/maps/api/geocode/json?address={$address}";
	$key     = auto_listings_option( 'maps_api_key' );
	$country = auto_listings_search_country();
	if ( ! empty( $key ) ) {
		$api_url = $api_url . '&key=' . $key;
	}
	if ( ! empty( $country ) ) {
		$api_url = $api_url . '&components=country:' . $country;
	}
	return apply_filters( 'auto_listings_google_geocode_maps_url', $api_url );
}


/**
 * Map height
 */
function auto_listings_map_height() {
	$height = auto_listings_option( 'map_height' ) ? auto_listings_option( 'map_height' ) : '300';
	return apply_filters( 'auto_listings_map_height', $height );
}

/**
 * Get search country
 */
function auto_listings_search_country() {
	$country = auto_listings_option( 'search_country' ) ? auto_listings_option( 'search_country' ) : '';
	return apply_filters( 'auto_listings_search_country', $country );
}