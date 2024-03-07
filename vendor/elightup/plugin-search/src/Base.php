<?php
namespace eLightUp\PluginSearch;

abstract class Base {
	protected $result;
	protected $action;
	protected $args;

	public function __construct() {
		add_filter( 'plugins_api_result', [ $this, 'process' ], 10, 3 );
	}

	public function process( $result, $action, $args ) {
		$this->result = $result;
		$this->action = $action;
		$this->args   = $args;

		if ( ! $this->check() ) {
			return $result;
		}

		$this->suggests();
		return $this->result;
	}

	abstract protected function suggests();

	protected function check(): bool {
		$paged = $_GET['paged'] ?? 1;
		if ( $paged != 1 ) {
			return false;
		}

		if ( is_wp_error( $this->result ) || $this->action !== 'query_plugins' ) {
			return false;
		}

		return $this->validate();
	}

	abstract protected function validate(): bool;

	protected function insert( string $slug, int $position ) {
		$slugs = wp_list_pluck( $this->result->plugins, 'slug' );
		$index = array_search( $slug, $slugs, true );

		// Not in the list? Add it.
		if ( $index === false ) {
			$plugin = $this->get_plugin_info( $slug );
			array_splice( $this->result->plugins, $position, 0, [ $plugin ] );
		}

		// Higher position: do nothing.
		if ( $index < $position ) {
			return;
		}

		// Move it to the new position.
		$plugin = $this->result->plugins[ $index ];
		array_splice( $this->result->plugins, $index, 1 );
		array_splice( $this->result->plugins, $position, 0, [ $plugin ] );
	}

	private function get_plugin_info( $slug ) {
		$cache_key = "eps_plugin_$slug";
		$info      = get_transient( $cache_key );
		if ( $info !== false ) {
			return $info;
		}

		$args = [
			'page'     => 1,
			'per_page' => 1,
			'locale'   => get_user_locale(),
			'search'   => $slug,
		];
		$url  = add_query_arg( [
			'action'  => 'query_plugins',
			'request' => $args,
		], 'https://api.wordpress.org/plugins/info/1.2/' );

		$request = wp_remote_get( $url, [ 'timeout' => 15 ] );
		$info    = wp_remote_retrieve_body( $request );
		if ( ! $info ) {
			return null;
		}
		$info = json_decode( $info, true );
		$info = $info['plugins'][0];

		set_transient( $cache_key, $info, DAY_IN_SECONDS );
		return $info;
	}
}
