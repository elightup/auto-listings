<?php
$prefix = '_al_listing_';

$fields      = [];
$spec_fields = auto_listings_spec_fields();
$display     = auto_listings_option( 'field_display' );

foreach ( $spec_fields as $id => $value ) {
	if ( is_array( $display ) && ! in_array( $id, $display ) ) {
		continue;
	}

	$fields[] = [
		'name'    => $value['label'],
		'id'      => $prefix . $id,
		'type'    => 'text',
		'columns' => 3,
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
