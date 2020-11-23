<?php
/**
 * Listings Setup setting fields.
 *
 * @package Auto Listings.
 */

return [
	'id'             => 'google_captcha',
	'title'          => __( 'Google reCaptcha Settings', 'auto-listings' ),
	'settings_pages' => 'auto-listings',
	'tab'            => 'general',
	'fields'         => apply_filters( 'auto_listings_captcha_fields', [
		[
			'type' => 'custom_html',
			'std'  => __(
				'<div class="fields-label">
				<h3>Authentication</h3>
				<i>
					Register your website with Google to get required API keys and enter them below.
					<a href="https://www.google.com/recaptcha/admin#list" target="_blank">Get the API Keys</a>
				</i>
				</div>'
				, 'autolistings-pro'
			),
		],
		[
			'name' => __( 'Site key', 'autolistings-pro' ),
			'id'   => 'captcha_site_key',
			'type' => 'text',
		],
		[
			'name' => __( 'Secret key', 'autolistings-pro' ),
			'id'   => 'captcha_secret_key',
			'type' => 'text',
		],
	] ),
];
