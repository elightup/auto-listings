<?php
/**
 * Register listings sidebar.
 *
 * @package Auto Listings.
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


add_action( 'widgets_init', 'auto_listings_register_sidebars' );

/**
 * Register Sidebar
 */
function auto_listings_register_sidebars() {
	register_sidebar(
		array(
			'name'          => __( 'Auto Listings Archive', 'auto-listings' ),
			'id'            => 'auto-listings',
			'description'   => __( 'Widgets in this area will be shown on all listings pages.', 'auto-listings' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h2 class="widgettitle">',
			'after_title'   => '</h2>',
		)
	);

	register_sidebar(
		array(
			'name'          => __( 'Auto Listings Single', 'auto-listings' ),
			'id'            => 'auto-listings-single',
			'description'   => __( 'Use this widget to customize the sidebar on the single listing page.', 'auto-listings' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h3 class="single-listing__sidebar-heading">',
			'after_title'   => '</h3>',
		)
	);

	register_widget( 'AutoListings\Widgets\Features' );
	register_widget( 'AutoListings\Widgets\Location' );
	register_widget( 'AutoListings\Widgets\ContactForm' );
}
