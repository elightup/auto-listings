<?php
namespace AutoListings\Upgrade;

use AutoListings\Roles;

class Ver2 {
	public function __construct() {
		$this->update_seller_caps();
	}

	private function update_seller_caps() {
		$caps = Roles::get_seller_caps();
		$role = get_role( 'auto_listings_seller' );

		$remove = array_keys( $role->capabilities );
		array_walk( $remove, [ $role, 'remove_cap' ] );

		foreach ( $caps as $cap ) {
			$role->add_cap( $cap );
		}
	}
}
