<?php
/**
 * The template file for post content.
 *
 * @package    Meta Box
 * @subpackage MB Frontend Submission
 */

$in_block = defined( 'REST_REQUEST' ) && REST_REQUEST;

$field = apply_filters( 'rwmb_frontend_post_content', [
	'type' => $in_block ? 'textarea' : 'wysiwyg',
	'desc' => $in_block ? '<small>' . __( 'This content field will be replaced by a WYSIWYG (visual) editor on the front end.', 'mb-frontend-submission' ) . '</small>' : '',
	'name' => $data->config['label_content'],
	'id'   => 'post_content',
] );
$field = RWMB_Field::call( 'normalize', $field );
RWMB_Field::call( $field, 'add_actions' );
RWMB_Field::call( $field, 'admin_enqueue_scripts' );
RWMB_Field::call( 'show', $field, false, $data->post_id );
