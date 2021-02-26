<?php
add_filter( 'rwmb_meta_boxes', 'meta_box_group_demo_register' );

/**
 * Register meta boxes
 *
 * @param array $meta_boxes
 *
 * @return array
 */
function meta_box_group_demo_register( $meta_boxes )
{
	// Meta Box
	$meta_boxes[] = array(
		'title'  => __( 'Books', 'rwmb' ),

		'fields' => array(
			array(
				'id'         => 'chapters',
				'name'       => __( 'Chapters', 'rwmb' ),
				'type'       => 'group', // Group type
				'clone'      => true,    // Can be cloned?
				'sort_clone' => true,    // Sort clones?

				// List of child fields
				'fields'     => array(
					array(
						'name'    => __( 'Chapter Title', 'rwmb' ),
						'id'      => 'chapter_title',
						'type'    => 'text',
						'columns' => 6, // Display child field in grid columns
					),
					array(
						'name'    => __( 'Page', 'rwmb' ),
						'id'      => 'page',
						'type'    => 'number',
						'size'    => 5,
						'columns' => 6, // Display child field in grid columns
					),
				),
			),
			array(
				'id'     => 'authors',
				'name'   => __( 'Authors', 'rwmb' ),
				'type'   => 'group', // Group type
				'clone'  => true,

				// List of child fields
				'fields' => array(
					array(
						'name'    => __( 'Full Name', 'rwmb' ),
						'id'      => 'name',
						'type'    => 'text',
						'columns' => 4, // Display child field in grid columns
					),
					array(
						'name'    => __( 'Phone', 'rwmb' ),
						'id'      => 'phone',
						'type'    => 'text',
						'size'    => 10,
						'columns' => 4, // Display child field in grid columns
					),
					array(
						'name'    => __( 'Email', 'rwmb' ),
						'id'      => 'email',
						'type'    => 'email',
						'size'    => 15,
						'columns' => 4, // Display child field in grid columns
					),
				),
			),
		),
	);

	$meta_boxes[] = array(
		'title'  => __( 'Album Tracks' ),

		'fields' => array(
			array(
				'id'     => 'standard',
				'type'   => 'group',

				'fields' => array(
					array(
						'name' => __( 'Track name', 'rwmb' ),
						'id'   => 'text',
						'type' => 'text',
					),
					array(
						'name' => __( 'Release Date', 'rwmb' ),
						'id'   => 'date',
						'type' => 'date',
					),
					array(
						'name'    => __( 'Genre', 'rwmb' ),
						'id'      => 'genre',
						'type'    => 'select_advanced',
						'options' => array(
							'pop'  => __( 'Pop', 'rwmb' ),
							'rock' => __( 'Rock', 'rwmb' ),
						),
					),
				),

				// Clone whole group?
				'clone'  => true,
			),
		),
	);

	$meta_boxes[] = array(
		'title'  => __( 'Meta Box Demo: Group' ),

		'fields' => array(
			array(
				'name'   => __( 'Standard Fields', 'rwmb' ),
				'id'     => 'standard',
				'type'   => 'group',

				'fields' => array(
					// TEXT
					array(
						// Field name - Will be used as label
						'name' => __( 'Text', 'rwmb' ),
						// Field ID, i.e. the meta key
						'id'   => 'text',
						// Field description (optional)
						'desc' => __( 'Text description', 'rwmb' ),
						'type' => 'text',
						// Default value (optional)
						'std'  => __( 'Default text value', 'rwmb' ),
					),
					// CHECKBOX
					array(
						'name' => __( 'Checkbox', 'rwmb' ),
						'id'   => 'checkbox',
						'type' => 'checkbox',
						// Value can be 0 or 1
						'std'  => 1,
					),
					// RADIO BUTTONS
					array(
						'name'    => __( 'Radio', 'rwmb' ),
						'id'      => 'radio',
						'type'    => 'radio',
						// Array of 'value' => 'Label' pairs for radio options.
						// Note: the 'value' is stored in meta field, not the 'Label'
						'options' => array(
							'value1' => __( 'Label1', 'rwmb' ),
							'value2' => __( 'Label2', 'rwmb' ),
						),
					),
					// SELECT BOX
					array(
						'name'        => __( 'Select', 'rwmb' ),
						'id'          => 'select',
						'type'        => 'select',
						// Array of 'value' => 'Label' pairs for select box
						'options'     => array(
							'value1' => __( 'Label1', 'rwmb' ),
							'value2' => __( 'Label2', 'rwmb' ),
						),
						// Select multiple values, optional. Default is false.
						'multiple'    => false,
						'std'         => 'value2',
						'placeholder' => __( 'Select an Item', 'rwmb' ),
					),
					// HIDDEN
					array(
						'id'   => 'hidden',
						'type' => 'hidden',
						// Hidden field must have predefined value
						'std'  => __( 'Hidden value', 'rwmb' ),
					),
					// PASSWORD
					array(
						'name' => __( 'Password', 'rwmb' ),
						'id'   => 'password',
						'type' => 'password',
					),
					// TEXTAREA
					array(
						'name' => __( 'Textarea', 'rwmb' ),
						'desc' => __( 'Textarea description', 'rwmb' ),
						'id'   => 'textarea',
						'type' => 'textarea',
						'cols' => 20,
						'rows' => 3,
					),
				),

				// Clone whole group?
				'clone'  => true,
			),

			array(
				'name'   => __( 'Advanced Fields', 'rwmb' ),
				'id'     => 'advanced',
				'type'   => 'group',

				'fields' => array(
					// HEADING
					array(
						'type' => 'heading',
						'name' => __( 'Heading', 'rwmb' ),
						'id'   => 'fake_id', // Not used but needed for plugin
					),
					// SLIDER
					array(
						'name'       => __( 'Slider', 'rwmb' ),
						'id'         => 'slider',
						'type'       => 'slider',

						// Text labels displayed before and after value
						'prefix'     => __( '$', 'rwmb' ),
						'suffix'     => __( ' USD', 'rwmb' ),

						// jQuery UI slider options. See here http://api.jqueryui.com/slider/
						'js_options' => array(
							'min'  => 10,
							'max'  => 255,
							'step' => 5,
						),
					),
					// NUMBER
					array(
						'name' => __( 'Number', 'rwmb' ),
						'id'   => 'number',
						'type' => 'number',

						'min'  => 0,
						'step' => 5,
					),
					// DATE
					array(
						'name'       => __( 'Date picker', 'rwmb' ),
						'id'         => 'date',
						'type'       => 'date',

						// jQuery date picker options. See here http://api.jqueryui.com/datepicker
						'js_options' => array(
							'appendText'      => __( '(yyyy-mm-dd)', 'rwmb' ),
							'dateFormat'      => __( 'yy-mm-dd', 'rwmb' ),
							'changeMonth'     => true,
							'changeYear'      => true,
							'showButtonPanel' => true,
						),
					),
					// DATETIME
					array(
						'name'       => __( 'Datetime picker', 'rwmb' ),
						'id'         => 'datetime',
						'type'       => 'datetime',

						// jQuery datetime picker options.
						// For date options, see here http://api.jqueryui.com/datepicker
						// For time options, see here http://trentrichardson.com/examples/timepicker/
						'js_options' => array(
							'stepMinute'     => 15,
							'showTimepicker' => true,
						),
					),
					// TIME
					array(
						'name'       => __( 'Time picker', 'rwmb' ),
						'id'         => 'time',
						'type'       => 'time',

						// jQuery datetime picker options.
						// For date options, see here http://api.jqueryui.com/datepicker
						// For time options, see here http://trentrichardson.com/examples/timepicker/
						'js_options' => array(
							'stepMinute' => 5,
							'showSecond' => true,
							'stepSecond' => 10,
						),
					),
					// COLOR
					array(
						'name' => __( 'Color picker', 'rwmb' ),
						'id'   => 'color',
						'type' => 'color',
					),
					// CHECKBOX LIST
					array(
						'name'    => __( 'Checkbox list', 'rwmb' ),
						'id'      => 'checkbox_list',
						'type'    => 'checkbox_list',
						// Options of checkboxes, in format 'value' => 'Label'
						'options' => array(
							'value1' => __( 'Label1', 'rwmb' ),
							'value2' => __( 'Label2', 'rwmb' ),
						),
					),
					// EMAIL
					array(
						'name' => __( 'Email', 'rwmb' ),
						'id'   => 'email',
						'desc' => __( 'Email description', 'rwmb' ),
						'type' => 'email',
						'std'  => 'name@email.com',
					),
					// RANGE
					array(
						'name' => __( 'Range', 'rwmb' ),
						'id'   => 'range',
						'desc' => __( 'Range description', 'rwmb' ),
						'type' => 'range',
						'min'  => 0,
						'max'  => 100,
						'step' => 5,
						'std'  => 0,
					),
					// URL
					array(
						'name' => __( 'URL', 'rwmb' ),
						'id'   => 'url',
						'desc' => __( 'URL description', 'rwmb' ),
						'type' => 'url',
						'std'  => 'http://google.com',
					),
					// OEMBED
					array(
						'name' => __( 'oEmbed', 'rwmb' ),
						'id'   => 'oembed',
						'desc' => __( 'oEmbed description', 'rwmb' ),
						'type' => 'oembed',
					),
					// SELECT ADVANCED BOX
					array(
						'name'        => __( 'Select', 'rwmb' ),
						'id'          => 'select_advanced',
						'type'        => 'select_advanced',
						// Array of 'value' => 'Label' pairs for select box
						'options'     => array(
							'value1' => __( 'Label1', 'rwmb' ),
							'value2' => __( 'Label2', 'rwmb' ),
						),
						// Select multiple values, optional. Default is false.
						'multiple'    => false,
						// 'std'         => 'value2', // Default value, optional
						'placeholder' => __( 'Select an Item', 'rwmb' ),
					),
					// TAXONOMY
					array(
						'name'    => __( 'Taxonomy', 'rwmb' ),
						'id'      => 'taxonomy',
						'type'    => 'taxonomy',
						'options' => array(
							// Taxonomy name
							'taxonomy' => 'category',
							// How to show taxonomy: 'checkbox_list' (default) or 'checkbox_tree', 'select_tree', select_advanced or 'select'. Optional
							'type'     => 'checkbox_list',
							// Additional arguments for get_terms() function. Optional
							'args'     => array()
						),
					),
					// POST
					array(
						'name'       => __( 'Posts (Pages)', 'rwmb' ),
						'id'         => 'pages',
						'type'       => 'post',

						// Post type
						'post_type'  => 'page',
						// Field type, either 'select' or 'select_advanced' (default)
						'field_type' => 'select_advanced',
						// Query arguments (optional). No settings means get all published posts
						'query_args' => array(
							'post_status'    => 'publish',
							'posts_per_page' => '-1',
						)
					),
					// WYSIWYG/RICH TEXT EDITOR
					array(
						'name'    => __( 'WYSIWYG / Rich Text Editor', 'rwmb' ),
						'id'      => 'wysiwyg',
						'type'    => 'wysiwyg',
						// Set the 'raw' parameter to TRUE to prevent data being passed through wpautop() on save
						'raw'     => false,
						'std'     => __( 'WYSIWYG default value', 'rwmb' ),

						// Editor settings, see wp_editor() function: look4wp.com/wp_editor
						'options' => array(
							'textarea_rows' => 4,
							'teeny'         => true,
							'media_buttons' => false,
						),
					),
				)
			),
		),
	);

	// Meta Box
	$meta_boxes[] = array(
		'title'  => __( 'Meta Box Demo: Group + Columns', 'rwmb' ),

		'fields' => array(
			array(
				'name'   => __( 'Contact Info', 'rwmb' ),
				'id'     => 'contact',
				'type'   => 'group', // Group type

				// List of child fields
				'fields' => array(
					array(
						'name'    => __( 'First Name', 'rwmb' ),
						'id'      => 'first_name',
						'type'    => 'text',
						'columns' => 6, // Display child field in grid columns
					),
					array(
						'name'    => __( 'Last Name', 'rwmb' ),
						'id'      => 'last_name',
						'type'    => 'text',
						'columns' => 6, // Display child field in grid columns
					),
					array(
						'name'    => __( 'Email', 'rwmb' ),
						'id'      => 'email',
						'type'    => 'email',
						'columns' => 6, // Display child field in grid columns
					),
					array(
						'name'    => __( 'Gender', 'rwmb' ),
						'id'      => 'gender',
						'type'    => 'radio',
						'options' => array(
							'm' => __( 'Male', 'rwmb' ),
							'f' => __( 'Female', 'rwmb' ),
						),
						'columns' => 6, // Display child field in grid columns
					),
					array(
						'name'    => __( 'Description', 'rwmb' ),
						'id'      => 'description',
						'type'    => 'wysiwyg',
						'columns' => 12, // Display child field in grid columns
						'options' => array(
							'teeny'         => true,
							'media_buttons' => false,
							'quicktags'     => false,
						),
					),
					array(
						'name'    => __( 'Other Notes', 'rwmb' ),
						'id'      => 'notes',
						'type'    => 'textarea',
						'columns' => 12, // Display child field in grid columns
					),
				),
			),
			array(
				'name'   => __( 'Address', 'rwmb' ),
				'id'     => 'full_address',
				'type'   => 'group', // Group type

				// List of child fields
				'fields' => array(
					array(
						'name'    => __( 'Street', 'rwmb' ),
						'id'      => 'street',
						'type'    => 'text',
						'columns' => 4, // Display child field in grid columns
					),
					array(
						'name'    => __( 'City', 'rwmb' ),
						'id'      => 'city',
						'type'    => 'text',
						'columns' => 4, // Display child field in grid columns
					),
					array(
						'name'    => __( 'State', 'rwmb' ),
						'id'      => 'state',
						'type'    => 'select',
						'options' => array(
							'ny' => __( 'New York', 'rwmb' ),
							'wa' => __( 'Washington', 'rwmb' ),
							'ci' => __( 'Chicago', 'rwmb' ),
						),
						'columns' => 4, // Display child field in grid columns
					),
					array(
						'name'          => __( 'Google Maps', 'rwmb' ),
						'id'            => 'map',
						'type'          => 'map',
						'address_field' => 'street,city,state',
						'style'         => 'width: 100%; height: 200px',
						'columns'       => 12, // Display child field in grid columns
					),
				),
			),
		),
	);


	return $meta_boxes;
}
