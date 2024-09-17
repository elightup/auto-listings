<?php ob_start(); ?>

<p><?php esc_html_e( 'Need to customize the plugin to suit your needs?', 'auto-listings' ); ?></p>
<p><?php esc_html_e( 'We offer customization service with affordable price.', 'auto-listings' ); ?></p>
<p><a href="https://wpautolistings.com/services/?utm_source=settings_page&utm_medium=link&utm_campaign=auto_listings" class="button button-primary" target="_blank"><?php esc_html_e( 'Send us an email', 'auto-listings' ); ?> &rarr;</a></p>
<?php
$message = ob_get_clean();
return [
	'id'             => 'sidebar-services',
	'title'          => __( 'Customization Service', 'auto-listings' ),
	'settings_pages' => 'auto-listings',
	'context'        => 'side',
	'fields'         => [
		[
			'std'  => wp_kses_post( $message ),
			'type' => 'custom_html',
		],
	],
];
