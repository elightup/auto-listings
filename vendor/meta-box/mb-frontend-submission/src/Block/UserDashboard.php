<?php
namespace MBFS\Block;

use MBFS\DashboardRenderer;
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
		wp_enqueue_style( 'mbfs-dashboard', MBFS_URL . 'assets/dashboard.css', '', MBFS_VER );

		$args  = [
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

		wp_localize_script( 'meta-box-user-dashboard-editor-script', 'mbudData', $args );
	}
}
