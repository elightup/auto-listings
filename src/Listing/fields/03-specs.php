<?php
/**
 * Specifications Fields.
 *
 * @package Auto Listings.
 */

$prefix = '_al_listing_';

$fields      = [];
$spec_fields = auto_listings_spec_fields();
$display     = auto_listings_option( 'field_display' );

foreach ( $spec_fields as $field_id => $value ) {
	if ( is_array( $display ) && ! in_array( $field_id, $display, true ) ) {
		continue;
	}

	$fields[] = [
		'name'              => $value['label'],
		'id'                => $prefix . $field_id,
		'type'              => 'text',
		'sanitize_callback' => 'wp_kses_post',
		'columns'           => 3,
	];
}

$fields = apply_filters( 'auto_listings_metabox_specs', $fields );

ksort( $fields );

return [
	'id'         => $prefix . 'specs',
	'title'      => __( 'Specifications', 'auto-listings' ),
	'post_types' => 'auto-listing',
	'priority'   => 'low',
	'fields'     => $fields,
];
