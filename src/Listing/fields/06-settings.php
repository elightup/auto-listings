<?php
/**
 * Listing setting fields.
 *
 * @package Auto Listings.
 */

$prefix = '_al_listing_';

$fields = [];

$fields[10] = [
	'type'     => 'custom_html',
	'callback' => 'auto_listings_admin_listing_status_area',
];

$fields[15] = [
	'name'       => __( 'Seller', 'auto-listings' ),
	'desc'       => __( 'Adding a Seller will automatically insert the Contact Form on the listing and all enquiries will be sent to this seller.', 'auto-listings' ),
	'id'         => $prefix . 'seller',
	'type'       => 'user',
	'std'        => get_current_user_id(),
	'query_args' => apply_filters(
		'auto_listings_sellers_as_dropdown',
		[
			'role__in'    => [ 'auto_listings_seller', 'administrator' ],
			'orderby'     => 'display_name',
			'order'       => 'ASC',
			'count_total' => false,
		]
	),
];

$fields[20] = [
	'name'    => __( 'Hide Items', 'auto-listings' ),
	'desc'    => __( 'Hide items on the frontend, even if filled in.', 'auto-listings' ),
	'id'      => $prefix . 'hide',
	'type'    => 'checkbox_list',
	'options' => [
		'price'        => __( 'Price', 'auto-listings' ),
		'contact_form' => __( 'Contact Form', 'auto-listings' ),
		'map'          => __( 'Map', 'auto-listings' ),
		'address'      => __( 'Address', 'auto-listings' ),
	],
];

$fields = apply_filters( 'auto_listings_metabox_settings', $fields );

ksort( $fields );
return [
	'id'         => $prefix . 'settings',
	'title'      => __( 'Settings', 'auto-listings' ),
	'post_types' => 'auto-listing',
	'fields'     => $fields,
	'context'    => 'side',
];
