<?php
/**
 * Test demo.php file from Meta Box demo folder.
 *
 * @package    Meta Box
 * @subpackage MB Frontend Submission
 */

add_filter(
	'the_content',
	function ( $content ) {
		$content .= do_shortcode( '[mb_frontend_form id="standard" post_fields="title,excerpt,content,thumbnail" post_status="draft" post_id="29"]' );
		// $content .= do_shortcode( '[mb_frontend_form id="advanced-fields" post_title="false" post_content="false" post_id="151"]' );
		return $content;
	}
);
