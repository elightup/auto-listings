<?php
namespace MBFS;

use WP_Error;

class Form {
	public $error;
	public $config;
	private $meta_boxes;
	private $post;
	private $template_loader;
	private $localize_data;

	/**
	 * Constructor.
	 *
	 * @param array          $meta_boxes      Meta box array.
	 * @param object         $post            Post object.
	 * @param array          $config          Form configuration.
	 * @param TemplateLoader $template_loader Template loader for loading form templates.
	 */
	public function __construct( $meta_boxes, $post, $config, $template_loader ) {
		$this->meta_boxes      = array_filter( $meta_boxes, [ $this, 'is_meta_box_visible' ] );
		$this->post            = $post;
		$this->config          = $config;
		$this->template_loader = $template_loader;
		$this->localize_data   = [];

		$this->error = new WP_Error();
	}

	/**
	 * Output the form.
	 */
	public function render() {
		$this->enqueue();
		$this->enqueue_recaptcha();
		$this->localize();

		if ( $this->is_deleted() ) {
			$this->show_confirmation( 'delete' );
			return;
		}

		if ( ! $this->user_can_edit() ) {
			echo '<div class="rwmb-error">', esc_html__( 'You are not allowed to edit this post.', 'mb-frontend-submission' ), '</div>';
			return;
		}

		$this->display_errors();

		if ( $this->is_processed() ) {
			$this->show_confirmation( 'submit' );

			if ( 'true' !== $this->config['edit'] ) {
				return;
			}
		}

		do_action( 'rwmb_frontend_before_form', $this->config );
		echo '<form class="rwmb-form mbfs-form" id="' . esc_attr( $this->config['id'] ) . '" method="post" enctype="multipart/form-data">';
		$this->render_hidden_fields();

		// Register wp color picker scripts for frontend.
		$this->register_scripts();

		$delete_button = '';
		if ( 'true' === $this->config['allow_delete'] && $this->config['object_id'] && get_post_status( $this->config['object_id'] ) ) {
			$delete_button = '<button type="submit" class="rwmb-button rwmb-button--delete" name="rwmb_delete" value="1">' . $this->config['delete_button'] . '</button>';
		}

		if ( 'false' === $this->config['only_delete'] ) {
			// Always enqueue Meta Box style & script, in case no meta boxes are set in the shortcode.
			// If the form contains only title, content, thumbnail, then the media scripts which requires rwmb will fail.
			wp_enqueue_style( 'rwmb', RWMB_CSS_URL . 'style.css', [], RWMB_VER );
			if ( is_rtl() ) {
				wp_enqueue_style( 'rwmb-rtl', RWMB_CSS_URL . 'style-rtl.css', [], RWMB_VER );
			}
			wp_enqueue_script( 'rwmb', RWMB_JS_URL . 'script.js', [ 'jquery' ], RWMB_VER, true );

			// Make sure Meta Box script is enqueued first.
			foreach ( $this->meta_boxes as $meta_box ) {
				$meta_box->enqueue( [
					'for' => 'frontend',
				] );
			}

			// Output post fields and assets.
			if ( $this->config['object_type'] === 'post' ) {
				$this->post->render();
			}

			foreach ( $this->meta_boxes as $meta_box ) {
				$meta_box->show();
			}

			do_action( 'rwmb_frontend_before_submit_button', $this->config );

			echo '<div class="rwmb-field rwmb-button-wrapper rwmb-form-submit"><div class="rwmb-input">';

				// Allow submit button to be filtered
				$submit_button = '<button type="submit" class="rwmb-button" data-edit="' . esc_attr( $this->config['edit'] ) . '" name="rwmb_submit" value="1">' . esc_html( $this->config['submit_button'] ) . '</button>';
				$submit_button = apply_filters( 'rwmb_frontend_submit_button', $submit_button, $this->config );
				echo $submit_button;

				echo $delete_button;
			echo '</div></div>';

			do_action( 'rwmb_frontend_after_submit_button', $this->config );
		} else {
			do_action( 'rwmb_frontend_before_submit_button', $this->config );
			echo '<div class="rwmb-field rwmb-button-wrapper rwmb-form-submit"><div class="rwmb-input">
					' . $delete_button . '
				</div></div>';
			do_action( 'rwmb_frontend_after_submit_button', $this->config );
		}

		wp_localize_jquery_ui_datepicker();

		echo '</form>';

		do_action( 'rwmb_frontend_after_form', $this->config );
	}

	private function user_can_edit() {
		if ( empty( $this->config['object_id'] ) ) {
			return true;
		}
		if ( ! is_user_logged_in() ) {
			return false;
		}

		if ( $this->config['object_type'] === 'post' ) {
			$post = get_post( $this->config['object_id'] );

			return $post && ( $post->post_status !== 'trash' ) && ( $post->post_author == get_current_user_id() || current_user_can( 'edit_post', $post->ID ) );
		}

		// Model
		// Get related model
		$first_meta_box_id = explode( ',', $this->config['id'] )[0];
		$meta_box          = rwmb_get_registry( 'meta_box' )->get( $first_meta_box_id );

		if ( ! class_exists( \MetaBox\CustomTable\Model\Factory::class ) || empty( $meta_box->meta_box['models'] ) ) {
			return false;
		}

		$model_id = $meta_box->meta_box['models'][0];
		$model    = \MetaBox\CustomTable\Model\Factory::get( $model_id );

		return current_user_can( $model->capability );
	}

	/**
	 * Check if a meta box is visible.
	 *
	 * @param  \RW_Meta_Box $meta_box Meta Box object.
	 * @return bool
	 */
	public function is_meta_box_visible( $meta_box ) {
		if ( empty( $meta_box ) ) {
			return false;
		}
		if ( method_exists( $meta_box, 'is_shown' ) ) {
			return $meta_box->is_shown();
		}
		$show = apply_filters( 'rwmb_show', true, $meta_box->meta_box );
		return apply_filters( "rwmb_show_{$meta_box->id}", $show, $meta_box->meta_box );
	}

	/**
	 * Process the form.
	 * Meta box auto hooks to 'save_post' action to save its data, so we only need to save the post.
	 *
	 * @return ?int Inserted object ID.
	 */
	public function process() {
		global $wpdb;

		$validate = true;
		foreach ( $this->meta_boxes as $meta_box ) {
			$validate = $validate && $meta_box->validate();
		}

		$validate = apply_filters( 'rwmb_frontend_validate', $validate, $this->config );

		if ( true !== $validate ) {
			$this->error->add( 'invalid', is_string( $validate ) ? $validate : __( 'Invalid form submission', 'mb-frontend-submission' ) );
			return null;
		}

		do_action( 'rwmb_frontend_before_process', $this->config );

		$object_id = -1;

		if ( $this->config['object_type'] === 'post' ) {
			$object_id           = $this->post->save();
			$this->post->post_id = $object_id;
		}

		do_action( 'rwmb_frontend_save_model', $this->config );
		if ( $this->config['object_type'] === 'model' ) {
			$object_id = $wpdb->insert_id;
		}
		do_action( 'rwmb_frontend_after_process', $this->config, $object_id );

		return $object_id;
	}

	/**
	 * Handling deleting posts by id.
	 */
	public function delete() {
		if ( empty( $this->config['object_id'] ) ) {
			return;
		}

		$force_delete = 'true' === $this->config['force_delete'];

		do_action( 'rwmb_frontend_before_delete', $this->config );
		wp_delete_post( $this->config['object_id'], $force_delete );
		do_action( 'rwmb_frontend_after_delete', $this->config, $this->config['object_id'] );
	}

	protected function display_errors() {
		if ( $this->error->has_errors() ) {
			printf( '<div class="rwmb-error">%s</div>', wp_kses_post( implode( '<br>', $this->error->get_error_messages() ) ) );
		}
	}

	private function register_scripts() {
		if ( wp_script_is( 'wp-color-picker', 'registered' ) ) {
			return;
		}
		wp_register_script(
			'iris',
			admin_url( 'js/iris.min.js' ),
			[
				'jquery-ui-draggable',
				'jquery-ui-slider',
				'jquery-touch-punch',
			],
			'1.0.7',
			true
		);
		wp_register_script( 'wp-color-picker', admin_url( 'js/color-picker.min.js' ), [ 'iris', 'wp-i18n' ], '', true );
		wp_localize_script(
			'wp-color-picker',
			'wpColorPickerL10n',
			[
				'clear'            => __( 'Clear', 'mb-frontend-submission' ),
				'clearAriaLabel'   => __( 'Clear color', 'mb-frontend-submission' ),
				'defaultString'    => __( 'Default', 'mb-frontend-submission' ),
				'defaultAriaLabel' => __( 'Select default color', 'mb-frontend-submission' ),
				'pick'             => __( 'Select Color', 'mb-frontend-submission' ),
				'defaultLabel'     => __( 'Color value', 'mb-frontend-submission' ),
			]
		);
	}

	private function enqueue() {
		wp_enqueue_style( 'mbfs-form', MBFS_URL . 'assets/form.css', [], MBFS_VER );
		wp_enqueue_script( 'mbfs', MBFS_URL . 'assets/frontend-submission.js', [ 'jquery' ], MBFS_VER, true );

		$this->localize_data = array_merge( $this->localize_data, [
			'ajaxUrl'        => admin_url( 'admin-ajax.php' ),
			'nonce'          => wp_create_nonce( 'ajax_nonce' ),
			'ajax'           => $this->config['ajax'],
			'redirect'       => $this->config['redirect'],
			'confirm_delete' => __( 'Are you sure to delete this post?', 'mb-frontend-submission' ),
		] );
	}

	private function enqueue_recaptcha() {
		if ( ! $this->config['recaptcha_key'] ) {
			return;
		}
		wp_enqueue_script( 'google-recaptcha', 'https://www.google.com/recaptcha/api.js?render=' . $this->config['recaptcha_key'], [], '3', true );

		$this->localize_data = array_merge(
			$this->localize_data,
			[
				'recaptchaKey'        => $this->config['recaptcha_key'],
				'captchaExecuteError' => __( 'Error trying to execute grecaptcha.', 'mb-frontend-submission' ),
			]
		);
	}

	private function localize() {
		wp_localize_script( 'mbfs', 'mbFrontendForm', $this->localize_data );
	}

	private function render_hidden_fields() {
		$key = ConfigStorage::store( $this->config );
		echo '<input type="hidden" name="mbfs_key" value="', esc_attr( $key ), '">';
		echo '<input type="hidden" name="action" value="mbfs_submit">';

		// Add hidden input if has recaptcha v3
		if ( $this->config['recaptcha_key'] ) {
			echo '<input type="hidden" name="mbfs_recaptcha_token" value="">';
		}
	}

	private function is_processed() {
		return ConfigStorage::get_key( $this->config ) === filter_input( INPUT_GET, 'rwmb-form-submitted' );
	}

	private function is_deleted() {
		return ConfigStorage::get_key( $this->config ) === filter_input( INPUT_GET, 'rwmb-form-deleted' );
	}

	/**
	 * Can call from Shortcode class to show confirmation message.
	 */
	public function show_confirmation( string $type ) {
		$hook     = $type === 'submit' ? 'display' : 'delete';
		$template = $type === 'submit' ? 'confirmation' : 'delete-confirmation';

		do_action( "rwmb_frontend_before_{$hook}_confirmation", $this->config );

		if ( $this->config['confirmation'] ) {
			$this->template_loader->set_template_data( $this->config )->get_template_part( $template );
		}

		do_action( "rwmb_frontend_after_{$hook}_confirmation", $this->config );
	}
}
