<?php
$prefix = '_al_listing_';
$fields = [];

$fields[10] = [
	'name' => __( 'Price', 'auto-listings' ),
	'id'   => $prefix . 'price',
	'type' => 'number',
	'min'  => 0,
	'step' => '0.01',
];
$fields[11] = [
	'name' => __( 'Suffix', 'auto-listings' ),
	'desc' => __( 'Optional text after price.', 'auto-listings' ),
	'id'   => $prefix . 'price_suffix',
	'type' => 'text',
];

$fields[20] = [
	'name' => auto_listings_miles_kms_label(),
	'desc' => __( '', 'auto-listings' ),
	'id'   => $prefix . 'odometer',
	'type' => 'number',
	'min'  => 0,
	'step' => '0.01',
];
$fields[30] = [
	'name' => __( 'Color', 'auto-listings' ),
	'id'   => $prefix . 'color',
	'type' => 'text',
];
$fields[40] = [
	'name' => __( 'Registration', 'auto-listings' ),
	'id'   => $prefix . 'registration',
	'type' => 'text',
];
$fields[50] = [
	'name'             => __( 'Status', 'auto-listings' ),
	'id'               => $prefix . 'status',
	'type'             => 'select',
	'show_option_none' => true,
	'options'          => auto_listings_available_listing_statuses(),
];
$fields[60] = [
	'name'    => __( 'Condition', 'auto-listings' ),
	'id'      => $prefix . 'condition',
	'type'    => 'select',
	'options' => auto_listings_available_listing_conditions(),
];

$fields = apply_filters( 'auto_listings_metabox_details', $fields );

ksort( $fields );

return [
	'id'         => $prefix . 'details',
	'title'      => __( 'Details', 'auto-listings' ),
	'post_types' => 'auto-listing',
	'fields'     => $fields,
	'context'    => 'side',
];
