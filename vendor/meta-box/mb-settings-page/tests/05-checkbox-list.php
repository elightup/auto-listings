<?php
add_filter( 'mb_settings_pages', 'swd_options_page' );
function swd_options_page( $settings_pages ) {

	$settings_pages[] = array(
		'id'          => 'swd-theme-settings',
		'option_name' => 'swd_theme_settings',
		'menu_title'  => __( 'Theme Settings', 'swd' ),
		'parent'      => 'themes.php',
		'style'       => 'no-boxes',
		'columns'     => 1,
		'tabs'        => array(
			'content' => __( 'Content Structure', 'swd' ),
			'layout'  => __( 'Layout', 'swd' ),
			'faq'     => __( 'FAQ & Help', 'swd' ),
		),
	);

	return $settings_pages;
}

add_filter( 'rwmb_meta_boxes', 'swd_options_meta_boxes' );
function swd_options_meta_boxes( $meta_boxes ) {
	$prefix       = 'swd_';
	$meta_boxes[] = array(
		'id'             => 'swd_content',
		'title'          => __( 'Content Structue', 'swd' ),
		'settings_pages' => 'swd-theme-settings',
		'tab'            => 'content',

		'fields' => array(
			[
				'type' => 'group',
				'id' => 'g',
				'collapsible' => true,
				'clone' => true,
				'fields' => [
					array(
						'id'      => $prefix . 'sections',
						'name'    => esc_html__( 'Sections', 'swd' ),
						'type'    => 'checkbox_list',
						'desc'    => esc_html__( 'Check or uncheck to enable or disable sections', 'swd' ),
						'options' => array(
							'gallery'      => 'Gallery',
							'portfolio'    => 'Portfolio',
							'services'     => 'Services',
							'testimonials' => 'Testimonials',
							'timeline'     => 'Timeline',
							'slides'       => 'Slides',
							'profiles'     => 'Profiles',
							'brands'       => 'Brands',
						),
						'std'     => array(
							'brands',
						),
						'select_all_none' => true,
					),
				],
			],
			array(
				'id'      => $prefix . 'sections2',
				'name'    => esc_html__( 'Sections', 'swd' ),
				'type'    => 'checkbox_list',
				'desc'    => esc_html__( 'Check or uncheck to enable or disable sections', 'swd' ),
				'options' => array(
					'gallery'      => 'Gallery',
					'portfolio'    => 'Portfolio',
					'services'     => 'Services',
					'testimonials' => 'Testimonials',
					'timeline'     => 'Timeline',
					'slides'       => 'Slides',
					'profiles'     => 'Profiles',
					'brands'       => 'Brands',
				),
				'std'     => array(
					'brands',
				),
				'select_all_none' => true,
			),
			array(
				'id'      => 'cat',
				'name'    => esc_html__( 'Categories', 'swd' ),
				'type'    => 'taxonomy_advanced',
				'taxonomy' => 'category',
				'multiple' => true,
			),
		),
	);
	return $meta_boxes;
}
