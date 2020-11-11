<?php
/**
 * Listings Status setting fields.
 *
 * @package Auto Listings.
 */

return [
	'id'             => 'listing_statuses',
	'title'          => __( 'Listing Statuses', 'auto-listings' ),
	'settings_pages' => 'auto-listings',
	'tab'            => 'listings',
	'fields'         => apply_filters( 'auto_listings_listing_statuses_fields', [
		[
			'type'        => 'group',
			'before'      => '<p>' . __( 'Once statuses have been added here, they are then available in the <strong>Status</strong> dropdown field when adding or editing a listing.', 'auto-listings' ) . '</p><p>' . __( 'Statuses appear in a styled box over the listing\'s image and are used primarily to attract attention.', 'auto-listings' ) . '</p>',
			'id'          => 'listing_status',
			'clone'       => true,
			'collapsible' => true,
			'group_title' => __( 'Status {#}', 'auto-listings' ),
			'add_button'  => __( '+ Add Status', 'auto-listings' ),
			'fields'      => [
				[
					'name' => __( 'Status', 'auto-listings' ),
					'id'   => 'status',
					'type' => 'text',
					'sanitize_callback' => 'wp_kses_post',
				],
				[
					'name' => __( 'Background Color', 'auto-listings' ),
					'id'   => 'bg_color',
					'type' => 'color',
				],
				[
					'name' => __( 'Text Color', 'auto-listings' ),
					'id'   => 'text_color',
					'type' => 'color',
				],
				[
					'name'        => __( 'Icon Class', 'auto-listings' ),
					'id'          => 'icon',
					'type'        => 'text',
					'placeholder' => 'auto-icon-odometer',
					/* translators: docs link */
					'desc'        => sprintf( __( 'Add icon class to display an icon. See %s for available icons.', 'auto-listings' ), '<a target="_blank" href="http://www.wpautolistings.com/docs/icons?utm_source=plugin&utm_medium=settings_page&utm_content=icon_docs">icon docs</a>' ) . '<br>' . __( 'Can also use FontAwesome icon classes such as "fa fa-caret-left".', 'auto-listings' ),
				],
			],
		],
	] ),
];
