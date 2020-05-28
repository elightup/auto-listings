<?php
/**
 * Test storage with text fields.
 *
 * @package Meta Box Group
 */

add_filter( 'rwmb_meta_boxes', function ( $meta_boxes ) {
	$meta_boxes[] = [
		'title'  => 'Storage test',
		'fields' => [
			[
				'id'     => 'group',
				'type'   => 'group',
				'clone'  => true,
				'fields' => [
					[
						'id'   => 't1',
						'type' => 'text',
						'name' => 'Text 1',
					],
					[
						'id'   => 't2',
						'type' => 'text',
						'name' => 'Text 2',
					],
				],
			],
		],
	];
	return $meta_boxes;
} );
