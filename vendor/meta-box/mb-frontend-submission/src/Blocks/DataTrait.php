<?php
namespace MBFS\Blocks;

use MetaBox\Support\Data;

trait DataTrait {
	private function get_data(): array {
		// Get all meta boxes for posts or models.
		$meta_boxes = rwmb_get_registry( 'meta_box' )->all();
		$meta_boxes = array_filter( $meta_boxes, function ( $meta_box ) {
			return in_array( $meta_box->get_object_type(), [ 'post', 'model' ], true ) && $meta_box->type !== 'block';
		} );

		$object_types    = [];
		$object_type_map = [
			'post'  => __( 'Post', 'mb-frontend-submission' ),
			'model' => __( 'Custom Model', 'mb-frontend-submission' ),
		];

		$post_types    = [];
		$post_type_map = array_map( function ( $post_type ) {
			return $post_type->labels->singular_name;
		}, Data::get_post_types() );

		$field_groups = [];

		foreach ( $meta_boxes as $meta_box ) {
			$object_type                  = $meta_box->get_object_type();
			$object_types[ $object_type ] = [
				'label' => $object_type_map[ $object_type ] ?? $object_type,
				'value' => $object_type,
			];

			if ( $object_type === 'post' ) {
				foreach ( $meta_box->post_types as $post_type ) {
					$label                    = $post_type_map[ $post_type ] ?? $post_type;
					$post_types[ $post_type ] = [
						'label' => "$label ($post_type)",
						'value' => $post_type,
					];
				}
			}

			$fields         = array_filter( $meta_box->fields, function ( $field ) {
				return isset( $field['id'] );
			} );
			$field_groups[] = [
				'value'       => $meta_box->id,
				'label'       => "{$meta_box->title} ({$meta_box->id})",
				'object_type' => $object_type,
				'post_types'  => $meta_box->post_types,
				'fields'      => array_values( wp_list_pluck( $fields, 'id' ) ),
			];
		}

		$post_types   = array_values( $post_types );
		$object_types = array_values( $object_types );

		return compact( 'post_types', 'object_types', 'field_groups' );
	}
}
