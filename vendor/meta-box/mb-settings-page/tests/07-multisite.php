<?php
add_filter( 'mb_settings_pages', function ( $settings_pages ) {
	$settings_pages[] = array(
		'id'          => 'test',
		'option_name' => 'test',
		'menu_title'  => 'Test',
		'network'     => true,
	);

	return $settings_pages;
} );

add_filter( 'rwmb_meta_boxes', function ( $meta_boxes ) {
	$meta_boxes[] = array(
		'id'             => 'general2',
		'title'          => 'General',
		'settings_pages' => 'test',
		'fields'         => array(
			array(
				'name' => 'Logo',
				'id'   => 'logo',
				'type' => 'file_input',
			),
			array(
				'name'    => 'Layout',
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
		'id'             => 'colors2',
		'title'          => 'Colors',
		'settings_pages' => 'test',
		'fields'         => array(
			array(
				'name' => 'Heading Color',
				'id'   => 'heading-color',
				'type' => 'color',
			),
			array(
				'name' => 'Image',
				'id'   => 'img',
				'type' => 'image_advanced',
			),
		),
	);

	return $meta_boxes;
} );


add_action( 'wp_head', function () {
	$option = 'test';
	$fields = [ 'logo', 'layout', 'heading-color', 'img' ];
	foreach ( $fields as $field ) {
		echo '<h1>Field: ', $field, '</h1>';
		echo '<p><code>rwmb_meta()</code></p>';
		$value = rwmb_meta( $field, [ 'object_type' => 'network_setting' ], $option );
		var_dump( $value );
		echo '<p><code>rwmb_get_value()</code></p>';
		$value = rwmb_get_value( $field, [ 'object_type' => 'network_setting' ], $option );
		var_dump( $value );
		echo '<p><code>rwmb_the_value()</code></p>';
		rwmb_the_value( $field, [ 'object_type' => 'network_setting' ], $option );
		echo '<br><br><hr><br>';
	}
	// echo 'Done';
	// die;
} );

