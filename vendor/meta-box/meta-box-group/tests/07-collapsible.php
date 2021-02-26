<?php
/**
 * Test style of collapsible groups.
 *
 * @package    Meta Box
 * @subpackage Meta Box Group
 */

add_filter( 'rwmb_meta_boxes', function ( $meta_boxes ) {
	// Clone groups.
	$meta_boxes[] = array(
		'title'  => 'Clone',
		'fields' => array(

			// Group 1: clone + sort + collapse.
			array(
				'id'            => 'g1',
				'name'          => 'Clone + Sort + Collapse + Default Group Title',
				'type'          => 'group',
				'clone'         => true,
				'sort_clone'    => true,
				'collapsible'   => true,
				'save_state'    => true,
				'default_state' => 'collapsed',
				'group_title'   => 'Entry {#}',

				'fields' => array(
					array(
						'name' => 'Text1a',
						'id'   => 'text1a',
						'type' => 'text',
					),
					array(
						'name' => 'Text1b',
						'id'   => 'text1b',
						'type' => 'text',
					),
				),
			),

			// Group 1b: clone + sort + collapse + sub-field group title.
			array(
				'id'          => 'g1b',
				'name'        => 'Clone + Sort + Collapse + Sub-field Group Title',
				'type'        => 'group',
				'clone'       => true,
				'sort_clone'  => true,
				'collapsible' => true,
				'group_title' => 'Field: {text1ba} - {text1bb}',

				'fields' => array(
					array(
						'name' => 'Text1ba',
						'id'   => 'text1ba',
						'type' => 'text',
					),
					array(
						'name' => 'Text1bb',
						'id'   => 'text1bb',
						'type' => 'text',
					),
				),
			),

			// Group 2: clone + sort.
			array(
				'id'          => 'g2',
				'name'        => 'Clone + Sort',
				'type'        => 'group',
				'clone'       => true,
				'sort_clone'  => true,
				'collapsible' => false,

				'fields' => array(
					array(
						'name' => 'Text2a',
						'id'   => 'text2a',
						'type' => 'text',
					),
					array(
						'name' => 'Text2b',
						'id'   => 'text2b',
						'type' => 'text',
					),
				),
			),

			// Group 3: clone + collapsible.
			array(
				'id'          => 'g3',
				'name'        => 'Clone + Collapsible',
				'type'        => 'group',
				'clone'       => true,
				'sort_clone'  => false,
				'collapsible' => true,

				'fields' => array(
					array(
						'name' => 'Text3a',
						'id'   => 'text3a',
						'type' => 'text',
					),
					array(
						'name' => 'Text3b',
						'id'   => 'text3b',
						'type' => 'text',
					),
				),
			),

			// Group 4: clone only.
			array(
				'id'          => 'g4',
				'name'        => 'Clone',
				'type'        => 'group',
				'clone'       => true,
				'sort_clone'  => false,
				'collapsible' => false,

				'fields' => array(
					array(
						'name' => 'Text4a',
						'id'   => 'text4a',
						'type' => 'text',
					),
					array(
						'name' => 'Text4b',
						'id'   => 'text4b',
						'type' => 'text',
					),
				),
			),
		),
	);

	// Non-clone groups.
	$meta_boxes[] = array(
		'title'  => 'No Clone',
		'fields' => array(

			// Group 7: collapsible.
			array(
				'id'          => 'g7',
				'name'        => 'Collapsible',
				'type'        => 'group',
				'clone'       => false,
				'sort_clone'  => false,
				'collapsible' => true,
				'group_title' => [ 'field' => 'text7a' ],

				'fields' => array(
					array(
						'name' => 'Text7a',
						'id'   => 'text7a',
						'type' => 'text',
					),
					array(
						'name' => 'Text7b',
						'id'   => 'text7b',
						'type' => 'text',
					),
				),
			),

			// Group 8: nothing.
			array(
				'id'          => 'g8',
				'name'        => 'Nothing',
				'type'        => 'group',
				'clone'       => false,
				'sort_clone'  => false,
				'collapsible' => false,

				'fields' => array(
					array(
						'name' => 'Text8a',
						'id'   => 'text8a',
						'type' => 'text',
					),
					array(
						'name' => 'Text8b',
						'id'   => 'text8b',
						'type' => 'text',
					),
				),
			),
		),
	);

	$meta_boxes[] = array(
		'title'  => 'Columns',
		'fields' => [
			[
				'name'        => 'Clone + Columns',
				'type'        => 'group',
				'id'          => 'gc',
				'collapsible' => true,
				'clone'       => true,
				'sort_clone'  => true,
				'fields'      => [
					[
						'type'    => 'text',
						'name'    => 'Name',
						'id'      => 'n',
						'columns' => 4,
					],
					[
						'type'    => 'text',
						'name'    => 'Phone',
						'id'      => 'p',
						'columns' => 4,
					],
					[
						'type'    => 'email',
						'name'    => 'Email',
						'id'      => 'e',
						'columns' => 4,
					],
				],
			],
			[
				'name'        => 'Non-Clone + Columns',
				'type'        => 'group',
				'id'          => 'gc2',
				'collapsible' => true,
				'fields'      => [
					[
						'type'    => 'text',
						'name'    => 'Name',
						'id'      => 'n2',
						'columns' => 4,
					],
					[
						'type'    => 'text',
						'name'    => 'Phone',
						'id'      => 'p2',
						'columns' => 4,
					],
					[
						'type'    => 'email',
						'name'    => 'Email',
						'id'      => 'e2',
						'columns' => 4,
					],
				],
			],
		],
	);

	return $meta_boxes;
} );
