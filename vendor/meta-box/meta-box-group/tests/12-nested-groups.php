<?php
/**
 * Test nested groups.
 *
 * @package    Meta Box
 * @subpackage Meta Box Group
 */

add_filter( 'rwmb_meta_boxes', function ( $meta_boxes ) {
	$meta_boxes[] = array(
		'title' => __( 'Books', 'rwmb' ),

		'fields' => array(
			array(
				'id'          => 'authors',
				'name'        => 'Clone + Collapse + (Sub groups collapse + clone)',
				'type'        => 'group',
				'clone'       => true,
				'collapsible' => true,
				'save_state'  => true,
				'group_title' => 'Author {#}',

				'fields' => array(
					array(
						'name'        => __( 'Full Name', 'rwmb' ),
						'id'          => 'name',
						'type'        => 'group',
						'columns'     => 4, // Display child field in grid columns.
						'collapsible' => true,
						'save_state'  => true,
						'group_title' => [ 'field' => 'first_name' ],
						'clone'       => true,
						'sort_clone'  => true,

						'fields' => array(
							[
								'id'   => 'first_name',
								'name' => 'First Name',
								'type' => 'text',
								'std'  => 'Test name',
							],
							[
								'id'   => 'last_name',
								'name' => 'Last Name',
								'type' => 'text',
							],
						),
					),
					array(
						'name'    => __( 'Phone', 'rwmb' ),
						'id'      => 'phone',
						'type'    => 'text',
						'size'    => 10,
						'columns' => 4, // Display child field in grid columns.
						'std'     => '123123',
					),
					array(
						'name'    => __( 'Email', 'rwmb' ),
						'id'      => 'email',
						'type'    => 'email',
						'size'    => 15,
						'columns' => 4, // Display child field in grid columns.
					),
				),
			),

			array(
				'id'          => 'authors2',
				'name'        => 'Sub groups collapse + clone',
				'type'        => 'group',
				'collapsible' => true,
				'fields' => array(
					array(
						'name'        => __( 'Full Name', 'rwmb' ),
						'id'          => 'name2',
						'type'        => 'group',
						'columns'     => 4, // Display child field in grid columns.
						'collapsible' => true,
						'save_state'  => true,
						'group_title' => [ 'field' => 'first_name2' ],
						'clone'       => true,
						'sort_clone'  => true,

						'fields' => array(
							[
								'id'   => 'first_name2',
								'name' => 'First Name',
								'type' => 'text',
								'std'  => 'Test name',
							],
							[
								'id'   => 'last_name2',
								'name' => 'Last Name',
								'type' => 'text',
							],
						),
					),
					array(
						'name'    => __( 'Phone', 'rwmb' ),
						'id'      => 'phone2',
						'type'    => 'text',
						'size'    => 10,
						'columns' => 4, // Display child field in grid columns.
						'std'     => '123123',
					),
					array(
						'name'    => __( 'Email', 'rwmb' ),
						'id'      => 'email2',
						'type'    => 'email',
						'size'    => 15,
						'columns' => 4, // Display child field in grid columns.
					),
				),
			),
		),
	);

	return $meta_boxes;
} );
