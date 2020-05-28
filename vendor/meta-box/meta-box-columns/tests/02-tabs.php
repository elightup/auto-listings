<?php
add_filter( 'rwmb_meta_boxes', 'meta_box_columns_test_tabs' );

/**
 * Register meta boxes
 *
 * @param array $meta_boxes Meta box array.
 *
 * @return array
 */
function meta_box_columns_test_tabs( $meta_boxes ) {
	// 1st Meta Box
	$meta_boxes[] = array(
		'id'     => 'test-columns-tabs',
		'title'  => __( 'Meta Box Columns Demo with tabs', 'rwmb' ),
		'taxonomies' => 'category',
		'tabs'   => array(
			'tab1' => __( 'Tab 1', 'rwmb' ),
			'tab2' => __( 'Tab 2', 'rwmb' ),
		),
		'columns' => array(
			'column-0' => 4,
			'column-1' => 8,
			'column-2' => array(
				'size' => 8,
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
				'tab'     => 'tab1',
			),
			array(
				'name'    => __( 'Twitter', 'rwmb' ),
				'id'      => 'twitter',
				'type'    => 'text',
				'column'  => 'column-0',
				'tab'     => 'tab1',
			),

			array(
				'name'    => __( 'Name', 'rwmb' ),
				'id'      => 'name',
				'type'    => 'text',
				'column'  => 'column-1',
				'tab'     => 'tab1',
			),
			array(
				'name'    => __( 'Email', 'rwmb' ),
				'id'      => 'email',
				'type'    => 'email',
				'column'  => 'column-1',
				'tab'     => 'tab1',
			),
			array(
				'name'    => __( 'Mobile', 'rwmb' ),
				'id'      => 'mobile',
				'type'    => 'text',
				'column'  => 'column-1',
				'tab'     => 'tab1',
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
				'tab'     => 'tab2',
			),
			array(
				'name'    => __( 'Zipcode', 'rwmb' ),
				'id'      => 'zipcode',
				'type'    => 'text',
				'column'  => 'column-2',
				'tab'     => 'tab2',
			),
			array(
				'name'    => __( 'Description', 'rwmb' ),
				'id'      => 'description',
				'type'    => 'textarea',
				'column'  => 'column-2',
				'tab'     => 'tab2',
			),

			array(
				'name'    => __( 'Google+', 'rwmb' ),
				'id'      => 'google',
				'type'    => 'text',
				'column'  => 'column-3',
				'tab'     => 'tab2',
			),
			array(
				'name'    => __( 'Facebook', 'rwmb' ),
				'id'      => 'facebook',
				'type'    => 'text',
				'column'  => 'column-3',
				'tab'     => 'tab2',
			),
		),
	);

	return $meta_boxes;
}
