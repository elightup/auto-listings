<?php
add_filter( 'rwmb_meta_boxes', function ( $meta_boxes ) {
	$meta_boxes[] = array(
		'id'         => 'dano-cerebral',
		'taxonomies' => 'category',
		'title'      => __( 'Preguntas', 'bateriabelieve' ),
		'fields'     => array(
			array(
				'type'    => 'group',
				'id'      => '200_113',
				'name'    => __( '¿Cuánto duró la pérdida de conocimiento?', 'bateriabelieve' ),
				'fields'  => array(
					array(
						'id'      => 'minutos',
						'name'    => __( 'Minutos', 'bateriabelieve' ),
						'type'    => 'number',
						'columns' => 2,
					),
					array(
						'id'      => 'horas',
						'name'    => __( 'Horas', 'bateriabelieve' ),
						'type'    => 'number',
						'columns' => 2,
					),
					array(
						'id'      => 'dias',
						'name'    => __( 'Días', 'bateriabelieve' ),
						'type'    => 'number',
						'columns' => 2,
					),
				),
				'columns' => 12,
			),
			array(
				'type'    => 'radio',
				'id'      => '200_114',
				'name'    => __( 'Aproximadamente, ¿cuántas veces le ha sucedido esto?', 'bateriabelieve' ),
				'options' => array(
					"1" => __( "1", 'bateriabelieve' ),
					"2" => __( "2", 'bateriabelieve' ),
				),
				'columns' => 12,
			),

			array(
				'type'    => 'file_advanced',
				'id'      => '200_122',
				'name'    => __( '¿Cómo fue eso para usted? ¿Qué se siente al estar mareada?', 'bateriabelieve' ),
				'columns' => 12,
			),
			array(
				'type'    => 'group',
				'id'      => '200_123',
				'name'    => __( '¿Cuándo pasó eso?', 'bateriabelieve' ),
				'fields'  => array(
					array(
						'type'    => 'select',
						'id'      => 'mes',
						'name'    => __( 'Mes', 'bateriabelieve' ),
						'columns' => 2,
						'options' => array(
							""  => __( 'Seleccionar', 'bateriabelieve' ),
							'1' => __( 'Enero', 'bateriabelieve' ),
							'2' => __( 'Febrero', 'bateriabelieve' ),
						),
					),
					array(
						'type'    => 'number',
						'id'      => 'agno',
						'name'    => __( 'Año', 'bateriabelieve' ),
						'columns' => 2,
					),
				),
				'columns' => 12,
			),
			array(
				'type'    => 'group',
				'id'      => '200_124',
				'name'    => __( '¿Cuánto duró el mareo?', 'bateriabelieve' ),
				'fields'  => array(
					array(
						'id'      => 'minutos',
						'name'    => __( 'Minutos', 'bateriabelieve' ),
						'type'    => 'number',
						'columns' => 2,
					),
					array(
						'id'      => 'horas',
						'name'    => __( 'Horas', 'bateriabelieve' ),
						'type'    => 'number',
						'columns' => 2,
					),
					array(
						'id'      => 'dias',
						'name'    => __( 'Días', 'bateriabelieve' ),
						'type'    => 'number',
						'columns' => 2,
					),
					array(
						'id'      => 'meses',
						'name'    => __( 'Meses', 'bateriabelieve' ),
						'type'    => 'number',
						'columns' => 2,
					),
					array(
						'id'      => 'agnos',
						'name'    => __( 'Años', 'bateriabelieve' ),
						'type'    => 'number',
						'columns' => 2,
					),
				),
				'columns' => 12,
			),
			array(
				'type'    => 'radio',
				'id'      => '200_125',
				'name'    => __( 'Aproximadamente, ¿cuántas veces le ha sucedido esto?', 'bateriabelieve' ),
				'options' => array(
					"1"     => __( "1", 'bateriabelieve' ),
					"2"     => __( "2", 'bateriabelieve' ),
					"3-5"   => __( "3-5", 'bateriabelieve' ),
					"6-10"  => __( "6-10", 'bateriabelieve' ),
					"11-16" => __( "11-16", 'bateriabelieve' ),
					"16<"   => __( "16<", 'bateriabelieve' ),
				),
				'visible' => array( '200_120', '=', 1 ),
				'columns' => 12,
				'si2'     => array(
					'required' => true,
				),
			),
			array(
				'type'    => 'group',
				'id'      => '200_126',
				'name'    => __( '¿Cuándo fue la <u>primera</u> vez que le sucedió?', 'bateriabelieve' ),
				'fields'  => array(
					array(
						'type'    => 'select',
						'id'      => 'mes',
						'name'    => __( 'Mes', 'bateriabelieve' ),
						'columns' => 2,
						'options' => array(
							""   => __( 'Seleccionar', 'bateriabelieve' ),
							'1'  => __( 'Enero', 'bateriabelieve' ),
							'2'  => __( 'Febrero', 'bateriabelieve' ),
							'3'  => __( 'Marzo', 'bateriabelieve' ),
							'4'  => __( 'Abril', 'bateriabelieve' ),
							'5'  => __( 'Mayo', 'bateriabelieve' ),
							'6'  => __( 'Junio', 'bateriabelieve' ),
							'7'  => __( 'Julio', 'bateriabelieve' ),
							'8'  => __( 'Agosto', 'bateriabelieve' ),
							'9'  => __( 'Septiembre', 'bateriabelieve' ),
							'10' => __( 'Octubre', 'bateriabelieve' ),
							'11' => __( 'Noviembre', 'bateriabelieve' ),
							'12' => __( 'Diciembre', 'bateriabelieve' ),
						),
					),
					array(
						'type'    => 'number',
						'id'      => 'agno',
						'name'    => __( 'Año', 'bateriabelieve' ),
						'columns' => 2,
						'min'     => date( 'Y' ) - 100,
						'max'     => date( 'Y' ),
					),
				),
				'columns' => 12,
				'visible' => array( '200_120', '=', 1 ),
				'si2'     => array(
					'required' => true,
				),
			),
			array(
				'type'    => 'group',
				'id'      => '200_127',
				'name'    => __( '¿Cuándo fue la <u>última</u> vez que le sucedió?', 'bateriabelieve' ),
				'fields'  => array(
					array(
						'type'    => 'select',
						'id'      => 'mes',
						'name'    => __( 'Mes', 'bateriabelieve' ),
						'columns' => 2,
						'options' => array(
							""   => __( 'Seleccionar', 'bateriabelieve' ),
							'1'  => __( 'Enero', 'bateriabelieve' ),
							'2'  => __( 'Febrero', 'bateriabelieve' ),
							'3'  => __( 'Marzo', 'bateriabelieve' ),
							'4'  => __( 'Abril', 'bateriabelieve' ),
							'5'  => __( 'Mayo', 'bateriabelieve' ),
							'6'  => __( 'Junio', 'bateriabelieve' ),
							'7'  => __( 'Julio', 'bateriabelieve' ),
							'8'  => __( 'Agosto', 'bateriabelieve' ),
							'9'  => __( 'Septiembre', 'bateriabelieve' ),
							'10' => __( 'Octubre', 'bateriabelieve' ),
							'11' => __( 'Noviembre', 'bateriabelieve' ),
							'12' => __( 'Diciembre', 'bateriabelieve' ),
						),
					),
					array(
						'type'    => 'number',
						'id'      => 'agno',
						'name'    => __( 'Año', 'bateriabelieve' ),
						'columns' => 2,
						'min'     => date( 'Y' ) - 100,
						'max'     => date( 'Y' ),
					),
				),
				'columns' => 12,
				'visible' => array( '200_120', '=', 1 ),
				'desc'    => __( "[Si responde que no a la pregunta anterior o no responde, considere investigar según la información de gravedad del abuso (por ejemplo, si te informó que le dió un puñetazo repetido en la cabeza)]", 'bateriabelieve' ),
				'si2'     => array(
					'required' => true,
				),
			),

			array(
				'type'    => 'radio',
				'id'      => '200_130',
				'name'    => __( 'Aproximadamente, ¿cuántas veces le ha sucedido esto?', 'bateriabelieve' ),
				'options' => array(
					"1"     => __( "1", 'bateriabelieve' ),
					"2"     => __( "2", 'bateriabelieve' ),
					"3-5"   => __( "3-5", 'bateriabelieve' ),
					"6-10"  => __( "6-10", 'bateriabelieve' ),
					"11-16" => __( "11-16", 'bateriabelieve' ),
					"16<"   => __( "16<", 'bateriabelieve' ),
				),
				'columns' => 12,
				'si2'     => array(
					'required' => true,
				),
			),

		),
		'columns'    => array(
			'column-1' => 2,
			'column-2' => 2,
			'column-3' => 2,
		),
		'validation' => array(
			'rules'    => array(),
			'messages' => array(),
		),
	);
	return $meta_boxes;
} );
