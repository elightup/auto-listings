<?php
namespace AutoListings;

class Query {
	public function __construct() {
		if ( is_admin() ) {
			return;
		}
		add_action( 'pre_get_posts', [ $this, 'pre_get_posts' ] );
		add_action( 'wp', [ $this, 'remove_query_hook' ] );
	}

	/**
	 * Hook into pre_get_posts to do the main listing query.
	 *
	 * @param mixed $query Query object.
	 */
	public function pre_get_posts( $query ) {
		if ( ! is_listing_archive() || ! $query->is_main_query() ) {
			return;
		}

		$this->listings_query( $query );
		$this->remove_query_hook();
	}

	/**
	 * Query the listings, applying sorting/ordering etc. This applies to the main WordPress loop.
	 *
	 * @param mixed $query
	 */
	public function listings_query( $query ) {
		$query->set( 'post_status', 'publish' );

		// Ordering query vars
		$ordering = $this->get_ordering_args();
		$query->set( 'orderby', $ordering['orderby'] );
		$query->set( 'order', $ordering['order'] );
		if ( isset( $ordering['meta_key'] ) ) {
			$query->set( 'meta_key', $ordering['meta_key'] );
		}

		// get default as either rent or sell. We don't want both at the same time
		// the search query can modify this later if need be
		// $meta_query[] = array(
		// 	'key' 		=> '_al_listing_purpose',
		// 	'value' 	=> auto_listings_display(),
		// 	'compare' 	=> 'LIKE',
		// );
		//$q->set( 'meta_query', $meta_query );
		//pp( $q );
	}

	public function get_ordering_args( $orderby = '', $order = '' ) {
		// Get ordering from query string unless defined
		if ( ! $orderby ) {
			$orderby_value = isset( $_GET['orderby'] ) ? esc_html( $_GET['orderby'] ) : 'date';

			// Get order + orderby args from string
			$orderby_value = explode( '-', $orderby_value );
			$orderby       = esc_attr( $orderby_value[0] );
			$order         = ! empty( $orderby_value[1] ) ? $orderby_value[1] : $order;
		}

		$orderby = strtolower( $orderby );
		$order   = strtoupper( $order );
		$args    = [];

		// Default - menu_order
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

	public function remove_query_hook() {
		remove_action( 'pre_get_posts', [ $this, 'pre_get_posts' ] );
	}
}
