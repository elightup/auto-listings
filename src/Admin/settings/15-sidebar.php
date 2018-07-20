<?php
return [
	'id'             => 'more',
	'title'          => __( 'More Features?', 'auto-listings' ),
	'settings_pages' => 'auto-listings',
	'context'        => 'side',
	'fields'         => [
		[
			'std'  => '<p><a target="_blank" href="http://wpautolistings.com/support?utm_source=WordPress&utm_medium=banner&utm_campaign=plugin"><img src="' . AUTO_LISTINGS_URL . 'assets/admin/images/support-banner.jpg" class="banner1" /></a></p>' .
			          '<p><a target="_blank" href="https://wordpress.org/support/plugin/auto-listings/reviews/?filter=5"><img src="' . AUTO_LISTINGS_URL . 'assets/admin/images/review-banner.jpg" class="banner2" /></a></p>' .
			          '<p><a target="_blank" href="http://wpautolistings.com/extensions?utm_source=WordPress&utm_medium=banner&utm_campaign=plugin"><img src="' . AUTO_LISTINGS_URL . 'assets/admin/images/extensions-banner.jpg" class="banner3" /></a></p>',
			'type' => 'custom_html',
		],
	],
];
