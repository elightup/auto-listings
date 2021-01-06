<?php
/**
 * Plugin conditional functions.
 *
 * @package Auto Listings.
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Returns true if on a listings page in the admin
 */
function is_auto_listings_admin() {
	$post_type = get_post_type();
	$screen    = get_current_screen();
	$return    = false;

	if ( in_array( $post_type, array( 'auto-listing', 'listing-enquiry' ), true ) ) {
		$return = true;
	}

	if ( in_array( $screen->id, array( 'auto-listing', 'edit-auto-listing', 'listing-enquiry', 'edit-listing-enquiry', 'settings_page_auto_listings_options' ), true ) ) {
		$return = true;
	}

	return apply_filters( 'is_auto_listings_admin', $return );
}

/**
 * Returns true if on a page which uses auto_listings templates
 */
function is_auto_listings() {

	// include on sellers page.
	$is_seller = false;
	if ( is_author() ) {
		$user       = new WP_User( auto_listings_seller_ID() );
		$user_roles = $user->roles;
		if ( in_array( 'auto_listings_seller', $user_roles, true ) ) {
			$is_seller = true;
		}
	}

	$result = apply_filters( 'is_auto_listings', ( is_post_type_archive( 'auto-listing' ) || is_listing() || is_listing_search() || is_listing_taxonomy() || $is_seller ) ? true : false );

	return $result;
}

/**
 * Returns true when viewing the listing taxonomy.
 */
if ( ! function_exists( 'is_listing_taxonomy' ) ) {
	/**
	 * Returns true when viewing the listing taxonomy.
	 */
	function is_listing_taxonomy() {
		return ( is_tax( get_object_taxonomies( 'auto-listing' ) ) );
	}
}

if ( ! function_exists( 'is_listing' ) ) {
	/**
	 * Returns true when viewing a single listing.
	 */
	function is_listing() {
		$result = false;
		if ( is_singular( 'auto-listing' ) ) {
			$result = true;
		}
		if ( is_single() && get_post_type() === 'auto-listing' ) {
			$result = true;
		}
		return apply_filters( 'is_listing', $result );
	}
}

if ( ! function_exists( 'is_listing_search' ) ) {
	/**
	 * Returns true when viewing listings search results page
	 */
	function is_listing_search() {
		if ( ! is_search() || ! is_page() ) {
			return false;
		}
		$current_page = sanitize_post( $GLOBALS['wp_the_query']->get_queried_object() );
		$result       = 'listing' === $current_page->name;
		return apply_filters( 'is_listing_search', $result );
	}
}
