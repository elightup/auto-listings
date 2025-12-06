<?php
/**
 * Fallback helpers for Meta Box support utilities.
 *
 * @package AutoListings
 */

namespace MetaBox\Support;

defined( 'ABSPATH' ) || exit;

/**
 * Data helper methods used by Meta Box extensions.
 */
class Data {
	/**
	 * Retrieve post types available for Meta Box Frontend Submission.
	 *
	 * @return array<string,\WP_Post_Type>
	 */
	public static function get_post_types() {
		$post_types = get_post_types(
			[
				'show_ui' => true,
			],
			'objects'
		);

		$excluded = [
			'attachment',
			'revision',
			'nav_menu_item',
			'custom_css',
			'customize_changeset',
			'oembed_cache',
			'user_request',
			'wp_block',
			'wp_template',
			'wp_template_part',
			'wp_global_styles',
			'wp_navigation',
		];

		foreach ( $post_types as $name => $post_type ) {
			if ( in_array( $name, $excluded, true ) ) {
				unset( $post_types[ $name ] );
				continue;
			}

			if ( empty( $post_type->show_ui ) ) {
				unset( $post_types[ $name ] );
			}
		}

		/**
		 * Filter the list of available post types for frontend submission.
		 *
		 * @since 2.6.19-elementor
		 *
		 * @param array<string,\WP_Post_Type> $post_types Post type objects keyed by name.
		 */
		return apply_filters( 'auto_listings_mbfs_post_types', $post_types );
	}
}


