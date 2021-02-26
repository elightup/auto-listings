<?php
add_filter( 'mb_settings_pages', function ( $settings_pages ) {
	$settings_pages[] = array(
		'id'              => 'theme-slug',
		'option_name'     => 'theme_slug',
		'menu_title'      => __( 'Theme Options', 'textdomain' ),
		'parent'          => 'themes.php',
		'customizer'      => true,
		'customizer_only' => true,
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
		),
	);

	$meta_boxes[] = array(
		'id'             => 'info',
		'title'          => __( 'Theme Info', 'textdomain' ),
		'context'        => 'side',
		'settings_pages' => 'theme-slug',
		'fields'         => array(
			array(
				'type' => 'custom_html',
				'std'  => '<img src="http://placehold.it/260x150?text=Thumbnail">' . __( '<strong>%Name%</strong> is a responsive theme for businesses and agencies. Built with HTML5, SASS and other latest technologies.<br><br><a href="http://domain.com" target="_blank" class="button-primary">Learn more</a>', 'textdomain' ),
			),
		),
	);

	return $meta_boxes;
} );

add_filter( 'the_content', function( $content ) {
	ob_start();
	echo '<h2>Settings</h2>';
	$fields = ['logo', 'layout', 'heading-color', 'text-color'];
	foreach ( $fields as $field ) {
		echo '<h4>', $field, '</h4>';
		$value = rwmb_meta( $field, [ 'object_type' => 'setting' ], 'theme_slug' );
		echo $value, '<br>';
	}
	$a = ob_get_clean();
	return $a . $content;
} );

/*
add_action( 'customize_register', function ($wp_customize) {
    $wp_customize->add_section( 'themename_color_scheme', array(
	    'title'          => __( 'Color Scheme', 'themename' ),
	    'priority'       => 35,
	) );
	$wp_customize->add_setting( 'themename_theme_options[color_scheme]', array(
	    'default'        => 'some-default-value',
	    'type'           => 'option',
	    'capability'     => 'edit_theme_options',
	) );
	$wp_customize->add_control( 'themename_color_scheme', array(
	    'label'      => __( 'Color Scheme', 'themename' ),
	    'section'    => 'themename_color_scheme',
	    'settings'   => 'themename_theme_options[color_scheme]',
	    'type'       => 'radio',
	    'choices'    => array(
	        'value1' => 'Choice 1',
	        'value2' => 'Choice 2',
	        'value3' => 'Choice 3',
	        ),
	) );
});
add_filter( 'the_content', function( $content ) {
	ob_start();
	$option = get_option( 'themename_theme_options' );
	print_r( $option );
	$a = ob_get_clean();
	return $a . $content;
} );
*/