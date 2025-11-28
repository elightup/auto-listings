<?php
namespace AutoListings\Elementor;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;

/**
 * Listings Query Form Elementor Widget
 * Provides a configurable search form that submits to listings page with query parameters
 */
class ListingsQueryForm extends Base {
	/**
	 * Get widget name
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'auto-listings-query-form';
	}

	/**
	 * Get widget title
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( 'Listings Query Form', 'auto-listings' );
	}

	/**
	 * Get widget icon
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-search';
	}

	/**
	 * Register widget controls
	 */
	protected function register_controls() {
		$this->start_controls_section(
			'section_form_fields',
			[
				'label' => esc_html__( 'Form Fields', 'auto-listings' ),
			]
		);

		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'field_type',
			[
				'label'   => esc_html__( 'Field Type', 'auto-listings' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'location',
				'options' => [
					'location'    => esc_html__( 'Location', 'auto-listings' ),
					'brand'       => esc_html__( 'Brand / Make', 'auto-listings' ),
					'model'       => esc_html__( 'Model', 'auto-listings' ),
					'year'        => esc_html__( 'Year', 'auto-listings' ),
					'condition'   => esc_html__( 'Condition', 'auto-listings' ),
					'price_min'   => esc_html__( 'Min Price', 'auto-listings' ),
					'price_max'   => esc_html__( 'Max Price', 'auto-listings' ),
					'odometer'    => esc_html__( 'Max Odometer', 'auto-listings' ),
					'transmission' => esc_html__( 'Transmission', 'auto-listings' ),
					'fuel'        => esc_html__( 'Fuel Type', 'auto-listings' ),
					'engine'      => esc_html__( 'Engine Type', 'auto-listings' ),
					'drive'       => esc_html__( 'Drive Type', 'auto-listings' ),
					'body'        => esc_html__( 'Body Type', 'auto-listings' ),
				],
			]
		);

		$repeater->add_control(
			'field_label',
			[
				'label'       => esc_html__( 'Label', 'auto-listings' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => '',
				'placeholder' => esc_html__( 'Enter field label', 'auto-listings' ),
			]
		);

		$repeater->add_control(
			'field_placeholder',
			[
				'label'       => esc_html__( 'Placeholder', 'auto-listings' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => '',
				'placeholder' => esc_html__( 'Enter placeholder text', 'auto-listings' ),
			]
		);

		$repeater->add_control(
			'show_field',
			[
				'label'        => esc_html__( 'Show Field', 'auto-listings' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'auto-listings' ),
				'label_off'    => esc_html__( 'Hide', 'auto-listings' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'form_fields',
			[
				'label'       => esc_html__( 'Fields', 'auto-listings' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'default'     => [
					[
						'field_type'  => 'location',
						'field_label' => esc_html__( 'Location', 'auto-listings' ),
						'show_field'  => 'yes',
					],
					[
						'field_type'  => 'brand',
						'field_label' => esc_html__( 'Brand', 'auto-listings' ),
						'show_field'  => 'yes',
					],
					[
						'field_type'  => 'model',
						'field_label' => esc_html__( 'Model', 'auto-listings' ),
						'show_field'  => 'yes',
					],
				],
				'title_field' => '{{{ field_label }}} ({{{ field_type }}})',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_form_settings',
			[
				'label' => esc_html__( 'Form Settings', 'auto-listings' ),
			]
		);

		$this->add_control(
			'form_action_url',
			[
				'label'       => esc_html__( 'Form Action URL', 'auto-listings' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => '',
				'placeholder' => esc_html__( '/our-stock/', 'auto-listings' ),
				'description' => esc_html__( 'Custom URL where the form will submit. Leave empty to use the default Listings Page. Example: /our-stock/', 'auto-listings' ),
			]
		);

		$this->add_control(
			'intro_text',
			[
				'label'       => esc_html__( 'Intro Text', 'auto-listings' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( "I'm Looking for", 'auto-listings' ),
				'placeholder' => esc_html__( "I'm Looking for", 'auto-listings' ),
			]
		);

		$this->add_control(
			'show_condition_button',
			[
				'label'        => esc_html__( 'Show Condition Button', 'auto-listings' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'auto-listings' ),
				'label_off'    => esc_html__( 'Hide', 'auto-listings' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'condition_button_text',
			[
				'label'       => esc_html__( 'Condition Button Text', 'auto-listings' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'All Conditions', 'auto-listings' ),
				'condition'   => [
					'show_condition_button' => 'yes',
				],
			]
		);

		$this->add_control(
			'condition_button_icon',
			[
				'label'       => esc_html__( 'Condition Button Icon', 'auto-listings' ),
				'type'        => Controls_Manager::ICONS,
				'default'     => [
					'value'   => 'fas fa-filter',
					'library' => 'fa-solid',
				],
				'condition'   => [
					'show_condition_button' => 'yes',
				],
			]
		);

		$this->add_control(
			'search_button_text',
			[
				'label'       => esc_html__( 'Search Button Text', 'auto-listings' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => '',
				'description' => esc_html__( 'Leave empty to show icon only', 'auto-listings' ),
			]
		);

		$this->add_control(
			'search_button_icon',
			[
				'label'       => esc_html__( 'Search Button Icon', 'auto-listings' ),
				'type'        => Controls_Manager::ICONS,
				'default'     => [
					'value'   => 'fas fa-search',
					'library' => 'fa-solid',
				],
			]
		);

		$this->add_control(
			'search_button_visibility',
			[
				'label'   => esc_html__( 'Search Button Visibility', 'auto-listings' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'always',
				'options' => [
					'always'      => esc_html__( 'Always Visible', 'auto-listings' ),
					'when_active'  => esc_html__( 'Only When Filters Active', 'auto-listings' ),
				],
			]
		);

		$this->add_control(
			'form_layout',
			[
				'label'   => esc_html__( 'Form Layout', 'auto-listings' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'horizontal',
				'options' => [
					'horizontal' => esc_html__( 'Horizontal', 'auto-listings' ),
					'vertical'   => esc_html__( 'Vertical', 'auto-listings' ),
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_form',
			[
				'label' => esc_html__( 'Form Container', 'auto-listings' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'form_background_type',
			[
				'label'   => esc_html__( 'Background Type', 'auto-listings' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'gradient',
				'options' => [
					'color'    => esc_html__( 'Color', 'auto-listings' ),
					'gradient' => esc_html__( 'Gradient', 'auto-listings' ),
				],
			]
		);

		$this->add_control(
			'form_background_color',
			[
				'label'     => esc_html__( 'Background Color', 'auto-listings' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#667eea',
				'selectors' => [
					'{{WRAPPER}} .auto-listings-query-form' => 'background: {{VALUE}};',
				],
				'condition' => [
					'form_background_type' => 'color',
				],
			]
		);

		$this->add_control(
			'form_gradient_color_1',
			[
				'label'     => esc_html__( 'Gradient Color 1', 'auto-listings' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#667eea',
				'condition' => [
					'form_background_type' => 'gradient',
				],
			]
		);

		$this->add_control(
			'form_gradient_color_2',
			[
				'label'     => esc_html__( 'Gradient Color 2', 'auto-listings' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#764ba2',
				'selectors' => [
					'{{WRAPPER}} .auto-listings-query-form' => 'background: linear-gradient(135deg, {{form_gradient_color_1.VALUE}} 0%, {{VALUE}} 100%);',
				],
				'condition' => [
					'form_background_type' => 'gradient',
				],
			]
		);

		$this->add_control(
			'form_gradient_angle',
			[
				'label'      => esc_html__( 'Gradient Angle', 'auto-listings' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'deg' ],
				'range'      => [
					'deg' => [
						'min' => 0,
						'max' => 360,
					],
				],
				'default'    => [
					'size' => 135,
					'unit' => 'deg',
				],
				'selectors'  => [
					'{{WRAPPER}} .auto-listings-query-form' => 'background: linear-gradient({{SIZE}}{{UNIT}}, {{form_gradient_color_1.VALUE}} 0%, {{form_gradient_color_2.VALUE}} 100%);',
				],
				'condition'  => [
					'form_background_type' => 'gradient',
				],
			]
		);

		$this->add_control(
			'form_padding',
			[
				'label'      => esc_html__( 'Padding', 'auto-listings' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'default'    => [
					'top'    => '30',
					'right'  => '30',
					'bottom' => '30',
					'left'   => '30',
					'unit'   => 'px',
				],
				'selectors'  => [
					'{{WRAPPER}} .auto-listings-query-form' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'form_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'auto-listings' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'default'    => [
					'top'    => '16',
					'right'  => '16',
					'bottom' => '16',
					'left'   => '16',
					'unit'   => 'px',
				],
				'selectors'  => [
					'{{WRAPPER}} .auto-listings-query-form' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'form_box_shadow',
				'selector' => '{{WRAPPER}} .auto-listings-query-form',
				'fields_options' => [
					'box_shadow_type' => [
						'default' => 'yes',
					],
					'box_shadow' => [
						'default' => [
							'horizontal' => 0,
							'vertical'   => 10,
							'blur'       => 40,
							'spread'     => 0,
							'color'      => 'rgba(0, 0, 0, 0.15)',
						],
					],
				],
			]
		);

		$this->add_control(
			'form_gap',
			[
				'label'      => esc_html__( 'Gap Between Elements', 'auto-listings' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min' => 0,
						'max' => 50,
					],
				],
				'default'    => [
					'size' => 20,
				],
				'selectors'  => [
					'{{WRAPPER}} .auto-listings-query-form' => 'gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		// Intro Text Styles
		$this->start_controls_section(
			'section_style_intro',
			[
				'label' => esc_html__( 'Intro Text', 'auto-listings' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'intro_text_color',
			[
				'label'     => esc_html__( 'Text Color', 'auto-listings' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .auto-listings-query-form__intro' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'intro_text_typography',
				'selector' => '{{WRAPPER}} .auto-listings-query-form__intro',
				'fields_options' => [
					'font_size' => [
						'default' => [
							'size' => 24,
							'unit' => 'px',
						],
					],
					'font_weight' => [
						'default' => '600',
					],
				],
			]
		);

		$this->add_control(
			'intro_text_shadow',
			[
				'label'     => esc_html__( 'Text Shadow', 'auto-listings' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => '0 2px 4px rgba(0, 0, 0, 0.1)',
				'selectors' => [
					'{{WRAPPER}} .auto-listings-query-form__intro' => 'text-shadow: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'intro_margin',
			[
				'label'      => esc_html__( 'Margin', 'auto-listings' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em' ],
				'default'    => [
					'top'    => '0',
					'right'  => '0',
					'bottom' => '5',
					'left'   => '0',
					'unit'   => 'px',
				],
				'selectors'  => [
					'{{WRAPPER}} .auto-listings-query-form__intro' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		// Fields Container
		$this->start_controls_section(
			'section_style_fields_container',
			[
				'label' => esc_html__( 'Fields Container', 'auto-listings' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'fields_container_background',
			[
				'label'     => esc_html__( 'Background Color', 'auto-listings' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => 'rgba(255, 255, 255, 0.95)',
				'selectors' => [
					'{{WRAPPER}} .auto-listings-query-form__fields' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'fields_container_padding',
			[
				'label'      => esc_html__( 'Padding', 'auto-listings' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em' ],
				'default'    => [
					'top'    => '24',
					'right'  => '24',
					'bottom' => '24',
					'left'   => '24',
					'unit'   => 'px',
				],
				'selectors'  => [
					'{{WRAPPER}} .auto-listings-query-form__fields' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'fields_container_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'auto-listings' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'default'    => [
					'top'    => '12',
					'right'  => '12',
					'bottom' => '12',
					'left'   => '12',
					'unit'   => 'px',
				],
				'selectors'  => [
					'{{WRAPPER}} .auto-listings-query-form__fields' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'fields_container_shadow',
				'selector' => '{{WRAPPER}} .auto-listings-query-form__fields',
				'fields_options' => [
					'box_shadow_type' => [
						'default' => 'yes',
					],
					'box_shadow' => [
						'default' => [
							'horizontal' => 0,
							'vertical'   => 4,
							'blur'       => 20,
							'spread'     => 0,
							'color'      => 'rgba(0, 0, 0, 0.08)',
						],
					],
				],
			]
		);

		$this->add_control(
			'field_spacing',
			[
				'label'      => esc_html__( 'Gap Between Fields', 'auto-listings' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min' => 0,
						'max' => 50,
					],
				],
				'default'    => [
					'size' => 16,
				],
				'selectors'  => [
					'{{WRAPPER}} .auto-listings-query-form__fields' => 'gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		// Individual Fields
		$this->start_controls_section(
			'section_style_fields',
			[
				'label' => esc_html__( 'Field Labels', 'auto-listings' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'field_label_color',
			[
				'label'     => esc_html__( 'Label Color', 'auto-listings' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#374151',
				'selectors' => [
					'{{WRAPPER}} .auto-listings-query-form__label' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'field_label_focus_color',
			[
				'label'     => esc_html__( 'Label Focus Color', 'auto-listings' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#667eea',
				'selectors' => [
					'{{WRAPPER}} .auto-listings-query-form__field:focus-within .auto-listings-query-form__label' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'field_label_typography',
				'selector' => '{{WRAPPER}} .auto-listings-query-form__label',
				'fields_options' => [
					'font_size' => [
						'default' => [
							'size' => 13,
							'unit' => 'px',
						],
					],
					'font_weight' => [
						'default' => '600',
					],
					'text_transform' => [
						'default' => 'uppercase',
					],
					'letter_spacing' => [
						'default' => [
							'size' => 0.5,
							'unit' => 'px',
						],
					],
				],
			]
		);

		$this->add_control(
			'field_label_margin',
			[
				'label'      => esc_html__( 'Label Spacing', 'auto-listings' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min' => 0,
						'max' => 30,
					],
				],
				'default'    => [
					'size' => 8,
				],
				'selectors'  => [
					'{{WRAPPER}} .auto-listings-query-form__label' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		// Input Fields
		$this->start_controls_section(
			'section_style_inputs',
			[
				'label' => esc_html__( 'Input Fields', 'auto-listings' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->start_controls_tabs( 'input_style_tabs' );

		// Normal State
		$this->start_controls_tab(
			'input_style_normal',
			[
				'label' => esc_html__( 'Normal', 'auto-listings' ),
			]
		);

		$this->add_control(
			'field_input_background',
			[
				'label'     => esc_html__( 'Background Color', 'auto-listings' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .auto-listings-query-form__select' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'field_input_color',
			[
				'label'     => esc_html__( 'Text Color', 'auto-listings' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#1f2937',
				'selectors' => [
					'{{WRAPPER}} .auto-listings-query-form__select' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'field_input_border',
				'selector' => '{{WRAPPER}} .auto-listings-query-form__select',
				'fields_options' => [
					'border' => [
						'default' => 'solid',
					],
					'width' => [
						'default' => [
							'top'    => '2',
							'right'  => '2',
							'bottom' => '2',
							'left'   => '2',
							'unit'   => 'px',
						],
					],
					'color' => [
						'default' => '#e5e7eb',
					],
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'field_input_shadow',
				'selector' => '{{WRAPPER}} .auto-listings-query-form__select',
				'fields_options' => [
					'box_shadow_type' => [
						'default' => 'yes',
					],
					'box_shadow' => [
						'default' => [
							'horizontal' => 0,
							'vertical'   => 1,
							'blur'       => 3,
							'spread'     => 0,
							'color'      => 'rgba(0, 0, 0, 0.05)',
						],
					],
				],
			]
		);

		$this->end_controls_tab();

		// Hover State
		$this->start_controls_tab(
			'input_style_hover',
			[
				'label' => esc_html__( 'Hover', 'auto-listings' ),
			]
		);

		$this->add_control(
			'field_input_border_color_hover',
			[
				'label'     => esc_html__( 'Border Color', 'auto-listings' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#667eea',
				'selectors' => [
					'{{WRAPPER}} .auto-listings-query-form__select:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'field_input_shadow_hover',
				'selector' => '{{WRAPPER}} .auto-listings-query-form__select:hover',
				'fields_options' => [
					'box_shadow_type' => [
						'default' => 'yes',
					],
					'box_shadow' => [
						'default' => [
							'horizontal' => 0,
							'vertical'   => 2,
							'blur'       => 8,
							'spread'     => 0,
							'color'      => 'rgba(102, 126, 234, 0.15)',
						],
					],
				],
			]
		);

		$this->end_controls_tab();

		// Focus State
		$this->start_controls_tab(
			'input_style_focus',
			[
				'label' => esc_html__( 'Focus', 'auto-listings' ),
			]
		);

		$this->add_control(
			'field_input_border_color_focus',
			[
				'label'     => esc_html__( 'Border Color', 'auto-listings' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#667eea',
				'selectors' => [
					'{{WRAPPER}} .auto-listings-query-form__select:focus' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'field_input_focus_ring_color',
			[
				'label'     => esc_html__( 'Focus Ring Color', 'auto-listings' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => 'rgba(102, 126, 234, 0.1)',
				'selectors' => [
					'{{WRAPPER}} .auto-listings-query-form__select:focus' => 'box-shadow: 0 0 0 3px {{VALUE}}, 0 2px 8px rgba(102, 126, 234, 0.15);',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control(
			'input_padding',
			[
				'label'      => esc_html__( 'Padding', 'auto-listings' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em' ],
				'default'    => [
					'top'    => '14',
					'right'  => '40',
					'bottom' => '14',
					'left'   => '16',
					'unit'   => 'px',
				],
				'selectors'  => [
					'{{WRAPPER}} .auto-listings-query-form__select' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator'  => 'before',
			]
		);

		$this->add_control(
			'input_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'auto-listings' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'default'    => [
					'top'    => '10',
					'right'  => '10',
					'bottom' => '10',
					'left'   => '10',
					'unit'   => 'px',
				],
				'selectors'  => [
					'{{WRAPPER}} .auto-listings-query-form__select' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'field_input_typography',
				'selector' => '{{WRAPPER}} .auto-listings-query-form__select',
				'fields_options' => [
					'font_size' => [
						'default' => [
							'size' => 15,
							'unit' => 'px',
						],
					],
					'font_weight' => [
						'default' => '500',
					],
				],
			]
		);

		$this->add_control(
			'input_arrow_color',
			[
				'label'       => esc_html__( 'Dropdown Arrow Color', 'auto-listings' ),
				'type'        => Controls_Manager::COLOR,
				'default'     => '#667eea',
				'description' => esc_html__( 'Change the color of the dropdown arrow icon', 'auto-listings' ),
			]
		);

		$this->end_controls_section();

		// Condition Button
		$this->start_controls_section(
			'section_style_condition_button',
			[
				'label'     => esc_html__( 'Condition Button', 'auto-listings' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_condition_button' => 'yes',
				],
			]
		);

		$this->start_controls_tabs( 'condition_button_tabs' );

		$this->start_controls_tab(
			'condition_button_normal',
			[
				'label' => esc_html__( 'Normal', 'auto-listings' ),
			]
		);

		$this->add_control(
			'condition_button_background',
			[
				'label'     => esc_html__( 'Background Color', 'auto-listings' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => 'rgba(255, 255, 255, 0.15)',
				'selectors' => [
					'{{WRAPPER}} .auto-listings-query-form__condition-btn' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'condition_button_color',
			[
				'label'     => esc_html__( 'Text Color', 'auto-listings' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .auto-listings-query-form__condition-btn' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'condition_button_border',
				'selector' => '{{WRAPPER}} .auto-listings-query-form__condition-btn',
				'fields_options' => [
					'border' => [
						'default' => 'solid',
					],
					'width' => [
						'default' => [
							'top'    => '2',
							'right'  => '2',
							'bottom' => '2',
							'left'   => '2',
							'unit'   => 'px',
						],
					],
					'color' => [
						'default' => 'rgba(255, 255, 255, 0.3)',
					],
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'condition_button_hover',
			[
				'label' => esc_html__( 'Hover', 'auto-listings' ),
			]
		);

		$this->add_control(
			'condition_button_background_hover',
			[
				'label'     => esc_html__( 'Background Color', 'auto-listings' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => 'rgba(255, 255, 255, 0.25)',
				'selectors' => [
					'{{WRAPPER}} .auto-listings-query-form__condition-btn:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'condition_button_border_color_hover',
			[
				'label'     => esc_html__( 'Border Color', 'auto-listings' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => 'rgba(255, 255, 255, 0.5)',
				'selectors' => [
					'{{WRAPPER}} .auto-listings-query-form__condition-btn:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'condition_button_shadow_hover',
				'selector' => '{{WRAPPER}} .auto-listings-query-form__condition-btn:hover',
				'fields_options' => [
					'box_shadow_type' => [
						'default' => 'yes',
					],
					'box_shadow' => [
						'default' => [
							'horizontal' => 0,
							'vertical'   => 4,
							'blur'       => 12,
							'spread'     => 0,
							'color'      => 'rgba(0, 0, 0, 0.15)',
						],
					],
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control(
			'condition_button_padding',
			[
				'label'      => esc_html__( 'Padding', 'auto-listings' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em' ],
				'default'    => [
					'top'    => '12',
					'right'  => '24',
					'bottom' => '12',
					'left'   => '24',
					'unit'   => 'px',
				],
				'selectors'  => [
					'{{WRAPPER}} .auto-listings-query-form__condition-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator'  => 'before',
			]
		);

		$this->add_control(
			'condition_button_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'auto-listings' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'default'    => [
					'top'    => '12',
					'right'  => '12',
					'bottom' => '12',
					'left'   => '12',
					'unit'   => 'px',
				],
				'selectors'  => [
					'{{WRAPPER}} .auto-listings-query-form__condition-btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'condition_button_typography',
				'selector' => '{{WRAPPER}} .auto-listings-query-form__condition-btn',
				'fields_options' => [
					'font_size' => [
						'default' => [
							'size' => 15,
							'unit' => 'px',
						],
					],
					'font_weight' => [
						'default' => '600',
					],
				],
			]
		);

		$this->end_controls_section();

		// Search Button
		$this->start_controls_section(
			'section_style_search_button',
			[
				'label' => esc_html__( 'Search Button', 'auto-listings' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'search_button_style_type',
			[
				'label'   => esc_html__( 'Background Type', 'auto-listings' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'gradient',
				'options' => [
					'color'    => esc_html__( 'Solid Color', 'auto-listings' ),
					'gradient' => esc_html__( 'Gradient', 'auto-listings' ),
				],
			]
		);

		$this->start_controls_tabs( 'search_button_tabs' );

		$this->start_controls_tab(
			'search_button_normal',
			[
				'label' => esc_html__( 'Normal', 'auto-listings' ),
			]
		);

		$this->add_control(
			'search_button_background',
			[
				'label'     => esc_html__( 'Background Color', 'auto-listings' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#667eea',
				'selectors' => [
					'{{WRAPPER}} .auto-listings-query-form__search-btn' => 'background: {{VALUE}};',
				],
				'condition' => [
					'search_button_style_type' => 'color',
				],
			]
		);

		$this->add_control(
			'search_button_gradient_1',
			[
				'label'     => esc_html__( 'Gradient Color 1', 'auto-listings' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#667eea',
				'condition' => [
					'search_button_style_type' => 'gradient',
				],
			]
		);

		$this->add_control(
			'search_button_gradient_2',
			[
				'label'     => esc_html__( 'Gradient Color 2', 'auto-listings' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#764ba2',
				'selectors' => [
					'{{WRAPPER}} .auto-listings-query-form__search-btn' => 'background: linear-gradient(135deg, {{search_button_gradient_1.VALUE}} 0%, {{VALUE}} 100%);',
				],
				'condition' => [
					'search_button_style_type' => 'gradient',
				],
			]
		);

		$this->add_control(
			'search_button_color',
			[
				'label'     => esc_html__( 'Text Color', 'auto-listings' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .auto-listings-query-form__search-btn' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'search_button_shadow',
				'selector' => '{{WRAPPER}} .auto-listings-query-form__search-btn',
				'fields_options' => [
					'box_shadow_type' => [
						'default' => 'yes',
					],
					'box_shadow' => [
						'default' => [
							'horizontal' => 0,
							'vertical'   => 4,
							'blur'       => 12,
							'spread'     => 0,
							'color'      => 'rgba(102, 126, 234, 0.3)',
						],
					],
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'search_button_hover',
			[
				'label' => esc_html__( 'Hover', 'auto-listings' ),
			]
		);

		$this->add_control(
			'search_button_transform_hover',
			[
				'label'        => esc_html__( 'Lift on Hover', 'auto-listings' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'auto-listings' ),
				'label_off'    => esc_html__( 'No', 'auto-listings' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'search_button_shadow_hover',
				'selector' => '{{WRAPPER}} .auto-listings-query-form__search-btn:hover',
				'fields_options' => [
					'box_shadow_type' => [
						'default' => 'yes',
					],
					'box_shadow' => [
						'default' => [
							'horizontal' => 0,
							'vertical'   => 6,
							'blur'       => 20,
							'spread'     => 0,
							'color'      => 'rgba(102, 126, 234, 0.4)',
						],
					],
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control(
			'search_button_padding',
			[
				'label'      => esc_html__( 'Padding', 'auto-listings' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em' ],
				'default'    => [
					'top'    => '14',
					'right'  => '28',
					'bottom' => '14',
					'left'   => '28',
					'unit'   => 'px',
				],
				'selectors'  => [
					'{{WRAPPER}} .auto-listings-query-form__search-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator'  => 'before',
			]
		);

		$this->add_control(
			'search_button_width',
			[
				'label'      => esc_html__( 'Width', 'auto-listings' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'em' ],
				'range'      => [
					'px' => [
						'min' => 50,
						'max' => 500,
					],
					'%' => [
						'min' => 10,
						'max' => 100,
					],
					'em' => [
						'min' => 1,
						'max' => 30,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .auto-listings-query-form__search-btn' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'search_button_height',
			[
				'label'      => esc_html__( 'Height', 'auto-listings' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'range'      => [
					'px' => [
						'min' => 30,
						'max' => 200,
					],
					'em' => [
						'min' => 1,
						'max' => 10,
					],
				],
				'default'    => [
					'size' => 56,
					'unit' => 'px',
				],
				'selectors'  => [
					'{{WRAPPER}} .auto-listings-query-form__search-btn' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'search_button_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'auto-listings' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'default'    => [
					'top'    => '10',
					'right'  => '10',
					'bottom' => '10',
					'left'   => '10',
					'unit'   => 'px',
				],
				'selectors'  => [
					'{{WRAPPER}} .auto-listings-query-form__search-btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'search_button_typography',
				'selector' => '{{WRAPPER}} .auto-listings-query-form__search-btn',
				'fields_options' => [
					'font_size' => [
						'default' => [
							'size' => 15,
							'unit' => 'px',
						],
					],
					'font_weight' => [
						'default' => '600',
					],
				],
			]
		);

		$this->add_control(
			'search_button_icon_size',
			[
				'label'      => esc_html__( 'Icon Size', 'auto-listings' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min' => 10,
						'max' => 50,
					],
				],
				'default'    => [
					'size' => 18,
				],
				'selectors'  => [
					'{{WRAPPER}} .auto-listings-query-form__search-btn svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .auto-listings-query-form__search-btn i' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Get available options for a field type
	 *
	 * @param string $field_type Field type.
	 * @return array Options array.
	 */
	protected function get_field_options( $field_type ) {
		$options = [ '' => esc_html__( 'All', 'auto-listings' ) ];

		switch ( $field_type ) {
			case 'brand':
				$makes = $this->get_unique_meta_values( '_al_listing_make_display' );
				foreach ( $makes as $make ) {
					if ( ! empty( $make ) ) {
						$options[ $make ] = $make;
					}
				}
				ksort( $options );
				break;

			case 'model':
				$models = $this->get_unique_meta_values( '_al_listing_model_name' );
				foreach ( $models as $model ) {
					if ( ! empty( $model ) ) {
						$options[ $model ] = $model;
					}
				}
				ksort( $options );
				break;

			case 'year':
				$years = $this->get_unique_meta_values( '_al_listing_model_year' );
				foreach ( $years as $year ) {
					if ( ! empty( $year ) ) {
						$options[ $year ] = $year;
					}
				}
				krsort( $options );
				break;

			case 'condition':
				$conditions = auto_listings_conditions();
				foreach ( $conditions as $key => $label ) {
					$options[ $key ] = $label;
				}
				break;

			case 'transmission':
				$transmissions = $this->get_unique_meta_values( '_al_listing_model_transmission_type' );
				foreach ( $transmissions as $transmission ) {
					if ( ! empty( $transmission ) ) {
						$options[ $transmission ] = $transmission;
					}
				}
				ksort( $options );
				break;

			case 'fuel':
				$fuels = $this->get_unique_meta_values( '_al_listing_model_engine_fuel' );
				foreach ( $fuels as $fuel ) {
					if ( ! empty( $fuel ) ) {
						$options[ $fuel ] = $fuel;
					}
				}
				ksort( $options );
				break;

			case 'engine':
				$engines = $this->get_unique_meta_values( '_al_listing_model_engine_type' );
				foreach ( $engines as $engine ) {
					if ( ! empty( $engine ) ) {
						$options[ $engine ] = $engine;
					}
				}
				ksort( $options );
				break;

			case 'drive':
				$drives = $this->get_unique_meta_values( '_al_listing_model_drive' );
				foreach ( $drives as $drive ) {
					if ( ! empty( $drive ) ) {
						$options[ $drive ] = $drive;
					}
				}
				ksort( $options );
				break;

			case 'body':
				$terms = get_terms( [
					'taxonomy'   => 'body-type',
					'hide_empty' => true,
				] );
				if ( ! is_wp_error( $terms ) && ! empty( $terms ) ) {
					foreach ( $terms as $term ) {
						$options[ $term->slug ] = $term->name;
					}
				}
				break;

			case 'location':
				$locations = $this->get_unique_meta_values( '_al_listing_city' );
				foreach ( $locations as $location ) {
					if ( ! empty( $location ) ) {
						$options[ $location ] = $location;
					}
				}
				ksort( $options );
				break;

			case 'price_min':
			case 'price_max':
			case 'odometer':
				$prices = $this->get_unique_meta_values( $field_type === 'odometer' ? '_al_listing_odometer' : '_al_listing_price' );
				$values = array_filter( array_map( 'floatval', $prices ) );
				if ( ! empty( $values ) ) {
					$min = min( $values );
					$max = max( $values );
					$step = ( $max - $min ) / 20;
					for ( $i = $min; $i <= $max; $i += $step ) {
						$options[ round( $i ) ] = number_format_i18n( round( $i ) );
					}
				}
				break;
		}

		return apply_filters( 'auto_listings_query_form_field_options', $options, $field_type );
	}

	/**
	 * Get unique meta values from listings
	 *
	 * @param string $meta_key Meta key.
	 * @return array Unique values.
	 */
	protected function get_unique_meta_values( $meta_key ) {
		global $wpdb;
		$values = $wpdb->get_col( $wpdb->prepare(
			"SELECT DISTINCT meta_value FROM {$wpdb->postmeta} 
			WHERE meta_key = %s 
			AND meta_value != '' 
			AND post_id IN (
				SELECT ID FROM {$wpdb->posts} 
				WHERE post_type = 'auto-listing' 
				AND post_status = 'publish'
			)",
			$meta_key
		) );
		return array_filter( $values );
	}

	/**
	 * Get query parameter name for field type
	 *
	 * @param string $field_type Field type.
	 * @return string Parameter name.
	 */
	protected function get_query_param_name( $field_type ) {
		$param_map = [
			'location'    => 'Location',
			'brand'       => 'Brand',
			'model'       => 'Model',
			'year'        => 'Year',
			'condition'   => 'Condition',
			'price_min'   => 'MinPrice',
			'price_max'   => 'MaxPrice',
			'odometer'    => 'Odometer',
			'transmission' => 'Transmission',
			'fuel'        => 'Fuel',
			'engine'      => 'Engine',
			'drive'       => 'Drive',
			'body'        => 'Body',
		];
		return isset( $param_map[ $field_type ] ) ? $param_map[ $field_type ] : '';
	}

	/**
	 * Get listings page URL
	 *
	 * @return string URL.
	 */
	protected function get_listings_page_url() {
		$settings = $this->get_settings_for_display();
		
		if ( ! empty( $settings['form_action_url'] ) ) {
			$custom_url = trim( $settings['form_action_url'] );
			if ( ! empty( $custom_url ) ) {
				if ( strpos( $custom_url, 'http' ) === 0 ) {
					return esc_url_raw( $custom_url );
				}
				if ( strpos( $custom_url, '/' ) === 0 ) {
					return home_url( $custom_url );
				}
				return home_url( '/' . $custom_url );
			}
		}
		
		$page_id = auto_listings_option( 'archives_page' );
		if ( $page_id ) {
			return get_permalink( $page_id );
		}
		return home_url( '/' );
	}

	/**
	 * Render widget output on the frontend
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();
		$form_fields = $settings['form_fields'];
		$listings_url = $this->get_listings_page_url();

		if ( empty( $form_fields ) ) {
			return;
		}

		$layout_class = 'auto-listings-query-form--' . $settings['form_layout'];
		$has_condition_field = false;
		foreach ( $form_fields as $field ) {
			if ( 'condition' === $field['field_type'] && 'yes' === $field['show_field'] ) {
				$has_condition_field = true;
				break;
			}
		}

		?>
		<style>
			<?php echo $this->get_inline_css(); ?>
		</style>
		<div class="auto-listings-query-form <?php echo esc_attr( $layout_class ); ?>">
			<?php if ( ! empty( $settings['intro_text'] ) ) : ?>
				<div class="auto-listings-query-form__intro">
					<?php echo esc_html( $settings['intro_text'] ); ?>
				</div>
			<?php endif; ?>

			<?php if ( 'yes' === $settings['show_condition_button'] && $has_condition_field ) : ?>
				<button type="button" class="auto-listings-query-form__condition-btn" data-target="Condition">
					<?php
					$icon = $settings['condition_button_icon'];
					if ( ! empty( $icon['value'] ) ) {
						\Elementor\Icons_Manager::render_icon( $icon, [ 'aria-hidden' => 'true' ] );
					}
					?>
					<?php echo esc_html( $settings['condition_button_text'] ); ?>
				</button>
			<?php endif; ?>

			<form method="get" action="<?php echo esc_url( $listings_url ); ?>" class="auto-listings-query-form__form">
				<div class="auto-listings-query-form__fields">
					<?php
					foreach ( $form_fields as $index => $field ) {
						if ( 'yes' !== $field['show_field'] ) {
							continue;
						}

						$field_type = $field['field_type'];
						$field_label = ! empty( $field['field_label'] ) ? $field['field_label'] : ucfirst( $field_type );
						$field_placeholder = ! empty( $field['field_placeholder'] ) ? $field['field_placeholder'] : esc_html__( 'All', 'auto-listings' );
						$param_name = $this->get_query_param_name( $field_type );
						$current_value = isset( $_GET[ $param_name ] ) ? sanitize_text_field( $_GET[ $param_name ] ) : '';

						$options = $this->get_field_options( $field_type );
						$field_id = 'auto-listings-query-' . $field_type . '-' . $index;
						?>
						<div class="auto-listings-query-form__field" data-field-type="<?php echo esc_attr( $field_type ); ?>">
							<label class="auto-listings-query-form__label" for="<?php echo esc_attr( $field_id ); ?>">
								<?php echo esc_html( $field_label ); ?>
							</label>
							<select 
								name="<?php echo esc_attr( $param_name ); ?>" 
								id="<?php echo esc_attr( $field_id ); ?>"
								class="auto-listings-query-form__select"
								data-param="<?php echo esc_attr( $param_name ); ?>"
							>
								<?php foreach ( $options as $value => $label ) : ?>
									<option value="<?php echo esc_attr( $value ); ?>" <?php selected( $current_value, $value ); ?>>
										<?php echo esc_html( $label ); ?>
									</option>
								<?php endforeach; ?>
							</select>
						</div>
						<?php
					}
					?>

					<?php
					$show_search_btn = false;
					if ( 'always' === $settings['search_button_visibility'] ) {
						$show_search_btn = true;
					} elseif ( 'when_active' === $settings['search_button_visibility'] ) {
						$has_active_filters = false;
						foreach ( $form_fields as $field ) {
							if ( 'yes' !== $field['show_field'] ) {
								continue;
							}
							$param_name = $this->get_query_param_name( $field['field_type'] );
							if ( isset( $_GET[ $param_name ] ) && ! empty( $_GET[ $param_name ] ) ) {
								$has_active_filters = true;
								break;
							}
						}
						$show_search_btn = $has_active_filters;
					}
					?>
					<?php if ( $show_search_btn ) : ?>
						<button type="submit" class="auto-listings-query-form__search-btn">
							<?php
							$icon = $settings['search_button_icon'];
							if ( ! empty( $icon['value'] ) ) {
								\Elementor\Icons_Manager::render_icon( $icon, [ 'aria-hidden' => 'true' ] );
							}
							?>
							<?php if ( ! empty( $settings['search_button_text'] ) ) : ?>
								<span><?php echo esc_html( $settings['search_button_text'] ); ?></span>
							<?php endif; ?>
						</button>
					<?php endif; ?>
				</div>
			</form>
		</div>
		<script>
		(function($) {
			$(document).ready(function() {
				var $form = $('.auto-listings-query-form');
				var $conditionBtn = $form.find('.auto-listings-query-form__condition-btn');
				var $conditionSelect = $form.find('select[name="Condition"]');
				
				if ($conditionBtn.length && $conditionSelect.length) {
					$conditionBtn.on('click', function() {
						var $btn = $(this);
						var currentValue = $conditionSelect.val();
						var options = $conditionSelect.find('option');
						var currentIndex = $conditionSelect.prop('selectedIndex');
						var nextIndex = (currentIndex + 1) % options.length;
						$conditionSelect.prop('selectedIndex', nextIndex).trigger('change');
					});
				}

				$form.find('form').on('submit', function(e) {
					e.preventDefault();
					
					var form = $(this);
					var action = form.attr('action');
					var params = [];
					
					form.find('select').each(function() {
						var $select = $(this);
						var name = $select.attr('name');
						var value = $select.val();
						
						if (value && value !== '' && value !== '0') {
							params.push(encodeURIComponent(name) + '=' + encodeURIComponent(value));
						}
					});
					
					var url = action;
					if (params.length > 0) {
						url += (url.indexOf('?') === -1 ? '?' : '&') + params.join('&');
					}
					
					window.location.href = url;
				});
			});
		})(jQuery);
		</script>
		<?php
	}

	/**
	 * Get inline CSS for form styling
	 */
	protected function get_inline_css() {
		$settings = $this->get_settings_for_display();
		
		// Get arrow color for dropdown
		$arrow_color = ! empty( $settings['input_arrow_color'] ) ? $settings['input_arrow_color'] : '#667eea';
		$arrow_color_encoded = str_replace( '#', '%23', $arrow_color );
		
		// Handle hover transform
		$hover_transform = ( isset( $settings['search_button_transform_hover'] ) && 'yes' === $settings['search_button_transform_hover'] ) 
			? 'transform: translateY(-2px);' 
			: '';
		
		return '
		.auto-listings-query-form {
			display: flex;
			flex-direction: column;
		}
		
		.auto-listings-query-form__intro {
			line-height: 1.3;
		}
		
		.auto-listings-query-form__condition-btn {
			display: inline-flex;
			align-items: center;
			justify-content: center;
			gap: 10px;
			backdrop-filter: blur(10px);
			-webkit-backdrop-filter: blur(10px);
			cursor: pointer;
			transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
			align-self: flex-start;
		}
		
		.auto-listings-query-form__condition-btn:hover {
			transform: translateY(-2px);
		}
		
		.auto-listings-query-form__condition-btn:active {
			transform: translateY(0);
		}
		
		.auto-listings-query-form__condition-btn svg,
		.auto-listings-query-form__condition-btn i {
			font-size: 16px;
		}
		
		.auto-listings-query-form__form {
			width: 100%;
		}
		
		.auto-listings-query-form__fields {
			display: flex;
			flex-wrap: wrap;
			align-items: flex-end;
		}
		
		.auto-listings-query-form--vertical .auto-listings-query-form__fields {
			flex-direction: column;
		}
		
		.auto-listings-query-form--horizontal .auto-listings-query-form__fields {
			flex-direction: row;
		}
		
		.auto-listings-query-form__field {
			display: flex;
			flex-direction: column;
			flex: 1;
			min-width: 180px;
			position: relative;
		}
		
		.auto-listings-query-form--vertical .auto-listings-query-form__field {
			width: 100%;
		}
		
		.auto-listings-query-form__label {
			transition: color 0.3s ease;
		}
		
		.auto-listings-query-form__select {
			width: 100%;
			cursor: pointer;
			appearance: none;
			-webkit-appearance: none;
			-moz-appearance: none;
			background-image: url("data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' width=\'14\' height=\'14\' viewBox=\'0 0 24 24\' fill=\'none\' stroke=\'' . $arrow_color_encoded . '\' stroke-width=\'3\' stroke-linecap=\'round\' stroke-linejoin=\'round\'%3E%3Cpolyline points=\'6 9 12 15 18 9\'%3E%3C/polyline%3E%3C/svg%3E");
			background-repeat: no-repeat;
			background-position: right 12px center;
			background-size: 16px;
			transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
		}
		
		.auto-listings-query-form__select:hover {
			transform: translateY(-1px);
		}
		
		.auto-listings-query-form__select:focus {
			outline: none;
			transform: translateY(-1px);
		}
		
		.auto-listings-query-form__search-btn {
			display: inline-flex;
			align-items: center;
			justify-content: center;
			gap: 10px;
			border: none;
			cursor: pointer;
			transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
			flex-shrink: 0;
			position: relative;
			overflow: hidden;
		}
		
		.auto-listings-query-form__search-btn::before {
			content: "";
			position: absolute;
			top: 0;
			left: -100%;
			width: 100%;
			height: 100%;
			background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
			transition: left 0.5s ease;
		}
		
		.auto-listings-query-form__search-btn:hover {
			' . $hover_transform . '
		}
		
		.auto-listings-query-form__search-btn:hover::before {
			left: 100%;
		}
		
		.auto-listings-query-form__search-btn:active {
			transform: translateY(0);
		}
		
		.auto-listings-query-form__search-btn svg,
		.auto-listings-query-form__search-btn i {
			transition: transform 0.3s ease;
		}
		
		.auto-listings-query-form__search-btn:hover svg,
		.auto-listings-query-form__search-btn:hover i {
			transform: scale(1.1);
		}
		
		/* Responsive adjustments */
		@media (max-width: 768px) {
			.auto-listings-query-form--horizontal .auto-listings-query-form__fields {
				flex-direction: column;
			}
			
			.auto-listings-query-form__field {
				min-width: 100%;
			}
			
			.auto-listings-query-form__search-btn {
				width: 100%;
			}
		}
		
		/* Smooth animations */
		@keyframes slideIn {
			from {
				opacity: 0;
				transform: translateY(20px);
			}
			to {
				opacity: 1;
				transform: translateY(0);
			}
		}
		
		.auto-listings-query-form {
			animation: slideIn 0.5s ease-out;
		}
		';
	}
}

