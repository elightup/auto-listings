<?php
namespace MBFS\Elementor;

use MBFS\FormFactory;
use Elementor\Controls_Manager;
use MetaBox\Support\Data;

class SubmissionForm extends \Elementor\Widget_Base {

	public function get_name() {
		return 'mbfs_submission_form';
	}

	public function get_title() {
		return esc_html__( 'Submission Form', 'mb-frontend-submission' );
	}

	public function get_icon() {
		return 'eicon-form-horizontal';
	}

	public function get_categories() {
		return [ 'metabox' ];
	}

	public function get_keywords() {
		return [ 'submission', 'form' ];
	}

	public function register_controls() {
		$this->start_controls_section(
			'content_section',
			[
				'label' => esc_html__( 'Content', 'mb-frontend-submission' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'title',
			[
				'type'               => Controls_Manager::TEXT,
				'label'              => esc_html__( 'Title', 'mb-frontend-submission' ),
				'placeholder'        => esc_html__( 'Enter the form title', 'mb-frontend-submission' ),
				'frontend_available' => true,
			]
		);

		$this->add_control(
			'group_ids',
			[
				'label'       => esc_html__( 'Field group ID(s)', 'mb-frontend-submission' ),
				'type'        => Controls_Manager::TEXT,
				'description' => esc_html__( 'If multiple field groups, enter their IDs separated by commas.', 'mb-frontend-submission' ),
			]
		);

		$post_types = wp_list_pluck( Data::get_post_types(), 'name' );
		$this->add_control(
			'post_type',
			[
				'type'    => Controls_Manager::SELECT,
				'label'   => esc_html__( 'Post type', 'mb-frontend-submission' ),
				'options' => $post_types,
				'default' => '',
			]
		);

		$this->add_control(
			'post_fields',
			[
				'type'        => Controls_Manager::SELECT2,
				'label'       => esc_html__( 'Post fields', 'mb-frontend-submission' ),
				'multiple'    => true,
				'options'     => [
					'title'     => esc_html__( 'Title', 'mb-frontend-submission' ),
					'content'   => esc_html__( 'Content', 'mb-frontend-submission' ),
					'excerpt'   => esc_html__( 'Excerpt', 'mb-frontend-submission' ),
					'thumbnail' => esc_html__( 'Thumbnail', 'mb-frontend-submission' ),
					'date'      => esc_html__( 'Date', 'mb-frontend-submission' ),
				],
				'description' => esc_html__( 'Choose post fields to show on the form', 'mb-frontend-submission' ),
				'default'     => [ 'title', 'content' ],
			]
		);

		$post_statuses = get_post_statuses();
		$this->add_control(
			'post_status',
			[
				'type'    => Controls_Manager::SELECT,
				'label'   => esc_html__( 'Post status', 'mb-frontend-submission' ),
				'options' => $post_statuses,
				'default' => 'publish',
			]
		);

		$this->add_control(
			'confirmation',
			[
				'label'       => esc_html__( 'Confirmation message', 'mb-frontend-submission' ),
				'type'        => Controls_Manager::WYSIWYG,
				'default'     => esc_html__( 'Your post has been successfully submitted. Thank you.', 'mb-frontend-submission' ),
				'placeholder' => esc_html__( 'Type your description here', 'mb-frontend-submission' ),
				'description' => esc_html__( 'The text for the confirmation message when the form is successfully submitted.', 'mb-frontend-submission' ),
			]
		);

		$this->add_control(
			'recaptcha',
			[
				'type'         => Controls_Manager::SWITCHER,
				'label'        => esc_html__( 'Use Google reCaptcha', 'mb-frontend-submission' ),
				'label_on'     => esc_html__( 'True', 'mb-frontend-submission' ),
				'label_off'    => esc_html__( 'False', 'mb-frontend-submission' ),
				'return_value' => 'yes',
				'default'      => 'no',
			]
		);

		$this->add_control(
			'recaptcha_key',
			[
				'type'               => Controls_Manager::TEXT,
				'label'              => esc_html__( 'reCaptcha key', 'mb-frontend-submission' ),
				'frontend_available' => true,
				'condition'          => [
					'recaptcha' => 'yes',
				],
			]
		);

		$this->add_control(
			'recaptcha_secret',
			[
				'type'               => Controls_Manager::TEXT,
				'label'              => esc_html__( 'reCaptcha secret', 'mb-frontend-submission' ),
				'frontend_available' => true,
				'condition'          => [
					'recaptcha' => 'yes',
				],
			]
		);

		$this->add_control(
			'ajax',
			[
				'label'        => esc_html__( 'Ajax', 'mb-frontend-submission' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'True', 'mb-frontend-submission' ),
				'label_off'    => esc_html__( 'False', 'mb-frontend-submission' ),
				'return_value' => 'yes',
				'default'      => 'no',
			]
		);

		$this->add_control(
			'redirect',
			[
				'label' => esc_html__( 'Custom Redirect URL', 'mb-frontend-submission' ),
				'type'  => Controls_Manager::TEXT,
			]
		);

		$this->end_controls_section();
	}

	public function render() {
		$atts     = [];
		$settings = $this->get_settings_for_display();

		if ( isset( $settings['title'] ) ) {
			echo '<h3>' . esc_html( $settings['title'] ) . '</h3>';
		}

		if ( $settings['post_type'] ) {
			$atts['post_type'] = $settings['post_type'];
		}

		if ( $settings['post_fields'] ) {
			$atts['post_fields'] = implode( ',', $settings['post_fields'] );
		}

		if ( $settings['post_status'] ) {
			$atts['post_status'] = $settings['post_status'];
		}

		if ( $settings['confirmation'] ) {
			$atts['confirmation'] = trim( $settings['confirmation'] );
		}

		if ( $settings['recaptcha'] === 'yes' && ! empty( $settings['recaptcha_key'] ) && ! empty( $settings['recaptcha_secret'] ) ) {
			$atts['recaptcha_key']    = $settings['recaptcha_key'];
			$atts['recaptcha_secret'] = $settings['recaptcha_secret'];
		}

		if ( ! empty( $settings['group_ids'] ) ) {
			$atts['id'] = trim( $settings['group_ids'] );
		}

		if ( $settings['ajax'] === 'yes' ) {
			$atts['ajax'] = 'true';
		}

		if ( ! empty( $settings['redirect'] ) ) {
			$atts['redirect'] = trim( $settings['redirect'] );
		}

		$form = FormFactory::make( $atts );
		$form->render();
	}
}
