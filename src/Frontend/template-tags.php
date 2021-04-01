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
function auto_listings_output_content_wrapper( $data = [] ) {
	auto_listings_get_part( 'global/wrapper-start.php', $data );
}

/**
 * Output wrapper end
 */
function auto_listings_output_content_wrapper_end( $data = [] ) {
	auto_listings_get_part( 'global/wrapper-end.php', $data );
}

/**
 * Output sidebar
 */
function auto_listings_get_sidebar( $data = [] ) {
	auto_listings_get_part( 'global/sidebar.php', $data );
}


/*=================================== Single Listing ===================================*/

/**
 * Output title in single listing template
 */
function auto_listings_template_single_title( $data = [] ) {
	auto_listings_get_part( 'single-listing/title.php', $data );
}

/**
 * Output address in single listing template
 */
function auto_listings_template_single_address( $data = [] ) {
	if ( auto_listings_hide_item( 'address' ) ) {
		return;
	}
	auto_listings_get_part( 'single-listing/address.php', $data );
}

/**
 * Output price in single listing template
 */
function auto_listings_template_single_price( $data = [] ) {
	if ( auto_listings_hide_item( 'price' ) ) {
		return;
	}
	auto_listings_get_part( 'single-listing/price.php', $data );
}

/**
 * Output at-a-glance box in single listing template
 */
function auto_listings_template_single_at_a_glance( $data = [] ) {
	auto_listings_get_part( 'single-listing/at-a-glance.php', $data );
}

/**
 * Output gallery in single listing template
 */
function auto_listings_template_single_gallery( $data = [] ) {
	auto_listings_get_part( 'single-listing/gallery.php', $data );
}

/**
 * Output map in single listing template
 */
function auto_listings_template_single_map( $data = [] ) {
	$key = auto_listings_option( 'maps_api_key' );
	if ( auto_listings_hide_item( 'map' ) || ! $key ) {
		return;
	}
	auto_listings_get_part( 'single-listing/map.php', $data );
}

/**
 * Output tagline in single listing template
 */
function auto_listings_template_single_tagline( $data = [] ) {
	auto_listings_get_part( 'single-listing/tagline.php', $data );
}

/**
 * Output description in single listing template
 */
function auto_listings_template_single_description( $data = [] ) {
	auto_listings_get_part( 'single-listing/description.php', $data );
}

/**
 * Output contact form in single listing template
 */
function auto_listings_template_single_contact_form( $data = [] ) {
	$seller = auto_listings_meta( 'seller' );
	if ( auto_listings_hide_item( 'contact_form' ) || empty( $seller ) ) {
		return;
	}
	auto_listings_get_part( 'single-listing/contact-form.php', $data );
}

/**
 * Output tabs in single listing template
 */
function auto_listings_output_listing_tabs( $data = [] ) {
	auto_listings_get_part( 'single-listing/tabs/tabs.php', $data );
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
function auto_listings_details_tab( $data = [] ) {
	auto_listings_get_part( 'single-listing/tabs/details.php', $data );
}

/**
 * Output spec tab in single listing template
 */
function auto_listings_specifications_tab( $data = [] ) {
	auto_listings_get_part( 'single-listing/tabs/specifications.php', $data );
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
	if ( is_post_type_archive( 'auto-listing' ) ) {
		$title = auto_listings_listing_archive_get_title();
	}
	return $title;
}

/**
 * Output page title in listings archive template
 */
function auto_listings_listing_archive_title() {
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
	} elseif ( is_post_type_archive( 'auto-listing' ) ) {
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
function auto_listings_ordering( $data = [] ) {
	auto_listings_get_part( 'loop/orderby.php', $data );
}

/**
 * Output view switcher in listings loop.
 */
function auto_listings_view_switcher( $data = [] ) {
	auto_listings_get_part( 'loop/view-switcher.php', $data );
}

/**
 * Output pagination in listings loop.
 */
function auto_listings_pagination( $data = [] ) {
	auto_listings_get_part( 'loop/pagination.php', $data );
}

/**
 * Output loop title in listings loop.
 */
function auto_listings_template_loop_title( $data = [] ) {
	auto_listings_get_part( 'loop/title.php', $data );
}

/**
 * Output address in listings loop.
 */
function auto_listings_template_loop_address( $data = [] ) {
	if ( auto_listings_hide_item( 'address' ) ) {
		return;
	}
	auto_listings_get_part( 'loop/address.php', $data );
}

/**
 * Output price in listings loop.
 */
function auto_listings_template_loop_price( $data = [] ) {
	if ( auto_listings_hide_item( 'price' ) ) {
		return;
	}
	auto_listings_get_part( 'loop/price.php', $data );
}

/**
 * Output at-a-glance box in listings loop.
 */
function auto_listings_template_loop_at_a_glance( $data = [] ) {
	auto_listings_get_part( 'loop/at-a-glance.php', $data );
}

/**
 * Output tagline in listings loop.
 */
function auto_listings_template_loop_tagline( $data = [] ) {
	auto_listings_get_part( 'loop/tagline.php', $data );
}

/**
 * Output description in listings loop.
 */
function auto_listings_template_loop_description( $data = [] ) {
	auto_listings_get_part( 'loop/description.php', $data );
}

/**
 * Output data after description in listings loop.
 */
function auto_listings_template_loop_bottom( $data = [] ) {
	auto_listings_get_part( 'loop/bottom.php', $data );
}

/**
 * Output listing image in listings loop.
 */
function auto_listings_template_loop_image( $data = [] ) {
	auto_listings_get_part( 'loop/image.php', $data );
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
	$template = apply_filters( 'auto_listings_get_part_legacy', auto_listings_get_part_legacy( $part ) );
	if ( $template ) {
		$data = (object) $data;
		include $template;
		return;
	}

	// Remove file name extension.
	$part = str_replace( '.php', '', $part );

	// Merge $data param with default $data.
	$data = array_merge(
		[
			'post_id' => get_the_ID(),
		],
		(array) $data
	);

	AutoListings\Frontend\TemplatePathLoader::load( $part, $data );
}

/**
 * Backward compatibility with old extensions.
 * @param string $part template part.
 */
function auto_listings_get_part_legacy( $part ) {
	// Look within passed path within the theme - this is priority.
	$template = locate_template(
		[
			trailingslashit( auto_listings_template_path() ) . $part,
			$part,
		]
	);

	if ( $template ) {
		return $template;
	}

	$dirs = apply_filters(
		'auto_listings_template_directory',
		[
			AUTO_LISTINGS_DIR . 'templates/',
		]
	);
	foreach ( $dirs as $dir ) {
		if ( file_exists( trailingslashit( $dir ) . $part ) ) {
			$template = $dir . $part;
		}
	}

	return $template ?: false;
}
