<?php
/**
 * Plugin Name: MB Frontend Submission
 * Plugin URI:  https://metabox.io/plugins/mb-frontend-submission
 * Description: Submit posts and custom fields in the frontend.
 * Version:     4.5.5
 * Author:      MetaBox.io
 * Author URI:  https://metabox.io
 * License:     GPL2+
 * Text Domain: mb-frontend-submission
 * Domain Path: /languages/
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

// Prevent loading this file directly.
if ( ! defined( 'ABSPATH' ) ) {
	return;
}

if ( ! function_exists( 'mb_frontend_submission_load' ) ) {
	if ( file_exists( __DIR__ . '/vendor' ) ) {
		require __DIR__ . '/vendor/autoload.php';
	}

	add_action( 'init', 'mb_frontend_submission_load', 20 );

	function mb_frontend_submission_load() {
		if ( ! defined( 'RWMB_VER' ) ) {
			return;
		}

		define( 'MBFS_DIR', __DIR__ );
		list( , $url ) = RWMB_Loader::get_path( MBFS_DIR );
		define( 'MBFS_URL', $url );
		define( 'MBFS_VER', '4.5.5' );
		define( 'MBFS_DB_VER', 2 );

		load_plugin_textdomain( 'mb-frontend-submission', false, basename( MBFS_DIR ) . '/languages' );

		new MBFS\Upgrade();

		new MBFS\Shortcode();
		new MBFS\HideFields();

		if ( is_admin() ) {
			new MBFS\PostFields();
		}

		// Dashboard.
		$dashboard_renderer = new MBFS\Dashboard\Renderer();
		new MBFS\Dashboard\Shortcode( $dashboard_renderer );
		new MBFS\Dashboard\Delete();

		new MBFS\Integrations\Bricks\Register();
		new MBFS\Integrations\Elementor\Register();

		new MBFS\Blocks\SubmissionForm();
		new MBFS\Blocks\UserDashboard( $dashboard_renderer );
		new MBFS\Blocks\Attributes();

		new MBFS\ConvertToBlocks();
	}
}
