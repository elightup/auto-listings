<?php
namespace MBFS\Block;

use MBFS\DashboardRenderer;
use MBFS\Helper;
use MetaBox\Support\Data;

class UserDashboard {
	private $dashboard_renderer;

	public function __construct( DashboardRenderer $dashboard_renderer ) {
		$this->dashboard_renderer = $dashboard_renderer;

		add_action( 'init', [ $this, 'register_block' ], 99 );
		add_action( 'enqueue_block_editor_assets', [ $this, 'enqueue' ], 99 );
	}

	public function register_block() {
		register_block_type( MBFS_DIR . '/block/user-dashboard/build', [
			'render_callback' => [ $this, 'render_block' ],
		] );
	}

	public function render_block( $attributes ): string {
		return $this->dashboard_renderer->render( $attributes );
	}

	public function enqueue() {
		wp_enqueue_style( 'mbfs-dashboard', MBFS_URL . 'assets/dashboard.css', [], MBFS_VER );

		$args = [
			'post_types' => wp_list_pluck( Data::get_post_types(), 'name' ),
			'pages'      => [],
		];

		$pages = get_pages();
		if ( ! empty( $pages ) ) {
			foreach ( $pages as $item ) {
				$args['pages'][] = [
					'value' => $item->ID,
					'label' => $item->post_title,
				];
			}
		}

		$object_types = [
			'post'  => __( 'Post', 'mb-frontend-submission' ),
			'model' => __( 'Custom Model', 'mb-frontend-submission' ),
		];

		$all_models = [];
		if ( class_exists( \MetaBox\CustomTable\Model\Factory::class ) ) {
			$models     = \MetaBox\CustomTable\Model\Factory::get();
			$all_models = array_keys( $models );
		}

		$args['all_models']        = $all_models;
		$args['object_types']      = $object_types;
		$args['fields_suggestion'] = Helper::get_field_suggestions();

		wp_localize_script( 'meta-box-user-dashboard-editor-script', 'mbudData', $args );
	}
}
