<?php
/**
 * Test group with WYSIWYG in settings page.
 * Check: if content of WYSIWYG after saving is rendered correctly.
 */

// Register settings page. In this case, it's a theme options page
add_filter( 'mb_settings_pages', function ( $settings_pages ) {
	$settings_pages[] = array(
		'id'          => 'theme-slug',
		'option_name' => 'theme_slug',
		'menu_title'  => __( 'Theme Options', 'textdomain' ),
		'parent'      => 'themes.php',
	);

	return $settings_pages;
} );

// Register meta boxes and fields for settings page
add_filter( 'rwmb_meta_boxes', function ( $meta_boxes ) {
	$meta_boxes[] = array(
		'id'             => 'general',
		'title'          => __( 'General', 'textdomain' ),
		'settings_pages' => 'theme-slug',
		'fields'         => array(
			array(
				'name'   => 'Group',
				'id'     => 'group2',
				'type' => 'group',
				'clone'  => true,
				'fields' => [
					array(
						'name'    => __( 'Author Bio', 'indigo-options' ),
						'id'      => 'bio2',
						'desc'    => __( 'Enter the text for this panel', 'indigo-metaboxes' ),
						'type'    => 'wysiwyg',
						'raw'     => false,
						'options' => array(
							'textarea_rows' => 3,
							'teeny'         => true,
							'media_buttons' => false,
						),
						'columns' => '6',
					),
				],
			),

		),
	);

	return $meta_boxes;
} );
