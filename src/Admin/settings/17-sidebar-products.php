<?php
/**
 * Plugin recomemdation.
 *
 * @package Auto Listings.
 */

ob_start();
?>

<p><?php echo wp_kses_post( sprintf( __( ' Wanna to improve SEO for your site? Check out <a href="%1$s" target="_blank"><strong>%2$s</strong></a>, our automated and lightweight SEO plugin that:', 'auto-listings' ), 'https://wpslimseo.com/?utm_source=settings_page&utm_medium=link&utm_campaign=auto_listings', 'Slim SEO' ) ); ?></p>
<ul>
	<li><span class="dashicons dashicons-yes-alt"></span> <?php esc_html_e( 'Automatically generates meta tags', 'auto-listings' ) ?></li>
	<li><span class="dashicons dashicons-yes-alt"></span> <?php esc_html_e( 'Adds XML sitemap', 'auto-listings' ) ?></li>
	<li><span class="dashicons dashicons-yes-alt"></span> <?php esc_html_e( 'Automatically generates schemas', 'auto-listings' ) ?></li>
	<li><span class="dashicons dashicons-yes-alt"></span> <?php esc_html_e( 'Integrates well with Auto Listings', 'auto-listings' ) ?></li>
</ul>
<a class="button button-primary" href="https://wpslimseo.com/?utm_source=settings_page&utm_medium=link&utm_campaign=auto_listings" target="_blank">
	<?php // Translators: %s - plugin name ?>
	<?php echo esc_html( sprintf( __( 'Get %s', 'auto-listings' ), 'Slim SEO' ) ); ?> &rarr;
</a>
<?php
$message = ob_get_clean();
return [
	'id'             => 'products-services',
	'title'          => __( 'Recommended SEO', 'auto-listings' ),
	'settings_pages' => 'auto-listings',
	'context'        => 'side',
	'fields'         => [
		[
			'std'  => wp_kses_post( $message ),
			'type' => 'custom_html',
		],
	],
];
