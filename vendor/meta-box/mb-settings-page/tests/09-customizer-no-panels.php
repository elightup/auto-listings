<?php
add_filter( 'rwmb_meta_boxes', function ( $meta_boxes ) {
	$meta_boxes[] = array(
		'id'                => 'general3',
		'title'             => __( 'General3', 'textdomain' ),

		// 'option_name'    => 'fasdf',
		'panel'             => '',

		'priority'          => 105,
		// 'capability'     => 'edit_theme_options',
		// 'theme_supports' => '', // Rarely needed.

		'fields'            => array(
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
		'id'     => 'colors3',
		'title'  => __( 'Colors3', 'textdomain' ),

		'panel'  => 'theme-slug',
		'option_name' => 'test',

		'fields' => array(
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
		),
	);

	return $meta_boxes;
} );

add_filter( 'the_content', function( $content ) {
	ob_start();
	echo '<h2>Theme Mods</h2>';
	$fields = ['logo', 'layout'];
	foreach ( $fields as $field ) {
		echo '<h4>', $field, '</h4>';
		$value = get_theme_mod( $field );
		echo $value, '<br>';
	}
	echo '<h2>Custom Option</h2>';
	$fields = ['heading-color', 'text-color'];
	foreach ( $fields as $field ) {
		echo '<h4>', $field, '</h4>';
		$value = rwmb_meta( $field, ['object_type' => 'setting'], 'test' );
		echo $value, '<br>';
	}
	$a = ob_get_clean();
	return $a . $content;
} );
