<?php
/**
 * Plugin Name: Auto Listings
 * Description: An automotive listings plugin for WordPress.
 * Author: WP Auto Listings
 * Author URI: https://wpautolistings.com
 * Plugin URI: https://wpautolistings.com
 * Version: 2.1.0
 * Text Domain: auto-listings
 * Domain Path: languages
 *
 * @package Auto Listings
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

register_activation_hook( __FILE__, 'auto_listings_check_php_version' );

/**
 * Display notice for old PHP version.
 */
function auto_listings_check_php_version() {
	if ( version_compare( phpversion(), '5.4', '<' ) ) {
		die( esc_html__( 'Auto listings plugin requires PHP version 5.4+. Please contact your host and ask them to upgrade.', 'auto-listings' ) );
	}
}

add_action( 'plugins_loaded', 'auto_listings_check_meta_box' );
/**
 * Check if Meta Box plugin is active.
 */
function auto_listings_check_meta_box() {
	if ( ! defined( 'RWMB_VER' ) ) {
		return;
	}
	require 'bootstrap.php';
}
