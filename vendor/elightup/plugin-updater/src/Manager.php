<?php
namespace eLightUp\PluginUpdater;

class Manager {
	public $api_url;
	public $option_name;
	public $my_account_url;
	public $buy_url;
	public $slug;
	public $plugin;
	public $parent_page;
	public $settings_page;
	public $settings_page_slug;

	public $option;
	public $checker;
	public $settings;
	public $notification;

	public function __construct( $args ) {
		$this->api_url        = $args['api_url'];
		$this->my_account_url = $args['my_account_url'];
		$this->buy_url        = $args['buy_url'];
		$this->slug           = $args['slug'];
		$this->option_name    = $this->slug . '_license';

		// Settings page.
		$this->parent_page        = $args['parent_page'] ?? 'options-general.php';
		$this->settings_page      = $args['settings_page'] ?? admin_url( "{$this->parent_page}?page={$this->slug}-license" );
		$this->settings_page_slug = $args['settings_page_slug'] ?? "{$this->slug}-license";

		if ( ! function_exists( 'get_plugin_data' ) ) {
			require_once ABSPATH . 'wp-admin/includes/plugin.php';
		}
		$this->plugin = (object) get_plugin_data( WP_PLUGIN_DIR . "/{$this->slug}/{$this->slug}.php" );

		$this->option       = new Option( $this );
		$this->checker      = new Checker( $this, $this->option );
		$this->settings     = new Settings( $this, $this->checker, $this->option );
		$this->notification = new Notification( $this, $this->option );
	}

	public function setup() {
		$this->settings->setup();
		$this->checker->setup();
		$this->notification->setup();
	}
}
