<?php
$prefix = '_al_listing_';

$fields     = [];
$fields[10] = [
	'name' => __( 'Tagline', 'auto-listings' ),
	'id'   => $prefix . 'tagline',
	'type' => 'text',
];
$fields[20] = [
	'name'    => __( 'Main Description', 'auto-listings' ),
	'id'      => $prefix . 'main_description',
	'type'    => 'wysiwyg',
	'options' => [
		'media_buttons' => false,
		'textarea_rows' => get_option( 'default_post_edit_rows', 3 ),
		'teeny'         => true,
		'quicktags'     => false,
	],
];
$fields     = apply_filters( 'auto_listings_metabox_description', $fields );

ksort( $fields );

return [
	'id'         => $prefix . 'description',
	'title'      => __( 'Description', 'auto-listings' ),
	'post_types' => 'auto-listing',
	'fields'     => $fields,
];
