<?php
return [
	'id'             => 'slider',
	'title'          => __( 'Image Slider', 'auto-listings' ),
	'settings_pages' => 'auto-listings',
	'tab'            => 'display',
	'fields'         => [
		[
			'name'      => __( 'Auto start', 'auto-listings' ),
			'id'        => 'slider_auto',
			'type'      => 'switch',
			'style'     => 'square',
			'on_label'  => __( 'Enable', 'auto-listings' ),
			'off_label' => __( 'Disable', 'auto-listings' ),
		],
		[
			'name'   => __( 'Slider speed', 'auto-listings' ),
			'id'     => 'slider_speed',
			'type'   => 'number',
			'min'    => 500,
			'max'    => 4000,
			'step'   => 100,
			'suffix' => 'ms',
			'desc'   => __( 'Transition duration, in miliseconds.', 'auto-listings' ),
		],
	],
];
