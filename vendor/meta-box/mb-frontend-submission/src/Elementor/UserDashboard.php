<?php
namespace MBFS\Elementor;

use Elementor\Controls_Manager;
use MBFS\DashboardRenderer;
use MBFS\Helper;
use MetaBox\Support\Arr;
use MetaBox\Support\Data;

class UserDashboard extends \Elementor\Widget_Base {
	public function get_name() {
		return 'mbfs_user_dashboard';
	}

	public function get_title() {
		return esc_html__( 'User Dashboard', 'mb-frontend-submission' );
	}

	public function get_icon() {
		return 'eicon-code';
	}

	public function get_categories() {
		return [ 'metabox' ];
	}

	public function get_keywords() {
		return [ 'dashboard' ];
	}

	public function register_controls() {
		$this->start_controls_section(
			'content_section',
			[
				'label' => esc_html__( 'Content', 'mb-frontend-submission' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$pages = get_pages();
		if ( isset( $pages ) ) {
			$args = [];
			foreach ( $pages as $item ) {
				$args [ $item->ID ] = $item->post_title;
			}

			$this->add_control(
				'dashboard_edit_page',
				[
					'type'        => Controls_Manager::SELECT,
					'label'       => esc_html__( 'Edit page', 'mb-frontend-submission' ),
					'multiple'    => true,
					'options'     => $args,
					'description' => esc_html__( 'Choose a page where users can submit posts.', 'mb-frontend-submission' ),
				]
			);
		}

		$this->add_control(
			'group_ids',
			[
				'label'       => esc_html__( 'Field group ID(s)', 'mb-frontend-submission' ),
				'type'        => Controls_Manager::TEXT,
				'description' => esc_html__( 'Overwrite field group ID(s) from the edit page. If multiple field groups, enter their IDs separated by commas.', 'mb-frontend-submission' ),
			]
		);

		$post_types = array_merge( [ '' => '-' ], wp_list_pluck( Data::get_post_types(), 'name' ) );
		$this->add_control(
			'post_type',
			[
				'type'        => Controls_Manager::SELECT,
				'label'       => esc_html__( 'Post type', 'mb-frontend-submission' ),
				'options'     => $post_types,
				'default'     => '',
				'description' => esc_html__( 'Overwrite the submitted post type from the edit page.', 'mb-frontend-submission' ),
			]
		);

		$this->add_control(
			'show_welcome_message',
			[
				'type'         => Controls_Manager::SWITCHER,
				'label'        => esc_html__( 'Show welcome message', 'mb-frontend-submission' ),
				'label_on'     => esc_html__( 'True', 'mb-frontend-submission' ),
				'label_off'    => esc_html__( 'False', 'mb-frontend-submission' ),
				'return_value' => 'yes',
				'default'      => 'no',
			]
		);

		$this->add_control(
			'columns',
			[
				'type'        => Controls_Manager::SELECT2,
				'label'       => esc_html__( 'Columns', 'mb-frontend-submission' ),
				'multiple'    => true,
				'options'     => [
					'title'  => esc_html__( 'Title', 'mb-frontend-submission' ),
					'date'   => esc_html__( 'Date', 'mb-frontend-submission' ),
					'status' => esc_html__( 'Status', 'mb-frontend-submission' ),
				],
				'default'     => [ 'title', 'date', 'status' ],
				'description' => esc_html__( 'List of columns to be displayed in the dashboard.', 'mb-frontend-submission' ),
			]
		);

		$this->add_control(
			'label_title',
			[
				'label'       => esc_html__( 'Title Column Label', 'mb-frontend-submission' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => __( 'Title', 'mb-frontend-submission' ),
				'description' => esc_html__( 'The label for the title column.', 'mb-frontend-submission' ),
			]
		);

		$this->add_control(
			'label_date',
			[
				'label'       => esc_html__( 'Date Column Label', 'mb-frontend-submission' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => __( 'Date', 'mb-frontend-submission' ),
				'description' => esc_html__( 'The label for the date column.', 'mb-frontend-submission' ),
			]
		);

		$this->add_control(
			'label_status',
			[
				'label'       => esc_html__( 'Status Column Label', 'mb-frontend-submission' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => __( 'Status', 'mb-frontend-submission' ),
				'description' => esc_html__( 'The label for the status column.', 'mb-frontend-submission' ),
			]
		);

		$this->add_control(
			'label_actions',
			[
				'label'       => esc_html__( 'Actions Column Label', 'mb-frontend-submission' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => __( 'Actions', 'mb-frontend-submission' ),
				'description' => esc_html__( 'The label for the actions column.', 'mb-frontend-submission' ),
			]
		);

		$this->add_control(
			'title_link',
			[
				'type'        => Controls_Manager::SELECT2,
				'label'       => esc_html__( 'Post Action Link', 'mb-frontend-submission' ),
				'options'     => [
					'view' => esc_html__( 'View', 'mb-frontend-submission' ),
					'edit' => esc_html__( 'Edit', 'mb-frontend-submission' ),
				],
				'default'     => 'view',
				'description' => esc_html__( 'The link action when clicking post titles.', 'mb-frontend-submission' ),
			]
		);

		$this->add_control(
			'label_actions',
			[
				'label'       => esc_html__( 'Add New Button Text', 'mb-frontend-submission' ),
				'type'        => Controls_Manager::TEXT,
				'description' => esc_html__( 'The label for the actions column.', 'mb-frontend-submission' ),
				'default'     => __( 'Add New', 'mb-frontend-submission' ),
			]
		);

		$this->end_controls_section();
	}

	public function render() {
		$settings = $this->get_settings_for_display();

		Arr::change_key( $settings, 'dashboard_edit_page', 'edit_page' );
		$settings['show_welcome_message'] = isset( $settings['show_welcome_message'] ) && $settings['show_welcome_message'] === 'yes' ? 'true' : 'false';

		$renderer = new DashboardRenderer();
		echo $renderer->render( $settings );
	}
}
