<?php
namespace eLightUp\PluginUpdater;

class Checker {
	private $manager;
	private $option;
	private $response;

	public function __construct( Manager $manager, Option $option ) {
		$this->manager = $manager;
		$this->option  = $option;
	}

	public function setup() {
		add_action( 'init', [ $this, 'enable_update' ], 1 );
	}

	public function enable_update() {
		add_filter( 'pre_set_site_transient_update_plugins', [ $this, 'check_update' ] );
		add_filter( 'plugins_api', [ $this, 'get_info' ], 10, 3 );
	}

	public function check_update( $data ) {
		$this->request();
		if ( ! $this->response ) {
			return $data;
		}

		if ( empty( $data ) ) {
			$data = new \stdClass;
		}
		if ( ! isset( $data->response ) ) {
			$data->response = [];
		}

		$update = $this->response['data'];
		if ( isset( $update->new_version ) && version_compare( $this->manager->plugin->Version, $update->new_version, '<' ) ) {
			if ( empty( $update->package ) ) {
				$update->upgrade_notice = __( 'UPDATE UNAVAILABLE! Please enter a valid license key to enable automatic updates.', 'elightup-plugin-updater' );
			}
			$data->response[ $update->plugin ] = $update;
		}

		$this->option->update( [
			'status' => $this->response['status'],
		] );

		return $data;
	}

	public function get_info( $data, $action, $args ) {
		if ( 'plugin_information' !== $action || ! isset( $args->slug ) || $args->slug !== $this->manager->slug ) {
			return $data;
		}

		$this->request();
		return $this->response ? $this->response['data'] : $data;
	}

	public function request( $args = [] ) {
		if ( null !== $this->response ) {
			return $this->response;
		}

		$args = wp_parse_args( $args, [
			'action'  => 'get_info',
			'api_key' => $this->option->get_license_key(),
			'product' => $this->manager->slug,
			'url'     => home_url(),
		] );

		// Get from cache first.
		// phpcs:ignore WordPress.PHP.DiscouragedPHPFunctions.serialize_serialize
		$cache_key = 'elightup_' . md5( serialize( $args ) );
		$cache     = get_transient( $cache_key );
		if ( $cache ) {
			$this->response = $cache;
			return $this->response;
		}

		$request = wp_remote_post( $this->manager->api_url, [
			'body' => $args,
		] );

		$response = wp_remote_retrieve_body( $request );
		// phpcs:ignore WordPress.PHP.NoSilencedErrors.Discouraged, WordPress.PHP.DiscouragedPHPFunctions.serialize_unserialize
		$this->response = $response ? @unserialize( $response ) : null;

		// Cache requests.
		set_transient( $cache_key, $this->response, DAY_IN_SECONDS );

		return $this->response;
	}
}
