<?php
add_filter( 'rwmb_meta_boxes', function ( $meta_boxes ) {
	$meta_boxes[] = [
		'title'  => 'Validation',
		'id'     => 'validation',
		'fields' => [
			'Text',
			[
				'id'       => 'text2',
				'name'     => 'Text2',
				'required' => true,
			],
		],
		// 'validation' => [
		// 	'rules' => [
		// 		'text' => ['required' => true],
		// 	]
		// ],
	];
	return $meta_boxes;
} );