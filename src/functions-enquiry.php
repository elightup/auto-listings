<?php
/**
 * Enquiry functions.
 *
 * @package Auto Listings.
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Get the enquiry meta
 *
 * @param string $meta    Enquiry meta.
 * @param int    $post_id Enquiry ID.
 */
function auto_listings_enquiry_meta( $meta, $post_id = 0 ) {
	if ( ! $post_id ) {
		$post_id = get_the_ID();
	}
	$meta_key = '_al_enquiry_' . $meta;
	$data     = get_post_meta( $post_id, $meta_key, true );
	return $data;
}
