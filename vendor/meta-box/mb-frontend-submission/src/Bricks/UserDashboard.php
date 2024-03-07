<?php
namespace MBFS\Bricks;

use MBFS\DashboardRenderer;
use MetaBox\Support\Data;

class UserDashboard extends \Bricks\Element {
	public $category = 'meta-box';
	public $name     = 'mbfs-user-dashboard';
	public $icon     = 'fa-solid fa-gauge';

	public function get_label() {
		return esc_html__( 'User Dashboard', 'mb-frontend-submission' );
	}

	public function set_controls() {

		$pages = get_pages();
		$args  = [];
		foreach ( $pages as $item ) {
			$args [ $item->ID ] = $item->post_title;
		}

		$this->controls['edit_page'] = [
			'tab'         => 'content',
			'label'       => esc_html__( 'Edit Page', 'mb-frontend-submission' ),
			'type'        => 'select',
			'options'     => $args,
			'default'     => '1',
			'description' => esc_html__( 'Choose a page where users can submit posts.', 'mb-frontend-submission' ),
		];

		$this->controls['meta_box_id'] = [
			'tab'         => 'content',
			'label'       => esc_html__( 'Field group ID(s)', 'mb-frontend-submission' ),
			'type'        => 'text',
			'default'     => '',
			'description' => esc_html__( 'Overwrite field group ID(s) from the edit page. If multiple field groups, enter their IDs separated by commas.', 'mb-frontend-submission' ),
		];

		$post_types                  = wp_list_pluck( Data::get_post_types(), 'name' );
		$this->controls['post_type'] = [
			'tab'         => 'content',
			'label'       => esc_html__( 'Post type', 'mb-frontend-submission' ),
			'type'        => 'select',
			'options'     => $post_types,
			'default'     => '',
			'description' => esc_html__( 'Overwrite the submitted post type from the edit page.', 'mb-frontend-submission' ),
		];

		$this->controls['show_welcome_message'] = [
			'tab'     => 'content',
			'label'   => esc_html__( 'Show welcome message', 'mb-frontend-submission' ),
			'type'    => 'checkbox',
			'default' => true,
		];

		$this->controls['columns'] = [
			'tab'         => 'content',
			'label'       => esc_html__( 'Columns', 'mb-frontend-submission' ),
			'type'        => 'select',
			'options'     => [
				'title'  => esc_html__( 'Title', 'mb-frontend-submission' ),
				'date'   => esc_html__( 'Date', 'mb-frontend-submission' ),
				'status' => esc_html__( 'Status', 'mb-frontend-submission' ),
			],
			'multiple'    => true,
			'default'     => [
				'title',
				'date',
				'status',
			],
			'description' => esc_html__( 'List of columns to be displayed in the dashboard.', 'mb-frontend-submission' ),
		];

		$this->controls['label_title'] = [
			'tab'         => 'content',
			'label'       => esc_html__( 'Title Column Label', 'mb-frontend-submission' ),
			'type'        => 'text',
			'default'     => __( 'Title', 'mb-frontend-submission' ),
			'description' => esc_html__( 'The label for the title column.', 'mb-frontend-submission' ),
		];

		$this->controls['label_date'] = [
			'tab'         => 'content',
			'label'       => esc_html__( 'Date Column Label', 'mb-frontend-submission' ),
			'type'        => 'text',
			'default'     => __( 'Date', 'mb-frontend-submission' ),
			'description' => esc_html__( 'The label for the date column.', 'mb-frontend-submission' ),
		];

		$this->controls['label_status'] = [
			'tab'         => 'content',
			'label'       => esc_html__( 'Status Column Label', 'mb-frontend-submission' ),
			'type'        => 'text',
			'default'     => __( 'Status', 'mb-frontend-submission' ),
			'description' => esc_html__( 'The label for the status column.', 'mb-frontend-submission' ),
		];

		$this->controls['label_actions'] = [
			'tab'         => 'content',
			'label'       => esc_html__( 'Actions Column Label', 'mb-frontend-submission' ),
			'type'        => 'text',
			'default'     => __( 'Actions', 'mb-frontend-submission' ),
			'description' => esc_html__( 'The label for the actions column.', 'mb-frontend-submission' ),
		];

		$this->controls['title_link'] = [
			'tab'         => 'content',
			'label'       => esc_html__( 'Post Action Link', 'mb-frontend-submission' ),
			'type'        => 'select',
			'options'     => [
				'view' => esc_html__( 'View', 'mb-frontend-submission' ),
				'edit' => esc_html__( 'Edit', 'mb-frontend-submission' ),
			],
			'default'     => 'view',
			'description' => esc_html__( 'The link action when clicking post titles.', 'mb-frontend-submission' ),
		];

		$this->controls['add_new'] = [
			'tab'     => 'content',
			'label'   => esc_html__( 'Add New Button Text', 'mb-frontend-submission' ),
			'type'    => 'text',
			'default' => __( 'Add New', 'mb-frontend-submission' ),
		];
	}

	public function enqueue_scripts() {
		wp_enqueue_style( 'mbfs-dashboard', MBFS_URL . 'assets/dashboard.css', '', MBFS_VER );
	}

	public function render() {
		$settings = $this->settings;

		$settings['show_welcome_message'] = empty( $settings['show_welcome_message'] ) ? false : $settings['show_welcome_message'];

		// Render.
		echo "<div {$this->render_attributes( '_root' )}>";

		$dashboard = new DashboardRenderer();
		echo $dashboard->render( $settings );

		echo '</div>';
	}
}
