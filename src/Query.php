<?php
/**
 * Build query for archive listings page.
 *
 * @package Auto Listings.
 */

namespace AutoListings;

/**
 * Class Query
 */
class Query {

	/**
	 * Add hooks when module is loaded.
	 */
	public function __construct() {
		if ( is_admin() ) {
			return;
		}
		add_action( 'pre_get_posts', [ $this, 'pre_get_posts' ] );
	}

	/**
	 * Hook into pre_get_posts to do the main listing query.
	 *
	 * @param mixed $query Query object.
	 */
	public function pre_get_posts( $query ) {
		$condition = apply_filters( 'auto_listings_ordering_condtion', ( $query->is_post_type_archive( 'auto-listing' ) || $query->is_tax( 'body-type' ) ) && $query->is_main_query() );
		if ( ! $condition ) {
			return;
		}

		$this->listings_query( $query );
	}

	/**
	 * Query the listings, applying sorting/ordering etc. This applies to the main WordPress loop.
	 *
	 * @param mixed $query Query object.
	 */
	public function listings_query( $query ) {
		$query->set( 'post_status', 'publish' );

		// Ordering query vars.
		$ordering = $this->get_ordering_args();
		$query->set( 'orderby', $ordering['orderby'] );
		$query->set( 'order', $ordering['order'] );
		if ( isset( $ordering['meta_key'] ) ) {
			$query->set( 'meta_key', $ordering['meta_key'] );
		}
	}

	/**
	 * Query the listings, applying sorting/ordering etc. This applies to the main WordPress loop.
	 *
	 * @param string $orderby Sort listings by parameter.
	 * @param string $order Ascending or descending order.
	 */
	public function get_ordering_args( $orderby = '', $order = '' ) {
		// Get ordering from query string unless defined.
		if ( ! $orderby ) {
			$orderby_value = filter_input( INPUT_GET, 'orderby' );
			$orderby_value = isset( $orderby_value ) ? esc_html( $orderby_value ) : 'date';

			// Get order + orderby args from string.
			$orderby_value = explode( '-', $orderby_value );
			$orderby       = esc_attr( $orderby_value[0] );
			$order         = ! empty( $orderby_value[1] ) ? $orderby_value[1] : $order;
		}

		$orderby = strtolower( $orderby );
		$order   = strtoupper( $order );
		$args    = [];

		// Default - menu_order.
		$args['orderby']  = 'date ID';
		$args['order']    = 'OLD' === $order ? 'ASC' : 'DESC';
		$args['meta_key'] = '';

		switch ( $orderby ) {
			case 'date':
				$args['orderby'] = 'date ID';
				$args['order']   = 'OLD' === $order ? 'ASC' : 'DESC';
				break;
			case 'price':
				$args['orderby']  = 'meta_value_num ID';
				$args['order']    = 'HIGH' === $order ? 'DESC' : 'ASC';
				$args['meta_key'] = '_al_listing_price';
				break;
		}

		return apply_filters( 'auto_listings_get_ordering_args', $args );
	}
}
