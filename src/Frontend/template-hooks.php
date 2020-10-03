<?php
/**
 * Hooks used in templates.
 *
 * @package Auto Listings.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_filter( 'post_class', 'auto_listings_listing_post_class', 20, 3 );

/**
 * Content Wrappers.
 */
add_action( 'auto_listings_before_main_content', 'auto_listings_output_content_wrapper', 10 );
add_action( 'auto_listings_after_main_content', 'auto_listings_output_content_wrapper_end', 10 );


/**
 * Archive Listings - Top of page
 */
add_action( 'auto_listings_archive_page_upper_full_width', 'auto_listings_listing_archive_title', 10 );
add_action( 'auto_listings_archive_page_upper_full_width', 'auto_listings_listing_archive_content', 20 );


/**
 * Archive Listings - Before listings
 */
add_action( 'auto_listings_before_listings_loop', 'auto_listings_ordering', 10 );
add_action( 'auto_listings_before_listings_loop', 'auto_listings_view_switcher', 20 );
add_action( 'auto_listings_before_listings_loop', 'auto_listings_pagination', 30 );

/**
 * Archive Listings - After listings
 */
add_action( 'auto_listings_after_listings_loop', 'auto_listings_pagination', 10 );


/**
 * Archive Listings - Listing Loop Items.
 */
add_action( 'auto_listings_before_listings_loop_item_summary', 'auto_listings_template_loop_image', 10 );

add_action( 'auto_listings_listings_loop_item', 'auto_listings_template_loop_title', 10 );
add_action( 'auto_listings_listings_loop_item', 'auto_listings_template_loop_at_a_glance', 20 );
add_action( 'auto_listings_listings_loop_item', 'auto_listings_template_loop_address', 30 );
add_action( 'auto_listings_listings_loop_item', 'auto_listings_template_loop_price', 40 );
add_action( 'auto_listings_listings_loop_item', 'auto_listings_template_loop_description', 50 );
add_action( 'auto_listings_listings_loop_item', 'auto_listings_template_loop_bottom', 60 );


/**
 * Single Listing
 */
add_action( 'auto_listings_single_upper_full_width', 'auto_listings_template_single_title', 10 );

add_action( 'auto_listings_single_gallery', 'auto_listings_template_single_gallery', 10 );

add_action( 'auto_listings_single_content', 'auto_listings_template_single_tagline', 10 );
add_action( 'auto_listings_single_content', 'auto_listings_template_single_description', 20 );
add_action( 'auto_listings_single_content', 'auto_listings_output_listing_tabs', 30 );
add_filter( 'auto_listings_single_tabs', 'auto_listings_default_tabs' );

add_action( 'auto_listings_single_sidebar', 'auto_listings_template_single_price', 10 );
add_action( 'auto_listings_single_sidebar', 'auto_listings_template_single_at_a_glance', 20 );
add_action( 'auto_listings_single_sidebar', 'auto_listings_template_single_address', 30 );
add_action( 'auto_listings_single_sidebar', 'auto_listings_template_single_map', 40 );
add_action( 'auto_listings_single_sidebar', 'auto_listings_template_single_contact_form', 50 );

function auto_listings_replace_hook_with_sidebar() {
	if ( ! is_active_sidebar( 'auto-listings-single' ) ) {
		return;
	}
	remove_all_filters( 'auto_listings_single_sidebar' );
	dynamic_sidebar( 'auto-listings-single' );
}
add_action( 'auto_listings_single_sidebar', 'auto_listings_replace_hook_with_sidebar', 0 );
