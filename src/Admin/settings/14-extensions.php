<?php
/**
 * List of Auto Listings extensions.
 *
 * @package Auto Listings.
 */

ob_start()
?>
<p class="about-description">
	<?php echo wp_kses_post( __( 'There are a number of premium extensions available at <a href="http://wpautolistings.com/docs/?utm_source=plugin&utm_medium=settings_page&utm_content=extensions" target="_blank">www.wpautolistings.com</a> that will take your automotive website to the next level.', 'auto-listings' ) ); ?>
</p>

<div class="extensions wp-clearfix">
	<div class="extension">
		<div class="extension-inner">
			<img class="extension-icon" src="<?php echo esc_url( AUTO_LISTINGS_URL . 'assets/images/dlva-search-icon.png' ); ?>" width="30" height="30">
			<div class="extension-info">
				<h3>DVLA Search</h3>
				<p><?php esc_html_e( 'Integrates with the DVLA Search API for the UK.', 'auto-listings' ); ?></p>
			</div>
		</div>
		<div class="extension-action">
			<a class="button" target="_blank" href="https://wpautolistings.com/extensions/dvla-search/?utm_source=WordPress&utm_medium=link&utm_campaign=plugin"><?php esc_html_e( 'Learn More', 'auto-listings' ); ?></a>
		</div>
	</div>

	<div class="extension">
		<div class="extension-inner">
			<img class="extension-icon" src="<?php echo esc_url( AUTO_LISTINGS_URL . 'assets/images/regcheck-api-icon.png' ); ?>" width="30" height="30">
			<div class="extension-info">
				<h3>RegCheck API</h3>
				<p><?php esc_html_e( 'Delivers precise data lookup for vehicles.', 'auto-listings' ); ?></p>
			</div>
		</div>
		<div class="extension-action">
			<a class="button" target="_blank" href="https://wpautolistings.com/extensions/regcheck-api/?utm_source=WordPress&utm_medium=link&utm_campaign=plugin"><?php esc_html_e( 'Learn More', 'auto-listings' ); ?></a>
		</div>
	</div>

	<div class="extension">
		<div class="extension-inner">
			<img class="extension-icon" src="<?php echo esc_url( AUTO_LISTINGS_URL . 'assets/images/frontend-icon.png' ); ?>" width="30" height="30">
			<div class="extension-info">
				<h3>Frontend</h3>
				<p><?php esc_html_e( 'Allow users to pay for and submit their own listings.', 'auto-listings' ); ?></p>
			</div>
		</div>
		<div class="extension-action">
			<a class="button" target="_blank" href="https://wpautolistings.com/extensions/frontend/?utm_source=WordPress&utm_medium=link&utm_campaign=plugin"><?php esc_html_e( 'Learn More', 'auto-listings' ); ?></a>
		</div>
	</div>

	<div class="extension">
		<div class="extension-inner">
			<img class="extension-icon" src="<?php echo esc_url( AUTO_LISTINGS_URL . 'assets/images/multiple-dealers-icon.png' ); ?>" width="30" height="30">
			<div class="extension-info">
				<h3>Multiple Dealers</h3>
				<p><?php esc_html_e( 'Create a multi-dealer car sales website.', 'auto-listings' ); ?></p>
			</div>
		</div>
		<div class="extension-action">
			<a class="button" target="_blank" href="https://wpautolistings.com/extensions/multiple-dealers/?utm_source=WordPress&utm_medium=link&utm_campaign=plugin"><?php esc_html_e( 'Learn More', 'auto-listings' ); ?></a>
		</div>
	</div>
</div>
<?php
$messages = ob_get_clean();

return [
	'id'             => 'extensions',
	'title'          => __( 'Extensions', 'auto-listings' ),
	'settings_pages' => 'auto-listings',
	'tab'            => 'extensions',
	'fields'         => [
		[
			'std'  => $messages,
			'type' => 'custom_html',
		],
	],
];



