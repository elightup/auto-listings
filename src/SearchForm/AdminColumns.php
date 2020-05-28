<?php
namespace AutoListings\SearchForm;

class AdminColumns {
	public function __construct() {
		add_filter( 'manage_auto-listings-search_posts_columns', array( $this, 'add_columns' ) );
		add_action( 'manage_auto-listings-search_posts_custom_column', array( $this, 'show_column' ) );
	}

	public function add_columns( $columns ) {
		$new_columns = array(
			'shortcode' => __( 'Shortcode', 'auto-listings' ),
		);
		$columns     = array_slice( $columns, 0, 2, true ) + $new_columns + array_slice( $columns, 2, null, true );
		return $columns;
	}

	public function show_column( $name ) {
		if ( 'shortcode' === $name ) {
			$shortcode = '[als id="' . get_the_ID() . '"]';
			echo '<input type="text" readonly value="' . esc_attr( $shortcode ) . '" onclick="this.select()">';
		}
	}
}
