<?php
namespace AutoListings\SearchForm;

class PostType {
	public function __construct() {
		add_action( 'init', array( $this, 'register_post_type' ) );
		add_filter( 'post_updated_messages', array( $this, 'updated_messages' ) );
	}

	public function register_post_type() {
		$post_type = 'auto-listings-search';

		$labels = array(
			'name'               => _x( 'Search Forms', 'post type general name', 'auto-listings' ),
			'singular_name'      => _x( 'Search Form', 'post type singular name', 'auto-listings' ),
			'menu_name'          => _x( 'Search Forms', 'admin menu', 'auto-listings' ),
			'name_admin_bar'     => _x( 'Search Forms', 'add new on admin bar', 'auto-listings' ),
			'add_new'            => _x( 'Add New', 'auto-listings', 'auto-listings' ),
			'add_new_item'       => __( 'Add new search form', 'auto-listings' ),
			'new_item'           => __( 'New search form', 'auto-listings' ),
			'edit_item'          => __( 'Edit search form', 'auto-listings' ),
			'view_item'          => __( 'View search form', 'auto-listings' ),
			'all_items'          => __( 'Search Forms', 'auto-listings' ),
			'search_items'       => __( 'Search search form', 'auto-listings' ),
			'parent_item_colon'  => __( 'Parent search form:', 'auto-listings' ),
			'not_found'          => __( 'No search forms found.', 'auto-listings' ),
			'not_found_in_trash' => __( 'No search forms found in Trash.', 'auto-listings' ),
		);

		$args = array(
			'labels'          => $labels,
			'public'          => false,
			'show_ui'         => true,
			'show_in_menu'    => 'edit.php?post_type=auto-listing',
			'query_var'       => true,
			'capability_type' => 'post',
			'hierarchical'    => false,
			'menu_position'   => 58,
			'supports'        => array( 'title' ),
			'menu_icon'       => 'dashicons-search',
			'map_meta_cap'    => true,
			'capabilities'    => array(
				// Meta capabilities.
				'edit_post'              => 'edit_auto_listings_search',
				'read_post'              => 'read_auto_listings_search',
				'delete_post'            => 'delete_auto_listings_search',

				// Primitive capabilities used outside of map_meta_cap():
				'edit_posts'             => 'manage_options',
				'edit_others_posts'      => 'manage_options',
				'publish_posts'          => 'manage_options',
				'read_private_posts'     => 'manage_options',

				// Primitive capabilities used within map_meta_cap():
				'read'                   => 'read',
				'delete_posts'           => 'manage_options',
				'delete_private_posts'   => 'manage_options',
				'delete_published_posts' => 'manage_options',
				'delete_others_posts'    => 'manage_options',
				'edit_private_posts'     => 'manage_options',
				'edit_published_posts'   => 'manage_options',
				'create_posts'           => 'manage_options',
			),
		);

		register_post_type( $post_type, $args );
	}

	public function updated_messages( $messages ) {
		$messages['auto_listings_search'] = array(
			0  => '', // Unused. Messages start at index 1.
			1  => __( 'Form updated.', 'auto_listings_search' ),
			2  => __( 'Form updated.', 'auto_listings_search' ),
			3  => __( 'Form deleted.', 'auto_listings_search' ),
			4  => __( 'Form updated.', 'auto_listings_search' ),
			5  => isset( $_GET['revision'] ) ? sprintf( __( 'Form restored to revision from %s', 'auto_listings_search' ), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
			6  => __( 'Form published.', 'auto_listings_search' ),
			7  => __( 'Form saved.', 'auto_listings_search' ),
			8  => __( 'Form submitted.', 'auto_listings_search' ),
			9  => __( 'Form scheduled.', 'auto_listings_search' ),
			10 => __( 'Form draft updated.', 'auto_listings_search' ),
		);

		return $messages;
	}
}
