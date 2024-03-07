<?php
namespace MBFS;

use MetaBox\Support\Arr;
use WP_Post;

class Helper {
	public static function convert_boolean( $value ): string {
		return is_string( $value ) ? $value : ( $value ? 'true' : 'false' );
	}

	public static function get_post_content( WP_Post $post ): string {
		$content = $post->post_content;

		// Oxygen Builder.
		if ( defined( 'CT_VERSION' ) && ! defined( 'SHOW_CT_BUILDER' ) ) {
			$shortcode = get_post_meta( $post->ID, 'ct_builder_shortcodes', true );
			$content   = $shortcode ? $shortcode : $content;
		}

		$content = apply_filters( 'mbfs_dashboard_edit_page_content', $content );
		$content = apply_filters( 'rwmb_frontend_dashboard_edit_page_content', $content );

		return $content;
	}

	public static function get_post_type_from_meta_box( \RW_Meta_Box $meta_box ): string {
		if ( $meta_box->get_object_type() !== 'post' || $meta_box->type === 'block' ) {
			return '';
		}

		$post_types = $meta_box->post_types;
		return reset( $post_types );
	}

	public static function parse_attributes( array $attributes ): array {
		Arr::change_key( $attributes, 'meta_box_id', 'id' );
		Arr::change_key( $attributes, 'group_ids', 'id' );
		$attributes = FormFactory::normalize( $attributes );

		// Get only 'id' and 'post_type' attributes.
		return array_intersect_key( $attributes, array_flip( [ 'id', 'post_type' ] ) );
	}
}
