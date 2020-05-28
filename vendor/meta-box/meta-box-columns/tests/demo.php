<?php
add_filter( 'rwmb_meta_boxes', 'meta_box_columns_demo_register' );

/**
 * Register meta boxes
 *
 * @param array $meta_boxes
 *
 * @return array
 */
function meta_box_columns_demo_register( $meta_boxes )
{
	// 1st Meta Box
	$meta_boxes[] = array(
		'title'  => __( 'Meta Box Columns Demo', 'rwmb' ),
		'taxonomies' => 'category',

		// Works with Meta Box Tabs plugin
		'tabs'   => array(
			'contact' => __( 'Contact', 'rwmb' ),
			'social'  => __( 'Social Media', 'rwmb' ),
		),

		'fields' => array(
			array(
				'name'    => __( 'Name', 'rwmb' ),
				'id'      => 'name',
				'type'    => 'text',

				// Number of columns (in grid 12)
				'columns' => 4,

				'tab'     => 'contact',
			),
			array(
				'name'    => __( 'Email', 'rwmb' ),
				'id'      => 'email',
				'type'    => 'email',
				'columns' => 4,
				'tab'     => 'contact',
			),
			array(
				'name'    => __( 'Mobile', 'rwmb' ),
				'id'      => 'mobile',
				'type'    => 'text',
				'columns' => 4,
				'tab'     => 'contact',
			),
			array(
				'name'    => __( 'Address', 'rwmb' ),
				'id'      => 'address',
				'type'    => 'text',
				'columns' => 4,
				'tab'     => 'contact',
			),
			array(
				'name'    => __( 'State', 'rwmb' ),
				'id'      => 'state',
				'type'    => 'select_advanced',
				'options' => array(
					'NY' => 'New York',
					'CA' => 'California',
				),
				'columns' => 4,
				'tab'     => 'contact',
			),
			array(
				'name'    => __( 'Zipcode', 'rwmb' ),
				'id'      => 'zipcode',
				'type'    => 'text',
				'columns' => 4,
				'tab'     => 'contact',
			),
			array(
				'name'    => __( 'Description', 'rwmb' ),
				'id'      => 'description',
				'type'    => 'textarea',
				'columns' => 12,
				'tab'     => 'contact',
			),
			array(
				'name'    => __( 'Facebook', 'rwmb' ),
				'id'      => 'facebook',
				'type'    => 'text',
				'columns' => 4,
				'tab'     => 'social',
			),
			array(
				'name'    => __( 'Google+', 'rwmb' ),
				'id'      => 'google',
				'type'    => 'text',
				'columns' => 4,
				'tab'     => 'social',
			),
			array(
				'name'    => __( 'Twitter', 'rwmb' ),
				'id'      => 'twitter',
				'type'    => 'text',
				'columns' => 4,
				'tab'     => 'social',
			),
		),
	);

	return $meta_boxes;
}
