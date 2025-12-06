<?php
namespace MBFS\Blocks;

use MBFS\Helper;
use MBFS\FormFactory;
use MetaBox\Support\Data;

class SubmissionForm {
	use DataTrait;

	public function __construct() {
		add_action( 'init', [ $this, 'register_block' ], 99 );
		add_action( 'enqueue_block_editor_assets', [ $this, 'admin_enqueue' ], 99 );
	}

	public function register_block(): void {
		register_block_type( MBFS_DIR . '/blocks/submission-form/build', [
			'render_callback' => [ $this, 'render_block' ],
		] );
	}

	public function admin_enqueue(): void {
		$data                  = $this->get_data();
		$data['post_statuses'] = get_post_statuses();

		wp_localize_script(
			'meta-box-submission-form-editor-script',
			'mbfsData',
			$data
		);
	}

	public function render_block( $attributes ): string {
		$id = $attributes['id'] ?? [];
		if ( empty( $id ) && ! empty( $attributes['meta_box_id'] ) ) {
			$id = $attributes['meta_box_id'];
		}
		$id = is_array( $id ) ? implode( ',', $id ) : $id;

		$form = FormFactory::make( [
			'id'                  => $id,
			'ajax'                => Helper::convert_boolean( $attributes['ajax'] ),
			'allow_scroll'        => Helper::convert_boolean( $attributes['allow_scroll'] ),
			'edit'                => Helper::convert_boolean( $attributes['edit'] ),
			'allow_delete'        => Helper::convert_boolean( $attributes['allow_delete'] ),
			'force_delete'        => Helper::convert_boolean( $attributes['force_delete'] ),
			'show_add_more'       => Helper::convert_boolean( $attributes['show_add_more'] ),
			'object_type'         => $attributes['object_type'],
			'object_id'           => $attributes['object_id'],
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

		if ( empty( $form ) || ( empty( $form->config['id'] ) ) ) {
			return '';
		}
		ob_start();
		$form->render();

		return ob_get_clean();
	}
}
