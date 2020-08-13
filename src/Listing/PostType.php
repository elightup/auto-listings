<?php
/**
 * Register Post Type and Taxonomy.
 *
 * @package Auto Listings.
 */

namespace AutoListings\Listing;

/**
 * Class PostType
 */
class PostType {
	/**
	 * Add hooks when module is loaded.
	 */
	public function __construct() {
		add_action( 'init', [ $this, 'register_post_type' ] );
		add_action( 'init', [ $this, 'register_taxonomy' ] );
		add_action( 'add_meta_boxes', [ $this, 'remove_body_type_meta_box' ] );
		add_filter( 'use_block_editor_for_post_type', [ $this, 'disable_block_editor' ], 10, 2 );
	}

	/**
	 * Register Listings Post Type.
	 */
	public function register_post_type() {
		$slug = auto_listings_option( 'single_url' ) ? auto_listings_option( 'single_url' ) : 'listing';

		$labels = [
			'name'                  => _x( 'Listings', 'Listing post type name', 'auto-listings' ),
			'singular_name'         => _x( 'Listing', 'Singular listing post type name', 'auto-listings' ),
			'add_new'               => __( 'New Listing', 'auto-listings' ),
			'add_new_item'          => __( 'Add New Listing', 'auto-listings' ),
			'edit_item'             => __( 'Edit Listing', 'auto-listings' ),
			'new_item'              => __( 'New Listing', 'auto-listings' ),
			'all_items'             => __( 'Listings', 'auto-listings' ),
			'view_item'             => __( 'View Listing', 'auto-listings' ),
			'search_items'          => __( 'Search Listings', 'auto-listings' ),
			'not_found'             => __( 'No listings found', 'auto-listings' ),
			'not_found_in_trash'    => __( 'No listings found in Trash', 'auto-listings' ),
			'parent_item_colon'     => '',
			'menu_name'             => _x( 'Listings', 'listing post type menu name', 'auto-listings' ),
			'filter_items_list'     => __( 'Filter listings list', 'auto-listings' ),
			'items_list_navigation' => __( 'Listings list navigation', 'auto-listings' ),
			'items_list'            => __( 'Listings list', 'auto-listings' ),
		];

		$archive_page = auto_listings_option( 'archives_page' );
		$args         = [
			'labels'             => $labels,
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'menu_icon'          => 'dashicons-dashboard',
			'menu_position'      => 56,
			'query_var'          => true,
			'rewrite'            => [
				'slug'       => untrailingslashit( $slug ),
				'with_front' => false,
				'feeds'      => true,
			],
			'capability_type'    => 'listing',
			'map_meta_cap'       => true,
			'has_archive'        => isset( $archive_page ) && get_post( $archive_page ) ? get_page_uri( $archive_page ) : 'listings',
			'hierarchical'       => false,
			'supports'           => apply_filters( 'auto_listings_listing_supports', [ 'title', 'editor', 'excerpt' ] ),
			'show_in_rest'       => true,
		];
		register_post_type( 'auto-listing', apply_filters( 'auto_listings_listing_post_type_args', $args ) );
	}

	/**
	 * Register Body Type Taxonomy.
	 */
	public function register_taxonomy() {
		$labels = [
			'name'                  => _x( 'Body Types', 'body-type general name', 'auto-listings' ),
			'singular_name'         => _x( 'Body Type', 'body-type singular name', 'auto-listings' ),
			'add_new'               => __( 'New Body Type', 'auto-listings' ),
			'add_new_item'          => __( 'Add New Body Type', 'auto-listings' ),
			'edit_item'             => __( 'Edit Body Type', 'auto-listings' ),
			'new_item'              => __( 'New Body Type', 'auto-listings' ),
			'all_items'             => __( 'Body Types', 'auto-listings' ),
			'view_item'             => __( 'View Body Type', 'auto-listings' ),
			'search_items'          => __( 'Search Body Types', 'auto-listings' ),
			'not_found'             => __( 'No body types found', 'auto-listings' ),
			'not_found_in_trash'    => __( 'No body types found in Trash', 'auto-listings' ),
			'parent_item_colon'     => '',
			'menu_name'             => _x( 'Body Types', 'body-type menu name', 'auto-listings' ),
			'filter_items_list'     => __( 'Filter body types list', 'auto-listings' ),
			'items_list_navigation' => __( 'Listings list navigation', 'auto-listings' ),
			'items_list'            => __( 'Listings list', 'auto-listings' ),
		];

		register_taxonomy(
			'body-type',
			'auto-listing',
			[
				'labels'            => $labels,
				'hierarchical'      => true,
				'public'            => true,
				'show_ui'           => true,
				'show_admin_column' => false,
			]
		);
	}

	/**
	 * Remove Body Type Metabox in single listing.
	 */
	public function remove_body_type_meta_box() {
		remove_meta_box( 'body-typediv', 'auto-listing', 'side' );
	}

	public function disable_block_editor( $enabled, $post_type ) {
		return 'auto-listing' === $post_type ? false : $enabled;
	}
}
