<?php
/**
 * Theme Compatibility setting fields.
 *
 * @package Auto Listings.
 */

return [
	'id'             => 'theme_compatibility',
	'title'          => __( 'Theme Compatibility', 'auto-listings' ),
	'settings_pages' => 'auto-listings',
	'tab'            => 'advanced',
	'fields'         => [
		[
			'name'        => __( 'Opening HTML Tag(s)', 'auto-listings' ),
			'desc'        => __( 'Override the opening HTML tags for all Listings pages.', 'auto-listings' ) . '<br>' .
							 __( 'This can help you to match the HTML with your current theme.', 'auto-listings' ),
			'id'          => 'opening_html',
			'type'        => 'textarea',
			'placeholder' => '<div class=&quot;container&quot;><div class=&quot;main-content&quot;>',
			'rows'        => 2,
		],
		[
			'name'        => __( 'Closing HTML Tag(s)', 'auto-listings' ),
			'desc'        => __( 'Override the closing HTML tags for all Listings pages.', 'auto-listings' ) . '<br>' .
							 __( 'This can help you to match the HTML with your current theme.', 'auto-listings' ),
			'id'          => 'closing_html',
			'type'        => 'textarea',
			'placeholder' => '</div></div>',
			'rows'        => 2,
		],
		[
			'name'    => __( 'Force Listings Page Title', 'auto-listings-related' ),
			'desc'    => __( 'Some themes may be using incorrect template tags to display the archive page title.' ) . '<br>' . __( 'If your page title is not displaying on the listings page, you can force the page title here.', 'auto-listings-related' ),
			'id'      => 'archives_page_title',
			'type'    => 'select',
			'default' => 'no',
			'options' => [
				'no'  => __( 'No', 'auto-listings' ),
				'yes' => __( 'Yes', 'auto-listings' ),
			],
		],
	],
];
