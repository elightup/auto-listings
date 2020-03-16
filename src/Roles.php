<?php
namespace AutoListings;

class Roles {
	/**
	 * Add seller role with the same capabilities as authors.
	 * @link https://wordpress.org/support/article/roles-and-capabilities/#author
	 */
	public function add_roles() {
		$seller_caps = self::get_seller_caps();
		$seller_caps = array_map( 'boolval', array_flip( $seller_caps ) );
		add_role(
			'auto_listings_seller',
			__( 'Auto Listings Seller', 'auto-listings' ),
			$seller_caps
		);
	}

	public function add_caps() {
		$caps = self::get_listings_caps();
		foreach ( $caps as $cap ) {
			wp_roles()->add_cap( 'administrator', $cap );
		}
	}

	public function remove_caps() {
		$caps = self::get_listings_caps();
		$admin_role  = get_role( 'administrator' );
		array_walk( $caps, [ $admin_role, 'remove_cap' ] );
	}

	public static function get_seller_caps() {
		return [
			'delete_posts',
			'delete_published_posts',
			'edit_posts',
			'edit_published_posts',
			'publish_posts',

			'delete_listings',
			'delete_published_listings',
			'edit_listings',
			'edit_published_listings',
			'publish_listings',

			'read',
			'upload_files',
		];
	}

	public static function get_listings_caps() {
		return [
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
			'create_listings',
		];
	}
}
