<?php
namespace AutoListings\Update;

class Checker {
	// Update API endpoint URL.
	// private $api_url = 'https://wpautolistings.com/index.php';
	private $api_url = 'http://localhost/autolistingsplugins/index.php';

	// The update option object.
	private $option;

	/**
	 * Constructor.
	 * @param object $option  Update option object.
	 */
	public function __construct( $option ) {
		$this->option = $option;
	}

	/**
	 * Add hooks to check plugin updates.
	 */
	public function init() {
		add_action( 'init', [ $this, 'enable_update' ], 1 );
	}

	/**
	 * Enable update checker when premium extensions are installed.
	 */
	public function enable_update() {
		if ( $this->has_extensions() ) {
			add_filter( 'pre_set_site_transient_update_plugins', [ $this, 'check_updates' ] );
			add_filter( 'plugins_api', [ $this, 'get_info' ], 10, 3 );
		}
	}

	/**
	 * Check if any premium extension is installed.
	 *
	 * @return bool
	 */
	public function has_extensions() {
		$extensions = $this->get_extensions();
		return ! empty( $extensions );
	}

	/**
	 * Get installed premium extensions.
	 *
	 * @return array Array of extension slugs.
	 */
	public function get_extensions() {
		if ( ! function_exists( 'get_plugins' ) ) {
			require_once ABSPATH . 'wp-admin/includes/plugin.php';
		}

		$extensions = [
			'auto-listings-pro',
		];
		$plugins    = get_plugins();
		$plugins    = array_map( 'dirname', array_keys( $plugins ) );

		return array_intersect( $extensions, $plugins );
	}

	/**
	 * Check plugin for updates
	 *
	 * @param object $data The plugin update data.
	 *
	 * @return mixed
	 */
	public function check_updates( $data ) {
		static $response = null;

		$request = rwmb_request();

		// Bypass embed plugins via TGMPA.
		if ( $request->get( 'tgmpa-update' ) || 'tgmpa-bulk-update' === $request->post( 'action' ) ) {
			return $data;
		}

		// Make sure to send remote request once.
		if ( null === $response ) {
			$response = $this->request( [ 'action' => 'check_updates' ] );
		}

		if ( false === $response ) {
			return $data;
		}

		if ( ! isset( $data->response ) ) {
			$data->response = [];
		}

		$plugins = array_filter( $response['data'], [ $this, 'has_update' ] );
		foreach ( $plugins as $plugin ) {
			if ( empty( $plugin->package ) ) {
				$plugin->upgrade_notice = __( 'UPDATE UNAVAILABLE! Please enter a valid license key to enable automatic updates.', 'auto-listings' );
			}

			$data->response[ $plugin->plugin ] = $plugin;
		}

		$this->option->update( [
			'status'  => $response['status'],
			'plugins' => array_keys( $plugins ),
		] );

		return $data;
	}

	/**
	 * Get plugin information
	 *
	 * @param object $data   The plugin update data.
	 * @param string $action Request action.
	 * @param object $args   Extra parameters.
	 *
	 * @return mixed
	 */
	public function get_info( $data, $action, $args ) {
		$plugins = $this->option->get( 'plugins', [] );
		if ( 'plugin_information' !== $action || ! isset( $args->slug ) || ! in_array( $args->slug, $plugins, true ) ) {
			return $data;
		}

		$response = $this->request( [
			'action'  => 'get_info',
			'product' => $args->slug,
		] );

		return false === $response ? $data : $response['data'];
	}

	/**
	 * Send request to remote host
	 *
	 * @param array|string $args Query arguments.
	 *
	 * @return mixed
	 */
	public function request( $args = '' ) {
		$args = wp_parse_args( $args, [
			'license_key' => $this->option->get_license_key(),
		] );
		$args = array_filter( $args );

		$request = wp_remote_post( $this->api_url, [
			'body' => $args,
		] );

		$response = wp_remote_retrieve_body( $request );
		return $response ? @unserialize( $response ) : false;
	}

	/**
	 * Check if a plugin has an update to a new version.
	 *
	 * @param object $plugin_data The plugin update data.
	 *
	 * @return bool
	 */
	private function has_update( $plugin_data ) {
		$plugins = get_plugins();

		return isset( $plugins[ $plugin_data->plugin ] ) && version_compare( $plugins[ $plugin_data->plugin ]['Version'], $plugin_data->new_version, '<' );
	}
}
