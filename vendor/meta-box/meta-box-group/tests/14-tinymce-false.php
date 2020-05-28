<?php
/**
 * If tinymce => false, check if quicktag works.
 */

function your_prefix_get_meta_box( $meta_boxes ) {
	$prefix = 'prefix-';

	$meta_boxes[] = array(
		'id' => 'untitled',
		'title' => esc_html__( 'Test Metabox', 'metabox-online-generator' ),
		'post_types' => array( 'post', 'page' ),
		'context' => 'advanced',
		'priority' => 'default',
		'autosave' => false,
		'fields' => array(
			array(
				'id' => 'partners',
				'type' => 'group',
				'clone' => true,
				'fields' => array(
					array(
						'id'    => "{$prefix}title",
						'class' => 'title',
						'type'  => 'text',
						'placeholder' => 'Partner',
					),
					array(
						'id'   => "{$prefix}contact",
						'type' => 'wysiwyg',
						'raw'  => true,
						'options' => array(
							'textarea_rows' => 7,
							'media_buttons' => false,
							'tinymce' => false,
						),
					),
				),
			),
		),
	);

	return $meta_boxes;
}
add_filter( 'rwmb_meta_boxes', 'your_prefix_get_meta_box' );