<?php ob_start(); ?>
<p><?php esc_html_e( 'Want a full-featured theme that is compatible with the plugin?', 'auto-listings' ); ?></p>
<p><?php printf( __( 'Check out %s - our <strong>free</strong> theme for car listings website.', 'auto-listings' ), '<a href="https://wpautolistings.com/themes/?utm_source=WordPress&utm_medium=link&utm_campaign=plugin" target="_blank">CarListing</a>' ); ?></p>
<?php
$message = ob_get_clean();
return [
	'id'             => 'sidebar-themes',
	'title'          => __( 'Get A Theme', 'auto-listings' ),
	'settings_pages' => 'auto-listings',
	'context'        => 'side',
	'fields'         => [
		[
			'std'  => wp_kses_post( $message ),
			'type' => 'custom_html',
		],
	],
];
