<?php
/**
 * Slider setting fields.
 *
 * @package Auto Listings.
 */

return [ 
	'id'             => 'slider',
	'title'          => __( 'Slider', 'auto-listings' ),
	'settings_pages' => 'auto-listings',
	'tab'            => 'display',
	'fields'         => [ 
		[ 
			'name'      => 'Enable auto start for image slider',
			'id'        => 'enable_auto',
			'type'      => 'switch',
			'style'     => 'square',
			'on_label'  => 'Enable',
			'off_label' => 'Disable',
		],
		[ 
			'name' => 'Slider speed',
			'id'   => 'slider_speed',
			'type' => 'number',
			'min'  => 500,
			'max'  => 4000,
			'step' => 500,
		],
	],
];
