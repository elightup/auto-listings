<?php
/**
 * Contact fields in single Enquiry .
 *
 * @package Auto Listings.
 */

$prefix = '_al_enquiry_';

$fields = [];

if ( is_admin() ) {
	$fields[10] = [
		'id'        => $prefix . 'listing_id',
		'name'      => __( 'Listing', 'auto-listing' ),
		'type'      => 'post',
		'post_type' => 'auto-listing',
	];
	$fields[20] = [
		'id'                => $prefix . 'listing_title',
		'name'              => __( 'Listing Title', 'auto-listing' ),
		'type'              => 'text',
		'sanitize_callback' => 'wp_kses_post',
	];
	$fields[30] = [
		'id'   => $prefix . 'listing_seller',
		'name' => __( 'Seller', 'auto-listing' ),
		'type' => 'user',
	];
	$fields[40] = [
		'type' => 'heading',
		'name' => __( 'Contact Information', 'auto-listings' ),
	];
}

$fields[50] = [
	'name'        => is_admin() ? __( 'Name', 'auto-listings' ) : '',
	'id'          => $prefix . 'name',
	'type'        => 'text',
	'required'    => true,
	'placeholder' => __( 'Name', 'auto-listings' ),
];

$fields[60] = [
	'name'        => is_admin() ? __( 'Email', 'auto-listings' ) : '',
	'id'          => $prefix . 'email',
	'type'        => 'text',
	'required'    => true,
	'placeholder' => __( 'Email', 'auto-listings' ),
];

$fields[70] = [
	'name'        => is_admin() ? __( 'Phone', 'auto-listings' ) : '',
	'id'          => $prefix . 'phone',
	'type'        => 'text',
	'placeholder' => __( 'Phone', 'auto-listings' ),
];

$fields[80] = [
	'name'        => is_admin() ? __( 'Message', 'auto-listings' ) : '',
	'id'          => $prefix . 'message',
	'type'        => 'textarea',
	'required'    => true,
	'placeholder' => __( 'Message', 'auto-listings' ),
	'rows'        => 3,
];

$fields = apply_filters( 'auto_listings_contact_fields', $fields );
ksort( $fields );

return [
	'id'         => 'auto_listings_contact_form',
	'title'      => __( 'Contact', 'auto-listings' ),
	'post_types' => 'listing-enquiry',
	'fields'     => $fields,
];
