<?php
/**
 * Listing gallery field.
 *
 * @package Auto Listings.
 */

$prefix = '_al_listing_';

$fields     = [];
$fields[10] = [
	'name' => __( 'Image Gallery', 'auto-listings' ),
	'id'   => $prefix . 'image_gallery',
	'type' => 'image_advanced',
];

$fields = apply_filters( 'auto_listings_metabox_images', $fields );

ksort( $fields );

return [
	'id'         => $prefix . 'images',
	'title'      => __( 'Gallery', 'auto-listings' ),
	'post_types' => 'auto-listing',
	'priority'   => 'low',
	'fields'     => $fields,
];
