<?php
namespace AutoListings\SearchForm\Shortcode;

// use AutoListingsPro\Frontend\Assets;

class Form {
	public function __construct() {
		add_shortcode( 'als', array( $this, 'render' ) );
	}

	public function render( $atts ) {
		if ( is_admin() ) {
			return '';
		}

		$atts = shortcode_atts(
			array(
				'id' => '',
			),
			$atts
		);

		$id = $atts['id'];
		unset( $atts['id'] );

		if ( empty( $id ) ) {
			return '';
		}

		$post = get_post( $id );
		if ( ! $post ) {
			return;
		}

		// Must enqueue frontend assets. Use filter to bypass is_auto_listing_pro check.
		// add_filter( 'is_auto_listings_pro', '__return_true' );
		// $assets = new Assets;
		// $assets->enqueue();

		$output = '';

		if ( $post->post_excerpt ) {
			$output .= '<style>' . $post->post_excerpt . '</style>';
		}

		$output .= '<form'
			. ' id="auto-listings-search" class="auto-listings-search" autocomplete="off"'
			. ' action="' . get_the_permalink( auto_listings_option( 'archives_page' ) ) . '"'
			. ' method="GET"'
			. ' role="search">';

		$output .= do_shortcode( $post->post_content );

		$output .= '</form>';

		return $output;
	}
}
