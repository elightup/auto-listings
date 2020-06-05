<?php
add_filter( 'mb_settings_pages', function ( $settings_pages ) {
	$settings_pages[] = array(
		'id'          => 'pencil',
		'option_name' => 'pencil',
		'menu_title'  => 'Pencil',
		'icon_url'    => 'dashicons-edit',
		'style'       => 'no-boxes',
		'columns'     => 1,
		'tabs'        => array(
			'general' => array(
				'label' => 'General Settings',
				'icon'  => 'dashicons-admin-settings',
			),
			'design'  => array(
				'label' => 'Design Customization',
				'icon'  => 'dashicons-admin-customizer',
			),
			'faq'    => array(
				'label' => 'FAQ & Help',
				'icon'  => 'http://i.imgur.com/nJtag1q.png',
			),
		),
		'tab_style'   => 'left',
	);
	return $settings_pages;
} );

add_filter( 'rwmb_meta_boxes', function ( $meta_boxes ) {
	$meta_boxes[] = array(
		'id'             => 'general',
		'title'          => 'General',
		'settings_pages' => 'pencil',
		'tab'            => 'general',
		'fields' => array(
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
					'sidebar-left'  => 'https://i.imgur.com/Y2sxQ2R.png',
					'sidebar-right' => 'https://i.imgur.com/h7ONxhz.png',
					'no-sidebar'    => 'https://i.imgur.com/m7oQKvk.png',
				),
			),
		),
		'validation' => [
			'rules' => [
				'logo' => 'required',
			],
		],
	);
	$meta_boxes[] = array(
		'id'             => 'colors',
		'title'          => 'Colors',
		'settings_pages' => 'pencil',
		'tab'            => 'design',
		'fields' => array(
			array(
				'name' => 'Heading Color',
				'id'   => 'heading-color',
				'type' => 'color',
			),
			array(
				'name' => 'Text Color',
				'id'   => 'text-color',
				'type' => 'color',
			),
			array(
				'name' => 'Footer Text',
				'id'   => 'footer_text',
			),
		),
		'validation' => [
			'rules' => [
				'footer_text' => 'required',
			],
		],
	);
	$meta_boxes[] = array(
		'id'             => 'info',
		'title'          => 'Theme Info',
		'settings_pages' => 'pencil',
		'tab'            => 'faq',
		'fields'         => array(
			array(
				'type' => 'custom_html',
				'std'  => 'Having questions? Check out our documentation',
			),
		),
	);
	return $meta_boxes;
} );
