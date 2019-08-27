<?php
/**
 * Listings State setting fields.
 *
 * @package Auto Listings.
 */

return [
	'id'             => 'listing_states',
	'title'          => __( 'Listing States', 'auto-listings' ),
	'settings_pages' => 'auto-listings',
	'tab'            => 'listings',
	'fields'         => [
		[
			'type'        => 'group',
			'before'      => '<p>' . __( 'Once state have been added here, they are then available in the <strong>Listings State</strong> dropdown field when adding or editing a listing.', 'auto-listings' ) . '</p>',
			'id'          => 'listing_state',
			'clone'       => true,
			'collapsible' => true,
			'group_title' => __( 'Listing State {#}', 'auto-listings' ),
			'add_button'  => __( '+ Add Listing State', 'auto-listings' ),
			'fields'      => [
				[
					'name'              => __( 'State', 'auto-listings' ),
					'id'                => 'state',
					'type'              => 'text',
					'sanitize_callback' => 'wp_kses_post',
				],
				[
					'name' => __( 'Text Color', 'auto-listings' ),
					'id'   => 'text_color',
					'type' => 'color',
				],
				[
					'name' => __( 'Hide Price', 'auto-listings' ),
					'id'   => 'hide_price',
					'type' => 'checkbox',
				],
			],
		],
	],
];
