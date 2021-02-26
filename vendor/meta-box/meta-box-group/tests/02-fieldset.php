<?php
add_filter( 'rwmb_meta_boxes', function ( $meta_boxes )
{
	$meta_boxes[] = [
		'title'  => 'Test',
		'fields' => [
			array(
				'id'      => 'group',
				'type'    => 'group',
				'clone'   => true,
				'fields'  => array(
					array(
						'id'      => 'fieldset_text',
						'name'    => __( 'Fieldset Text', 'your-prefix' ),
						'type'    => 'fieldset_text',
						'desc'    => __( 'Please enter following details:', 'your-prefix' ),
						'rows'    => 3,
						'options' => array(
							'name'    => __( 'Name', 'your-prefix' ),
							'address' => __( 'Address', 'your-prefix' ),
							'email'   => __( 'Email', 'your-prefix' ),
						),
					),
				),
			),
		],
	];
	return $meta_boxes;
} );
