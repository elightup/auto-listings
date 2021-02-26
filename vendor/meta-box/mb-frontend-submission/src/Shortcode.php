<?php
namespace MBFS;

class Shortcode {
	public function __construct() {
		add_shortcode( 'mb_frontend_form', array( $this, 'shortcode' ) );

		add_action( 'template_redirect', array( $this, 'init_session' ) );

		add_action( 'wp_ajax_mbfs_submit', array( $this, 'process' ) );
		add_action( 'wp_ajax_nopriv_mbfs_submit', array( $this, 'process' ) );

		add_action( 'wp_ajax_mbfs_delete', array( $this, 'delete' ) );
		add_action( 'wp_ajax_nopriv_mbfs_delete', array( $this, 'delete' ) );

		add_action( 'template_redirect', [ $this, 'handle_request' ] );
	}

	public function shortcode( $atts ) {
		/*
		 * Do not render the shortcode in the admin.
		 * Prevent errors with enqueue assets in Gutenberg where requests are made via REST to preload the post content.
		 */
		if ( is_admin() ) {
			return '';
		}

		$form = $this->get_form( $atts );
		if ( null === $form ) {
			return '';
		}
		ob_start();

		$form->render();

		return ob_get_clean();
	}

	public function handle_request() {
		$action = filter_input( INPUT_POST, 'action', FILTER_SANITIZE_STRING );
		if ( ! $action || ! in_array( $action, ['mbfs_submit', 'mbfs_delete'], true ) ) {
			return;
		}
		$method = 'mbfs_delete' === $action ? 'delete' : 'process';
		$this->{$method}();
	}

	public function init_session() {
		if ( session_status() === PHP_SESSION_NONE && ! headers_sent() ) {
			session_start();
		}
	}

	/**
	 * Handle the form submit.
	 */
	public function process() {
		// Make sure session is available for ajax requests.
		$this->init_session();

		$data = (array) $_POST;

		$config_key = filter_var( $data[ 'rwmb_form_config' ], FILTER_SANITIZE_STRING );
		$config     = ConfigStorage::get( $config_key );

		if ( empty( $config ) ) {
			$this->send_error_message( __( 'Invalid request. Please try again.', 'mb-frontend-submission' ) );
		}

		$form = $this->get_form( $config );
		if ( null === $form ) {
			$this->send_error_message( __( 'Invalid request. Please try again.', 'mb-frontend-submission' ) );
		}

		$this->check_ajax();

		$this->check_recaptcha( $form, $data );

		// Make sure to include the WordPress media uploader functions to process uploaded files.
		if ( ! function_exists( 'media_handle_upload' ) ) {
			require_once ABSPATH . 'wp-admin/includes/image.php';
			require_once ABSPATH . 'wp-admin/includes/file.php';
			require_once ABSPATH . 'wp-admin/includes/media.php';
		}

		$config['post_id'] = $form->process();

		$meta_box_ids = array_filter( explode( ',', $config['id'] . ',' ) );
		$meta_box_ids = implode( ',', $meta_box_ids );

		$this->send_success_message( $config['confirmation'], $form );

		$redirect = add_query_arg( [] );
		if ( $config['post_id'] ) {
			$redirect = add_query_arg( 'rwmb-form-submitted', $meta_box_ids );
		}

		// Allow to re-edit the submitted post.
		if ( 'true' === $config['edit'] && $config['post_id'] ) {
			$redirect = add_query_arg( 'rwmb_frontend_field_post_id', $config['post_id'], $redirect );
		}

		$redirect = apply_filters( 'rwmb_frontend_redirect', $redirect, $config );

		if ( $config[ 'redirect' ] ) {
			$redirect = $config[ 'redirect' ];
		}

		wp_redirect( $redirect );

		die;
	}

	private function check_ajax() {
		if ( $this->is_ajax() && ! check_ajax_referer( 'ajax_nonce' ) ) {
			$this->send_error_message( __( 'Invalid ajax request. Please try again.', 'mb-frontend-submission' ) );
		}
	}

	private function check_recaptcha( $form, $data ) {
		if ( ! $form->config['recaptcha_secret'] ) {
			return;
		}

		$captcha = filter_var( $data[ 'recaptcha_token' ], FILTER_SANITIZE_STRING );
		$action  = filter_var( $data[ 'recaptcha_action' ], FILTER_SANITIZE_STRING );

		if ( ! $captcha || ! $action ) {
			$this->send_error_message( __( 'Invalid captcha token.', 'mb-frontend-submission' ) );
		}

		$url = 'https://www.google.com/recaptcha/api/siteverify';
		$url = add_query_arg( [
			'secret'   => $form->config['recaptcha_secret'],
			'response' => $captcha,
		], $url );

		$response = wp_remote_retrieve_body( wp_remote_get( $url ) );
		$response = json_decode( $response, true );

		if ( empty( $response['action'] ) || $action !== $response[ 'action' ] ) {
			$this->send_error_message( __( 'Invalid captcha token.', 'mb-frontend-submission' ) );
		}
	}

	/**
	 * Handle the form submit delete.
	 */
	public function delete() {
		// Make sure session is available for ajax requests.
		$this->init_session();

		$data = (array) $_POST;

		$config_key = filter_var( $data[ 'rwmb_form_config' ], FILTER_SANITIZE_STRING );
		$config     = ConfigStorage::get( $config_key );

		if ( empty( $config ) || empty( $config['post_id'] ) ) {
			$this->send_error_message( __( 'Invalid request. Please try again.', 'mb-frontend-submission' ) );
		}

		$form = $this->get_form( $config );
		if ( null === $form ) {
			$this->send_error_message( __( 'Invalid request. Please try again.', 'mb-frontend-submission' ) );
		}

		$this->check_ajax();

		$form->delete();

		$meta_box_ids = array_filter( explode( ',', $config['id'] . ',' ) );
		$meta_box_ids = implode( ',', $meta_box_ids );

		$this->send_success_message( $config['delete_confirmation'], $form );

		$redirect = add_query_arg( 'rwmb-form-deleted', $meta_box_ids );
		$redirect = apply_filters( 'rwmb_frontend_redirect', $redirect, $config );

		if ( $config[ 'redirect' ] ) {
			$redirect = $config[ 'redirect' ];
		}

		wp_redirect( $redirect );
		die;
	}

	/**
	 * Get the form.
	 *
	 * @param array $args Form configuration.
	 *
	 * @return Form Form object.
	 */
	private function get_form( $args ) {
		$args = shortcode_atts(
			array(
				// Meta Box ID.
				'id'                  => '',

				// Allow to edit the submitted post.
				'edit'                => false,
				'allow_delete'        => false,
				'force_delete'        => 'false',

				'only_delete'         => 'false',

				// Ajax
				'ajax'                => '',

				// Redirect
				'redirect'            => '',

				// Google reCaptcha v3
				'recaptcha_key'       => '',
				'recaptcha_secret'    => '',

				// Post fields.
				'post_type'           => '',
				'post_id'             => 0,
				'post_status'         => 'publish',
				'post_fields'         => '',
				'label_title'         => '',
				'label_content'       => '',
				'label_excerpt'       => '',
				'label_date'          => '',
				'label_thumbnail'     => '',

				// Appearance options.
				'submit_button'       => __( 'Submit', 'mb-frontend-submission' ),
				'delete_button'       => __( 'Delete', 'mb-frontend-submission' ),
				'confirmation'        => __( 'Your post has been successfully submitted. Thank you.', 'mb-frontend-submission' ),
				'delete_confirmation' => __( 'Your post has been successfully deleted.', 'mb-frontend-submission' ),
			),
			$args
		);

		// Quick set the current post ID.
		if ( 'current' === $args['post_id'] ) {
			$args['post_id'] = get_the_ID();
		}

		// Allows developers to dynamically populate shortcode params via query string.
		$this->populate_via_query_string( $args );

		// Allows developers to dynamically populate shortcode params via hooks.
		$this->populate_via_hooks( $args );

		$meta_boxes   = array();
		$meta_box_ids = array_filter( explode( ',', $args['id'] . ',' ) );

		foreach ( $meta_box_ids as $meta_box_id ) {
			$meta_boxes[] = rwmb_get_registry( 'meta_box' )->get( $meta_box_id );
		}

		$meta_boxes = array_filter( $meta_boxes );

		if ( $meta_boxes ) {
			$meta_box_ids = array();
			foreach ( $meta_boxes as $meta_box ) {
				$meta_box->set_object_id( $args['post_id'] );
				if ( ! $args['post_type'] ) {
					$post_types        = $meta_box->post_types;
					$args['post_type'] = reset( $post_types );
				}
				$meta_box_ids[] = $meta_box->id;
			}

			$args['id'] = implode( ',', $meta_box_ids );
		}

		$template_loader = new TemplateLoader();

		$post = new Post( $args['post_type'], $args['post_id'], $args, $template_loader );

		return new Form( $meta_boxes, $post, $args, $template_loader );
	}

	/**
	 * Allows developers to dynamically populate post ID via query string.
	 *
	 * @param array $args Shortcode params.
	 */
	private function populate_via_query_string( &$args ) {
		$post_id = filter_input( INPUT_GET, 'rwmb_frontend_field_post_id', FILTER_SANITIZE_NUMBER_INT );
		if ( $post_id ) {
			$args['post_id'] = $post_id;
		}
	}

	/**
	 * Allows developers to dynamically populate shortcode params via hooks.
	 *
	 * @param array $args Shortcode params.
	 */
	private function populate_via_hooks( &$args ) {
		foreach ( $args as $key => $value ) {
			$args[ $key ] = apply_filters( "rwmb_frontend_field_value_{$key}", $value, $args );
		}
	}

	private function send_error_message( $message ) {
		if ( $this->is_ajax() ) {
			wp_send_json_error( ['message' => $message] );
		}
		wp_die( $message );
	}

	private function send_success_message( $message, $form ) {
		if ( ! $this->is_ajax() ) {
			return;
		}
		wp_send_json_success( [
			'message'  => $message,
			'redirect' => $form->config['redirect'],
		] );
	}

	private function is_ajax() {
		return defined( 'DOING_AJAX' ) && DOING_AJAX;
	}
}
