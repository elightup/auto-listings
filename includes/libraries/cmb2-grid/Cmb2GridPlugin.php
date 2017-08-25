<?php
/**
 * Plugin Name: CMB2 Grid
 * Plugin URI:  https://github.com/origgami/CMB2-grid
 * Description: A grid system for Wordpress CMB2 library that allows columns creation
 * Version:     1.0.0
 * Author:      Origgami
 * Author URI:  http://origgami.com.br
 * Depends:     CMB2
 * License:     GPLv2
 * Text Domain: cmb2-grid
 */

/**
 * Show admin notice & de-activate itself if PHP < 5.3 is detected.
 */
if ( version_compare( PHP_VERSION, '5.3', '<' ) ) {
	add_action( 'admin_init', 'cmb2_grid_deactivate' );

	if ( ! function_exists( 'cmb2_grid_deactivate' ) ) {
		/**
		 * Check for parent plugin.
		 */
		function cmb2_grid_deactivate() {
			if ( is_admin() && current_user_can( 'activate_plugins' ) 
				// && is_plugin_active( plugin_basename( __FILE__ ) ) 
				) {
				add_action( 'admin_notices', create_function( null, 'echo \'<div class="error"><p>\', __( \'Activation failed: The CMB2 Grid plugin required PHP 5.3+. Please contact your webhost and ask them to upgrade the PHP version for your webhosting account.\', \'cmb2-grid\' ), \'</a></p></div>\';' ) );

				// deactivate_plugins( plugin_basename( __FILE__ ) );
				// if ( isset( $_GET['activate'] ) ) {
				// 	unset( $_GET['activate'] );
				// }
			}
		}
	}
} else {
	/* PHP 5.3+, so load the plugin.  */
	include_once dirname( __FILE__ ) . '/Cmb2GridPluginLoad.php';
}
/* PHP 5.3+, so load the plugin.  */
	include_once dirname( __FILE__ ) . '/Cmb2GridPluginLoad.php';