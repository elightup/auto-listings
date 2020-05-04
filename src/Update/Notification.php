<?php
namespace AutoListings\Update;

class Notification {
	/**
	 * The update option object.
	 */
	private $option;

	/**
	 * Settings page URL.
	 */
	private $settings_page;

	/**
	 * The update checker object.
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

		$this->settings_page = admin_url( 'admin.php?page=auto-listings#tab-license' );
	}

	public function init() {
		add_action( 'init', [ $this, 'show_notifications' ] );
	}

	public function show_notifications() {
		if ( ! $this->checker->has_extensions() ) {
			return;
		}

		// Show update message on Plugins page.
		$extensions = $this->checker->get_extensions();
		foreach ( $extensions as $extension ) {
			$file = "{$extension}/{$extension}.php";
			add_action( "in_plugin_update_message-$file", array( $this, 'show_update_message' ), 10, 2 );
			add_filter( "plugin_action_links_$file", array( $this, 'plugin_links' ), 20 );
		}

		add_action( 'admin_notices', array( $this, 'notify' ) );
	}

	/**
	 * Notify users to enter license key.
	 */
	public function notify() {
		$messages = array(
			'no_key'  => __( 'You have not set a license key for Auto Listings PRO yet, which means you are missing out on automatic updates and support! Please <a href="%1$s">enter your license key</a> or <a href="%2$s" target="_blank">get a new one here</a>.', 'auto-listings' ),
			'invalid' => __( 'Your license key for Auto Listings PRO is <b>invalid</b>. Please <a href="%1$s">update your license key</a> or <a href="%2$s" target="_blank">get a new one</a> to enable automatic updates.', 'auto-listings' ),
			'error'   => __( 'Your license key for Auto Listings PRO is <b>invalid</b>. Please <a href="%1$s">update your license key</a> or <a href="%2$s" target="_blank">get a new one</a> to enable automatic updates.', 'auto-listings' ),
			'expired' => __( 'Your license key for Auto Listings PRO is <b>expired</b>. Please renew your license to get automatic updates and premium support.', 'auto-listings' ),
		);
		$status   = $this->option->get_license_status();
		if ( ! isset( $messages[ $status ] ) ) {
			return;
		}

		echo '<div class="notice notice-warning is-dismissible"><p><span class="dashicons dashicons-warning" style="color: #f56e28"></span> ', wp_kses_post( sprintf( $messages[ $status ], $this->settings_page, 'https://wpautolistings.com/pro/' ) ), '</p></div>';
	}

	/**
	 * Show update message on Plugins page.
	 *
	 * @param  array  $plugin_data Plugin data.
	 * @param  object $response    Available plugin update data.
	 */
	public function show_update_message( $plugin_data, $response ) {
		// Users have an active license.
		if ( ! empty( $response->package ) ) {
			return;
		}

		$messages = array(
			'no_key'  => __( 'Please <a href="%1$s">enter your license key</a> or <a href="%2$s" target="_blank">get a new one here</a>.', 'auto-listings' ),
			'invalid' => __( 'Your license key is <b>invalid</b>. Please <a href="%1$s">update your license key</a> or <a href="%2$s" target="_blank">get a new one here</a>.', 'auto-listings' ),
			'error'   => __( 'Your license key is <b>invalid</b>. Please <a href="%1$s">update your license key</a> or <a href="%2$s" target="_blank">get a new one here</a>.', 'auto-listings' ),
			'expired' => __( 'Your license key is <b>expired</b>. Please renew your license.', 'auto-listings' ),
		);
		$status   = $this->option->get_license_status();
		if ( ! isset( $messages[ $status ] ) ) {
			return;
		}

		echo '<br><span style="width: 26px; height: 20px; display: inline-block;">&nbsp;</span>' . wp_kses_post( sprintf( $messages[ $status ], $this->settings_page, 'https://wpautolistings.com/pro/' ) );
	}

	/**
	 * Add link for activate or update the license key.
	 *
	 * @param array $links Array of plugin links.
	 *
	 * @return array
	 */
	public function plugin_links( $links ) {
		$status = $this->option->get_license_status();
		if ( 'active' === $status ) {
			return $links;
		}

		$text    = 'no_key' === $status ? __( 'Activate License', 'auto-listings' ) : __( 'Update License', 'auto-listings' );
		$links[] = '<a href="' . esc_url( $this->settings_page ) . '" style="color: #39b54a; font-weight: bold">' . esc_html( $text ) . '</a>';

		return $links;
	}
}
