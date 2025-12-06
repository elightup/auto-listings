<?php
namespace AutoListings\Elementor;

use Elementor\Widget_Base;

/**
 * Base class for Auto Listings Elementor widgets
 */
abstract class Base extends Widget_Base {
	/**
	 * Get widget categories
	 *
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return [ 'auto-listings' ];
	}

	/**
	 * Get widget keywords
	 *
	 * @return array Widget keywords.
	 */
	public function get_keywords() {
		return [ 'auto', 'listings', 'car', 'vehicle', 'dealership' ];
	}

	/**
	 * Register common style controls
	 *
	 * @param string $selector CSS selector for the element.
	 */
	protected function register_style_typography_controls( $selector = '{{WRAPPER}}' ) {
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'typography',
				'selector' => $selector,
			]
		);
	}

	/**
	 * Register common color controls
	 *
	 * @param string $label    Control label.
	 * @param string $selector CSS selector.
	 * @param string $property CSS property.
	 */
	protected function register_color_control( $label, $selector, $property = 'color' ) {
		$this->add_control(
			str_replace( '-', '_', $property ) . '_color',
			[
				'label'     => $label,
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					$selector => $property . ': {{VALUE}};',
				],
			]
		);
	}

	/**
	 * Register spacing controls
	 *
	 * @param string $selector CSS selector.
	 */
	protected function register_spacing_controls( $selector = '{{WRAPPER}}' ) {
		$this->add_responsive_control(
			'margin',
			[
				'label'      => esc_html__( 'Margin', 'auto-listings' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					$selector => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'padding',
			[
				'label'      => esc_html__( 'Padding', 'auto-listings' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					$selector => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
	}

	/**
	 * Register border controls
	 *
	 * @param string $selector CSS selector.
	 */
	protected function register_border_controls( $selector = '{{WRAPPER}}' ) {
		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name'     => 'border',
				'selector' => $selector,
			]
		);

		$this->add_responsive_control(
			'border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'auto-listings' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					$selector => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
	}

	/**
	 * Register background controls
	 *
	 * @param string $selector CSS selector.
	 */
	protected function register_background_controls( $selector = '{{WRAPPER}}' ) {
		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name'     => 'background',
				'types'    => [ 'classic', 'gradient' ],
				'selector' => $selector,
			]
		);
	}

	/**
	 * Register box shadow controls
	 *
	 * @param string $selector CSS selector.
	 */
	protected function register_shadow_controls( $selector = '{{WRAPPER}}' ) {
		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'box_shadow',
				'selector' => $selector,
			]
		);
	}

	/**
	 * Check if we're in Elementor editor mode
	 *
	 * @return bool
	 */
	protected function is_editor_mode() {
		return \Elementor\Plugin::$instance && 
		       isset( \Elementor\Plugin::$instance->editor ) && 
		       \Elementor\Plugin::$instance->editor->is_edit_mode();
	}
}

