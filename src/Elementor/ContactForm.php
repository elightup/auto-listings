<?php
namespace AutoListings\Elementor;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;

/**
 * Contact Form Elementor Widget
 */
class ContactForm extends Base {
	/**
	 * Get widget name
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'auto-listings-contact-form';
	}

	/**
	 * Get widget title
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( 'Contact Form', 'auto-listings' );
	}

	/**
	 * Get widget icon
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-form-horizontal';
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
			'title',
			[
				'label'       => esc_html__( 'Title', 'auto-listings' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Contact Seller', 'auto-listings' ),
				'placeholder' => esc_html__( 'Enter title', 'auto-listings' ),
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
					'{{WRAPPER}} .auto-listings-contact-form h3' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'title_typography',
				'selector' => '{{WRAPPER}} .auto-listings-contact-form h3',
			]
		);

		$this->add_responsive_control(
			'title_spacing',
			[
				'label'      => esc_html__( 'Bottom Spacing', 'auto-listings' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .auto-listings-contact-form h3' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		// Style Tab - Form Fields
		$this->start_controls_section(
			'section_fields_style',
			[
				'label' => esc_html__( 'Form Fields', 'auto-listings' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'field_text_color',
			[
				'label'     => esc_html__( 'Text Color', 'auto-listings' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .auto-listings-contact-form input[type="text"]'     => 'color: {{VALUE}};',
					'{{WRAPPER}} .auto-listings-contact-form input[type="email"]'    => 'color: {{VALUE}};',
					'{{WRAPPER}} .auto-listings-contact-form input[type="tel"]'      => 'color: {{VALUE}};',
					'{{WRAPPER}} .auto-listings-contact-form textarea'               => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'field_background_color',
			[
				'label'     => esc_html__( 'Background Color', 'auto-listings' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .auto-listings-contact-form input[type="text"]'     => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .auto-listings-contact-form input[type="email"]'    => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .auto-listings-contact-form input[type="tel"]'      => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .auto-listings-contact-form textarea'               => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'field_typography',
				'selector' => '{{WRAPPER}} .auto-listings-contact-form input, {{WRAPPER}} .auto-listings-contact-form textarea',
			]
		);

		$this->add_responsive_control(
			'field_padding',
			[
				'label'      => esc_html__( 'Padding', 'auto-listings' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .auto-listings-contact-form input[type="text"]'     => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .auto-listings-contact-form input[type="email"]'    => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .auto-listings-contact-form input[type="tel"]'      => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .auto-listings-contact-form textarea'               => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'field_border',
				'selector' => '{{WRAPPER}} .auto-listings-contact-form input[type="text"], {{WRAPPER}} .auto-listings-contact-form input[type="email"], {{WRAPPER}} .auto-listings-contact-form input[type="tel"], {{WRAPPER}} .auto-listings-contact-form textarea',
			]
		);

		$this->add_responsive_control(
			'field_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'auto-listings' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .auto-listings-contact-form input[type="text"]'     => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .auto-listings-contact-form input[type="email"]'    => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .auto-listings-contact-form input[type="tel"]'      => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .auto-listings-contact-form textarea'               => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		// Style Tab - Submit Button
		$this->start_controls_section(
			'section_button_style',
			[
				'label' => esc_html__( 'Submit Button', 'auto-listings' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->start_controls_tabs( 'button_style_tabs' );

		// Normal State
		$this->start_controls_tab(
			'button_normal',
			[
				'label' => esc_html__( 'Normal', 'auto-listings' ),
			]
		);

		$this->add_control(
			'button_text_color',
			[
				'label'     => esc_html__( 'Text Color', 'auto-listings' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .auto-listings-contact-form button[type="submit"]' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_background_color',
			[
				'label'     => esc_html__( 'Background Color', 'auto-listings' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .auto-listings-contact-form button[type="submit"]' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		// Hover State
		$this->start_controls_tab(
			'button_hover',
			[
				'label' => esc_html__( 'Hover', 'auto-listings' ),
			]
		);

		$this->add_control(
			'button_hover_text_color',
			[
				'label'     => esc_html__( 'Text Color', 'auto-listings' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .auto-listings-contact-form button[type="submit"]:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_hover_background_color',
			[
				'label'     => esc_html__( 'Background Color', 'auto-listings' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .auto-listings-contact-form button[type="submit"]:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'button_typography',
				'selector'  => '{{WRAPPER}} .auto-listings-contact-form button[type="submit"]',
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'button_padding',
			[
				'label'      => esc_html__( 'Padding', 'auto-listings' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .auto-listings-contact-form button[type="submit"]' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'button_border',
				'selector' => '{{WRAPPER}} .auto-listings-contact-form button[type="submit"]',
			]
		);

		$this->add_responsive_control(
			'button_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'auto-listings' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .auto-listings-contact-form button[type="submit"]' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'button_box_shadow',
				'selector' => '{{WRAPPER}} .auto-listings-contact-form button[type="submit"]',
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

		$this->register_background_controls( '{{WRAPPER}} .auto-listings-contact-form' );
		$this->register_spacing_controls( '{{WRAPPER}} .auto-listings-contact-form' );
		$this->register_border_controls( '{{WRAPPER}} .auto-listings-contact-form' );
		$this->register_shadow_controls( '{{WRAPPER}} .auto-listings-contact-form' );

		$this->end_controls_section();
	}

	/**
	 * Render widget output on the frontend
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();

		echo '<div class="auto-listings-contact-form">';
		
		if ( 'yes' === $settings['show_title'] && ! empty( $settings['title'] ) ) {
			echo '<h3>' . esc_html( $settings['title'] ) . '</h3>';
		}

		// Use the existing template function
		auto_listings_template_single_contact_form();
		
		echo '</div>';
	}
}

