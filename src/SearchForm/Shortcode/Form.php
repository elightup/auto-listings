<?php
namespace AutoListings\SearchForm\Shortcode;

class Form {
	public function __construct() {
		add_shortcode( 'als', array( $this, 'render' ) );
	}

	public function render( $atts ) {
		if ( is_admin() ) {
			return '';
		}

		$atts = shortcode_atts(
			apply_filters( 'als_shortcode_atts', [
				'id' => '',
			] ),
			$atts
		);

		$id = apply_filters( 'als_form_id', $atts['id'] );
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

		$form_attributes = [
			'class'        => 'als',
			'autocomplete' => 'off',
			'action'       => $action,
			'method'       => 'GET',
			'role'         => 'search',
		];

		$form_attributes = apply_filters( 'als_form_atts', array_merge( $form_attributes, $atts ) );

		$output .= '<form';
		foreach( $form_attributes as $attr => $value ) {
			$output .= ' ' . $attr . '=' . htmlspecialchars( $value );
		}
		$output .= '>';

		$output .= do_shortcode( $post->post_content );

		$output .= '</form>';

		return $output;
	}
}
