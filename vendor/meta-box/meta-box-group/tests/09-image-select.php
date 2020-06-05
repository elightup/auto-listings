<?php
add_filter( 'rwmb_meta_boxes', function ( $meta_boxes )
{
	$meta_boxes[] = array(
		'id'     => 'layout-content',
		'title'  => 'Contenido',
		'fields' => array(
			array(
				'name'   => 'Select Layout',
				'id'     => '_item_row',
				'type'   => 'group',
				'clone'  => true,
				'fields' => array(
					array(
						'name'     => 'Layout',
						'id'       => 'layout',
						'required' => true,
						'type'     => 'image_select',
						'options'  => array(
							'textimage' => 'http://placehold.it/80?text=1',
							'imagetext' => 'http://placehold.it/80?text=2',
							'onlytext'  => 'http://placehold.it/80?text=3',
							'onlyimage' => 'http://placehold.it/80?text=4',
						),
					),
					array(
						'name'    => 'Text',
						'id'      => 'item-text',
						'type'    => 'textarea',
						'cols'    => 1,
						'rows'    => 5,
						'visible' => array( 'layout', 'in', array( 'onlytext', 'textimage', 'imagetext' ) ),
					),
					array(
						'name'      => 'Images',
						'id'        => 'item-images',
						'type'      => 'file_advanced',
						'mime_type' => 'image',
						'visible'   => array( 'layout', 'in', array( 'onlyimage', 'textimage', 'imagetext' ) ),
					),
				),
			),
		),
	);
	return $meta_boxes;
} );
