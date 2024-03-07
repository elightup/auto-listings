<?php
namespace eLightUp\PluginUpdater;

class Settings {
	protected $manager;
	protected $option;
	protected $checker;
	protected $fake_api_key;

	public function __construct( Manager $manager, Checker $checker, Option $option ) {
		$this->manager      = $manager;
		$this->checker      = $checker;
		$this->option       = $option;
		$this->fake_api_key = 'Please do not steal this license key';
	}

	public function setup() {
		add_action( 'admin_menu', [ $this, 'add_settings_page' ] );
	}

	public function add_settings_page() {
		// Translators: %s - The plugin name.
		$title = sprintf( __( '%s License', 'elightup-plugin-updater' ), $this->manager->plugin->Name );
		$page  = add_submenu_page(
			$this->manager->parent_page,
			$title,
			$title,
			'manage_options',
			$this->manager->slug . '-license',
			[ $this, 'render' ]
		);
		add_action( "load-{$page}", [ $this, 'handle_save' ] );
	}

	public function render() {
		?>
		<div class="wrap">
			<h1><?= esc_html( get_admin_page_title() ) ?></h1>
			<p>
				<?php
				printf(
					// Translators: %1$s - URL to the My Account page, %2$s - The plugin name.
					wp_kses_post( __( 'Please enter your <a href="%1$s">license key</a> to enable automatic updates for %2$s.', 'elightup-plugin-updater' ) ),
					esc_url( $this->manager->my_account_url ),
					esc_html( $this->manager->plugin->Name )
				);
				?>
			</p>

			<form action="" method="post">
				<?php wp_nonce_field( 'save' ); ?>

				<table class="form-table">
					<tr>
						<th scope="row"><?php esc_html_e( 'License Key', 'elightup-plugin-updater' ); ?></th>
						<td>
							<?php $this->render_input() ?>
						</td>
					</tr>
				</table>

				<?php submit_button( __( 'Save Changes', 'elightup-plugin-updater' ) ); ?>
			</form>
		</div>
		<?php
	}

	protected function render_input() {
		$messages    = [
			// Translators: %1$s - URL to the buy page.
			'invalid' => __( 'Your license key is <b style="color: #d63638">invalid</b>.', 'elightup-plugin-updater' ),
			// Translators: %1$s - URL to the buy page.
			'error'   => __( 'Your license key is <b style="color: #d63638">invalid</b>.', 'elightup-plugin-updater' ),
			// Translators: %2$s - URL to the My Account page.
			'expired' => __( 'Your license key is <b style="color: #d63638">expired</b>. Please <a href="%2$s" target="_blank">renew your license</a>.', 'elightup-plugin-updater' ),
			'active'  => __( 'Your license key is <b style="color: #00a32a">active</b>.', 'elightup-plugin-updater' ),
		];
		$status      = $this->option->get_license_status();
		$license_key = 'active' === $status || $this->option->get_license_key_constant() ? $this->fake_api_key : $this->option->get_license_key();
		?>
		<input class="regular-text" name="<?= esc_attr( $this->manager->option_name ) ?>[api_key]" value="<?= esc_attr( $license_key ) ?>" type="password" autocomplete="autocomplete_off_randString">
		<?php if ( isset( $messages[ $status ] ) ) : ?>
			<p class="description"><?= wp_kses_post( sprintf( $messages[ $status ], $this->manager->buy_url, $this->manager->my_account_url ) ); ?></p>
		<?php endif; ?>
		<?php
	}

	public function handle_save() {
		if ( empty( $_POST['submit'] ) ) {
			return;
		}
		check_admin_referer( 'save' );

		$this->save();

		add_action( 'admin_notices', 'settings_errors' );
	}

	public function save() {
		// @codingStandardsIgnoreLine.
		$option = isset( $_POST[ $this->manager->option_name ] ) ? (array) $_POST[ $this->manager->option_name ] : [];

		// Prefer user-defined license key via a constant.
		if ( $this->option->get_license_key_constant() ) {
			$option['api_key'] = $this->option->get_license_key_constant();
		}

		// Do nothing if license key remains the same.
		$prev_key = $this->option->get_license_key_constant() ?: $this->option->get_license_key();
		if ( isset( $option['api_key'] ) && in_array( $option['api_key'], [ $prev_key, $this->fake_api_key ], true ) ) {
			return;
		}

		$option['status'] = 'active';
		$args             = $option;
		$args['action']   = 'check_license';
		$response         = $this->checker->request( $args );
		$status           = isset( $response['status'] ) ? $response['status'] : 'invalid';

		if ( false === $response ) {
			add_settings_error( '', 'epu-error', __( 'Something wrong with the connection. Please try again later.', 'elightup-plugin-updater' ) );
		} elseif ( 'active' === $status ) {
			add_settings_error( '', 'epu-success', __( 'Your license is activated.', 'elightup-plugin-updater' ), 'updated' );
		} elseif ( 'expired' === $status ) {
			// Translators: %s - URL to the My Account page.
			$message = __( 'License expired. Please renew on the <a href="%s" target="_blank">My Account</a> page.', 'elightup-plugin-updater' );
			$message = wp_kses_post( sprintf( $message, $this->manager->my_account_url ) );

			add_settings_error( '', 'epu-expired', $message );
		} else {
			// Translators: %1$s - URL to the My Account page, %2$s - URL to the pricing page.
			$message = __( 'Invalid license. Please <a href="%1$s" target="_blank">check again</a> or <a href="%2$s" target="_blank">get a new license here</a>.', 'elightup-plugin-updater' );
			$message = wp_kses_post( sprintf( $message, $this->manager->my_account_url, $this->manager->buy_url ) );

			add_settings_error( '', 'epu-invalid', $message );
		}

		$option['status'] = $status;

		// Don't save user-defined license key via a constant in the database.
		if ( $this->option->get_license_key_constant() ) {
			unset( $option['api_key'] );
		}

		$this->option->update( $option );
	}
}
