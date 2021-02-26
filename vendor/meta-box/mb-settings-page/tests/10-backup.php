<?php
add_filter( 'mb_settings_pages', function ( $settings_pages ) {
	$settings_pages[] = array(
		'id'          => 'theme-slug',
		'option_name' => 'theme_slug',
		'menu_title'  => __( 'Theme Options', 'textdomain' ),
		'parent'      => 'themes.php',
		'network'     => true,
	);

	return $settings_pages;
} );
add_filter( 'rwmb_meta_boxes', function ( $meta_boxes ) {
	$meta_boxes[] = array(
		'id'             => 'general',
		'title'          => __( 'General', 'textdomain' ),
		'settings_pages' => 'theme-slug',
		'fields'         => array(
			array(
				'name' => __( 'Logo', 'textdomain' ),
				'id'   => 'logo',
				'type' => 'file_input',
			),
			array(
				'name'    => __( 'Layout', 'textdomain' ),
				'id'      => 'layout',
				'type'    => 'image_select',
				'options' => array(
					'sidebar-left'  => 'http://i.imgur.com/Y2sxQ2R.png',
					'sidebar-right' => 'http://i.imgur.com/h7ONxhz.png',
					'no-sidebar'    => 'http://i.imgur.com/m7oQKvk.png',
				),
			),
		),
	);
	$meta_boxes[] = array(
		'id'             => 'colors',
		'title'          => __( 'Colors', 'textdomain' ),
		'settings_pages' => 'theme-slug',
		'fields'         => array(
			array(
				'name' => __( 'Heading Color', 'textdomain' ),
				'id'   => 'heading-color',
				'type' => 'color',
			),
			array(
				'name' => __( 'Text Color', 'textdomain' ),
				'id'   => 'text-color',
				'type' => 'color',
			),
			[
				'name' => 'Backup',
				'type' => 'backup',
			],
		),
	);

	return $meta_boxes;
} );
