<?php
/**
 * Add Plugin roles.
 *
 * @package Auto Listings.
 */

namespace AutoListings;

/**
 * Class Roles
 */
class Roles {
	/**
	 * Add custom role.
	 */
	public function add_roles() {
		add_role(
			'auto_listings_seller',
			__( 'Auto Listings Seller', 'auto-listings' ),
			[
				'read'                   => true,
				'edit_posts'             => true,
				'delete_posts'           => true,
				'unfiltered_html'        => true,
				'upload_files'           => true,
				'delete_private_posts'   => true,
				'delete_published_posts' => true,
				'edit_others_pages'      => true,
				'edit_private_posts'     => true,
				'edit_published_posts'   => true,
				'edit_published_pages'   => true,
				'publish_posts'          => true,
				'read_private_posts'     => true,
			]
		);
	}

	/**
	 * Add caps for custom role and administrator.
	 */
	public function add_caps() {
		global $wp_roles;

		if ( ! isset( $wp_roles ) && class_exists( 'WP_Roles' ) ) {
			$wp_roles = new \WP_Roles();
		}

		if ( ! is_object( $wp_roles ) ) {
			return;
		}
		$seller_caps = $this->get_seller_caps();
		foreach ( $seller_caps as $key => $cap_group ) {
			foreach ( $cap_group as $cap ) {
				if ( 'administrator_listing' !== $key ) {
					$wp_roles->add_cap( 'auto_listings_seller', $cap );
				}
				$wp_roles->add_cap( 'administrator', $cap );
			}
		}
	}

	/**
	 * Get seller caps.
	 */
	public function get_seller_caps() {
		$capabilities = [];

		$capabilities['listing'] = [

			// Listings.
			'edit_listing',
			'read_listing',
			'delete_listing',
			'edit_listings',
			'publish_listings',
			'read_private_listings',
			'delete_listings',
			'delete_private_listings',
			'delete_published_listings',
			'edit_private_listings',
			'edit_published_listings',

			// Enquiries use post capability.
		];

		$capabilities['administrator_listing'] = [
			'edit_others_listings',
			'delete_others_listings',
		];

		return $capabilities;
	}

	/**
	 * Remove caps from seller and administrator.
	 */
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
