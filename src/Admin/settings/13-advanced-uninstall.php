<?php
return [
	'id'             => 'uninstall',
	'title'          => __( 'Uninstall', 'auto-listings' ),
	'settings_pages' => 'auto-listings',
	'tab'            => 'advanced',
	'fields'         => [
		[
			'name'    => __( 'Delete Data', 'auto-listings' ),
			'desc'    => __( 'Should all plugin data be deleted upon uninstalling this plugin?', 'auto-listings' ),
			'id'      => 'delete_data',
			'type'    => 'select',
			'default' => 'yes',
			'options' => [
				'yes' => __( 'Yes', 'auto-listings' ),
				'no'  => __( 'No', 'auto-listings' ),
			],
		],
	],
];
