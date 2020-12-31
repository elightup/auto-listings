<?php
/**
 * Contact form setting fields.
 *
 * @package Auto Listings.
 */

return [
	'id'             => 'contact_form',
	'title'          => __( 'Contact Form Settings', 'auto-listings' ),
	'settings_pages' => 'auto-listings',
	'tab'            => 'contact',
	'fields'         => [
		[
			'name'   => __( 'Email From', 'auto-listings' ),
			'desc'   => __( 'The "from" address for all enquiry emails that are sent to Sellers.', 'auto-listings' ),
			'id'     => 'email_from',
			'type'   => 'text',
			'std'    => get_bloginfo( 'admin_email' ),
			'before' => '<p class="description">' . __( 'Contact form enquiries are sent directly to the selected Seller on that listing.', 'auto-listings' ) . '<br>' . __( 'Therefore, it is important to include the seller on each listing.', 'auto-listings' ) . '</p>',
		],
		[
			'name' => __( 'Email From Name', 'auto-listings' ),
			'desc' => __( 'The "from" name for all enquiry emails that are sent to Sellers.', 'auto-listings' ),
			'id'   => 'email_from_name',
			'type' => 'text',
			'std'  => get_bloginfo( 'name' ),
		],
		[
			'name'        => __( 'CC', 'auto-listings' ),
			'desc'        => __( 'Extra email addresses that are CC\'d on every enquiry (comma separated).', 'auto-listings' ),
			'id'          => 'contact_form_cc',
			'type'        => 'text',
			'placeholder' => 'somebody@somewhere.com',
		],
		[
			'name'        => __( 'BCC', 'auto-listings' ),
			'desc'        => __( 'Extra email addresses that are BCC\'d on every enquiry (comma separated).', 'auto-listings' ),
			'id'          => 'contact_form_bcc',
			'type'        => 'text',
			'placeholder' => 'somebody@somewhere.com',
		],
		[
			'name'        => __( 'Enable Ajax submission', 'auto-listings' ),
			'id'          => 'contact_form_ajax',
			'type'        => 'checkbox',
			'std'         => 1,
		],
	],
];
