<?php
/**
 * Template Loader.
 *
 * @package Auto Listings.
 */

namespace AutoListings\Frontend;

/**
 * Template Loader Class
 */
class TemplateLoader {
	/**
	 * Add hooks when module is loaded.
	 */
	public function __construct() {
		add_filter( 'template_include', [ $this, 'template_include' ] );
	}

	/**
	 * Include plugin templates.
	 *
	 * @param string $template template part.
	 */
	public function template_include( $template ) {

		if ( class_exists( '\ElementorPro\Modules\ThemeBuilder\Module' ) ) {
			$location = '';
			if ( is_single() && get_post_type() === 'auto-listing' ) {
				$location = 'single';
			} elseif ( is_post_type_archive( 'auto-listing' ) || is_listing_search() || is_listing_taxonomy() ) {
				$location = 'archive';
			}

			if ( ! empty( $location ) ) {
				$document = \ElementorPro\Modules\ThemeBuilder\Module::instance()->get_conditions_manager()->get_documents_for_location( $location );
				if ( ! empty( $document ) ) {
					return $template;
				}
			}
		}
		$file = '';

		if ( is_single() && get_post_type() === 'auto-listing' ) {
			$file = 'single-listing.php';
		}

		if ( is_post_type_archive( 'auto-listing' ) || is_listing_search() || is_listing_taxonomy() ) {
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
