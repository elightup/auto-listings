<?php
return [
	'id'             => 'gallery_settings',
	'title'          => __( 'Gallery Settings', 'auto-listings' ),
	'settings_pages' => 'auto-listings',
	'tab'            => 'display',
	'fields'         => [
		[
			'name'    => __( 'Auto Slide Images', 'auto-listings' ),
			'desc'    => __( 'Should images start to slide automatically?', 'auto-listings' ),
			'id'      => 'auto_slide',
			'type'    => 'select',
			'std'     => 'yes',
			'options' => [
				'yes' => 'Yes',
				'no'  => 'No',
			],
		],
		[
			'name' => __( 'Transition Delay', 'auto-listings' ),
			'desc' => __( 'The time (in ms) between each auto transition', 'auto-listings' ),
			'id'   => 'slide_delay',
			'type' => 'number',
			'std'  => 2000,
		],
		[
			'name' => __( 'Transition Duration', 'auto-listings' ),
			'desc' => __( 'Transition duration (in ms)', 'auto-listings' ),
			'id'   => 'slide_duration',
			'type' => 'number',
			'std'  => 1000,
		],
		[
			'name' => __( 'Thumbnails Shown', 'auto-listings' ),
			'desc' => __( 'Number of thumbnails shown below main image', 'auto-listings' ),
			'id'   => 'thumbs_shown',
			'type' => 'number',
			'std'  => 6,
		],
		[
			'name'    => __( 'Transition Type', 'auto-listings' ),
			'desc'    => __( 'Should images slide or fade?', 'auto-listings' ),
			'id'      => 'gallery_mode',
			'type'    => 'select',
			'std'     => 'fade',
			'options' => [
				'fade'  => 'Fade',
				'slide' => 'Slide',
			],
		],
	],
];
