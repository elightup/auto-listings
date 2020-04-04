<?php
/**
 * Custom template functions .
 *
 * @package Auto Listings.
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Work out which theme the user has active
 */
function auto_listings_get_theme() {
	if ( function_exists( 'et_divi_fonts_url' ) ) {
		$theme = 'divi';
	} elseif ( function_exists( 'genesis_constants' ) ) {
		$theme = 'genesis';
	} else {
		$theme = get_option( 'template' );
	}
	return $theme;
}

/*=================================== Global ===================================*/

/**
 * Output wrapper start
 */
function auto_listings_output_content_wrapper() {
	auto_listings_get_part( 'global/wrapper-start.php' );
}

/**
 * Output wrapper end
 */
function auto_listings_output_content_wrapper_end() {
	auto_listings_get_part( 'global/wrapper-end.php' );
}

/**
 * Output sidebar
 */
function auto_listings_get_sidebar() {
	auto_listings_get_part( 'global/sidebar.php' );
}


/*=================================== Single Listing ===================================*/

/**
 * Output title in single listing template
 */
function auto_listings_template_single_title() {
	auto_listings_get_part( 'single-listing/title.php' );
}

/**
 * Output address in single listing template
 */
function auto_listings_template_single_address() {
	if ( auto_listings_hide_item( 'address' ) ) {
		return;
	}
	auto_listings_get_part( 'single-listing/address.php' );
}

/**
 * Output price in single listing template
 */
function auto_listings_template_single_price() {
	if ( auto_listings_hide_item( 'price' ) ) {
		return;
	}
	auto_listings_get_part( 'single-listing/price.php' );
}

/**
 * Output at-a-glance box in single listing template
 */
function auto_listings_template_single_at_a_glance() {
	auto_listings_get_part( 'single-listing/at-a-glance.php' );
}

/**
 * Output gallery in single listing template
 */
function auto_listings_template_single_gallery() {
	auto_listings_get_part( 'single-listing/gallery.php' );
}

/**
 * Output map in single listing template
 */
function auto_listings_template_single_map() {
	$key = auto_listings_option( 'maps_api_key' );
	if ( auto_listings_hide_item( 'map' ) || ! $key ) {
		return;
	}
	auto_listings_get_part( 'single-listing/map.php' );
}

/**
 * Output tagline in single listing template
 */
function auto_listings_template_single_tagline() {
	auto_listings_get_part( 'single-listing/tagline.php' );
}

/**
 * Output description in single listing template
 */
function auto_listings_template_single_description() {
	auto_listings_get_part( 'single-listing/description.php' );
}

/**
 * Output contact form in single listing template
 */
function auto_listings_template_single_contact_form() {
	$seller = auto_listings_meta( 'seller' );
	if ( auto_listings_hide_item( 'contact_form' ) || empty( $seller ) ) {
		return;
	}
	auto_listings_get_part( 'single-listing/contact-form.php' );
}

/**
 * Output tabs in single listing template
 */
function auto_listings_output_listing_tabs() {
	auto_listings_get_part( 'single-listing/tabs/tabs.php' );
}

/**
 * Output default tab in single listing template
 *
 * @param array $tabs default tabs.
 */
function auto_listings_default_tabs( $tabs = [] ) {
	// Details tab.
	$tabs['details'] = [
		'title'    => __( 'Details', 'auto-listings' ),
		'priority' => 10,
		'callback' => 'auto_listings_details_tab',
	];

	// Specs tab.
	$tabs['specifications'] = [
		'title'    => __( 'Specifications', 'auto-listings' ),
		'priority' => 20,
		'callback' => 'auto_listings_specifications_tab',
	];

	return apply_filters( 'auto_listings_default_tabs', $tabs );
}

/**
 * Output detail tab in single listing template
 */
function auto_listings_details_tab() {
	auto_listings_get_part( 'single-listing/tabs/details.php' );
}

/**
 * Output spec tab in single listing template
 */
function auto_listings_specifications_tab() {
	auto_listings_get_part( 'single-listing/tabs/specifications.php' );
}

/*
=================================== Archive page ===================================
*/
add_filter( 'get_the_archive_title', 'auto_listings_listing_display_theme_title' );
/**
 * Filter the archive page title
 *
 * @param string $title archive template title.
 */
function auto_listings_listing_display_theme_title( $title ) {
	if ( is_listing_archive() ) {
		$title = auto_listings_listing_archive_get_title();
	}
	return $title;
}

/**
 * Output page title in listings archive template
 */
function auto_listings_listing_archive_title() {
	$force = auto_listings_force_page_title();
	if ( 'yes' !== $force ) {
		return;
	}
	?>
	<h1 class="page-title"><?php echo esc_html( auto_listings_listing_archive_get_title() ); ?></h1>
	<?php
}

/**
 * Get the page tile of archive template
 */
function auto_listings_listing_archive_get_title() {
	// get the title we need (search page or not).
	if ( is_search() ) {
		$query = isset( $_GET['s'] ) && ! empty( $_GET['s'] ) ? ' - ' . esc_html( $_GET['s'] ) : '';
		// Translators: %s is listing title.
		$page_title = sprintf( __( 'Search Results %s', 'auto-listings' ), esc_html( $query ) );

		if ( get_query_var( 'paged' ) ) {
			// Translators: %s is page number.
			$page_title .= sprintf( __( '&nbsp;&ndash; Page %s', 'auto-listings' ), get_query_var( 'paged' ) );
		}
	} elseif ( is_listing_archive() ) {
		$page_id    = auto_listings_option( 'archives_page' );
		$page_title = get_the_title( $page_id );
	} else {
		$page_title = get_the_title();
	}

	$page_title = apply_filters( 'auto_listings_archive_page_title', $page_title );

	return $page_title;
}

/**
 * Get the page tile of archive template
 */
function auto_listings_page_title() {
	$page_title = auto_listings_listing_archive_get_title();
	return $page_title;
}

/**
 * Get the page description of archive template
 */
function auto_listings_listing_archive_content() {
	if ( is_post_type_archive( 'auto-listing' ) ) {
		$archive_page = get_post( auto_listings_option( 'archives_page' ) );
		if ( $archive_page ) {
			$description = apply_filters( 'auto_listings_format_archive_content', do_shortcode( shortcode_unautop( wpautop( $archive_page->post_content ) ) ), $archive_page->post_content );
			if ( $description ) {
				echo '<div class="page-description">' . $description . '</div>'; // wpcs xss: ok.
			}
		}
	}
}

/*
=================================== Loop ===================================
*/

/**
 * Output order by selection in listings loop.
 */
function auto_listings_ordering() {
	auto_listings_get_part( 'loop/orderby.php' );
}

/**
 * Output view switcher in listings loop.
 */
function auto_listings_view_switcher() {
	auto_listings_get_part( 'loop/view-switcher.php' );
}

/**
 * Output pagination in listings loop.
 */
function auto_listings_pagination() {
	auto_listings_get_part( 'loop/pagination.php' );
}

/**
 * Output loop title in listings loop.
 */
function auto_listings_template_loop_title() {
	auto_listings_get_part( 'loop/title.php' );
}

/**
 * Output address in listings loop.
 */
function auto_listings_template_loop_address() {
	if ( auto_listings_hide_item( 'address' ) ) {
		return;
	}
	auto_listings_get_part( 'loop/address.php' );
}

/**
 * Output price in listings loop.
 */
function auto_listings_template_loop_price() {
	if ( auto_listings_hide_item( 'price' ) ) {
		return;
	}
	auto_listings_get_part( 'loop/price.php' );
}

/**
 * Output at-a-glance box in listings loop.
 */
function auto_listings_template_loop_at_a_glance() {
	auto_listings_get_part( 'loop/at-a-glance.php' );
}

/**
 * Output tagline in listings loop.
 */
function auto_listings_template_loop_tagline() {
	auto_listings_get_part( 'loop/tagline.php' );
}

/**
 * Output description in listings loop.
 */
function auto_listings_template_loop_description() {
	auto_listings_get_part( 'loop/description.php' );
}

/**
 * Output data after description in listings loop.
 */
function auto_listings_template_loop_bottom() {
	auto_listings_get_part( 'loop/bottom.php' );
}

/**
 * Output listing image in listings loop.
 */
function auto_listings_template_loop_image() {
	auto_listings_get_part( 'loop/image.php' );
}

/**
 * Set the path to be used in the theme folder.
 * Templates in this folder will override the plugins frontend templates.
 */
function auto_listings_template_path() {
	return apply_filters( 'auto_listings_template_path', 'listings/' );
}

/**
 * Get template parts.
 *
 * @param string $part template part.
 */
function auto_listings_get_part( $part, $data = [] ) {
	// Remove file name extension.
	$part = str_replace( '.php', '', $part );

	// Merge $data param with default $data.
	$data = array_merge(
		[
			'post_id' => get_the_ID(),
		],
		$data
	);
	static $template_loader = null;
	if ( null === $template_loader ) {
		$template_loader = new AutoListings\Frontend\TemplatePathLoader;
	}
	$template_loader->set_template_data( $data )->get_template_part( $part );
}
