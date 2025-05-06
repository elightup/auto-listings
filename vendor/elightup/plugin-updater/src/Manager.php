<?php
namespace eLightUp\PluginUpdater;

class Manager {
	public $api_url;
	public $option_name;
	public $my_account_url;
	public $buy_url;
	public $slug;
	public $plugin_id;
	public $plugin;
	public $parent_page;
	public $settings_page;
	public $settings_page_slug;

	public $option;
	public $checker;
	public $settings;
	public $notification;

	public function __construct( array $args ) {
		$this->api_url        = $args['api_url'];
		$this->my_account_url = $args['my_account_url'];
		$this->buy_url        = $args['buy_url'];
		$this->slug           = $args['slug'];
		$this->plugin_id      = $args['plugin_id'] ?? $args['slug'];
		$this->option_name    = $this->slug . '_license';

		// Settings page.
		$this->parent_page        = $args['parent_page'] ?? 'options-general.php';
		$this->settings_page      = $args['settings_page'] ?? admin_url( "{$this->parent_page}?page={$this->slug}-license" );
		$this->settings_page_slug = $args['settings_page_slug'] ?? "{$this->slug}-license";

		$this->option       = new Option( $this );
		$this->checker      = new Checker( $this, $this->option );
		$this->settings     = new Settings( $this, $this->checker, $this->option );
		$this->notification = new Notification( $this, $this->option );

		add_action( 'init', [ $this, 'load_plugin_data' ] );
	}

	public function setup(): void {
		if ( apply_filters( 'elightup_plugin_updater_disallow_setup', false, $this->plugin_id ) ) {
			return;
		}

		$this->settings->setup();
		$this->checker->setup();
		$this->notification->setup();
	}

	public function load_plugin_data(): void {
		if ( ! function_exists( 'get_plugin_data' ) ) {
			require_once ABSPATH . 'wp-admin/includes/plugin.php';
		}
		$this->plugin = (object) get_plugin_data( WP_PLUGIN_DIR . "/{$this->slug}/{$this->slug}.php" );
	}
}
