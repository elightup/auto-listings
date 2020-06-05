<?php
add_action( 'init', function() {
	// Remove post type supports and show Meta Box fields for them.
	remove_post_type_support( 'post', 'title' );
	remove_post_type_support( 'post', 'thumbnail' );
} );
add_filter( 'rwmb_meta_boxes', function ( $meta_boxes ) {
	$meta_boxes[] = [
		'title'  => 'Bill Submit',
		'id'     => 'bill',
		'fields' => [
			[
				'name' => 'Submission Date',
				'id'   => 'submission_date',
				'type' => 'date',
			],
			[
				'name' => 'Title',
				'id'   => 'post_title',
			],
			[
				'name'    => 'Type',
				'id'      => 'type',
				'type'    => 'select',
				'options' => [
					'docs'    => 'Document',
					'receipt' => 'Receipt',
				],
			],
			[
				'name' => 'Description',
				'type' => 'textarea',
				'id'   => 'post_content',
			],
			[
				'name' => 'Thumbnail',
				'type' => 'single_image',
				'id'   => '_thumbnail_id',
			],
		],
	];

	return $meta_boxes;
} );

add_filter( 'the_content', function ( $content ) {
	if ( is_page() ) {
		$content .= do_shortcode( '[mb_frontend_form id="bill"]' );
	}

	return $content;
} );
