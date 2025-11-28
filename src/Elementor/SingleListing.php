<?php
namespace AutoListings\Elementor;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;

/**
 * Single Listing Elementor Widget
 */
class SingleListing extends Base {
	/**
	 * Get widget name
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'auto-listings-single-listing';
	}

	/**
	 * Get widget title
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( 'Single Listing', 'auto-listings' );
	}

	/**
	 * Get widget icon
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-post-content';
	}

	/**
	 * Register widget controls
	 */
	protected function register_controls() {
		// Content Tab
		$this->start_controls_section(
			'section_content',
			[
				'label' => esc_html__( 'Listing Selection', 'auto-listings' ),
			]
		);

		$this->add_control(
			'listing_id',
			[
				'label'       => esc_html__( 'Listing ID', 'auto-listings' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => '',
				'placeholder' => esc_html__( 'Enter listing ID (leave empty for current listing)', 'auto-listings' ),
				'description' => esc_html__( 'Leave empty to display the current listing when used on single listing pages', 'auto-listings' ),
			]
		);

		$this->add_control(
			'important_note',
			[
				'type'            => Controls_Manager::RAW_HTML,
				'raw'             => esc_html__( 'Tip: You can also use this widget on single listing template pages without entering an ID.', 'auto-listings' ),
				'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
			]
		);

		$this->end_controls_section();

		// Elements to Display
		$this->start_controls_section(
			'section_elements',
			[
				'label' => esc_html__( 'Elements to Display', 'auto-listings' ),
			]
		);

		$this->add_control(
			'show_title',
			[
				'label'        => esc_html__( 'Show Title', 'auto-listings' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'auto-listings' ),
				'label_off'    => esc_html__( 'Hide', 'auto-listings' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'show_price',
			[
				'label'        => esc_html__( 'Show Price', 'auto-listings' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'auto-listings' ),
				'label_off'    => esc_html__( 'Hide', 'auto-listings' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'show_tagline',
			[
				'label'        => esc_html__( 'Show Tagline', 'auto-listings' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'auto-listings' ),
				'label_off'    => esc_html__( 'Hide', 'auto-listings' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'show_gallery',
			[
				'label'        => esc_html__( 'Show Gallery', 'auto-listings' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'auto-listings' ),
				'label_off'    => esc_html__( 'Hide', 'auto-listings' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'show_description',
			[
				'label'        => esc_html__( 'Show Description', 'auto-listings' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'auto-listings' ),
				'label_off'    => esc_html__( 'Hide', 'auto-listings' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'show_features',
			[
				'label'        => esc_html__( 'Show Features', 'auto-listings' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'auto-listings' ),
				'label_off'    => esc_html__( 'Hide', 'auto-listings' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->end_controls_section();

		// Style Tab - Title
		$this->start_controls_section(
			'section_title_style',
			[
				'label'     => esc_html__( 'Title', 'auto-listings' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_title' => 'yes',
				],
			]
		);

		$this->add_control(
			'title_color',
			[
				'label'     => esc_html__( 'Color', 'auto-listings' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .auto-listings-single .single-listing__title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'title_typography',
				'selector' => '{{WRAPPER}} .auto-listings-single .single-listing__title',
			]
		);

		$this->add_responsive_control(
			'title_spacing',
			[
				'label'      => esc_html__( 'Spacing', 'auto-listings' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .auto-listings-single .single-listing__title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		// Style Tab - Price
		$this->start_controls_section(
			'section_price_style',
			[
				'label'     => esc_html__( 'Price', 'auto-listings' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_price' => 'yes',
				],
			]
		);

		$this->add_control(
			'price_color',
			[
				'label'     => esc_html__( 'Color', 'auto-listings' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .auto-listings-single .single-listing__price' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'price_typography',
				'selector' => '{{WRAPPER}} .auto-listings-single .single-listing__price',
			]
		);

		$this->end_controls_section();

		// Style Tab - Description
		$this->start_controls_section(
			'section_description_style',
			[
				'label'     => esc_html__( 'Description', 'auto-listings' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_description' => 'yes',
				],
			]
		);

		$this->add_control(
			'description_color',
			[
				'label'     => esc_html__( 'Color', 'auto-listings' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .auto-listings-single .single-listing__description' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'description_typography',
				'selector' => '{{WRAPPER}} .auto-listings-single .single-listing__description',
			]
		);

		$this->end_controls_section();

		// Style Tab - Container
		$this->start_controls_section(
			'section_container_style',
			[
				'label' => esc_html__( 'Container', 'auto-listings' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->register_background_controls( '{{WRAPPER}} .auto-listings-single' );
		$this->register_spacing_controls( '{{WRAPPER}} .auto-listings-single' );
		$this->register_border_controls( '{{WRAPPER}} .auto-listings-single' );
		$this->register_shadow_controls( '{{WRAPPER}} .auto-listings-single' );

		$this->end_controls_section();
	}

	/**
	 * Render widget output on the frontend
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();
		
		$listing_id = ! empty( $settings['listing_id'] ) ? absint( $settings['listing_id'] ) : get_the_ID();
		
		if ( empty( $listing_id ) ) {
			if ( $this->is_editor_mode() ) {
				echo '<div class="elementor-alert elementor-alert-warning">';
				esc_html_e( 'Please select a listing or use this widget on a single listing page.', 'auto-listings' );
				echo '</div>';
			}
			return;
		}

		$args  = [
			'post_type'      => 'auto-listing',
			'posts_per_page' => 1,
			'no_found_rows'  => 1,
			'post_status'    => 'publish',
			'p'              => $listing_id,
		];
		
		$query = new \WP_Query( $args );
		
		if ( ! $query->have_posts() ) {
			if ( $this->is_editor_mode() ) {
				echo '<div class="elementor-alert elementor-alert-warning">';
				esc_html_e( 'Listing not found.', 'auto-listings' );
				echo '</div>';
			}
			return;
		}

		// Temporarily modify template actions based on settings
		if ( 'yes' !== $settings['show_title'] ) {
			remove_action( 'auto_listings_single_listing', 'auto_listings_template_single_title', 5 );
		}
		if ( 'yes' !== $settings['show_price'] ) {
			remove_action( 'auto_listings_single_listing', 'auto_listings_template_single_price', 10 );
		}
		if ( 'yes' !== $settings['show_tagline'] ) {
			remove_action( 'auto_listings_single_listing', 'auto_listings_template_single_tagline', 15 );
		}
		if ( 'yes' !== $settings['show_gallery'] ) {
			remove_action( 'auto_listings_single_listing', 'auto_listings_template_single_gallery', 20 );
		}
		if ( 'yes' !== $settings['show_description'] ) {
			remove_action( 'auto_listings_single_listing', 'auto_listings_template_single_description', 25 );
		}
		if ( 'yes' !== $settings['show_features'] ) {
			remove_action( 'auto_listings_single_listing', 'auto_listings_template_single_at_a_glance', 30 );
		}

		while ( $query->have_posts() ) {
			$query->the_post();
			echo '<div class="auto-listings-single">';
			auto_listings_get_part( 'content-single-listing.php' );
			echo '</div>';
		}

		// Re-add the actions we removed
		if ( 'yes' !== $settings['show_title'] ) {
			add_action( 'auto_listings_single_listing', 'auto_listings_template_single_title', 5 );
		}
		if ( 'yes' !== $settings['show_price'] ) {
			add_action( 'auto_listings_single_listing', 'auto_listings_template_single_price', 10 );
		}
		if ( 'yes' !== $settings['show_tagline'] ) {
			add_action( 'auto_listings_single_listing', 'auto_listings_template_single_tagline', 15 );
		}
		if ( 'yes' !== $settings['show_gallery'] ) {
			add_action( 'auto_listings_single_listing', 'auto_listings_template_single_gallery', 20 );
		}
		if ( 'yes' !== $settings['show_description'] ) {
			add_action( 'auto_listings_single_listing', 'auto_listings_template_single_description', 25 );
		}
		if ( 'yes' !== $settings['show_features'] ) {
			add_action( 'auto_listings_single_listing', 'auto_listings_template_single_at_a_glance', 30 );
		}

		wp_reset_postdata();
	}
}

