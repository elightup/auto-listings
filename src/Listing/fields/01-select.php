<?php
/**
 * Vehicle select fields.
 *
 * @package Auto Listings.
 */

$prefix = '_al_listing_';

return [
	'id'         => $prefix . 'select',
	'title'      => __( 'Vehicle Select', 'auto-listings' ),
	'post_types' => 'auto-listing',
	'priority'   => 'low',
	'fields'     => apply_filters( 'auto_listings_vehicle_select', [
		[
			'type'       => 'button',
			'id'         => 'cq-select-model',
			'std'        => __( 'Load Makes &amp; Models', 'auto-listings' ),
			'attributes' => [
				'class' => 'al-button button-small',
			],
			'desc'       => __( 'Click the button to load Make & Model data into the dropdowns.', 'auto-listings' ),
		],
		[
			'name'    => __( 'Years', 'auto-listings' ),
			'id'      => 'car-years',
			'type'    => 'select',
			'options' => [
				'' => '---',
			],
			'columns' => 3,
		],
		[
			'name'    => __( 'Makes', 'auto-listings' ),
			'id'      => 'car-makes',
			'type'    => 'select',
			'options' => [
				'' => '---',
			],
			'columns' => 3,
		],
		[
			'name'    => __( 'Models', 'auto-listings' ),
			'id'      => 'car-models',
			'type'    => 'select',
			'options' => [
				'' => '---',
			],
			'columns' => 3,
		],
		[
			'name'    => __( 'Trims', 'auto-listings' ),
			'id'      => 'car-model-trims',
			'type'    => 'select',
			'options' => [
				'' => '---',
			],
			'columns' => 3,
		],
		[
			'type'       => 'button',
			'id'         => 'cq-show-data',
			'std'        => __( 'Populate The Fields', 'auto-listings' ),
			'attributes' => [
				'class' => 'al-button button-small',
			],
			'desc'       => __( 'Once your vehicle is selected, hit the button to automatically populate the fields below.', 'auto-listings' ),
		],
	] ),
];
