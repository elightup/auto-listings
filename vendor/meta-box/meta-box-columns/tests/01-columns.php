<?php

/**
 * Register meta boxes
 *
 * @param array $meta_boxes
 *
 * @return array
 */
add_filter( 'rwmb_meta_boxes', function( $meta_boxes ) {
	// 1st Meta Box
	$meta_boxes[] = array(
		'id'     => 'test-columns',
		'title'  => __( 'Meta Box Columns Demo', 'rwmb' ),
		'taxonomies' => 'category',
		'columns' => array(
			'column-0' => 4,
			'column-1' => 4,
			'column-2' => array(
				'size' => 6,
				'class' => 'column-2-class',
			),
			'column-3' => 4,
		),
		'fields' => array(
			array(
				'name'    => __( 'Address', 'rwmb' ),
				'id'      => 'address',
				'type'    => 'text',
				'column'  => 'column-0',
			),
			array(
				'name'    => __( 'Twitter', 'rwmb' ),
				'id'      => 'twitter',
				'type'    => 'text',
				'column'  => 'column-0',
			),

			array(
				'name'    => __( 'Name', 'rwmb' ),
				'id'      => 'name',
				'type'    => 'text',
				'column'  => 'column-1',
			),
			array(
				'name'    => __( 'Email', 'rwmb' ),
				'id'      => 'email',
				'type'    => 'email',
				'column'  => 'column-1',
			),
			array(
				'name'    => __( 'Mobile', 'rwmb' ),
				'id'      => 'mobile',
				'type'    => 'text',
				'column'  => 'column-1',
			),

			array(
				'name'    => __( 'State', 'rwmb' ),
				'id'      => 'state',
				'type'    => 'select_advanced',
				'options' => array(
					'NY' => 'New York',
					'CA' => 'California',
				),
				'column'  => 'column-2',
			),
			array(
				'name'    => __( 'Zipcode', 'rwmb' ),
				'id'      => 'zipcode',
				'type'    => 'text',
				'column'  => 'column-2',
			),
			array(
				'name'    => __( 'Description', 'rwmb' ),
				'id'      => 'description',
				'type'    => 'textarea',
				'column'  => 'column-2',
			),

			array(
				'name'    => __( 'Google+', 'rwmb' ),
				'id'      => 'google',
				'type'    => 'text',
				'column'  => 'column-3',
			),
			array(
				'name'    => __( 'Facebook', 'rwmb' ),
				'id'      => 'facebook',
				'type'    => 'text',
				'column'  => 'column-3',
			),
		),
	);

	return $meta_boxes;
} );
