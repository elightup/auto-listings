<?php ob_start(); ?>
<p>
	<?php
	/* translators: theme url */
	echo wp_kses_post( sprintf( __( '%s - our premium theme for car dealership and car listings websites.', 'auto-listings' ), '<a href="https://themeforest.net/item/corify-wordpress-car-listings-dealership-theme/25740868?ref=fitwp" target="_blank">Corify</a>' ) );
	?>
</p>
<p>
	<?php
	/* translators: theme url */
	echo wp_kses_post( sprintf( __( '%s - free theme that helps you build a listings website with ease.', 'auto-listings' ), '<a href="https://wpautolistings.com/themes/?utm_source=WordPress&utm_medium=link&utm_campaign=plugin" target="_blank">CarListings</a>' ) );
	?>
</p>
<?php
$message = ob_get_clean();
return [
	'id'             => 'sidebar-themes',
	'title'          => __( 'Recommended Themes', 'auto-listings' ),
	'settings_pages' => 'auto-listings',
	'context'        => 'side',
	'fields'         => [
		[
			'std'  => wp_kses_post( $message ),
			'type' => 'custom_html',
		],
	],
];
