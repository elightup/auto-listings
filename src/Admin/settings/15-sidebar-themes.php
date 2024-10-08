<?php ob_start(); ?>
<p>
	<span class="dashicons dashicons-yes-alt"></span>
	<?php
	/* translators: theme url */
	echo wp_kses_post( sprintf( __( '%s - powerful, elegant and lightweight premium theme for car dealership and car listings websites.', 'auto-listings' ), '<strong>eCar</strong>' ) );
	?>
</p>
<p>
	<span class="dashicons dashicons-yes-alt"></span>
	<?php
	/* translators: theme url */
	echo wp_kses_post( sprintf( __( '%s - a must-have WordPress theme for car dealership and car listings websites.', 'auto-listings' ), '<strong>Corify</strong>' ) );
	?>
</p>
<p>
	<span class="dashicons dashicons-yes-alt"></span>
	<?php
	/* translators: theme url */
	echo wp_kses_post( sprintf( __( '%s - free theme that helps you build a listings website with ease.', 'auto-listings' ), '<strong>CarListings</strong>' ) );
	?>
</p>
<a href="https://wpautolistings.com/themes/?utm_source=settings_page&utm_medium=link&utm_campaign=auto_listings" class="button button-primary"><?php esc_html_e( 'Get all themes', 'auto-listings' ); ?> &rarr;</a>
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
