<?php
/**
 * Enquiry settings fields.
 *
 * @package Auto Listings.
 */

$prefix = '_al_enquiry_';

$fields     = [];
$fields[10] = [
	'type'     => 'custom_html',
	'callback' => 'auto_listings_admin_listing_status_area',
];

$fields = apply_filters( 'auto_listings_enquiry_metabox_settings', $fields );

ksort( $fields );

return [
	'id'         => $prefix . 'settings',
	'title'      => sprintf( __( 'Settings', 'auto-listings' ) ),
	'post_types' => 'listing-enquiry',
	'context'    => 'side',
	'fields'     => $fields,
];
