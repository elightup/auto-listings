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
			'name' => __( 'Success Message', 'auto-listings' ),
			'desc' => __( 'The message that is displayed to users upon successfully sending a message.', 'auto-listings' ),
			'id'   => 'contact_form_success',
			'type' => 'text',
			'std'  => __( 'Thank you, we will be in touch with you soon.', 'auto-listings' ),
		],
		[
			'name' => __( 'Error Message', 'auto-listings' ),
			'desc' => __( 'The message that is displayed if there is an error sending the message.', 'auto-listings' ),
			'id'   => 'contact_form_error',
			'type' => 'text',
			'std'  => __( 'There was an error. Please try again.', 'auto-listings' ),
		],
		[
			'name'    => __( 'Include Error Code', 'auto-listings' ),
			'desc'    => __( 'Should the error code be shown with the error. Can be helpful for troubleshooting.', 'auto-listings' ),
			'id'      => 'contact_form_include_error',
			'type'    => 'select',
			'options' => [
				'yes' => __( 'Yes', 'auto-listings' ),
				'no'  => __( 'No', 'auto-listings' ),
			],
			'std'     => 'yes',
		],
	],
];
