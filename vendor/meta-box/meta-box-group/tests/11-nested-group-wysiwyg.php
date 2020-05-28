<?php
/**
 * Check tinymce and quicktag when clone.
 */
add_filter( 'rwmb_meta_boxes', function ( $meta_boxes ) {
	$prefix       = '';
	$meta_boxes[] = array(
		'title'      => __( 'FAQ Questions Blocs', '_tk' ),
		'post_types' => array( 'page' ),
		'fields'     => array(
			array(
				'id'          => $prefix . 'FAQ_bloc',
				'type'        => 'group',
				'clone'       => true,
				'sort_clone'  => true,
				'collapsible' => true,
				'fields'      => array(
					array(
						'name' => __( 'Questions Bloc Title', '_tk' ),
						'id'   => $prefix . 'bloc_title',
						'type' => 'text',
					),
					array(
						'name'        => __( 'Questions', '_tk' ),
						'id'          => $prefix . 'question_bloc',
						'type'        => 'group',
						'clone'       => true,
						'sort_clone'  => true,
						'collapsible' => true,
						'fields'      => array(
							array(
								'name' => __( 'Title', '_tk' ),
								'id'   => $prefix . 'question_title',
								'type' => 'text',
							),
							array(
								'name' => __( 'Description', '_tk' ),
								'id'   => $prefix . 'question_desc',
								'type' => 'wysiwyg',
								'options' => [
									'media_buttons' => false,
									'teeny' => true,
								],
								'clone' => true,
							),
						),
					),
				),
			),
		),
	);
	return $meta_boxes;
} );
