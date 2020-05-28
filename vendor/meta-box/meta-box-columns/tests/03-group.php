<?php
add_filter( 'rwmb_meta_boxes', function ( $meta_boxes ) {
	$meta_boxes[] = [
		'title'  => 'Test',
		'taxonomies' => 'category',
		'fields' => [
			array(
				'name'       => 'Group 6',
				'id'         => 'numbered_items',
				'type'       => 'group',
				'columns'    => 6,
				'sort_clone' => true,
				'fields'     => array(
					array(
						'name'    => __( 'Col 3', 'indigo-metaboxes' ),
						'id'      => 'title',
						'type'    => 'text',
						'class'   => 'big-text',
						'columns' => 3,
					),
					array(
						'name'    => __( 'Col 3', 'indigo-metaboxes' ),
						'id'      => 'desc',
						'type'    => 'text',
						'class'   => 'big-text2',
						'columns' => 3,
					),
				),
			),
			array(
				'name'       => 'Group 6',
				'id'         => 'numbered_items2',
				'type'       => 'group',
				'columns'    => 6,
//				'clone'      => true,
				'sort_clone' => true,
				'fields'     => array(
					array(
						'name'    => __( 'Col 9', 'indigo-metaboxes' ),
						'id'      => 'title2',
						'type'    => 'text',
						'class'   => 'big-text3',
						'columns' => 9,
					),
					array(
						'name'    => __( 'Col 3', 'indigo-metaboxes' ),
						'id'      => 'desc2',
						'type'    => 'text',
						'class'   => 'big-text4',
						'columns' => 3,
					),
				),
			),
		],
	];
	return $meta_boxes;
} );
