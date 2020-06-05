<?php
/**
 * https://metabox.io/support/topic/image_upload-field-and-mb-settings-page/
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

add_filter( 'rwmb_meta_boxes', function ( $meta_boxes ) {
	$meta_boxes[] = array(
		'id'             => 'general',
		'title'          => __( 'General', 'textdomain' ),
		'settings_pages' => 'theme-slug',
		'fields'         => array(
			array(
				'name' => __( 'Layout', 'textdomain' ),
				'id'   => 'layout',
				'type' => 'image_advanced',
			),
		),
	);
	return $meta_boxes;
} );

add_action( 'wp_head', function () {
	$option = 'theme_slug';
	$value  = rwmb_meta( 'layout', [ 'object_type' => 'setting', 'size' => 'thumbnail', 'limit' => 1 ], $option );
	var_dump( $value );
	die;
}, 0 );

