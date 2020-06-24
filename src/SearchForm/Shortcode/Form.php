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

		$output = '';

		if ( $post->post_excerpt ) {
			$output .= '<style>' . $post->post_excerpt . '</style>';
		}

		if ( $post->post_content_filtered ) {
			$output .= '<script>' . $post->post_content_filtered . '</script>';
		}

		$action = apply_filters( 'auto_listings_search_form_action', get_the_permalink( auto_listings_option( 'archives_page' ) ) );

		$output .= '<form'
			. ' class="als" autocomplete="off"'
			. ' action="' . $action . '"'
			. ' method="GET"'
			. ' role="search">';

		$output .= do_shortcode( $post->post_content );

		$output .= '</form>';

		return $output;
	}
}
