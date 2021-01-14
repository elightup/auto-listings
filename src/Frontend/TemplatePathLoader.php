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
class TemplatePathLoader {
	public static function load( $name, $args ) {
		// Locate template file from child theme and parent theme and load it.
		$file = locate_template( ["listings/$name.php"] );
		if ( $file ) {
			extract( $args );
			$data = (object) $args;
			require $file;
			return;
		}

		// Else load from the plugins.
		$paths = apply_filters( 'auto_listings_template_paths', [AUTO_LISTINGS_DIR . 'templates'] );
		krsort( $paths );
		foreach ( $paths as $path ) {
			$file = trailingslashit( $path ) . $name . '.php';
			if ( file_exists( $file ) ) {
				extract( $args );
				$data = (object) $args;
				require $file;
				return;
			}
		}
	}
}
