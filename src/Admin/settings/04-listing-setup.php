<?php
return [
	'id'             => 'listing_setup',
	'title'          => __( 'Listing Setup', 'auto-listings' ),
	'settings_pages' => 'auto-listings',
	'tab'            => 'listings',
	'fields'         => [
		[
			'name'    => __( 'Condition', 'auto-listings' ),
			'desc'    => __( 'What type of condition vehicles are you selling?', 'auto-listings' ),
			'id'      => 'display_condition',
			'type'    => 'checkbox_list',
			'options' => [
				'New'       => __( 'New', 'auto-listings' ),
				'Used'      => __( 'Used', 'auto-listings' ),
				'Certified' => __( 'Certified', 'auto-listings' ),
			],
		],
		[
			'name' => __( 'Highlight New Listings', 'auto-listings' ),
			'desc' => __( 'How many days to highlight new listings for? Leave blank for no highlight.', 'auto-listings' ),
			'id'   => 'highlight_new_days',
			'type' => 'text',
		],
		[
			'name'    => __( 'Default List/Grid View', 'auto-listings' ),
			'desc'    => __( 'Set the default view for listings', 'auto-listings' ),
			'id'      => 'list_grid_view',
			'type'    => 'select',
			'options' => [
				'list' => __( 'List', 'auto-listings' ),
				'grid' => __( 'Grid', 'auto-listings' ),
			],
		],
		[
			'name' => __( 'Highlight Color', 'auto-listings' ),
			'desc' => __( 'The background color of the new listing highlight. (Icon & text are white)', 'auto-listings' ),
			'id'   => 'highlight_new_color',
			'type' => 'color',
		],
		[
			'name'      => __( 'Listings Page', 'auto-listings' ),
			'desc'      => __( 'The main page to display your listings (not the front page).', 'auto-listings' ) . '<br>' . sprintf( __( 'Please visit <a target="_blank" href="%s">Settings &rarr; Permalinks</a> if this options is changed.', 'auto-listings' ), '<a target="_blank" href="' . admin_url( 'options-permalink.php' ) ),
			'id'        => 'archives_page',
			'type'      => 'post',
			'post_type' => 'page',
		],
		[
			'name' => __( 'Single Listing URL', 'auto-listings' ),
			'desc' => __( 'The single listing URL (or slug).', 'auto-listings' ) . '<br>' . sprintf( __( 'Please visit <a target="_blank" href="%s">Settings &rarr; Permalinks</a> if this options is changed.', 'auto-listings' ), '<a target="_blank" href="' . admin_url( 'options-permalink.php' ) ),
			'id'   => 'single_url',
			'type' => 'text',
			'std'  => 'listing',
		],
	],
];
