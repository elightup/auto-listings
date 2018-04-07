<?php
namespace AutoListings;

class Roles {
	public function add_roles() {
		add_role( 'auto_listings_seller', __( 'Auto Listings Seller', 'auto-listings' ), [
			'read'                   => true,
			'edit_posts'             => true,
			'delete_posts'           => true,
			'unfiltered_html'        => true,
			'upload_files'           => true,
			'delete_others_posts'    => true,
			'delete_private_posts'   => true,
			'delete_published_posts' => true,
			'edit_others_posts'      => true,
			'edit_private_posts'     => true,
			'edit_published_posts'   => true,
			'publish_posts'          => true,
			'read_private_posts'     => true,
		] );

	}

	public function add_caps() {
		global $wp_roles;

		if ( ! isset( $wp_roles ) && class_exists( 'WP_Roles' ) ) {
			$wp_roles = new \WP_Roles();
		}

		if ( ! is_object( $wp_roles ) ) {
			return;
		}

		$seller_caps = $this->get_seller_caps();
		foreach ( $seller_caps as $cap_group ) {
			foreach ( $cap_group as $cap ) {
				$wp_roles->add_cap( 'auto_listings_seller', $cap );
				$wp_roles->add_cap( 'administrator', $cap );
			}
		}
	}

	public function get_seller_caps() {
		$capabilities = [];

		$capabilities['listing'] = [
			// Users
			'list_users',
			'create_users',
			'edit_users',

			// Listings
			'edit_listing',
			'read_listing',
			'delete_listing',
			'edit_listings',
			'edit_others_listings',
			'publish_listings',
			'read_private_listings',
			'delete_listings',
			'delete_private_listings',
			'delete_published_listings',
			'delete_others_listings',
			'edit_private_listings',
			'edit_published_listings',

			// Enquiries use post capability
		];

		return $capabilities;
	}

	public function remove_caps() {
		global $wp_roles;

		if ( ! isset( $wp_roles ) && class_exists( 'WP_Roles' ) ) {
			$wp_roles = new \WP_Roles();
		}

		if ( ! is_object( $wp_roles ) ) {
			return;
		}

		$seller_caps = $this->get_seller_caps();
		$seller_role = get_role( 'auto_listings_seller' );
		$admin_role  = get_role( 'administrator' );

		foreach ( $seller_caps as $cap_group ) {
			foreach ( $cap_group as $cap ) {
				if ( $seller_role ) {
					$seller_role->remove_cap( $cap );
				}
				if ( $admin_role ) {
					$admin_role->remove_cap( $cap );
				}
			}
		}
	}
}
