<?php
namespace AutoListings\Update;

class Settings {
	/**
	 * The update option object.
	 */
	private $option;

	/**
	 * The update checker object
	 */
	private $checker;

	/**
	 * Constructor.
	 *
	 * @param object $checker Update checker object.
	 * @param object $option  Update option object.
	 */
	public function __construct( $checker, $option ) {
		$this->checker = $checker;
		$this->option  = $option;
	}

	public function init() {
		add_filter( 'mb_settings_pages', [ $this, 'add_settings_tabs' ], 99 );
		add_filter( 'rwmb_meta_boxes', [ $this, 'register_settings_fields' ], 99 );
		add_filter( 'rwmb_al-license_after_save_post', [ $this, 'check_license' ] );
	}

	public function add_settings_tabs( $settings_pages ) {
		if ( $this->checker->has_extensions() ) {
			$settings_pages['auto-listings']['tabs']['license'] = __( 'License', 'auto-listings' );
		}
		return $settings_pages;
	}

	public function register_settings_fields( $meta_boxes ) {
		if ( $this->checker->has_extensions() ) {
			$meta_boxes[] = [
				'id' => 'al-license',
				'title' => __( 'License', 'auto-listings' ),
				'settings_pages' => 'auto-listings',
				'tab' => 'license',
				'fields' => [
					[
						'name' => __( 'License Key', 'auto-listings' ),
						'id' => 'license_key',
						'before' => $this->output_instruction(),
						'desc' => $this->output_status(),
					],
				],
			];
		}

		return $meta_boxes;
	}

	public function output_instruction() {
		ob_start();
		?>
			<p><?php esc_html_e( 'Please enter your license key to enable automatic updates for the PRO version.', 'auto-listings' ); ?></p>
			<p>
				<?php
				printf(
					wp_kses_post( __( 'The license key was sent to your email when you purchased the PRO version. If you have not purchased it yet, please <a href="%1$s" target="_blank">get a new license here</a>.', 'auto-listings' ) ),
					'https://wpautolistings.com/pro/'
				);
				?>
			</p>
		<?php
		return ob_get_clean();
	}

	public function output_status() {
		$messages = array(
			'invalid' => __( 'Your license key is <b>invalid</b>. Please update your license key or <a href="%1$s" target="_blank">get a new one here</a>.', 'auto-listings' ),
			'expired' => __( 'Your license key is <b>expired</b>. Please renew your license.', 'auto-listings' ),
			'active'  => __( 'Your license key is <b>active</b>.', 'auto-listings' ),
		);
		$status = $this->option->get_license_status();
		if ( isset( $messages[ $status ] ) ) {
			return sprintf( $messages[ $status ], 'https://wpautolistings.com/pro/' );
		}
		return '';
	}

	public function check_license() {
		$request = rwmb_request();

		$option = get_option( 'auto_listings_options' );
		$option['license_status'] = 'invalid';

		$args           = $option;
		$args['action'] = 'check_license';
		$response       = $this->checker->request( $args );
		$status         = isset( $response['status'] ) ? $response['status'] : 'invalid';

		if ( false === $response ) {
			add_settings_error( '', 'al-error', __( 'Something wrong with the connection to wpautolistings.com. Please try again later.', 'auto-listings' ) );
		} elseif ( 'active' === $status ) {
			add_settings_error( '', 'al-success', __( 'Your license is activated.', 'auto-listings' ), 'updated' );
		} elseif ( 'invalid' === $status ) {
			$message = __( 'Invalid license. Please check again or <a href="%1$s" target="_blank">get a new license here</a>.', 'auto-listings' );
			$message = wp_kses_post( sprintf( $message, 'https://wpautolistings.com/pro/' ) );
			add_settings_error( '', 'al-invalid', $message );
		} elseif ( 'expired' === $status ) {
			$message = __( 'License expired. Please renew the license to continue using the PRO version.', 'auto-listings' );
			$message = wp_kses_post( $message );
			add_settings_error( '', 'al-expired', $message );
		}

		$option['license_status'] = $status;

		$this->option->update( $option );
	}
}
