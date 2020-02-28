<?php
namespace AutoListings\Upgrade;

class Ver300 {
	public function __construct() {
		$this->update_role();
	}

	public function get_seller_caps() {
		return [
			'list_users',
			'create_users',
			'edit_users',
			'edit_others_posts',
			'delete_others_posts',
			'edit_others_listings',
			'delete_others_listings',
		];
	}

	private function update_role() {
		global $wp_roles;

		if ( ! isset( $wp_roles ) && class_exists( 'WP_Roles' ) ) {
			$wp_roles = new \WP_Roles();
		}

		if ( ! is_object( $wp_roles ) ) {
			return;
		}

		$seller_caps = $this->get_seller_caps();
		$seller_role = get_role( 'auto_listings_seller' );

		foreach ( $seller_caps as $cap ) {
			if ( $seller_role ) {
				$seller_role->remove_cap( $cap );
			}
			if ( $admin_role ) {
				$admin_role->remove_cap( $cap );
			}
		}
	}
}
