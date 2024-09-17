<?php ob_start(); ?>

<?php if ( ! class_exists( '\AutoListingsTabs\General\Settings' ) ) : ?>
	<p>
		<span class="dashicons dashicons-yes-alt"></span>
		<?php
		// Translators: %1$s - extension URL, %2$s - extension name.
		echo wp_kses_post( sprintf( __( '<a href="%1$s" target="_blank"><b>%2$s</b></a> - Add custom tabs for listings to show your terms or promotions.', 'auto-listings' ), 'https://wpautolistings.com/extensions/tabs/?utm_source=settings_page&utm_medium=link&utm_campaign=auto_listings', 'Tabs' ) );
		?>
	</p>
<?php endif ?>

<?php if ( ! defined( 'ALCP_DIR' ) ) : ?>
	<p>
		<span class="dashicons dashicons-yes-alt"></span>
		<?php
		// Translators: %1$s - extension URL, %2$s - extension name.
		echo wp_kses_post( sprintf( __( '<a href="%1$s" target="_blank"><b>%2$s</b></a> - Create custom page to show your sold or new cars.', 'auto-listings' ), 'https://wpautolistings.com/extensions/custom-page/?utm_source=settings_page&utm_medium=link&utm_campaign=auto_listings', 'Custom Page' ) );
		?>
	</p>
<?php endif ?>

<?php if ( ! defined( 'AL_DVLA_DIR' ) ) : ?>
	<p>
		<span class="dashicons dashicons-yes-alt"></span>
		<?php
		// Translators: %1$s - extension URL, %2$s - extension name.
		echo wp_kses_post( sprintf( __( '<a href="%1$s" target="_blank"><b>%2$s</b></a> - Integrates with the DVLA Search API for the UK to query vehicle details.', 'auto-listings' ), 'https://wpautolistings.com/extensions/dvla-search/?utm_source=settings_page&utm_medium=link&utm_campaign=auto_listings', 'DVLA Search' ) );
		?>
	</p>
<?php endif ?>

<?php if ( ! defined( 'AL_REGCHECK_DIR' ) ) : ?>
	<p>
		<span class="dashicons dashicons-yes-alt"></span>
		<?php
		// Translators: %1$s - extension URL, %2$s - extension name.
		echo wp_kses_post( sprintf( __( '<a href="%1$s" target="_blank"><b>%2$s</b></a> - Delivers precise data lookup for vehicles.', 'auto-listings' ), 'https://wpautolistings.com/extensions/regcheck-api/?utm_source=settings_page&utm_medium=link&utm_campaign=auto_listings', 'RegCheck API' ) );
		?>
	</p>
<?php endif ?>

<?php if ( ! defined( 'AL_FRONTEND_PLUGIN_DIR' ) ) : ?>
	<p>
		<span class="dashicons dashicons-yes-alt"></span>
		<?php
		// Translators: %1$s - extension URL, %2$s - extension name.
		echo wp_kses_post( sprintf( __( '<a href="%1$s" target="_blank"><b>%2$s</b></a> - Allow users to pay for and submit their own listings.', 'auto-listings' ), 'https://wpautolistings.com/extensions/frontend/?utm_source=settings_page&utm_medium=link&utm_campaign=auto_listings', 'Frontend' ) );
		?>
	</p>
<?php endif ?>

<?php if ( ! defined( 'AL_DEALERS_PLUGIN_DIR' ) ) : ?>
	<p>
		<span class="dashicons dashicons-yes-alt"></span>
		<?php
		// Translators: %1$s - extension URL, %2$s - extension name.
		echo wp_kses_post( sprintf( __( '<a href="%1$s" target="_blank"><b>%2$s</b></a> - Create a multi-dealer car sales website.', 'auto-listings' ), 'https://wpautolistings.com/extensions/multiple-dealers/?utm_source=settings_page&utm_medium=link&utm_campaign=auto_listings', 'Multiple Dealers' ) );
		?>
	</p>
<?php endif ?>

<?php
$message = trim( ob_get_clean() );

if ( empty( $message ) ) {
	return [];
}

$message .= '<a href="https://wpautolistings.com/extensions/?utm_source=settings_page&utm_medium=link&utm_campaign=auto_listings" class="button button-primary">' . esc_html__( 'Get all extensions', 'auto-listings' ) . ' &rarr;</a>';

return [
	'id'             => 'auto-listings-premium-extensions',
	'title'          => __( 'Premium Extensions', 'auto-listings' ),
	'settings_pages' => 'auto-listings',
	'context'        => 'side',
	'fields'         => [
		[
			'std'  => wp_kses_post( $message ),
			'type' => 'custom_html',
		],
	],
];
