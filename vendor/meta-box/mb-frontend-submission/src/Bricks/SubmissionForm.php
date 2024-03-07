<?php
namespace MBFS\Bricks;

use MBFS\Helper;
use MBFS\FormFactory;
use MetaBox\Support\Data;

class SubmissionForm extends \Bricks\Element {
	public $category = 'meta-box';
	public $name     = 'mbfs-form-submission';
	public $icon     = 'fa-regular fa-rectangle-list';

	public function get_label() {
		return esc_html__( 'Submission Form', 'mb-frontend-submission' );
	}

	public function set_controls() {
		$this->controls['meta_box_id'] = [
			'tab'         => 'content', // Control tab: content/style
			'label'       => esc_html__( 'ID', 'mb-frontend-submission' ),
			'type'        => 'text',
			'default'     => '',
			'description' => esc_html__( 'Field group ID(s). If multiple field groups, enter their IDs separated by commas.', 'mb-frontend-submission' ),
		];

		$this->controls['ajax'] = [
			'tab'     => 'content',
			'label'   => esc_html__( 'Enable Ajax submission', 'mb-frontend-submission' ),
			'type'    => 'checkbox',
			'default' => false,
		];

		$this->controls['allow_scroll'] = [
			'tab'         => 'content',
			'label'       => esc_html__( 'Allow scroll', 'mb-frontend-submission' ),
			'type'        => 'checkbox',
			'default'     => true,
			'description' => esc_html__( 'Enable scroll to message after ajax submission.', 'mb-frontend-submission' ),
		];

		$this->controls['edit'] = [
			'tab'         => 'content',
			'label'       => esc_html__( 'Edit', 'mb-frontend-submission' ),
			'type'        => 'checkbox',
			'default'     => false,
			'description' => esc_html__( 'Allow users to edit the post after submitting. If enabled then ajax attribute will be disabled.', 'mb-frontend-submission' ),
		];

		$this->controls['allow_delete'] = [
			'tab'         => 'content',
			'label'       => esc_html__( 'Allow delete', 'mb-frontend-submission' ),
			'type'        => 'checkbox',
			'default'     => false,
			'description' => esc_html__( 'Allow users to delete the submitted post.', 'mb-frontend-submission' ),
		];

		$this->controls['force_delete'] = [
			'tab'         => 'content',
			'label'       => esc_html__( 'Force delete', 'mb-frontend-submission' ),
			'type'        => 'checkbox',
			'default'     => false,
			'description' => esc_html__( 'Whether to delete the submitted post permanently or temporarily (move to Trash).', 'mb-frontend-submission' ),
		];

		$this->controls['show_add_more'] = [
			'tab'         => 'content',
			'label'       => esc_html__( 'Show add more', 'mb-frontend-submission' ),
			'type'        => 'checkbox',
			'default'     => false,
			'description' => esc_html__( 'Show add new button after submit.', 'mb-frontend-submission' ),
		];

		$post_types                  = wp_list_pluck( Data::get_post_types(), 'name' );
		$this->controls['post_type'] = [
			'tab'         => 'content',
			'label'       => esc_html__( 'Post type', 'mb-frontend-submission' ),
			'type'        => 'select',
			'options'     => $post_types,
			'default'     => 'post',
			'description' => esc_html__( 'The submitted post type. Default is the first post type defined in the meta box. If meta box is made for multiple post types, you should set this attribute to the correct one.', 'mb-frontend-submission' ),
		];

		$this->controls['post_id'] = [
			'tab'         => 'content',
			'label'       => esc_html__( 'Post ID', 'mb-frontend-submission' ),
			'type'        => 'text',
			'default'     => '',
			'description' => esc_html__( 'The post ID. Used when you want to update an existing post. If you want to pass the ID of the current post, set it to "current".', 'mb-frontend-submission' ),
		];

		$post_statuses                 = get_post_statuses();
		$this->controls['post_status'] = [
			'tab'         => 'content',
			'label'       => esc_html__( 'Post status', 'mb-frontend-submission' ),
			'type'        => 'select',
			'options'     => $post_statuses,
			'default'     => 'publish',
			'description' => esc_html__( 'The status for submitted posts.', 'mb-frontend-submission' ),
		];

		$this->controls['post_fields'] = [
			'tab'         => 'content',
			'label'       => esc_html__( 'Post Fields', 'mb-frontend-submission' ),
			'type'        => 'select',
			'options'     => [
				'title'     => esc_html__( 'Title', 'mb-frontend-submission' ),
				'content'   => esc_html__( 'Content', 'mb-frontend-submission' ),
				'excerpt'   => esc_html__( 'Excerpt', 'mb-frontend-submission' ),
				'date'      => esc_html__( 'Date', 'mb-frontend-submission' ),
				'thumbnail' => esc_html__( 'Thumbnail', 'mb-frontend-submission' ),
			],
			'multiple'    => true,
			'default'     => [
				'title',
				'content',
			],
			'description' => esc_html__( 'List of post fields you want to show in the frontend.', 'mb-frontend-submission' ),
		];

		$this->controls['label_title'] = [
			'tab'     => 'content',
			'label'   => esc_html__( 'Title field label', 'mb-frontend-submission' ),
			'type'    => 'text',
			'default' => __( 'Title', 'mb-frontend-submission' ),
		];

		$this->controls['label_content'] = [
			'tab'     => 'content',
			'label'   => esc_html__( 'Content field label', 'mb-frontend-submission' ),
			'type'    => 'text',
			'default' => __( 'Content', 'mb-frontend-submission' ),
		];

		$this->controls['label_excerpt'] = [
			'tab'     => 'content',
			'label'   => esc_html__( 'Excerpt field label', 'mb-frontend-submission' ),
			'type'    => 'text',
			'default' => __( 'Excerpt', 'mb-frontend-submission' ),
		];

		$this->controls['label_date'] = [
			'tab'     => 'content',
			'label'   => esc_html__( 'Date field label', 'mb-frontend-submission' ),
			'type'    => 'text',
			'default' => __( 'Date', 'mb-frontend-submission' ),
		];

		$this->controls['label_thumbnail'] = [
			'tab'     => 'content',
			'label'   => esc_html__( 'Thumbnail field label', 'mb-frontend-submission' ),
			'type'    => 'text',
			'default' => __( 'Thumbnail', 'mb-frontend-submission' ),
		];

		$this->controls['submit_button'] = [
			'tab'     => 'content',
			'label'   => esc_html__( 'Submit button text', 'mb-frontend-submission' ),
			'type'    => 'text',
			'default' => __( 'Submit', 'mb-frontend-submission' ),
		];

		$this->controls['add_button'] = [
			'tab'     => 'content',
			'label'   => esc_html__( 'Add new button text', 'mb-frontend-submission' ),
			'type'    => 'text',
			'default' => __( 'Add new', 'mb-frontend-submission' ),
		];

		$this->controls['delete_button'] = [
			'tab'     => 'content',
			'label'   => esc_html__( 'Delete button text', 'mb-frontend-submission' ),
			'type'    => 'text',
			'default' => __( 'Delete', 'mb-frontend-submission' ),
		];

		$this->controls['redirect'] = [
			'tab'     => 'content',
			'label'   => esc_html__( 'Custom redirect URL', 'mb-frontend-submission' ),
			'type'    => 'text',
			'default' => '',
		];

		$this->controls['confirmation'] = [
			'tab'         => 'content',
			'label'       => esc_html__( 'Confirmation text', 'mb-frontend-submission' ),
			'type'        => 'text',
			'default'     => 'Your post has been successfully submitted. Thank you.',
			'description' => esc_html__( 'The text for the confirmation message when the form is successfully submitted.', 'mb-frontend-submission' ),
		];

		$this->controls['delete_confirmation'] = [
			'tab'         => 'content',
			'label'       => esc_html__( 'Delete confirmation text', 'mb-frontend-submission' ),
			'type'        => 'text',
			'default'     => 'Your post has been successfully deleted.',
			'description' => esc_html__( 'The text for the confirmation message when the post is deleted.', 'mb-frontend-submission' ),
		];

		$this->controls['recaptcha_key'] = [
			'tab'         => 'content',
			'label'       => esc_html__( 'Recaptcha key', 'mb-frontend-submission' ),
			'type'        => 'text',
			'default'     => '',
			'description' => esc_html__( 'Google reCaptcha site key (version 3).', 'mb-frontend-submission' ),
		];

		$this->controls['recaptcha_secret'] = [
			'tab'         => 'content',
			'label'       => esc_html__( 'Recaptcha secret', 'mb-frontend-submission' ),
			'type'        => 'text',
			'default'     => '',
			'description' => esc_html__( 'Google reCaptcha secret key (version 3).', 'mb-frontend-submission' ),
		];
	}

	public function render() {
		$settings       = $this->settings;
		$root_classes[] = 'form-submission-wrapper';

		if ( ! empty( $this->settings['type'] ) ) {
			$root_classes[] = "color-{$this->settings['type']}";
		}

		$this->set_attribute( '_root', 'class', $root_classes );

		$form = FormFactory::make( [
			'id'                  => $settings['meta_box_id'] ?? '',
			'ajax'                => isset( $settings['ajax'] ) ? Helper::convert_boolean( $settings['ajax'] ) : 'false',
			'allow_scroll'        => Helper::convert_boolean( $settings['allow_scroll'] ),
			'edit'                => isset( $settings['edit'] ) ? Helper::convert_boolean( $settings['edit'] ) : 'false',
			'allow_delete'        => isset( $settings['allow_delete'] ) ? Helper::convert_boolean( $settings['allow_delete'] ) : 'false',
			'force_delete'        => isset( $settings['force_delete'] ) ? Helper::convert_boolean( $settings['force_delete'] ) : 'false',
			'show_add_more'       => isset( $settings['show_add_more'] ) ? Helper::convert_boolean( $settings['show_add_more'] ) : 'false',
			'post_type'           => $settings['post_type'] ?? '',
			'post_id'             => $settings['post_id'] ?? '',
			'post_status'         => $settings['post_status'],
			'post_fields'         => implode( ',', $settings['post_fields'] ),
			'label_title'         => $settings['label_title'],
			'label_content'       => $settings['label_content'],
			'label_excerpt'       => $settings['label_excerpt'],
			'label_date'          => $settings['label_date'],
			'label_thumbnail'     => $settings['label_thumbnail'],
			'submit_button'       => $settings['submit_button'],
			'add_button'          => $settings['add_button'],
			'delete_button'       => $settings['delete_button'],
			'redirect'            => $settings['redirect'] ?? '',
			'confirmation'        => $settings['confirmation'],
			'delete_confirmation' => $settings['delete_confirmation'],
			'recaptcha_key'       => $settings['recaptcha_key'] ?? '',
			'recaptcha_secret'    => $settings['recaptcha_secret'] ?? '',
		] );
		if ( empty( $form ) || ( empty( $form->config['id'] ) && empty( $form->config['post_fields'] ) ) ) {
			echo '';
			return;
		}

		echo "<div {$this->render_attributes( '_root' )}>";

		$form->render();

		echo '</div>';
	}
}
