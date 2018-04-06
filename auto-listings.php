<?php
/**
 * Plugin Name: Auto Listings
 * Description: An Automotive Listings plugin for WordPress.
 * Author: WP Auto Listings
 * Author URI: https://wpautolistings.com
 * Plugin URI: https://wpautolistings.com
 * Version: 1.1.6
 * Text Domain: auto-listings
 * Domain Path: languages
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

include 'bootstrap.php';
