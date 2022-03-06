<?php
/**
 * Plugin Name: Auto Listings
 * Description: The best car listings and car dealership plugin for WordPress
 * Author:      WP Auto Listings
 * Author URI:  https://wpautolistings.com
 * Plugin URI:  https://wpautolistings.com
 * Version:     2.6.0
 * Text Domain: auto-listings
 * Domain Path: languages
 *
 * @package Auto Listings
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || die;

include __DIR__ . '/vendor/autoload.php';

new AutoListings\Installer( __FILE__ );

register_activation_hook( __FILE__, 'auto_listings_check_php_version' );

/**
 * Display notice for old PHP version.
 */
function auto_listings_check_php_version() {
	if ( version_compare( phpversion(), '5.6', '<' ) ) {
		die( esc_html__( 'Auto listings plugin requires PHP version 5.4+. Please contact your host and ask them to upgrade.', 'auto-listings' ) );
	}
}

add_action( 'plugins_loaded', 'auto_listings_load' );

function auto_listings_load() {
	// If Meta Box is NOT active.
	if ( ! defined( 'RWMB_VER' ) ) {
		add_action( 'admin_notices', 'auto_listings_admin_notice' );
	} else {
		require __DIR__ . '/bootstrap.php';
	}
}

function auto_listings_admin_notice() {
	$plugins      = get_plugins();
	$is_installed = isset( $plugins['meta-box/meta-box.php'] );
	$install_url  = wp_nonce_url( admin_url( 'update.php?action=install-plugin&plugin=meta-box' ), 'install-plugin_meta-box' );
	$activate_url = wp_nonce_url( admin_url( 'plugins.php?action=activate&amp;plugin=meta-box/meta-box.php' ), 'activate-plugin_meta-box/meta-box.php' );
	$action_url   = $is_installed ? $activate_url : $install_url;
	$action       = $is_installed ? __( 'activate', 'auto-listings' ) : __( 'install', 'auto-listings' );

	$child  = __( 'Auto Listings', 'auto-listings' );
	$parent = __( 'Meta Box', 'auto-listings' );
	printf(
		// Translators: %1$s is the plugin name, %2$s is the Meta Box plugin name.
		'<div class="error"><p>' . esc_html__( '%1$s requires %2$s to function correctly. %3$s to %4$s %2$s.', 'auto-listings' ) . '</p></div>',
		'<strong>' . esc_html( $child ) . '</strong>',
		'<strong>' . esc_html( $parent ) . '</strong>',
		'<a href="' . esc_url( $action_url ) . '">' . esc_html__( 'Click here', 'auto-listings' ) . '</a>',
		esc_html( $action )
	);

	if ( isset( $_GET['activate'] ) ) {
		unset( $_GET['activate'] );
	}
}
