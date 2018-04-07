<?php
namespace AutoListings\Admin;

class SellerColumns {
	public function __construct() {
		if ( ! isset( $_GET['role'] ) || ( $_GET['role'] !== 'auto_listings_seller' && $_GET['role'] !== 'administrator' ) ) {
			return;
		}
		add_filter( 'manage_users_columns', [ $this, 'columns' ] );
		add_filter( 'manage_users_custom_column', [ $this, 'show' ], 10, 3 );
	}

	public function columns( $columns ) {
		if ( isset( $_GET['role'] ) && $_GET['role'] === 'auto_listings_seller' ) {
			unset( $columns['posts'] );
			unset( $columns['role'] );
		}
		$columns['listings']     = __( 'Listings', 'auto-listings' );
		$columns['mobile']       = __( 'Mobile', 'auto-listings' );
		$columns['office_phone'] = __( 'Office Phone', 'auto-listings' );
		return $columns;
	}

	public function show( $val, $column_name, $user_id ) {
		switch ( $column_name ) {
			case 'listings':
				return '<a href="' . esc_url( admin_url( 'edit.php?post_type=listing&sellers=' . $user_id ) ) . '"><strong>' . auto_listings_seller_listings_count( $user_id ) . '</strong></a>';
				break;

			case 'mobile':
				return get_the_author_meta( 'mobile', $user_id );
				break;

			case 'name':
				return get_the_author_meta( 'display_name', $user_id ) . '<br>' . get_the_author_meta( 'title_position', $user_id );
				break;

			case 'office_phone':
				return get_the_author_meta( 'office_phone', $user_id );
				break;

			default:
		}
		return $val;
	}
}
