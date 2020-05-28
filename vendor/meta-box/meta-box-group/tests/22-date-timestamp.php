<?php
add_filter( 'rwmb_meta_boxes', function( $meta_boxes ) {
	$meta_boxes[] = [
		'title'  => 'Group with Date picker (timestamp)',
		'fields' => [
			[
				'id'     => 'g',
				'type'   => 'group',
				'clone'  => true,
				'fields' => [
					[
						'name'      => 'Date',
						'id'        => 'd',
						'type'      => 'date',
						'timestamp' => true,
					],
				]
			],
		]
	];
	return $meta_boxes;
} );