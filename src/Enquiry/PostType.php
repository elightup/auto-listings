<?php
/**
 * Register Enquiry Post Type.
 *
 * @package Auto Listings.
 */

namespace AutoListings\Enquiry;

/**
 * Class Contact Form
 */
class PostType {

	/**
	 * Add hooks when module is loaded.
	 */
	public function __construct() {
		add_action( 'init', [ $this, 'register_post_type' ] );
	}

	/**
	 * Register Enquiry post type.
	 */
	public function register_post_type() {
		$labels = [
			'name'                  => _x( 'Enquiries', 'Enquiry post type name', 'auto-listings' ),
			'singular_name'         => _x( 'Enquiry', 'Singular enquiry post type name', 'auto-listings' ),
			'add_new'               => __( 'New Enquiry', 'auto-listings' ),
			'add_new_item'          => __( 'Add New Enquiry', 'auto-listings' ),
			'edit_item'             => __( 'Edit Enquiry', 'auto-listings' ),
			'new_item'              => __( 'New Enquiry', 'auto-listings' ),
			'all_items'             => __( 'Enquiries', 'auto-listings' ),
			'view_item'             => __( 'View Enquiry', 'auto-listings' ),
			'search_items'          => __( 'Search Enquiries', 'auto-listings' ),
			'not_found'             => __( 'No enquiries found', 'auto-listings' ),
			'not_found_in_trash'    => __( 'No enquiries found in Trash', 'auto-listings' ),
			'parent_item_colon'     => '',
			'menu_name'             => _x( 'Enquiries', 'enquiry post type menu name', 'auto-listings' ),
			'filter_items_list'     => __( 'Filter enquiries list', 'auto-listings' ),
			'items_list_navigation' => __( 'Enquiries list navigation', 'auto-listings' ),
			'items_list'            => __( 'Enquiries list', 'auto-listings' ),
		];

		$args = [
			'labels'              => $labels,
			'public'              => false,
			'publicly_queryable'  => false,
			'exclude_from_search' => true,
			'show_in_nav_menus'   => false,
			'show_ui'             => true,
			'show_in_menu'        => 'edit.php?post_type=auto-listing',
			'show_in_admin_bar'   => false,
			'menu_icon'           => 'dashicons-email',
			'menu_position'       => 56,
			'query_var'           => true,
			'capability_type'     => 'post',
			'capabilities'        => [
				'create_posts' => false,
				// Removes support for the "Add New" function ( use 'do_not_allow' instead of false for multisite set ups ).
			],
			'map_meta_cap'        => true, // Set to `false`, if users are not allowed to edit/delete existing posts.
			'hierarchical'        => false,
			'supports'            => [ 'title', 'revisions' ],
		];
		register_post_type( 'listing-enquiry', $args );
	}
}
