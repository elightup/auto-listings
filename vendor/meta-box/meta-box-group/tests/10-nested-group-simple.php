<?php
/**
 * Nested group clone not work.
 */
add_filter( 'rwmb_meta_boxes', function ( $meta_boxes )
{
	$meta_boxes[] = [
		'title'  => 'Clone group with image',
		'fields' => [
			[
				'id'     => 'group5',
				'type'   => 'group',
				'clone'  => true,
				'fields' => [
					[
						'name'  => 'Text',
						'id'    => 'text5',
						'type'  => 'text',
						'clone' => true,
					],
				],
			],
		],
	];
	return $meta_boxes;
} );
