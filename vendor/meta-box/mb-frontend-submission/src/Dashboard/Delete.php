<?php
/**
 * Handle delete request for dashboard via REST API.
 */

namespace MBFS\Dashboard;

use WP_REST_Server;
use WP_REST_Request;
use WP_Error;

class Delete {
	public function __construct() {
		add_action( 'rest_api_init', [ $this, 'register_routes' ] );
	}

	public function register_routes() {
		register_rest_route( 'mbfs', 'dashboard/delete', [
			'methods'             => WP_REST_Server::DELETABLE,
			'callback'            => [ $this, 'delete' ],
			'permission_callback' => [ $this, 'permission_check' ],
			'args'                => [
				'id' => [
					'type'              => 'integer',
					'required'          => true,
					'sanitize_callback' => 'absint',
				],
			],
		] );
	}

	public function permission_check( WP_REST_Request $request ): bool {
		$id          = $request->get_param( 'id' );
		$object_type = $request->get_param( 'object_type' ) ?: 'post';

		if ( ! is_user_logged_in() ) {
			return false;
		}

		// Post.
		if ( $object_type === 'post' ) {
			$post = get_post( $id );
			return $post && ( $post->post_author == get_current_user_id() || current_user_can( 'delete_post', $post->ID ) );
		}

		// Custom model.
		if ( $object_type !== 'model' || ! class_exists( \MetaBox\CustomTable\Model\Factory::class ) ) {
			return false;
		}

		$model_name = $request->get_param( 'model' );
		if ( ! $model_name ) {
			return false;
		}

		$model = \MetaBox\CustomTable\Model\Factory::get( $model_name );
		if ( empty( $model ) ) {
			return false;
		}

		return \MetaBox\CustomTable\API::exists( $id, $model->table );
	}

	public function delete( WP_REST_Request $request ) {
		$object_type = $request->get_param( 'object_type' ) ?: 'post';
		$id          = $request->get_param( 'id' );
		$force       = $request->get_param( 'force' ) ?: false;
		$result      = true;

		// Post.
		if ( $object_type === 'post' ) {
			$result = wp_delete_post( $id, $force );
			return $result ? true : new WP_Error( 'mbfs_dashboard_delete_failed', __( 'Failed to delete the record.', 'mb-frontend-submission' ) );
		}

		// Custom model.
		$model_name = $request->get_param( 'model' );
		$model      = \MetaBox\CustomTable\Model\Factory::get( $model_name );
		$result     = \MetaBox\CustomTable\API::delete( $id, $model->table );

		return $result ? true : new WP_Error( 'mbfs_dashboard_delete_failed', __( 'Failed to delete the record.', 'mb-frontend-submission' ) );
	}
}
