<?php
/**
 * Customize columns in Seller Table.
 *
 * @package Auto Listings.
 */

namespace AutoListings\Admin;

/**
 * Seller Columns class.
 */
class SellerColumns {
	/**
	 * Add hooks when module is loaded.
	 */
	public function __construct() {
		if ( ! isset( $_GET['role'] ) || ( 'auto_listings_seller' !== $_GET['role'] && 'administrator' !== $_GET['role'] ) ) {
			return;
		}
		add_filter( 'manage_users_columns', [ $this, 'columns' ] );
		add_filter( 'manage_users_custom_column', [ $this, 'show' ], 10, 3 );
	}

	/**
	 * Customize the sellers column.
	 *
	 * @param array $columns array of columns.
	 */
	public function columns( $columns ) {
		if ( isset( $_GET['role'] ) && 'auto_listings_seller' === $_GET['role'] ) {
			unset( $columns['posts'] );
			unset( $columns['role'] );
		}
		$columns['listings']     = __( 'Listings', 'auto-listings' );
		$columns['mobile']       = __( 'Mobile', 'auto-listings' );
		$columns['office_phone'] = __( 'Office Phone', 'auto-listings' );
		return $columns;
	}

	/**
	 * Display output of custom columns.
	 *
	 * @param string $val         Custom column output.
	 * @param string $column_name Column name.
	 * @param int    $user_id     ID of the currently-listed user.
	 */
	public function show( $val, $column_name, $user_id ) {
		switch ( $column_name ) {
			case 'listings':
				return '<a href="' . esc_url( admin_url( 'edit.php?post_type=listing&sellers=' . $user_id ) ) . '"><strong>' . auto_listings_seller_listings_count( $user_id ) . '</strong></a>';

			case 'mobile':
				return get_the_author_meta( 'mobile', $user_id );

			case 'name':
				return get_the_author_meta( 'display_name', $user_id ) . '<br>' . get_the_author_meta( 'title_position', $user_id );

			case 'office_phone':
				return get_the_author_meta( 'office_phone', $user_id );

			default:
				return $val;
		}
	}
}
