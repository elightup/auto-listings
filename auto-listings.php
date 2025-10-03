<?php
/**
 * Plugin Name:      Auto Listings
 * Description:      The best car listings and car dealership plugin for WordPress
 * Author:           WP Auto Listings
 * Author URI:       https://wpautolistings.com
 * Plugin URI:       https://wpautolistings.com
 * Version:          2.6.19
 * Text Domain:      auto-listings
 * License:          GPLv3
 *
 * Copyright (C) 2010-2025 Tran Ngoc Tuan Anh. All rights reserved.
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <http://www.gnu.org/licenses/>.
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || die;

require __DIR__ . '/vendor/autoload.php';

new AutoListings\Installer( __FILE__ );

add_action( 'plugins_loaded', 'auto_listings_load' );

function auto_listings_load() {
	// If Meta Box is NOT active.
	if ( ! defined( 'RWMB_VER' ) ) {
		add_action( 'admin_notices', 'auto_listings_admin_notice' );
		return;
	}

	$plugins = [
		'mb-frontend-submission',
		'mb-settings-page',
		'meta-box-columns',
		'meta-box-geolocation',
		'meta-box-group',
	];
	foreach ( $plugins as $plugin ) {
		require __DIR__ . "/vendor/meta-box/$plugin/$plugin.php";
	}

	require __DIR__ . '/bootstrap.php';
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
