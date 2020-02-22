<?php
/**
 * Plugin Name: Auto Listings
 * Description: The best car listings and car dealership plugin for WordPress
 * Author:      WP Auto Listings
 * Author URI:  https://wpautolistings.com
 * Plugin URI:  https://wpautolistings.com
 * Version:     2.1.5
 * Text Domain: auto-listings
 * Domain Path: languages
 *
 * @package Auto Listings
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || die;

final class AutoListings {
	public function __construct() {
		register_activation_hook( __FILE__, array( $this, 'check_php_version' ) );

		add_action( 'plugins_loaded', array( $this, 'load' ) );

		add_action( 'init', [ $this, 'load_plugin_textdomain' ], 0 );
	}

	public function check_php_version() {
		if ( version_compare( phpversion(), '5.4', '<' ) ) {
			die( esc_html__( 'Auto listings plugin requires PHP version 5.4+. Please contact your host and ask them to upgrade.', 'auto-listings' ) );
		}
	}

	public function load_plugin_textdomain() {
		load_plugin_textdomain( 'auto-listings', false, basename( __DIR__ ) . '/languages' );
	}

	public function load() {
		require __DIR__ . '/bootstrap.php';
	}
}

require __DIR__ . '/vendor/autoload.php';
new AutoListings\Installer( __FILE__ );

new AutoListings();