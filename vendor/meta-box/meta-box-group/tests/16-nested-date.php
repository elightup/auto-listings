<?php

function register_meta_boxes( $meta_boxes ) {
	$prefix = 'test_';
	$meta_boxes[] = array(
		'title'   => 'Linked Public Page',
		'fields' => array(
			array(
			'id'                => $prefix . 'dates',
			'name'              => __( 'Utbildningsort', 'textdomain' ),
			'label_description' => __( 'Välj stad och period för utbildningen.', 'textdomain' ),
			'type'              => 'group',
			'clone'             => true,
			'sort_clone'        => true,
			'collapsible'       => true,
			'group_title'       => array( 'field' => 'city' ),
			'save_state'        => true,
			'add_button'        => __( '+ Lägg till stad', 'textdomain' ),
			'fields'            => array(
				array(
					'name'              => esc_html__( 'Stad', 'textdomain' ),
					'id'                => 'city',
					'type'              => 'text',
					'std'               => false,
					'placeholder'       => __( 'Välj eller ange stad', 'textdomain' ),
					'size'              => 30,
					'datalist'          => array(
						'id'            => 'cities_datalist',
						'options'       => array(
							__( 'Örebro', 'textdomain' ),
							__( 'Västerås', 'textdomain' ),
							__( 'Linköping', 'textdomain' ),
							__( 'Kalmar', 'textdomain' ),
							__( 'Malmö', 'textdomain' ),
						),
					),
				),

				array(
					'name'              => __( 'Utbildningstillfälle', 'textdomain' ),
					'id'                => 'dates',
					'type'              => 'group',
					'clone'             => true,
					'add_button'        => __( '+ Lägg till ett tillfälle', 'textdomain' ),
					'label_description' => __( 'Detta är en beskrivning', 'textdomain' ),
					'fields'            => array(
						array(
							//'name'        => 'test',
							'id'            => 'days',
							'type'          => 'date',
							'inline'        => true,
							'js_options'    => array(
								'showButtonPanel'   => false,
							),
						),
					),
				),
			),
		),
		)
	);

	return $meta_boxes;
}
add_filter( 'rwmb_meta_boxes', 'register_meta_boxes' );
