<?php
/**
 * Nested group clone not work.
 */

add_filter( 'mb_settings_pages', function ( $settings_pages ) {
	$settings_pages[] = array(
		'id'          => 'theme-slug',
		'option_name' => 'theme_slug',
		'menu_title'  => __( 'Theme Options', 'textdomain' ),
		'parent'      => 'themes.php',
	);

	return $settings_pages;
} );

function your_prefix_register_meta_boxes( $meta_boxes ) {
	$meta_boxes[] = array(
		'title'  => 'Nested',
		'settings_pages' => 'theme-slug',
		'fields' => array(
			array(
				'name'  => 'Text 1',
				'id'    => 'text1',
				'type'  => 'text',
				'clone' => true,
			),
			array(
				'name'  => 'Text 2',
				'id'    => 'text2',
				'type'  => 'text',
			),
			array(
				'name'   => 'Sort',
				'id'     => 'group',
				'type'   => 'group',
				'clone'  => true,
				'fields' => array(
					array(
						'name'  => 'Text',
						'id'    => 'text',
						'type'  => 'text',
						'clone' => true,
					),
					array(
						'id'     => 'group2',
						'type'   => 'group',
						'clone'  => true,
						'sort_clone' => true,
						'fields' => array(
							array(
								'name'  => 'Text',
								'id'    => 'text2',
								'type'  => 'text',
								'clone' => true,
								'sort_clone' => true,
							),
						),
					),
				),
			),
		),
	);
	return $meta_boxes;
}
add_filter( 'rwmb_meta_boxes', 'your_prefix_register_meta_boxes' );
