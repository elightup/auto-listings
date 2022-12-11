<?php
namespace eLightUp\PluginUpdater;

class Notification {
	private $manager;
	private $option;

	public function __construct( Manager $manager, Option $option ) {
		$this->manager = $manager;
		$this->option  = $option;
	}

	public function setup() {
		$file = "{$this->manager->slug}/{$this->manager->slug}.php";
		add_action( "in_plugin_update_message-$file", [ $this, 'show_update_message' ], 10, 2 );
		add_filter( "plugin_action_links_$file", [ $this, 'plugin_links' ], 20 );

		// Only show admin notice if license key is not defined via a constant.
		if ( ! $this->option->get_license_key_constant() ) {
			add_action( 'admin_notices', [ $this, 'notify' ] );
		}
	}

	/**
	 * Notify users to enter license key.
	 */
	public function notify() {
		// Do not show notification on License page.
		if ( filter_input( INPUT_GET, 'page' ) === $this->manager->settings_page_slug ) {
			return;
		}

		$messages = [
			// Translators: %1$s - URL to the settings page, %2$s - URL to the buy page, %3$s - plugin name.
			'no_key'  => __( 'You have not set a license key for %3$s yet, which means you are missing out on automatic updates and support! Please <a href="%1$s">enter your license key</a> or <a href="%2$s" target="_blank">get a new one here</a>.', 'elightup-plugin-updater' ),
			// Translators: %1$s - URL to the settings page, %2$s - URL to the buy page, %3$s - plugin name.
			'invalid' => __( 'Your license key for %3$s is <b>invalid</b>. Please <a href="%1$s">update your license key</a> or <a href="%2$s" target="_blank">get a new one</a> to enable automatic updates.', 'elightup-plugin-updater' ),
			// Translators: %1$s - URL to the settings page, %2$s - URL to the buy page, %3$s - plugin name.
			'error'   => __( 'Your license key for %3$s is <b>invalid</b>. Please <a href="%1$s">update your license key</a> or <a href="%2$s" target="_blank">get a new one</a> to enable automatic updates.', 'elightup-plugin-updater' ),
			// Translators: %1$s - URL to the settings page, %2$s - URL to the buy page, %3$s - plugin name.
			'expired' => __( 'Your license key for %3$s is <b>expired</b>. Please renew your license to get automatic updates and premium support.', 'elightup-plugin-updater' ),
		];
		$status   = $this->option->get_license_status();
		if ( ! isset( $messages[ $status ] ) ) {
			return;
		}

		echo '<div class="notice notice-warning is-dismissible"><p><span class="dashicons dashicons-warning" style="color: #f56e28"></span> ', wp_kses_post( sprintf( $messages[ $status ], $this->manager->settings_page, $this->manager->buy_url, $this->manager->plugin->Name ) ), '</p></div>';
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

		$messages = [
			// Translators: %1$s - URL to the settings page, %2$s - URL to the buy page.
			'no_key'  => __( 'Please <a href="%1$s">enter your license key</a> or <a href="%2$s" target="_blank">get a new one here</a>.', 'elightup-plugin-updater' ),
			// Translators: %1$s - URL to the settings page, %2$s - URL to the buy page.
			'invalid' => __( 'Your license key is <b>invalid</b>. Please <a href="%1$s">update your license key</a> or <a href="%2$s" target="_blank">get a new one here</a>.', 'elightup-plugin-updater' ),
			// Translators: %1$s - URL to the settings page, %2$s - URL to the buy page.
			'error'   => __( 'Your license key is <b>invalid</b>. Please <a href="%1$s">update your license key</a> or <a href="%2$s" target="_blank">get a new one here</a>.', 'elightup-plugin-updater' ),
			// Translators: %3$s - URL to the My Account page.
			'expired' => __( 'Your license key is <b>expired</b>. Please <a href="%3$s" target="_blank">renew your license</a>.', 'elightup-plugin-updater' ),
		];
		$status   = $this->option->get_license_status();
		if ( ! isset( $messages[ $status ] ) ) {
			return;
		}

		echo '<br><span style="width: 26px; height: 20px; display: inline-block;">&nbsp;</span>', wp_kses_post( sprintf( $messages[ $status ], $this->manager->settings_page, $this->manager->buy_url, $this->manager->my_account_url ) );
	}

	/**
	 * Add link for activate or update the license key.
	 *
	 * @param array $links Array of plugin links.
	 * @return array
	 */
	public function plugin_links( $links ) {
		$status = $this->option->get_license_status();
		if ( 'active' === $status ) {
			return $links;
		}

		$text    = 'no_key' === $status ? __( 'Activate License', 'elightup-plugin-updater' ) : __( 'Update License', 'elightup-plugin-updater' );
		$links[] = '<a href="' . esc_url( $this->manager->settings_page ) . '" style="color: #39b54a; font-weight: bold">' . esc_html( $text ) . '</a>';

		return $links;
	}
}
