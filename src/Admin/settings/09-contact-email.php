<?php
/**
 * Contact email setting fields.
 *
 * @package Auto Listings.
 */

return [
	'id'             => 'contact_form_email',
	'title'          => __( 'Contact Form Email', 'auto-listings' ),
	'settings_pages' => 'auto-listings',
	'tab'            => 'contact',
	'fields'         => [
		[
			'name'    => __( 'Email Type', 'auto-listings' ),
			'id'      => 'contact_form_email_type',
			'type'    => 'select',
			'options' => [
				'html_email' => __( 'HTML', 'auto-listings' ),
				'text_email' => __( 'Plain Text', 'auto-listings' ),
			],
			'std'     => 'html_email',
		],
		[
			'name'              => __( 'Email Subject', 'auto-listings' ),
			'id'                => 'contact_form_subject',
			'type'              => 'text',
			'std'               => __( 'New enquiry on listing #{listing_id}', 'auto-listings' ),
			'sanitize_callback' => 'wp_kses_post',
		],
		[
			'name' => __( 'Email Message', 'auto-listings' ),
			'desc' => __(
				'Content of the email that is sent to the seller (and other email addresses above). ' .
					'Available tags are:<br>' .
					'{seller_name}<br>' .
					'{listing_title}<br>' .
					'{listing_id}<br>' .
					'{enquiry_name}<br>' .
					'{enquiry_email}<br>' .
					'{enquiry_phone}<br>' .
					'{enquiry_message}<br>',
				'auto-listings'
			),
			'std'  => __( 'Hi {seller_name},', 'auto-listings' ) . "\r\n" .
					__( 'There has been a new enquiry on <strong>{listing_title}</strong>', 'auto-listings' ) . "\r\n" .
					'<hr>' . "\r\n" .
					__( 'Name: {enquiry_name}', 'auto-listings' ) . "\r\n" .
					__( 'Email: {enquiry_email}', 'auto-listings' ) . "\r\n" .
					__( 'Phone: {enquiry_phone}', 'auto-listings' ) . "\r\n" .
					__( 'Message: {enquiry_message}', 'auto-listings' ) . "\r\n" .
					'<hr>',
			'id'   => 'contact_form_message',
			'type' => 'textarea',
		],
	],
];
