<?php
add_filter( 'rwmb_meta_boxes', function ( $meta_boxes ) {
	$meta_boxes[] = array (
		'title' => 'Category custom options',
		'id' => 'dmb-cat-single-options',
		'fields' => array(
			array (
				'id' => 'dmb_cat_group_top_page_content',
				'type' => 'group',
				'name' => 'Top page content',
				'fields' => array(
					// MAIN MENU
					array(
						'type' => 'heading',
						'name' => 'Main menu',
					),

					// [select] Show main menu yes no
					array (
						'id' => 'dmb_cat_main_menu_yesno',
						'name' => 'Show main menu?',
						'type' => 'select_advanced',
						'placeholder' => 'Select an Item',
						'options' => array(
							'yes' => 'Yes',
							'no' => 'No',
						),
						'std' => 'yes',
					),
					// [select] Custom main menu
					array (
						'id' => 'dmb_cat_main_menu_custom_yesno',
						'name' => 'Change default main menu?',
						'type' => 'select_advanced',
						'placeholder' => 'Choose',
						'options' => array(
							'yes' => 'Yes',
							'no' => 'No',
						),
						'std' => 'no',
						'hidden' => array( 'dmb_cat_main_menu_yesno', '=', 'no' ),
					),
					// [select] Main menu - menu select
					array (
						'id' => 'dmb_cat_main_menu_select',
						'name' => 'Select main menu',
						'type' => 'select_advanced',
						'placeholder' => 'Select a menu',
						'options' => array(
							'main' => 'Main menu',
							'footer' => 'Footer menu',
						),
						'visible' => array(
							array( 'dmb_cat_main_menu_yesno', '=', 'yes' ),
							array( 'dmb_cat_main_menu_custom_yesno', '=', 'yes' )
						),
					),

				),
				'default_state' => 'collapsed',
				'collapsible' => true,
				'group_title' => 'Top page content',
			),
		),
		'taxonomies' => array(
			0 => 'category',
		),
	);
	return $meta_boxes;
} );