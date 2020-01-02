<?php
/**
 * Plugin recomemdation.
 *
 * @package Auto Listings.
 */

ob_start();
?>

<p><?php esc_html_e( ' Like this plugin? Check out our other WordPress products:', 'auto-listings' ); ?></p>
<p><a href="https://metabox.io/?utm_source=WordPress&utm_medium=link&utm_campaign=autolistings" target="_blank"><?php esc_html_e( 'Meta Box', 'auto-listings' ); ?></a> - <?php esc_html_e( 'Custom Fields Framework for WordPress' ); ?>.</p>
<p><a href="https://wpslimseo.com/?utm_source=WordPress&utm_medium=link&utm_campaign=autolistings" target="_blank"><?php esc_html_e( 'Slim SEO', 'auto-listings' ); ?></a> - <?php esc_html_e( 'Automated & fast SEO plugin for WordPress' ); ?>.</p>
<p><a href="https://gretathemes.com/?utm_source=WordPress&utm_medium=link&utm_campaign=autolistings" target="_blank"><?php esc_html_e( 'GretaThemes', 'auto-listings' ); ?></a> - <?php esc_html_e( 'Free and Premium WordPress Themes' ); ?>.</p>
<?php
$message = ob_get_clean();
return [
	'id'             => 'products-services',
	'title'          => __( 'Our WordPress Products', 'auto-listings' ),
	'settings_pages' => 'auto-listings',
	'context'        => 'side',
	'fields'         => [
		[
			'std'  => wp_kses_post( $message ),
			'type' => 'custom_html',
		],
	],
];
