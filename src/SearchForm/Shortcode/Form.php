<?php
namespace AutoListings\SearchForm\Shortcode;

use AutoListings\Frontend\Assets;

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

		// Must enqueue frontend assets. Use filter to bypass is_auto_listing check.
		add_filter( 'is_auto_listings', '__return_true' );
		$assets = new Assets;
		$assets->enqueue();

		$output = '';

		if ( $post->post_excerpt ) {
			$output .= '<style>' . $post->post_excerpt . '</style>';
		}

		if ( $post->post_content_filtered ) {
			$output .= '<script>' . $post->post_content_filtered . '</script>';
		}

		$output .= '<form'
			. ' class="als" autocomplete="off"'
			. ' action="' . get_the_permalink( auto_listings_option( 'archives_page' ) ) . '"'
			. ' method="GET"'
			. ' role="search">';

		$output .= do_shortcode( $post->post_content );

		$output .= '</form>';

		return $output;
	}
}
