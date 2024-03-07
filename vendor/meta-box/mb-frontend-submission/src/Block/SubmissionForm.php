<?php
namespace MBFS\Block;

use MBFS\Helper;
use MBFS\FormFactory;
use MetaBox\Support\Data;

class SubmissionForm {
	public function __construct() {

		add_action( 'init', [ $this, 'register_block' ], 99 );
		add_action( 'enqueue_block_editor_assets', [ $this, 'admin_enqueue' ], 99 );
	}

	public function register_block() {
		register_block_type( MBFS_DIR . '/block/submission-form/build', [
			'render_callback' => [ $this, 'render_block' ],
		] );
	}

	public function admin_enqueue() {
		$post_types    = wp_list_pluck( Data::get_post_types(), 'name' );
		$post_statuses = get_post_statuses();

		wp_localize_script( 'meta-box-submission-form-editor-script', 'mbfsData', compact( 'post_types', 'post_statuses' ) );
	}

	public function render_block( $attributes ): string {
		$form = FormFactory::make( [
			'id'                  => $attributes['meta_box_id'],
			'ajax'                => Helper::convert_boolean( $attributes['ajax'] ),
			'allow_scroll'        => Helper::convert_boolean( $attributes['allow_scroll'] ),
			'edit'                => Helper::convert_boolean( $attributes['edit'] ),
			'allow_delete'        => Helper::convert_boolean( $attributes['allow_delete'] ),
			'force_delete'        => Helper::convert_boolean( $attributes['force_delete'] ),
			'show_add_more'       => Helper::convert_boolean( $attributes['show_add_more'] ),
			'post_type'           => $attributes['post_type'],
			'post_id'             => $attributes['post_id'],
			'post_status'         => $attributes['post_status'],
			'post_fields'         => implode( ',', $attributes['post_fields'] ),
			'label_title'         => $attributes['label_title'],
			'label_content'       => $attributes['label_content'],
			'label_excerpt'       => $attributes['label_excerpt'],
			'label_date'          => $attributes['label_date'],
			'label_thumbnail'     => $attributes['label_thumbnail'],
			'submit_button'       => $attributes['submit_button'],
			'add_button'          => $attributes['add_button'],
			'delete_button'       => $attributes['delete_button'],
			'redirect'            => $attributes['redirect'],
			'confirmation'        => $attributes['confirmation'],
			'delete_confirmation' => $attributes['delete_confirmation'],
			'recaptcha_key'       => $attributes['recaptcha_key'],
			'recaptcha_secret'    => $attributes['recaptcha_secret'],
		] );
		if ( empty( $form ) || ( empty( $form->config['id'] ) && empty( $form->config['post_fields'] ) ) ) {
			return '';
		}
		ob_start();
		$form->render();

		return ob_get_clean();
	}
}
