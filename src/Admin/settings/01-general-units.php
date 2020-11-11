<?php
/**
 * Measurements Fields.
 *
 * @package Auto Listings.
 */

return [
	'id'             => 'units',
	'title'          => __( 'Measurements', 'auto-listings' ),
	'settings_pages' => 'auto-listings',
	'tab'            => 'general',
	'fields'         => apply_filters( 'auto_listings_units_fields', [
		[
			'name'    => __( 'Metric or Imperial', 'auto-listings' ),
			'id'      => 'metric',
			'type'    => 'select',
			'options' => [
				'yes' => __( 'Metric', 'auto-listings' ),
				'no'  => __( 'Imperial', 'auto-listings' ),
			],
		],
	] ),
];
