<?php
$prefix = '_al_listing_';

$fields     = [];
$fields[10] = [
	'name'  => __( 'Image Gallery', 'auto-listings' ),
	'id'    => $prefix . 'image_gallery',
	'type'  => 'file_input',
	'clone' => true,
];

// filter the fields
$fields = apply_filters( 'auto_listings_metabox_images', $fields );

// sort numerically
ksort( $fields );

return [
	'id'         => $prefix . 'images',
	'title'      => __( 'Gallery', 'auto-listings' ),
	'post_types' => 'auto-listing',
	'fields'     => $fields,
];
