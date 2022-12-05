<?php
add_filter('rwmb_meta_boxes', function ($meta_boxes) {
	$meta_boxes[] = [
		'title'  => 'Columns with conditional logic',
		'id'     => 'columns-with-conditional-logic',
		'fields' => [
			[
				'id' => 'status',
				'name' => 'Status',
				'type' => 'select',
				'options' => [
					'scheduled' => 'Scheduled',
					'realized'  => 'Realized',
					'review'    => 'Review',
					'declined'  => 'Declined',
				],
			],
			array(
				'visible'    => array('status', 'in', array('scheduled', 'realized', 'review')),
				'name'       => 'Data da Consulta',
				'id'         => 'scheduled_to',
				'type'       => 'datetime',
				'attributes' => array(
					'required' => true,
				),
				'js_options' => array(
					'stepMinute'      => 15,
					'showTimepicker'  => true,
					'controlType'     => 'select',
					'showButtonPanel' => false,
					'oneLine'         => true,
				),
				'inline'    => false,
				'timestamp' => false,
				'tooltip'   => array(
					'icon'     => 'help',
					'content'  => esc_html__('Se for o caso, informe a data para a qual a consulta com o cliente foi agendada.', 'mercadoterra'),
					'position' => 'right',
				),
				'columns' => 6,
			),
			[
				'name' => 'Another Field',
				'columns' => 6,
			],
			[
				'name' => 'Another Field',
				'columns' => 6,
			],
			array(
				'visible' => array('status', 'in', array('scheduled', 'realized', 'review')),
				'name'    => 'Informe o local da consulta',
				'id'      => 'location',
				'type'    => 'textarea',
				'tooltip' => array(
					'icon'     => 'help',
					'content'  => esc_html__('Informe o endereço de forma detalhada onde será realizada a consulta. Caso seja na casa do cliente, informe "Em domicílio"', 'mercadoterra'),
					'position' => 'right',
				),
				'columns' => 6,
			),
			array(
				'visible' => array('status', '=', 'declined'),
				'name'    => 'Informe o motivo da desistência',
				'id'      => 'declined_by',
				'type'    => 'textarea',
				'tooltip' => array(
					'icon'     => 'help',
					'content'  => esc_html__('O motivo não será divulgado para o cliente e servirá para que possamos melhorar nosso serviço.', 'mercadoterra'),
					'position' => 'right',
				),
				'columns' => 12
			),
		],
	];
	return $meta_boxes;
});
