<?php
/**
 * Plugin Name: MB Frontend Submission
 * Plugin URI:  https://metabox.io/plugins/mb-frontend-submission
 * Description: Submit posts and custom fields in the frontend.
 * Version:     4.4.2
 * Author:      MetaBox.io
 * Author URI:  https://metabox.io
 * License:     GPL2+
 * Text Domain: mb-frontend-submission
 * Domain Path: /languages/
 */

// Prevent loading this file directly.
defined( 'ABSPATH' ) || die;

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
		define( 'MBFS_VER', '4.4.2' );

		load_plugin_textdomain( 'mb-frontend-submission', false, basename( MBFS_DIR ) . '/languages' );

		new MBFS\Shortcode();
		new MBFS\HideFields();
		new MBFS\DuplicatedFields();

		$dashboard_renderer = new MBFS\DashboardRenderer();
		new MBFS\Dashboard( $dashboard_renderer );

		new MBFS\Bricks\Register();
		new MBFS\Elementor\Register();

		new MBFS\Block\SubmissionForm();
		new MBFS\Block\UserDashboard( $dashboard_renderer );
		new MBFS\Block\Attributes();
	}
}
