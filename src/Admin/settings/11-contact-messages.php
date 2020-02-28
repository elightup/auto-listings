<?php
/**
 * Contact form messages setting fields.
 *
 * @package Auto Listings.
 */

return [
	'id'             => 'contact_form_messages',
	'title'          => __( 'Contact Form Messages', 'auto-listings' ),
	'settings_pages' => 'auto-listings',
	'tab'            => 'contact',
	'fields'         => [
		[
			'name'              => __( 'Success Message', 'auto-listings' ),
			'desc'              => __( 'The message that is displayed to users upon successfully sending a message.', 'auto-listings' ),
			'id'                => 'contact_form_success',
			'type'              => 'text',
			'std'               => __( 'Thank you, we will be in touch with you soon.', 'auto-listings' ),
			'sanitize_callback' => 'wp_kses_post',
		],
	],
];
