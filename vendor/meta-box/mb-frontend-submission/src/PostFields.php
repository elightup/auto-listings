<?php
/**
 * Hide fields which are used to save post data (title, content, excerpt, date, thumbnail).
 * Only hide fields from admin edit post screen, do not disable saving process (which can be use elsewhere).
 */

namespace MBFS;

class PostFields {
	public function __construct() {
		// Hide fields in add new and edit post screens.
		add_action( 'load-post-new.php', [ $this, 'filter_field_output' ] );
		add_action( 'load-post.php', [ $this, 'filter_field_output' ] );

		// Make fields show proper post's values in edit post and post list table screens.
		add_action( 'load-post.php', [ $this, 'filter_fields_values' ] );
		add_action( 'load-edit.php', [ $this, 'filter_fields_values' ] );
	}

	public function filter_field_output(): void {
		add_filter( 'rwmb_outer_html', [ $this, 'hide_field' ], 10, 2 );
	}

	public function hide_field( string $html, array $field ): string {
		$post_type_supports_map = [
			'post_title'    => 'title',
			'post_content'  => 'editor',
			'post_excerpt'  => 'excerpt',
			'post_date'     => 'date',
			'_thumbnail_id' => 'thumbnail',
		];
		if ( ! isset( $post_type_supports_map[ $field['id'] ] ) ) {
			return $html;
		}

		$post_type = get_current_screen()->post_type;
		$support   = $post_type_supports_map[ $field['id'] ];
		return post_type_supports( $post_type, $support ) ? '' : $html;
	}

	public function filter_fields_values(): void {
		$fields = [ 'post_title', 'post_content', 'post_excerpt', 'post_date' ];
		foreach ( $fields as $field ) {
			add_filter(
				"rwmb_{$field}_raw_meta",
				function ( $value, $field, $object_id ) {
					return get_post_field( $field['id'], $object_id );
				},
				10,
				3
			);
		}
	}
}
