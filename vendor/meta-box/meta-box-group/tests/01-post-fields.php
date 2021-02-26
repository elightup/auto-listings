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
						'id'   => 'post1',
						'type' => 'post',
						'name' => 'Post 1',
					],
					[
						'id'   => 'post2',
						'type' => 'post',
						'name' => 'Post 2',
					],
					[
						'id'   => 'post3',
						'type' => 'post',
						'name' => 'Post 3',
					],
				],
			],
		],
	];
	return $meta_boxes;
} );
