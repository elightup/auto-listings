<?php
add_filter( 'rwmb_meta_boxes', function ( $meta_boxes )
{
	$meta_boxes[] = [
		'title'  => 'Test',
		'fields' => [
			[
				'name'  => 'Color2 ',
				'id'    => 'color2',
				'type'  => 'color',
				'clone' => true,
			],
			[
				'id'     => 'group1',
				'type'   => 'group',
				'clone'  => true,
				'fields' => [
					[
						'name' => 'Color',
						'id'   => 'color',
						'type' => 'color',
					],
					[
						'name'   => 'Subgroup',
						'id'     => 'group2',
						'type'   => 'group',
						'clone'  => true,
						'fields' => [
							[
								'name' => 'Color 3',
								'id'   => 'color3',
								'type' => 'color',
							],
						],
					],
				],
			],
		],
	];

	return $meta_boxes;
} );
