<?php
/**
 * This file tests maps are always visible when toggle collapsible groups.
 *
 * @package    Meta Box
 * @subpackage Meta Box Group
 */

add_filter( 'rwmb_meta_boxes', function ( $meta_boxes ) {
	$meta_boxes[] = [
		'title'  => 'Test Collapsible Group w/ Map',
		'fields' => [
			[
				'id'          => 'g',
				'type'        => 'group',
				'collapsible' => true,
				'save_state'  => true,
				'clone'       => true,
				'fields'      => [
					[
						'type' => 'text',
						'id'   => 'address',
						'name' => 'Address',
					],
					[
						'type'          => 'map',
						'id'            => 'map',
						'name'          => 'Map',
						'address_field' => 'address',
					],
				],
			],
		],
	];
	return $meta_boxes;
} );
