<?php
namespace AutoListings\Elementor;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;

/**
 * Location Elementor Widget
 */
class Location extends Base {
	/**
	 * Get widget name
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'auto-listings-location';
	}

	/**
	 * Get widget title
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( 'Location & Map', 'auto-listings' );
	}

	/**
	 * Get widget icon
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-google-maps';
	}

	/**
	 * Register widget controls
	 */
	protected function register_controls() {
		// Content Tab
		$this->start_controls_section(
			'section_content',
			[
				'label' => esc_html__( 'Content', 'auto-listings' ),
			]
		);

		$this->add_control(
			'show_address',
			[
				'label'        => esc_html__( 'Show Address', 'auto-listings' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'auto-listings' ),
				'label_off'    => esc_html__( 'Hide', 'auto-listings' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'address_title',
			[
				'label'       => esc_html__( 'Address Title', 'auto-listings' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Location', 'auto-listings' ),
				'placeholder' => esc_html__( 'Enter title', 'auto-listings' ),
				'condition'   => [
					'show_address' => 'yes',
				],
			]
		);

		$this->add_control(
			'show_map',
			[
				'label'        => esc_html__( 'Show Map', 'auto-listings' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'auto-listings' ),
				'label_off'    => esc_html__( 'Hide', 'auto-listings' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'separator'    => 'before',
			]
		);

		$this->add_responsive_control(
			'map_height',
			[
				'label'      => esc_html__( 'Map Height', 'auto-listings' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min' => 200,
						'max' => 800,
					],
				],
				'default'    => [
					'size' => 400,
				],
				'selectors'  => [
					'{{WRAPPER}} .auto-listings-map iframe'  => 'height: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .auto-listings-map'         => 'height: {{SIZE}}{{UNIT}};',
				],
				'condition'  => [
					'show_map' => 'yes',
				],
			]
		);

		$this->end_controls_section();

		// Style Tab - Address
		$this->start_controls_section(
			'section_address_style',
			[
				'label'     => esc_html__( 'Address', 'auto-listings' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_address' => 'yes',
				],
			]
		);

		$this->add_control(
			'address_title_color',
			[
				'label'     => esc_html__( 'Title Color', 'auto-listings' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .auto-listings-location h3' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'address_title_typography',
				'label'    => esc_html__( 'Title Typography', 'auto-listings' ),
				'selector' => '{{WRAPPER}} .auto-listings-location h3',
			]
		);

		$this->add_control(
			'address_text_color',
			[
				'label'     => esc_html__( 'Text Color', 'auto-listings' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .auto-listings-location address' => 'color: {{VALUE}};',
				],
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'address_typography',
				'label'    => esc_html__( 'Address Typography', 'auto-listings' ),
				'selector' => '{{WRAPPER}} .auto-listings-location address',
			]
		);

		$this->add_responsive_control(
			'address_padding',
			[
				'label'      => esc_html__( 'Padding', 'auto-listings' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .auto-listings-location address' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'address_background_color',
			[
				'label'     => esc_html__( 'Background Color', 'auto-listings' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .auto-listings-location' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'address_border',
				'selector' => '{{WRAPPER}} .auto-listings-location',
			]
		);

		$this->add_responsive_control(
			'address_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'auto-listings' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .auto-listings-location' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		// Style Tab - Map
		$this->start_controls_section(
			'section_map_style',
			[
				'label'     => esc_html__( 'Map', 'auto-listings' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_map' => 'yes',
				],
			]
		);

		$this->add_responsive_control(
			'map_margin',
			[
				'label'      => esc_html__( 'Margin', 'auto-listings' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .auto-listings-map' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'map_border',
				'selector' => '{{WRAPPER}} .auto-listings-map',
			]
		);

		$this->add_responsive_control(
			'map_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'auto-listings' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .auto-listings-map'        => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .auto-listings-map iframe' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
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

		$this->register_spacing_controls( '{{WRAPPER}} .auto-listings-location-widget' );
		$this->register_shadow_controls( '{{WRAPPER}} .auto-listings-location-widget' );

		$this->end_controls_section();
	}

	/**
	 * Render widget output on the frontend
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();

		echo '<div class="auto-listings-location-widget">';
		
		if ( 'yes' === $settings['show_address'] ) {
			echo '<div class="auto-listings-location">';
			if ( ! empty( $settings['address_title'] ) ) {
				echo '<h3>' . esc_html( $settings['address_title'] ) . '</h3>';
			}
			// Use the existing template function
			auto_listings_template_single_address();
			echo '</div>';
		}

		if ( 'yes' === $settings['show_map'] ) {
			// Use the existing template function
			auto_listings_template_single_map();
		}
		
		echo '</div>';
	}
}

