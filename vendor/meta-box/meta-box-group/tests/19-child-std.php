<?php
/**
 * Allows to set 'std' for child fields from the upper group field.
 */
add_filter( 'rwmb_meta_boxes', function( $meta_boxes ) {
	$meta_boxes[] = array (
		'title' => 'Social link settings',
		'id'    => 'social',
		'fields' => array(
			array (
				'id' => 'social_links',
				'type' => 'group',
				'std' => array(
					array( 'title' => '500px', 'url' => '#' ),
					array( 'title' => 'Amazon', 'url' => '#' ),
					array( 'title' => 'Adn', 'url' => '#' )
				),
				'fields' => array(
					array (
						'id' => 'title',
						'type' => 'text',
						'name' => 'Title',
						// 'std' => 'So good',
					),
					array (
						'id' => 'url',
						'type' => 'text',
						'name' => 'URL',
					),
				),
				'clone' => true,
				'collapsible' => true,
				'add_button' => 'Add new social link',
				'group_title' => array( 'field' => 'name' ),
			),
		),
	);
	return $meta_boxes;
} );
