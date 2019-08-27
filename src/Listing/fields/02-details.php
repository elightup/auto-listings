<?php
/**
 * Listing detail fields.
 *
 * @package Auto Listings.
 */

$prefix = '_al_listing_';
$fields = [];

$fields[] = [
	'name' => __( 'Price', 'auto-listings' ),
	'id'   => $prefix . 'price',
	'type' => 'number',
	'min'  => 0,
	'step' => '0.01',
];
$fields[] = [
	'name'              => __( 'Suffix', 'auto-listings' ),
	'desc'              => __( 'Optional text after price.', 'auto-listings' ),
	'id'                => $prefix . 'price_suffix',
	'type'              => 'text',
	'sanitize_callback' => 'wp_kses_post',
];

$fields[] = [
	'name' => auto_listings_miles_kms_label(),
	'desc' => '',
	'id'   => $prefix . 'odometer',
	'type' => 'number',
	'min'  => 0,
	'step' => '0.01',
];
$fields[] = [
	'name'              => __( 'Color', 'auto-listings' ),
	'id'                => $prefix . 'color',
	'type'              => 'text',
	'sanitize_callback' => 'wp_kses_post',
];
$fields[] = [
	'name'              => __( 'Registration', 'auto-listings' ),
	'id'                => $prefix . 'registration',
	'type'              => 'text',
	'sanitize_callback' => 'wp_kses_post',
];
$fields[] = [
	'name'     => __( 'Body Type', 'auto-listings' ),
	'id'       => $prefix . 'body_type',
	'type'     => 'taxonomy',
	'taxonomy' => 'body-type',
];
$fields[] = [
	'name'             => __( 'Status', 'auto-listings' ),
	'id'               => $prefix . 'status',
	'type'             => 'select',
	'placeholder'      => __( 'Hidden', 'auto-listings' ),
	'show_option_none' => true,
	'options'          => auto_listings_available_listing_statuses(),
];
$fields[] = [
	'name'             => __( 'Listing State', 'auto-listings' ),
	'id'               => $prefix . 'listing_state',
	'type'             => 'select',
	'placeholder'      => __( 'Available', 'auto-listings' ),
	'show_option_none' => true,
	'options'          => auto_listings_available_listing_states(),
];
$fields[] = [
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
