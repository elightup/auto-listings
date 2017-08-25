<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Work out which theme the user has active
 */
function auto_listings_get_theme() {

    if( function_exists('et_divi_fonts_url') ) {
		$theme = 'divi'; 
	} else if( function_exists('genesis_constants') ) {
		$theme = 'genesis';
	} else {
		$theme = get_option( 'template' );
	}
	return $theme;
	
}

/*=================================== Global ===================================
*/

/**
 * Output the start of the page wrapper.
 */
if ( ! function_exists( 'auto_listings_output_content_wrapper' ) ) {
	function auto_listings_output_content_wrapper() {
		auto_listings_get_part( 'global/wrapper-start.php' );
	}
}

/**
 * Output the end of the page wrapper.
 */
if ( ! function_exists( 'auto_listings_output_content_wrapper_end' ) ) {
	function auto_listings_output_content_wrapper_end() {
		auto_listings_get_part( 'global/wrapper-end.php' );
	}
}

/**
 * Output the end of the page wrapper.
 */
if ( ! function_exists( 'auto_listings_get_sidebar' ) ) {
	function auto_listings_get_sidebar() {
		auto_listings_get_part( 'global/sidebar.php' );
	}
}



/*=================================== Single Listing ===================================
*/

/**
 * Output the title.
 */
if ( ! function_exists( 'auto_listings_template_single_title' ) ) {
	function auto_listings_template_single_title() {
		auto_listings_get_part( 'single-listing/title.php' );
	}
}

/**
 * Output the address.
 */
if ( ! function_exists( 'auto_listings_template_single_address' ) ) {
	function auto_listings_template_single_address() {
		if( auto_listings_hide_item( 'address' ) )
			return;
		auto_listings_get_part( 'single-listing/address.php' );
	}
}

/**
 * Output the price.
 */
if ( ! function_exists( 'auto_listings_template_single_price' ) ) {
	function auto_listings_template_single_price() {
		if( auto_listings_hide_item( 'price' ) )
			return;
		auto_listings_get_part( 'single-listing/price.php' );
	}
}

/**
 * Output the at a glance.
 */
if ( ! function_exists( 'auto_listings_template_single_at_a_glance' ) ) {
	function auto_listings_template_single_at_a_glance() {
		auto_listings_get_part( 'single-listing/at-a-glance.php' );
	}
}

/**
 * Output the gallery.
 */
if ( ! function_exists( 'auto_listings_template_single_gallery' ) ) {
	function auto_listings_template_single_gallery() {
		$images = auto_listings_meta( 'image_gallery' );
		if( ! $images )
			return;
		auto_listings_get_part( 'single-listing/gallery.php' );
	}
}
/**
 * Output the map.
 */
if ( ! function_exists( 'auto_listings_template_single_map' ) ) {
	function auto_listings_template_single_map() {
		$key = auto_listings_option( 'maps_api_key' );
		if( auto_listings_hide_item( 'map' ) || ! $key )
			return;
		auto_listings_get_part( 'single-listing/map.php' );
	}
}

/**
 * Output the address.
 */
if ( ! function_exists( 'auto_listings_template_single_address' ) ) {
	function auto_listings_template_single_address() {
		if( auto_listings_hide_item( 'address' ) )
			return;
		auto_listings_get_part( 'single-listing/address.php' );
	}
}

/**
 * Output the tagline.
 */
if ( ! function_exists( 'auto_listings_template_single_tagline' ) ) {
	function auto_listings_template_single_tagline() {
		auto_listings_get_part( 'single-listing/tagline.php' );
	}
}

/**
 * Output the description.
 */
if ( ! function_exists( 'auto_listings_template_single_description' ) ) {
	function auto_listings_template_single_description() {
		auto_listings_get_part( 'single-listing/description.php' );
	}
}

/**
 * Output the contact form.
 */
if ( ! function_exists( 'auto_listings_template_single_contact_form' ) ) {
	function auto_listings_template_single_contact_form() {
		$seller = auto_listings_meta( 'seller' );
		if( auto_listings_hide_item( 'contact_form' ) || empty( $seller ) )
			return;
		auto_listings_get_part( 'single-listing/contact-form.php' );
	}
}



/**
 * Output the details tab content.
 */
if ( ! function_exists( 'auto_listings_output_listing_tabs' ) ) {
	function auto_listings_output_listing_tabs() {
		auto_listings_get_part( 'single-listing/tabs/tabs.php' );
	}
}
/**
 * Add default tabs to listings.
 */
if ( ! function_exists( 'auto_listings_default_tabs' ) ) {

	function auto_listings_default_tabs( $tabs = array() ) {

		// Details tab
		$tabs['details'] = array(
			'title'    => __( 'Details', 'auto-listings' ),
			'priority' => 10,
			'callback' => 'auto_listings_details_tab',
		);


		// Specs tab
		$tabs['specifications'] = array(
			'title'    => __( 'Specifications', 'auto-listings' ),
			'priority' => 20,
			'callback' => 'auto_listings_specifications_tab',
		);

		return apply_filters( 'auto_listings_default_tabs', $tabs );
	}
}

/**
 * Output the details tab content.
 */
if ( ! function_exists( 'auto_listings_details_tab' ) ) {
	function auto_listings_details_tab() {
		auto_listings_get_part( 'single-listing/tabs/details.php' );
	}
}
/**
 * Output the details tab content.
 */
if ( ! function_exists( 'auto_listings_specifications_tab' ) ) {
	function auto_listings_specifications_tab() {
		auto_listings_get_part( 'single-listing/tabs/specifications.php' );
	}
}

/*=================================== Archive page ===================================
*/
add_filter( 'get_the_archive_title', 'auto_listings_listing_display_theme_title' );
function auto_listings_listing_display_theme_title( $title ) {
	if( is_listing_archive() ){
		$title = auto_listings_listing_archive_get_title();
	}
	return $title;
}


if ( ! function_exists( 'auto_listings_listing_archive_title' ) ) {
	
	function auto_listings_listing_archive_title() {

		$force = auto_listings_force_page_title();

		if( $force != 'yes' )
			return;
		?>

	        <h1 class="page-title"><?php echo esc_html( auto_listings_listing_archive_get_title() ); ?></h1>

	    <?php

	}

}

function auto_listings_listing_archive_get_title() {

	// get the title we need (search page or not)
	if ( is_search() ) {
		
		$query = isset( $_GET['s'] ) && ! empty( $_GET['s'] ) ? ' - ' . esc_html( $_GET['s'] ) : '';
		$page_title = sprintf( __( 'Search Results %s', 'auto-listings' ), esc_html( $query ) );

		if ( get_query_var( 'paged' ) )
			$page_title .= sprintf( __( '&nbsp;&ndash; Page %s', 'auto-listings' ), get_query_var( 'paged' ) );

	} elseif ( is_listing_archive() ) {

		$page_id = auto_listings_option( 'archives_page' );
		$page_title = get_the_title( $page_id );

	} else {

		$page_title = get_the_title();
	}

	$page_title = apply_filters( 'auto_listings_archive_page_title', $page_title );

    return $page_title;

}

/**
 * Archive page title
 *
 */
if ( ! function_exists( 'auto_listings_page_title' ) ) {

	function auto_listings_page_title() {
	    $page_title = auto_listings_listing_archive_get_title();
	    return $page_title;
	}
	
}

/**
 * Show the description on listings archive page
 */
if ( ! function_exists( 'auto_listings_listing_archive_content' ) ) {
	function auto_listings_listing_archive_content() {
		if ( is_post_type_archive( 'auto-listing' ) ) {
			$archive_page = get_post( auto_listings_option( 'archives_page' ) );
			if ( $archive_page ) {
				$description = apply_filters( 'auto_listings_format_archive_content', do_shortcode( shortcode_unautop( wpautop( $archive_page->post_content ) ) ), $archive_page->post_content );
				if ( $description ) {
					echo '<div class="page-description">' . $description . '</div>';
				}
			}
		}
	}
}

/*=================================== Loop ===================================
*/

/**
 * Output sorting options.
 */
if ( ! function_exists( 'auto_listings_ordering' ) ) {
	function auto_listings_ordering() {
		auto_listings_get_part( 'loop/orderby.php' );
	}
}

/**
 * View switcher.
 */
if ( ! function_exists( 'auto_listings_view_switcher' ) ) {
	function auto_listings_view_switcher() {
		auto_listings_get_part( 'loop/view-switcher.php' );
	}
}

/**
 * Output pagination.
 */
if ( ! function_exists( 'auto_listings_pagination' ) ) {
	function auto_listings_pagination() {
		auto_listings_get_part( 'loop/pagination.php' );
	}
}

/**
 * Output the title.
 */
if ( ! function_exists( 'auto_listings_template_loop_title' ) ) {
	function auto_listings_template_loop_title() {
		auto_listings_get_part( 'loop/title.php' );
	}
}

/**
 * Output the address.
 */
if ( ! function_exists( 'auto_listings_template_loop_address' ) ) {
	function auto_listings_template_loop_address() {
		if( auto_listings_hide_item( 'address' ) )
			return;
		auto_listings_get_part( 'loop/address.php' );
	}
}

/**
 * Output the price.
 */
if ( ! function_exists( 'auto_listings_template_loop_price' ) ) {
	function auto_listings_template_loop_price() {
		if( auto_listings_hide_item( 'price' ) )
			return;
		auto_listings_get_part( 'loop/price.php' );
	}
}

/**
 * Output the at a glance.
 */
if ( ! function_exists( 'auto_listings_template_loop_at_a_glance' ) ) {
	function auto_listings_template_loop_at_a_glance() {
		auto_listings_get_part( 'loop/at-a-glance.php' );
	}
}

/**
 * Output the tagline.
 */
if ( ! function_exists( 'auto_listings_template_loop_tagline' ) ) {
	function auto_listings_template_loop_tagline() {
		auto_listings_get_part( 'loop/tagline.php' );
	}
}

/**
 * Output the description.
 */
if ( ! function_exists( 'auto_listings_template_loop_description' ) ) {
	function auto_listings_template_loop_description() {
		auto_listings_get_part( 'loop/description.php' );
	}
}
/**
 * Output the description.
 */
if ( ! function_exists( 'auto_listings_template_loop_bottom' ) ) {
	function auto_listings_template_loop_bottom() {
		auto_listings_get_part( 'loop/bottom.php' );
	}
}

/**
 * Output the image.
 */
if ( ! function_exists( 'auto_listings_template_loop_image' ) ) {
	function auto_listings_template_loop_image() {
		auto_listings_get_part( 'loop/image.php' );
	}
}




/*
 * Set the path to be used in the theme folder.
 * Templates in this folder will override the plugins frontend templates.
 */
function auto_listings_template_path() {
	return apply_filters( 'auto_listings_template_path', 'listings/' );
}


function auto_listings_get_part( $part, $id = null ) {
	
	if ( $part ) {

		// Look within passed path within the theme - this is priority.
		$template = locate_template(
			array(
				trailingslashit( auto_listings_template_path() ) . $part,
				$part,
			)
		);

		// Get template from plugin directory
		if ( ! $template ) {

			$check_dirs = apply_filters( 'auto_listings_template_directory', array(
				AUTOLISTINGS_PLUGIN_DIR . 'templates/',
			));
			foreach ( $check_dirs as $dir ) {
				if ( file_exists( trailingslashit( $dir ) . $part ) ) {
					$template = $dir . $part;
				}
			}

		}

		include( $template );

	}	

}