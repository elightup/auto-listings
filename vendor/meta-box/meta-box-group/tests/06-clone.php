<?php
add_filter( 'rwmb_meta_boxes', function ( $meta_boxes )
{
	$meta_boxes[] = [
		'title'  => 'Non-clone group w/ clone fields',
		'fields' => [
			[
				'id'     => 'group1',
				'type'   => 'group',
				'fields' => [
					[
						'name'  => 'Text',
						'id'    => 'text1',
						'type'  => 'text',
						'clone' => true,
					],
					[
						'name'    => 'Checkbox List',
						'id'      => 'cblist1',
						'type'    => 'checkbox_list',
						'clone'   => true,
						'options' => [
							'asia'      => 'Asia',
							'europe'    => 'Europe',
							'america'   => 'America',
							'australia' => 'Australia',
							'africa'    => 'Africa',
						],
					],
					[
						'name'      => 'Post',
						'id'        => 'post1',
						'type'      => 'post',
						'post_type' => 'post',
						'clone'     => true,
					],
					[
						'name'  => 'Editor',
						'id'    => 'wysiwyg1',
						'type'  => 'wysiwyg',
						'clone' => true,
					],
				],
			],
		],
	];
	$meta_boxes[] = [
		'title'  => 'Clone group w/ non-clone fields',
		'fields' => [
			[
				'id'     => 'group2',
				'type'   => 'group',
				'clone'  => true,
				'fields' => [
					[
						'name' => 'Text',
						'id'   => 'text',
						'type' => 'text',
					],
					[
						'name'    => 'Checkbox List',
						'id'      => 'cblist',
						'type'    => 'checkbox_list',
						'options' => [
							'asia'      => 'Asia',
							'europe'    => 'Europe',
							'america'   => 'America',
							'australia' => 'Australia',
							'africa'    => 'Africa',
						],
					],
					[
						'name'      => 'Post',
						'id'        => 'post',
						'type'      => 'post',
						'post_type' => 'post',
					],
					[
						'name' => 'Editor',
						'id'   => 'wysiwyg2',
						'type' => 'wysiwyg',
					],
				],
			],
		],
	];
	$meta_boxes[] = [
		'title'  => 'Cloned group with cloned fields',
		'fields' => [
			[
				'id'     => 'group3',
				'type'   => 'group',
				'clone'  => true,
				'fields' => [
					[
						'name'  => 'Text',
						'id'    => 'text3',
						'type'  => 'text',
						'clone' => true,
					],
					[
						'name'    => 'Checkbox List',
						'id'      => 'cblist3',
						'type'    => 'checkbox_list',
						'clone'   => true,
						'options' => [
							'asia'      => 'Asia',
							'europe'    => 'Europe',
							'america'   => 'America',
							'australia' => 'Australia',
							'africa'    => 'Africa',
						],
					],
					[
						'name'      => 'Post',
						'id'        => 'post3',
						'type'      => 'post',
						'post_type' => 'post',
						'clone'     => true,
					],
					[
						'name'  => 'Editor',
						'id'    => 'wysiwyg3',
						'type'  => 'wysiwyg',
						'clone' => true,
					],
				],
			],
		],
	];
	$meta_boxes[] = [
		'title'  => 'Multi-level nested groups',
		'fields' => [
			[
				'id'     => 'group4',
				'type'   => 'group',
				'clone'  => true,
				'fields' => [
					// Normal field (cloned)
					[
						'name'  => 'Text',
						'id'    => 'text4',
						'type'  => 'text',
						'clone' => true,
					],
					// Nested group level 2
					[
						'name'   => 'Sub group',
						'id'     => 'group2',
						'type'   => 'group',
						'clone'  => true,
						'fields' => [
							// Normal field (cloned)
							[
								'name'  => 'Sub text',
								'id'    => 'text4',
								'type'  => 'text',
								'clone' => true,
							],
						],
					],
				],
			],
		],
	];
	return $meta_boxes;
} );
