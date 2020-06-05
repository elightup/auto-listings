<?php
add_filter( 'rwmb_meta_boxes', function ( $meta_boxes )
{
	$meta_boxes[] = [
		'title'  => '2 date fields',
		'fields' => [
			[
				'id'     => 'group',
				'type'   => 'group',
				'clone'  => true,
				'fields' => [
					[
						'id'   => 'date',
						'type' => 'date',
						'name' => 'Date 1',
					],
					[
						'id'   => 'date2',
						'type' => 'date',
						'name' => 'Date 2',
					],
					[
						'id'   => 'text',
						'type' => 'text',
						'name' => 'Text',
					],
				],
			],
		],
	];
	return $meta_boxes;
} );
