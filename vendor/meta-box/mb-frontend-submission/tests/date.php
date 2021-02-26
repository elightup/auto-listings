<?php
/**
 * Test simple form with default HTML inputs.
 *
 * @package    Meta Box
 * @subpackage MB Frontend Submission
 */

add_filter(
	'rwmb_meta_boxes',
	function ( $meta_boxes ) {
		$meta_boxes[] = [
			'title'  => 'Date form',
			'id'     => 'date-form',
			'fields' => [
				[
					'name' => 'Date',
					'id'   => 'date',
					'type' => 'date',
				],
			],
		];

		return $meta_boxes;
	}
);

add_filter(
	'the_content',
	function ( $content ) {
		$content .= do_shortcode( '[mb_frontend_form id="date-form" post_id="1"]' );

		return $content;
	}
);
