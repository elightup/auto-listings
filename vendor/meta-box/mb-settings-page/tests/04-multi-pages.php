<?php
/**
 * In this test, make sure rwmb_meta(), rwmb_get_value() and rwmb_the_value() runs correctly.
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
add_filter( 'mb_settings_pages', function ( $settings_pages ) {
	$settings_pages[] = array(
		'id'          => 'theme-slug2',
		'option_name' => 'theme_slug2',
		'menu_title'  => __( 'Theme Options 2', 'textdomain' ),
		'parent'      => 'themes.php',
	);

	return $settings_pages;
} );

add_filter( 'rwmb_meta_boxes', function ( $meta_boxes ) {
	$meta_boxes[] = array(
		'id'             => 'general2',
		'title'          => __( 'General', 'textdomain' ),
		'settings_pages' => array( 'theme-slug' ),
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
		'id'             => 'colors3',
		'title'          => __( 'Colors', 'textdomain' ),
		'settings_pages' => array( 'theme-slug', 'theme-slug2' ),
		'fields'         => array(
			array(
				'name' => __( 'Heading Color', 'textdomain' ),
				'id'   => 'heading-color',
				'type' => 'color',
			),
			array(
				'name' => __( 'Image', 'textdomain' ),
				'id'   => 'img',
				'type' => 'image_advanced',
			),
		),
	);

	return $meta_boxes;
} );


add_action( 'wp_head', function () {
	vd( rwmb_get_registry( 'field' ) );

	$settings_page_id = 'theme_slug';
	$fields = [ 'logo', 'layout', 'heading-color', 'img' ];
	foreach ( $fields as $field ) {
		echo '<h1>Field: ', $field, '</h1>';
		echo '<p><code>rwmb_meta()</code></p>';
		$value = rwmb_meta( $field, [ 'object_type' => 'setting' ], $settings_page_id );
		var_dump( $value );
		echo '<p><code>rwmb_get_value()</code></p>';
		$value = rwmb_get_value( $field, [ 'object_type' => 'setting' ], $settings_page_id );
		var_dump( $value );
		echo '<p><code>rwmb_the_value()</code></p>';
		rwmb_the_value( $field, [ 'object_type' => 'setting' ], $settings_page_id );
		echo '<br><br><hr><br>';
	}
	echo 'Done';
	die;
} );

