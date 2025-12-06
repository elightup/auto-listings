<?php
namespace MBFS\Blocks;

use MBFS\Dashboard\Renderer;
use MBFS\Helper;
use MetaBox\Support\Data;

class UserDashboard {
	use DataTrait;

	private $dashboard_renderer;

	public function __construct( Renderer $dashboard_renderer ) {
		$this->dashboard_renderer = $dashboard_renderer;

		add_action( 'init', [ $this, 'register_block' ], 99 );
		add_action( 'enqueue_block_editor_assets', [ $this, 'enqueue' ], 99 );
	}

	public function register_block() {
		register_block_type( MBFS_DIR . '/blocks/user-dashboard/build', [
			'render_callback' => [ $this, 'render_block' ],
		] );
	}

	public function render_block( $attributes ): string {
		$id = $attributes['id'] ?? [];
		if ( empty( $id ) && ! empty( $attributes['meta_box_id'] ) ) {
			$id = $attributes['meta_box_id'];
		}
		$id               = is_array( $id ) ? implode( ',', $id ) : $id;
		$attributes['id'] = $id;

		$attributes['show_welcome_message'] = Helper::convert_boolean( $attributes['show_welcome_message'] );

		return $this->dashboard_renderer->render( $attributes );
	}

	public function enqueue() {
		wp_enqueue_style( 'mbfs-dashboard', MBFS_URL . 'assets/dashboard.css', [], MBFS_VER );

		$args          = $this->get_data();
		$args['pages'] = [];

		$pages = get_pages();
		if ( ! empty( $pages ) ) {
			foreach ( $pages as $item ) {
				$args['pages'][] = [
					'value' => $item->ID,
					'label' => $item->post_title,
				];
			}
		}

		$all_models = [];
		if ( class_exists( \MetaBox\CustomTable\Model\Factory::class ) ) {
			$models     = \MetaBox\CustomTable\Model\Factory::get();
			$all_models = array_keys( $models );
		}

		$args['all_models']        = $all_models;
		$args['fields_suggestion'] = Helper::get_field_suggestions();

		wp_localize_script( 'meta-box-user-dashboard-editor-script', 'mbudData', $args );
	}
}
