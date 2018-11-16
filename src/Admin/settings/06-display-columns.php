<?php
/**
 * Number of Columns field.
 *
 * @package Auto Listings.
 */

return [
	'id'             => 'columns',
	'title'          => __( 'Columns', 'auto-listings' ),
	'settings_pages' => 'auto-listings',
	'tab'            => 'display',
	'fields'         => [
		[
			'name'    => __( 'Number of Columns', 'auto-listings' ),
			'desc'    => __( 'The number of columns to display on the archive page, when viewing listings in grid mode.', 'auto-listings' ),
			'id'      => 'grid_columns',
			'type'    => 'select',
			'default' => 3,
			'options' => [
				2 => __( '2 Column', 'auto-listings' ),
				3 => __( '3 Column', 'auto-listings' ),
				4 => __( '4 Column', 'auto-listings' ),
			],
		],
	],
];
