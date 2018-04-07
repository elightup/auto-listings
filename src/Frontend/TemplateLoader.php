<?php
namespace AutoListings\Frontend;

class TemplateLoader {
	public function __construct() {
		add_filter( 'template_include', [ $this, 'template_include' ] );
	}

	public function template_include( $template ) {
		$file = '';

		// Only show on sellers page.
		if ( is_author() ) {
			$user       = new \WP_User( auto_listings_seller_ID() );
			$user_roles = $user->roles;

			$listings_count = auto_listings_seller_listings_count( auto_listings_seller_ID() );

			if ( in_array( 'auto_listings_seller', $user_roles ) || $listings_count > 0 ) {
				$file = 'seller.php';
			}
		}

		if ( is_single() && get_post_type() == 'auto-listing' ) {
			$file = 'single-listing.php';
		}

		if ( is_listing_archive() ||
		     is_listing_search() ||
		     is_listing_taxonomy()
		) {
			$file = 'archive-listing.php';
		}

		$file = apply_filters( 'auto_listings_template_file', $file );

		if ( ! $file ) {
			return $template;
		}

		$template = auto_listings_get_part( $file );
		return $template;
	}
}
