<?php
/**
 * Colors setting fields.
 *
 * @package Auto Listings.
 */

return [
	'id'             => 'colors',
	'title'          => __( 'Colors', 'auto-listings' ),
	'settings_pages' => 'auto-listings',
	'tab'            => 'display',
	'fields'         => [
		[
			'name' => __( 'Button Background', 'auto-listings' ),
			'desc' => __( 'Background color for buttons. Also used as highlight color in search field, tabs and image gallery.', 'auto-listings' ),
			'id'   => 'button_bg_color',
			'type' => 'color',
		],
		[
			'name' => __( 'Button Text', 'auto-listings' ),
			'desc' => '',
			'id'   => 'button_text_color',
			'type' => 'color',
		],
		[
			'name' => __( 'Price', 'auto-listings' ),
			'desc' => '',
			'id'   => 'price_color',
			'type' => 'color',
		],
		[
			'name' => __( 'Contact Icons', 'auto-listings' ),
			'desc' => '',
			'id'   => 'contact_icon_color',
			'type' => 'color',
		],
		[
			'name' => __( 'Listing Icons', 'auto-listings' ),
			'desc' => '',
			'id'   => 'listing_icon_color',
			'type' => 'color',
		],
	],
];
