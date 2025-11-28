<?php
namespace AutoListings\Elementor;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;

/**
 * Listings Grid Elementor Widget
 */
class ListingsGrid extends Base {
	/**
	 * Get widget name
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'auto-listings-listings-grid';
	}

	/**
	 * Get widget title
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( 'Listings Grid', 'auto-listings' );
	}

	/**
	 * Get widget icon
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-gallery-grid';
	}

	/**
	 * Get available Elementor templates
	 *
	 * @return array
	 */
	protected function get_elementor_templates() {
		$templates = get_posts( [
			'post_type'      => 'elementor_library',
			'posts_per_page' => -1,
			'orderby'        => 'title',
			'order'          => 'ASC',
			'post_status'    => 'publish',
			'meta_query'     => [
				[
					'key'     => '_elementor_template_type',
					'value'   => [ 'page', 'section', 'container' ],
					'compare' => 'IN',
				],
			],
		] );

		$options = [
			'' => esc_html__( 'Select a template...', 'auto-listings' ),
		];

		foreach ( $templates as $template ) {
			$options[ $template->ID ] = $template->post_title;
		}

		if ( count( $options ) === 1 ) {
			$options[''] = esc_html__( 'No templates found - Create one first', 'auto-listings' );
		}

		return $options;
	}

	/**
	 * Register widget controls
	 */
	protected function register_controls() {
		$this->start_controls_section(
			'section_query',
			[
				'label' => esc_html__( 'Query', 'auto-listings' ),
			]
		);

		$this->add_control(
			'number',
			[
				'label'   => esc_html__( 'Number of Listings', 'auto-listings' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 12,
				'min'     => 1,
				'max'     => 100,
			]
		);

		$this->add_control(
			'orderby',
			[
				'label'   => esc_html__( 'Order By', 'auto-listings' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'date',
				'options' => [
					'date'       => esc_html__( 'Date', 'auto-listings' ),
					'title'      => esc_html__( 'Title', 'auto-listings' ),
					'modified'   => esc_html__( 'Modified', 'auto-listings' ),
					'menu_order' => esc_html__( 'Menu Order', 'auto-listings' ),
					'rand'       => esc_html__( 'Random', 'auto-listings' ),
					'ID'         => esc_html__( 'ID', 'auto-listings' ),
				],
			]
		);

		$this->add_control(
			'order',
			[
				'label'   => esc_html__( 'Order', 'auto-listings' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'desc',
				'options' => [
					'asc'  => esc_html__( 'Ascending', 'auto-listings' ),
					'desc' => esc_html__( 'Descending', 'auto-listings' ),
				],
			]
		);

		$this->add_control(
			'ids',
			[
				'label'       => esc_html__( 'Specific IDs', 'auto-listings' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'e.g. 1,2,3', 'auto-listings' ),
				'description' => esc_html__( 'Enter comma-separated listing IDs to show only specific listings', 'auto-listings' ),
				'separator'   => 'before',
			]
		);

		$this->add_control(
			'seller',
			[
				'label'       => esc_html__( 'Filter by Seller', 'auto-listings' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Enter seller ID', 'auto-listings' ),
				'description' => esc_html__( 'Show listings from a specific seller only', 'auto-listings' ),
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_card_template',
			[
				'label' => esc_html__( 'Card Template', 'auto-listings' ),
			]
		);

		$this->add_control(
			'card_template_type',
			[
				'label'   => esc_html__( 'Template Type', 'auto-listings' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'default',
				'options' => [
					'default' => esc_html__( 'Default Card', 'auto-listings' ),
					'custom'  => esc_html__( 'Custom Elementor Template', 'auto-listings' ),
				],
			]
		);

		$this->add_control(
			'custom_template_info',
			[
				'type'            => Controls_Manager::RAW_HTML,
				'raw'             => sprintf(
					/* translators: %s: URL to create template */
					__( '<div style="background: #062139; padding: 12px; border-radius: 4px; margin-bottom: 10px;">
						<strong>💡 How to use Custom Templates:</strong>
						<ol style="margin: 8px 0 0 0; padding-left: 20px; line-height: 1.6;">
							<li>Create a new template in <a href="%1$s" target="_blank">Templates → Saved Templates</a></li>
							<li>Design your listing card layout</li>
							<li>Use <strong>Dynamic Tags</strong> to insert listing data:
								<ul style="margin: 5px 0; padding-left: 20px;">
									<li>Post Title → Listing title</li>
									<li>Featured Image → Listing image</li>
									<li>Post Custom Field → Use field keys like <code>_price</code>, <code>_odometer</code></li>
								</ul>
							</li>
							<li>Save your template and select it below</li>
						</ol>
					</div>', 'auto-listings' ),
					admin_url( 'edit.php?post_type=elementor_library&tabs_group=library' )
				),
				'content_classes' => 'elementor-panel-alert',
				'condition'       => [
					'card_template_type' => 'custom',
				],
			]
		);

		$this->add_control(
			'custom_template_id',
			[
				'label'       => esc_html__( 'Select Template', 'auto-listings' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => $this->get_elementor_templates(),
				'default'     => '',
				'description' => esc_html__( 'Choose an Elementor template to use for each listing card', 'auto-listings' ),
				'condition'   => [
					'card_template_type' => 'custom',
				],
			]
		);

		$this->add_control(
			'template_refresh',
			[
				'type'            => Controls_Manager::RAW_HTML,
				'raw'             => '<button type="button" class="elementor-button" onclick="location.reload();" style="width: 100%; margin-top: 10px;">
					<i class="eicon-refresh" style="margin-right: 5px;"></i> Refresh Template List
				</button>',
				'content_classes' => 'elementor-control-field-description',
				'condition'       => [
					'card_template_type' => 'custom',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_query_params',
			[
				'label' => esc_html__( 'URL Query Parameters', 'auto-listings' ),
			]
		);

		$this->add_control(
			'enable_query_params',
			[
				'label'        => esc_html__( 'Enable URL Filtering', 'auto-listings' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'auto-listings' ),
				'label_off'    => esc_html__( 'No', 'auto-listings' ),
				'return_value' => 'yes',
				'default'      => 'no',
				'description' => esc_html__( 'Allow filtering listings via URL query parameters (e.g., ?Brand=bmw&Year=2023)', 'auto-listings' ),
			]
		);

		$this->add_control(
			'query_params_info',
			[
				'type'            => Controls_Manager::RAW_HTML,
				'raw'             => __( '<div style="background: #001010; border: 1px solid #333; padding: 16px; border-radius: 4px; margin-top: 10px; color: #e0e0e0;">
					<h4 style="margin: 0 0 12px 0; font-size: 14px; font-weight: 600; color: #ffffff;">📋 Supported Parameters</h4>
					<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 8px 16px; margin-bottom: 16px; color: #e0e0e0;">
						<div><code style="background: #1a1a1a; color: #4fc3f7; padding: 2px 6px; border-radius: 3px; font-size: 12px; border: 1px solid #333;">Brand</code> or <code style="background: #1a1a1a; color: #4fc3f7; padding: 2px 6px; border-radius: 3px; font-size: 12px; border: 1px solid #333;">Make</code> - Brand/Make</div>
						<div><code style="background: #1a1a1a; color: #4fc3f7; padding: 2px 6px; border-radius: 3px; font-size: 12px; border: 1px solid #333;">Model</code> - Model name</div>
						<div><code style="background: #1a1a1a; color: #4fc3f7; padding: 2px 6px; border-radius: 3px; font-size: 12px; border: 1px solid #333;">Year</code> - Model year</div>
						<div><code style="background: #1a1a1a; color: #4fc3f7; padding: 2px 6px; border-radius: 3px; font-size: 12px; border: 1px solid #333;">Condition</code> - Condition (new/used)</div>
						<div><code style="background: #1a1a1a; color: #4fc3f7; padding: 2px 6px; border-radius: 3px; font-size: 12px; border: 1px solid #333;">Price</code> - Exact price</div>
						<div><code style="background: #1a1a1a; color: #4fc3f7; padding: 2px 6px; border-radius: 3px; font-size: 12px; border: 1px solid #333;">MinPrice</code> - Minimum price</div>
						<div><code style="background: #1a1a1a; color: #4fc3f7; padding: 2px 6px; border-radius: 3px; font-size: 12px; border: 1px solid #333;">MaxPrice</code> - Maximum price</div>
						<div><code style="background: #1a1a1a; color: #4fc3f7; padding: 2px 6px; border-radius: 3px; font-size: 12px; border: 1px solid #333;">Odometer</code> - Maximum mileage</div>
						<div><code style="background: #1a1a1a; color: #4fc3f7; padding: 2px 6px; border-radius: 3px; font-size: 12px; border: 1px solid #333;">Transmission</code> - Transmission type</div>
						<div><code style="background: #1a1a1a; color: #4fc3f7; padding: 2px 6px; border-radius: 3px; font-size: 12px; border: 1px solid #333;">Fuel</code> - Fuel type</div>
						<div><code style="background: #1a1a1a; color: #4fc3f7; padding: 2px 6px; border-radius: 3px; font-size: 12px; border: 1px solid #333;">Engine</code> - Engine type</div>
						<div><code style="background: #1a1a1a; color: #4fc3f7; padding: 2px 6px; border-radius: 3px; font-size: 12px; border: 1px solid #333;">Drive</code> - Drive type</div>
						<div><code style="background: #1a1a1a; color: #4fc3f7; padding: 2px 6px; border-radius: 3px; font-size: 12px; border: 1px solid #333;">Body</code> - Body type</div>
						<div><code style="background: #1a1a1a; color: #4fc3f7; padding: 2px 6px; border-radius: 3px; font-size: 12px; border: 1px solid #333;">orderby</code> - Sort field</div>
						<div><code style="background: #1a1a1a; color: #4fc3f7; padding: 2px 6px; border-radius: 3px; font-size: 12px; border: 1px solid #333;">order</code> - Sort direction</div>
					</div>
					<div style="border-top: 1px solid #333; padding-top: 12px; margin-top: 12px;">
						<h5 style="margin: 0 0 8px 0; font-size: 13px; font-weight: 600; color: #ffffff;">💡 Examples:</h5>
						<ul style="margin: 0; padding-left: 20px; line-height: 1.8; font-size: 12px; color: #e0e0e0;">
							<li><code style="background: #1a1a1a; color: #81c784; padding: 2px 6px; border-radius: 3px; border: 1px solid #333;">/our-stock/?Brand=bmw</code></li>
							<li><code style="background: #1a1a1a; color: #81c784; padding: 2px 6px; border-radius: 3px; border: 1px solid #333;">/our-stock/?Brand=bmw&Year=2023</code></li>
							<li><code style="background: #1a1a1a; color: #81c784; padding: 2px 6px; border-radius: 3px; border: 1px solid #333;">/our-stock/?Make=ford&Model=focus&Condition=used</code></li>
							<li><code style="background: #1a1a1a; color: #81c784; padding: 2px 6px; border-radius: 3px; border: 1px solid #333;">/our-stock/?MinPrice=20000&MaxPrice=50000</code></li>
							<li><code style="background: #1a1a1a; color: #81c784; padding: 2px 6px; border-radius: 3px; border: 1px solid #333;">/our-stock/?Brand=bmw&Year=2023&MinPrice=30000&Transmission=automatic</code></li>
							<li><code style="background: #1a1a1a; color: #81c784; padding: 2px 6px; border-radius: 3px; border: 1px solid #333;">/our-stock/?Body=sedan&Fuel=gasoline&orderby=price&order=ASC</code></li>
						</ul>
					</div>
				</div>', 'auto-listings' ),
				'content_classes' => 'elementor-panel-alert',
				'condition'       => [
					'enable_query_params' => 'yes',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_layout',
			[
				'label' => esc_html__( 'Layout', 'auto-listings' ),
			]
		);

		$this->add_responsive_control(
			'columns',
			[
				'label'          => esc_html__( 'Columns', 'auto-listings' ),
				'type'           => Controls_Manager::SELECT,
				'default'        => '3',
				'tablet_default' => '2',
				'mobile_default' => '1',
				'options'        => [
					'1' => '1',
					'2' => '2',
					'3' => '3',
					'4' => '4',
				],
			]
		);

		$this->add_control(
			'view',
			[
				'label'     => esc_html__( 'View Mode', 'auto-listings' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'grid',
				'options'   => [
					'grid' => esc_html__( 'Grid', 'auto-listings' ),
					'list' => esc_html__( 'List', 'auto-listings' ),
				],
				'condition' => [
					'card_template_type' => 'default',
				],
			]
		);

		$this->add_control(
			'compact',
			[
				'label'        => esc_html__( 'Compact Mode', 'auto-listings' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'auto-listings' ),
				'label_off'    => esc_html__( 'No', 'auto-listings' ),
				'return_value' => 'yes',
				'default'      => 'no',
				'description'  => esc_html__( 'Hide description and features for a more compact display', 'auto-listings' ),
				'condition'    => [
					'card_template_type' => 'default',
				],
			]
		);

		$this->add_responsive_control(
			'column_gap',
			[
				'label'      => esc_html__( 'Column Gap', 'auto-listings' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default'    => [
					'size' => 30,
				],
				'selectors'  => [
					'{{WRAPPER}} .auto-listings-items' => 'column-gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'row_gap',
			[
				'label'      => esc_html__( 'Row Gap', 'auto-listings' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default'    => [
					'size' => 30,
				],
				'selectors'  => [
					'{{WRAPPER}} .auto-listings-items' => 'row-gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_items_style',
			[
				'label'     => esc_html__( 'Listing Items', 'auto-listings' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'card_template_type' => 'default',
				],
			]
		);

		$this->add_control(
			'item_background_color',
			[
				'label'     => esc_html__( 'Background Color', 'auto-listings' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .auto-listings-items li' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'item_padding',
			[
				'label'      => esc_html__( 'Padding', 'auto-listings' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .auto-listings-items li' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'item_border',
				'selector' => '{{WRAPPER}} .auto-listings-items li',
			]
		);

		$this->add_responsive_control(
			'item_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'auto-listings' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .auto-listings-items li' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'item_box_shadow',
				'selector' => '{{WRAPPER}} .auto-listings-items li',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_hover_style',
			[
				'label'     => esc_html__( 'Hover Effects', 'auto-listings' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'card_template_type' => 'default',
				],
			]
		);

		$this->add_control(
			'item_hover_background_color',
			[
				'label'     => esc_html__( 'Background Color', 'auto-listings' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .auto-listings-items li:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'item_hover_box_shadow',
				'selector' => '{{WRAPPER}} .auto-listings-items li:hover',
			]
		);

		$this->add_control(
			'item_hover_border_color',
			[
				'label'     => esc_html__( 'Border Color', 'auto-listings' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .auto-listings-items li:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'hover_transition',
			[
				'label'      => esc_html__( 'Transition Duration (ms)', 'auto-listings' ),
				'type'       => Controls_Manager::SLIDER,
				'range'      => [
					'px' => [
						'min' => 0,
						'max' => 1000,
					],
				],
				'default'    => [
					'size' => 300,
				],
				'selectors'  => [
					'{{WRAPPER}} .auto-listings-items li' => 'transition: all {{SIZE}}ms ease;',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_title_style',
			[
				'label'     => esc_html__( 'Title', 'auto-listings' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'card_template_type' => 'default',
				],
			]
		);

		$this->add_control(
			'title_color',
			[
				'label'     => esc_html__( 'Color', 'auto-listings' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#1a1a1a',
				'selectors' => [
					'{{WRAPPER}} .auto-listings-items .listing__title a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'title_hover_color',
			[
				'label'     => esc_html__( 'Hover Color', 'auto-listings' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#246d6d',
				'selectors' => [
					'{{WRAPPER}} .auto-listings-items .listing__title a:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'title_typography',
				'selector' => '{{WRAPPER}} .auto-listings-items .listing__title',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_price_style',
			[
				'label'     => esc_html__( 'Price', 'auto-listings' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'card_template_type' => 'default',
				],
			]
		);

		$this->add_control(
			'price_color',
			[
				'label'     => esc_html__( 'Color', 'auto-listings' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#246d6d',
				'selectors' => [
					'{{WRAPPER}} .auto-listings-items .listing__price' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'price_typography',
				'selector' => '{{WRAPPER}} .auto-listings-items .listing__price',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_buttons_style',
			[
				'label'     => esc_html__( 'Buttons', 'auto-listings' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'card_template_type' => 'default',
				],
			]
		);

		$this->add_control(
			'primary_button_color',
			[
				'label'     => esc_html__( 'Primary Button Color', 'auto-listings' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#246d6d',
				'selectors' => [
					'{{WRAPPER}} .listing__btn-primary' => 'background-color: {{VALUE}}; border-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'primary_button_text_color',
			[
				'label'     => esc_html__( 'Primary Button Text Color', 'auto-listings' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .listing__btn-primary' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'primary_button_hover_color',
			[
				'label'     => esc_html__( 'Primary Button Hover Color', 'auto-listings' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#1a5555',
				'selectors' => [
					'{{WRAPPER}} .listing__btn-primary:hover' => 'background-color: {{VALUE}}; border-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'primary_button_hover_text_color',
			[
				'label'     => esc_html__( 'Primary Button Hover Text Color', 'auto-listings' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .listing__btn-primary:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'secondary_button_heading',
			[
				'label'     => esc_html__( 'Secondary Button', 'auto-listings' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'secondary_button_color',
			[
				'label'     => esc_html__( 'Secondary Button Text Color', 'auto-listings' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#246d6d',
				'selectors' => [
					'{{WRAPPER}} .listing__btn-secondary' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'secondary_button_border_color',
			[
				'label'     => esc_html__( 'Secondary Button Border Color', 'auto-listings' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#e0e0e0',
				'selectors' => [
					'{{WRAPPER}} .listing__btn-secondary' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'secondary_button_hover_border',
			[
				'label'     => esc_html__( 'Secondary Button Hover Border', 'auto-listings' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#246d6d',
				'selectors' => [
					'{{WRAPPER}} .listing__btn-secondary:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'secondary_button_hover_color',
			[
				'label'     => esc_html__( 'Secondary Button Hover Text Color', 'auto-listings' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#246d6d',
				'selectors' => [
					'{{WRAPPER}} .listing__btn-secondary:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'button_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'auto-listings' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min' => 0,
						'max' => 50,
					],
				],
				'default'    => [
					'size' => 6,
				],
				'selectors'  => [
					'{{WRAPPER}} .listing__btn' => 'border-radius: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_details_style',
			[
				'label'     => esc_html__( 'Details & Badges', 'auto-listings' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'card_template_type' => 'default',
				],
			]
		);

		$this->add_control(
			'details_color',
			[
				'label'     => esc_html__( 'Details Color', 'auto-listings' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#666666',
				'selectors' => [
					'{{WRAPPER}} .listing__details' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'new_badge_color',
			[
				'label'     => esc_html__( 'New Badge Background', 'auto-listings' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#246d6d',
				'selectors' => [
					'{{WRAPPER}} .listing-badge-new' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'year_badge_color',
			[
				'label'     => esc_html__( 'Year Badge Background', 'auto-listings' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .listing-badge-year' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'card_border_radius',
			[
				'label'      => esc_html__( 'Card Border Radius', 'auto-listings' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min' => 0,
						'max' => 30,
					],
				],
				'default'    => [
					'size' => 12,
				],
				'selectors'  => [
					'{{WRAPPER}} .listing-card' => 'border-radius: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_container_style',
			[
				'label' => esc_html__( 'Container', 'auto-listings' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->register_background_controls( '{{WRAPPER}} .auto-listings-grid-widget' );
		$this->register_spacing_controls( '{{WRAPPER}} .auto-listings-grid-widget' );
		$this->register_border_controls( '{{WRAPPER}} .auto-listings-grid-widget' );

		$this->end_controls_section();
	}

	/**
	 * Apply URL query parameters to query args
	 *
	 * @param array $query_args Existing query arguments.
	 * @return array Modified query arguments.
	 */
	protected function apply_query_parameters( $query_args ) {
		$meta_query = isset( $query_args['meta_query'] ) ? $query_args['meta_query'] : [];
		$tax_query  = isset( $query_args['tax_query'] ) ? $query_args['tax_query'] : [];

		if ( ! isset( $_GET ) || empty( $_GET ) ) {
			return $query_args;
		}

		$param_mapping = [
			'Brand'        => '_al_listing_make_display',
			'Make'         => '_al_listing_make_display',
			'Model'        => '_al_listing_model_name',
			'Year'         => '_al_listing_model_year',
			'Condition'    => '_al_listing_condition',
			'Transmission' => '_al_listing_model_transmission_type',
			'Fuel'         => '_al_listing_model_engine_fuel',
			'Engine'       => '_al_listing_model_engine_type',
			'Drive'        => '_al_listing_model_drive',
			'Body'         => 'body-type',
		];

		foreach ( $param_mapping as $param => $meta_key ) {
			if ( ! isset( $_GET[ $param ] ) || empty( $_GET[ $param ] ) ) {
				continue;
			}

			$value = sanitize_text_field( wp_unslash( $_GET[ $param ] ) );

			if ( 'Body' === $param ) {
				$tax_query[] = [
					'taxonomy' => 'body-type',
					'field'    => 'slug',
					'terms'    => $value,
				];
			} else {
				$meta_query[] = [
					'key'     => $meta_key,
					'value'   => $value,
					'compare' => '=',
				];
			}
		}

		if ( isset( $_GET['Odometer'] ) && ! empty( $_GET['Odometer'] ) ) {
			$odometer = floatval( $_GET['Odometer'] );
			$meta_query[] = [
				'key'     => '_al_listing_odometer',
				'value'   => [ 0, $odometer ],
				'compare' => 'BETWEEN',
				'type'    => 'NUMERIC',
			];
		}

		if ( isset( $_GET['Price'] ) && ! empty( $_GET['Price'] ) ) {
			$price = floatval( $_GET['Price'] );
			$meta_query[] = [
				'key'     => '_al_listing_price',
				'value'   => $price,
				'compare' => '=',
			];
		}

		if ( isset( $_GET['MinPrice'] ) || isset( $_GET['MaxPrice'] ) ) {
			$min_price = isset( $_GET['MinPrice'] ) ? floatval( $_GET['MinPrice'] ) : 0;
			$max_price = isset( $_GET['MaxPrice'] ) ? floatval( $_GET['MaxPrice'] ) : 999999999;

			if ( $min_price > 0 && $max_price > 0 ) {
				$meta_query[] = [
					'key'     => '_al_listing_price',
					'value'   => [ $min_price, $max_price ],
					'compare' => 'BETWEEN',
					'type'    => 'NUMERIC',
				];
			} elseif ( $min_price > 0 ) {
				$meta_query[] = [
					'key'     => '_al_listing_price',
					'value'   => $min_price,
					'compare' => '>=',
					'type'    => 'NUMERIC',
				];
			} elseif ( $max_price < 999999999 ) {
				$meta_query[] = [
					'key'     => '_al_listing_price',
					'value'   => $max_price,
					'compare' => '<=',
					'type'    => 'NUMERIC',
				];
			}
		}

		if ( ! empty( $meta_query ) ) {
			if ( count( $meta_query ) > 1 ) {
				$meta_query['relation'] = 'AND';
			}
			$query_args['meta_query'] = $meta_query;
		}

		if ( ! empty( $tax_query ) ) {
			$query_args['tax_query'] = $tax_query;
		}

		if ( isset( $_GET['orderby'] ) && ! empty( $_GET['orderby'] ) ) {
			$orderby = sanitize_text_field( $_GET['orderby'] );
			$valid_orderby = [ 'date', 'title', 'modified', 'menu_order', 'rand', 'ID', 'price' ];
			
			if ( in_array( $orderby, $valid_orderby, true ) ) {
				$query_args['orderby'] = $orderby;
				
				if ( 'price' === $orderby ) {
					$query_args['orderby']  = 'meta_value_num';
					$query_args['meta_key'] = '_al_listing_price';
				}
			}
		}

		if ( isset( $_GET['order'] ) && ! empty( $_GET['order'] ) ) {
			$order = strtoupper( sanitize_text_field( $_GET['order'] ) );
			if ( in_array( $order, [ 'ASC', 'DESC' ], true ) ) {
				$query_args['order'] = $order;
			}
		}

		return $query_args;
	}

	/**
	 * Render widget output on the frontend
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();

		$query_args = [
			'post_type'           => 'auto-listing',
			'post_status'         => 'publish',
			'ignore_sticky_posts' => 1,
			'orderby'             => $settings['orderby'],
			'order'               => $settings['order'],
			'posts_per_page'      => $settings['number'],
		];

		if ( ! empty( $settings['ids'] ) ) {
			$query_args['post__in'] = array_map( 'trim', explode( ',', $settings['ids'] ) );
		}

		if ( ! empty( $settings['seller'] ) ) {
			$query_args['meta_key']     = '_al_listing_seller';
			$query_args['meta_value']   = absint( $settings['seller'] );
			$query_args['meta_compare'] = '=';
		}

		if ( 'yes' === $settings['enable_query_params'] ) {
			$query_args = $this->apply_query_parameters( $query_args );
		}

		$use_custom_template = ( 'custom' === $settings['card_template_type'] && ! empty( $settings['custom_template_id'] ) );

		if ( ! $use_custom_template && 'yes' === $settings['compact'] ) {
			remove_action( 'auto_listings_listings_loop_item', 'auto_listings_template_loop_at_a_glance', 20 );
			remove_action( 'auto_listings_listings_loop_item', 'auto_listings_template_loop_description', 50 );
			add_filter( 'post_class', [ $this, 'add_compact_class' ] );
		}

		$columns = ! empty( $settings['columns'] ) ? $settings['columns'] : 3;
		add_filter( 'auto_listings_columns', function () use ( $columns ) {
			return $columns;
		} );

		$query = new \WP_Query( apply_filters( 'auto_listings_elementor_grid_query', $query_args, $settings ) );

		if ( ! $query->have_posts() ) {
			if ( $this->is_editor_mode() ) {
				echo '<div class="elementor-alert elementor-alert-warning">';
				esc_html_e( 'No listings found. Try adjusting your query settings.', 'auto-listings' );
				echo '</div>';
			}
			return;
		}

		if ( $use_custom_template ) {
			$this->render_custom_template( $query, $settings );
		} else {
			$this->render_default_template( $query, $settings );
		}

		if ( ! $use_custom_template && 'yes' === $settings['compact'] ) {
			add_action( 'auto_listings_listings_loop_item', 'auto_listings_template_loop_at_a_glance', 20 );
			add_action( 'auto_listings_listings_loop_item', 'auto_listings_template_loop_description', 50 );
			remove_filter( 'post_class', [ $this, 'add_compact_class' ] );
		}

		wp_reset_postdata();
	}

	/**
	 * Render with default template
	 *
	 * @param \WP_Query $query    The query object.
	 * @param array     $settings Widget settings.
	 */
	protected function render_default_template( $query, $settings ) {
		$view = ! empty( $settings['view'] ) ? $settings['view'] : 'grid';
		$view .= '-view';

		echo '<div class="auto-listings-grid-widget">';
		
		echo '<style>
			.elementor-element-' . $this->get_id() . ' .auto-listings-items {
				display: grid !important;
				list-style: none;
				margin: 0;
				padding: 0;
			}
			@media (min-width: 1025px) {
				.elementor-element-' . $this->get_id() . ' .auto-listings-items {
					grid-template-columns: repeat(' . absint( $settings['columns'] ) . ', 1fr);
				}
			}
			@media (min-width: 768px) and (max-width: 1024px) {
				.elementor-element-' . $this->get_id() . ' .auto-listings-items {
					grid-template-columns: repeat(' . absint( $settings['columns_tablet'] ?? 2 ) . ', 1fr);
				}
			}
			@media (max-width: 767px) {
				.elementor-element-' . $this->get_id() . ' .auto-listings-items {
					grid-template-columns: repeat(' . absint( $settings['columns_mobile'] ?? 1 ) . ', 1fr);
				}
			}
			
			/* Reset list item widths to fill grid cells */
			.elementor-element-' . $this->get_id() . ' .auto-listings-items > li,
			.elementor-element-' . $this->get_id() . ' .auto-listings-items > li.listing-card,
			.elementor-element-' . $this->get_id() . ' .auto-listings-items > li.col-1,
			.elementor-element-' . $this->get_id() . ' .auto-listings-items > li.col-2,
			.elementor-element-' . $this->get_id() . ' .auto-listings-items > li.col-3,
			.elementor-element-' . $this->get_id() . ' .auto-listings-items > li.col-4 {
				width: 100% !important;
				max-width: 100% !important;
				margin-right: 0 !important;
				margin-left: 0 !important;
				float: none !important;
			}
			
			/* Ensure grid items stretch to fill their cells */
			.elementor-element-' . $this->get_id() . ' .auto-listings-items > li {
				align-self: stretch;
				justify-self: stretch;
			}
			
			/* Override old grid-view styles */
			.elementor-element-' . $this->get_id() . ' .auto-listings-items.grid-view > li,
			.elementor-element-' . $this->get_id() . ' .auto-listings-items.grid-view > li.col-2,
			.elementor-element-' . $this->get_id() . ' .auto-listings-items.grid-view > li.col-3,
			.elementor-element-' . $this->get_id() . ' .auto-listings-items.grid-view > li.col-4 {
				width: 100% !important;
				max-width: 100% !important;
				margin-right: 0 !important;
			}
			
			/* Modern Card Styling */
			.elementor-element-' . $this->get_id() . ' .listing-card {
				background: #ffffff;
				border-radius: 12px;
				overflow: hidden;
				box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
				transition: transform 0.3s ease, box-shadow 0.3s ease;
				display: flex;
				flex-direction: column;
				height: 100%;
				width: 100%;
			}
			
			.elementor-element-' . $this->get_id() . ' .listing-card:hover {
				transform: translateY(-4px);
				box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
			}
			
			.elementor-element-' . $this->get_id() . ' .listing-card-inner {
				display: flex;
				flex-direction: column;
				height: 100%;
			}
			
			/* Image Section */
			.elementor-element-' . $this->get_id() . ' .listing-card-image {
				position: relative;
				overflow: hidden;
				background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
				aspect-ratio: 4/3;
			}
			
			.elementor-element-' . $this->get_id() . ' .listing-card-image:has(img) {
				background: #f5f5f5;
			}
			
			.elementor-element-' . $this->get_id() . ' .listing-card-image a {
				display: block;
				width: 100%;
				height: 100%;
			}
			
			.elementor-element-' . $this->get_id() . ' .listing-card-img {
				width: 100%;
				height: 100%;
				object-fit: cover;
				transition: transform 0.3s ease;
			}
			
			.elementor-element-' . $this->get_id() . ' .listing-card:hover .listing-card-img {
				transform: scale(1.05);
			}
			
			/* Badges */
			.elementor-element-' . $this->get_id() . ' .listing-badges {
				position: absolute;
				top: 16px;
				left: 16px;
				right: 16px;
				display: flex;
				justify-content: space-between;
				align-items: flex-start;
				z-index: 2;
				pointer-events: none;
			}
			
			.elementor-element-' . $this->get_id() . ' .listing-badge {
				display: inline-block;
				padding: 6px 14px;
				border-radius: 6px;
				font-size: 13px;
				font-weight: 600;
				line-height: 1.4;
				box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
			}
			
			.elementor-element-' . $this->get_id() . ' .listing-badge-new {
				color: #ffffff;
			}
			
			.elementor-element-' . $this->get_id() . ' .listing-badge-year {
				color: #333333;
				margin-left: auto;
			}
			
			/* Content Section */
			.elementor-element-' . $this->get_id() . ' .listing-card-content {
				padding: 24px;
				display: flex;
				flex-direction: column;
				flex-grow: 1;
				min-height: 200px;
			}
			
			/* Title */
			.elementor-element-' . $this->get_id() . ' .listing__title {
				margin: 0 0 12px 0;
				font-size: 20px;
				font-weight: 600;
				line-height: 1.3;
			}
			
			.elementor-element-' . $this->get_id() . ' .listing__title a {
				text-decoration: none;
				transition: color 0.2s ease;
			}
			
			/* Details (mileage, transmission) */
			.elementor-element-' . $this->get_id() . ' .listing__details {
				display: flex;
				align-items: center;
				gap: 8px;
				margin-bottom: 16px;
				font-size: 14px;
			}
			
			.elementor-element-' . $this->get_id() . ' .listing__detail-item {
				white-space: nowrap;
			}
			
			.elementor-element-' . $this->get_id() . ' .listing__detail-separator {
				color: #cccccc;
			}
			
			/* Price */
			.elementor-element-' . $this->get_id() . ' .listing__price {
				margin: 0 0 20px 0;
				font-size: 28px;
				font-weight: 700;
				line-height: 1.2;
			}
			
			/* Actions (Buttons) */
			.elementor-element-' . $this->get_id() . ' .listing__actions {
				display: flex;
				gap: 12px;
				margin-top: auto;
				flex-wrap: wrap;
			}
			
			.elementor-element-' . $this->get_id() . ' .listing__btn {
				flex: 1;
				min-width: 120px;
				display: inline-flex;
				align-items: center;
				justify-content: center;
				padding: 12px 20px;
				font-size: 14px;
				font-weight: 600;
				text-decoration: none;
				transition: all 0.2s ease;
				text-align: center;
				border: 2px solid transparent;
				line-height: 1.4;
				white-space: nowrap;
			}
			
			.elementor-element-' . $this->get_id() . ' .listing__btn-secondary {
				background: #ffffff;
			}
			
			.elementor-element-' . $this->get_id() . ' .listing__btn-secondary:hover {
				background: #f8f8f8;
			}
			
			/* Hide unwanted elements */
			.elementor-element-' . $this->get_id() . ' .listing-card-content > .address,
			.elementor-element-' . $this->get_id() . ' .listing-card-content > .description {
				display: none;
			}
			
			/* Responsive adjustments */
			@media (max-width: 767px) {
				.elementor-element-' . $this->get_id() . ' .listing-card-content {
					padding: 20px;
				}
				
				.elementor-element-' . $this->get_id() . ' .listing__title {
					font-size: 18px;
				}
				
				.elementor-element-' . $this->get_id() . ' .listing__price {
					font-size: 24px;
				}
				
				.elementor-element-' . $this->get_id() . ' .listing__actions {
					flex-direction: column;
				}
				
				.elementor-element-' . $this->get_id() . ' .listing__btn {
					width: 100%;
				}
			}
		</style>';

		do_action( 'auto_listings_shortcode_before_listings_loop' );

		echo '<ul class="auto-listings-items ' . esc_attr( $view ) . '" data-filterable="true">';
		
		while ( $query->have_posts() ) {
			$query->the_post();
			auto_listings_get_part( 'content-listing.php' );
		}
		
		echo '</ul>';

		do_action( 'auto_listings_after_listings_loop', [ 'query' => $query ] );
		do_action( 'auto_listings_shortcode_after_listings_loop' );

		echo '</div>';
	}

	/**
	 * Render with custom Elementor template
	 *
	 * @param \WP_Query $query    The query object.
	 * @param array     $settings Widget settings.
	 */
	protected function render_custom_template( $query, $settings ) {
		$template_id = absint( $settings['custom_template_id'] );

		if ( ! $template_id || get_post_status( $template_id ) !== 'publish' ) {
			if ( $this->is_editor_mode() ) {
				echo '<div class="elementor-alert elementor-alert-danger">';
				esc_html_e( 'Selected template not found or not published. Please select a valid template.', 'auto-listings' );
				echo '</div>';
			}
			return;
		}

		echo '<div class="auto-listings-grid-widget auto-listings-custom-template">';
		
		echo '<style>
			.elementor-element-' . $this->get_id() . ' .auto-listings-custom-template-grid {
				display: grid !important;
				list-style: none;
				margin: 0;
				padding: 0;
			}
			@media (min-width: 1025px) {
				.elementor-element-' . $this->get_id() . ' .auto-listings-custom-template-grid {
					grid-template-columns: repeat(' . absint( $settings['columns'] ) . ', 1fr);
				}
			}
			@media (min-width: 768px) and (max-width: 1024px) {
				.elementor-element-' . $this->get_id() . ' .auto-listings-custom-template-grid {
					grid-template-columns: repeat(' . absint( $settings['columns_tablet'] ?? 2 ) . ', 1fr);
				}
			}
			@media (max-width: 767px) {
				.elementor-element-' . $this->get_id() . ' .auto-listings-custom-template-grid {
					grid-template-columns: repeat(' . absint( $settings['columns_mobile'] ?? 1 ) . ', 1fr);
				}
			}
			
			.elementor-element-' . $this->get_id() . ' .auto-listings-custom-template-item {
				width: 100% !important;
				max-width: 100% !important;
				margin: 0 !important;
			}
		</style>';

		echo '<ul class="auto-listings-custom-template-grid" data-filterable="true">';
		
		while ( $query->have_posts() ) {
			$query->the_post();
			
			echo '<li class="auto-listings-custom-template-item ' . esc_attr( implode( ' ', get_post_class() ) ) . '">';
			
			echo $this->render_elementor_template( $template_id );
			
			echo '</li>';
		}
		
		echo '</ul>';

		echo '</div>';
	}

	/**
	 * Render an Elementor template
	 *
	 * @param int $template_id The template ID.
	 * @return string
	 */
	protected function render_elementor_template( $template_id ) {
		if ( ! class_exists( '\Elementor\Plugin' ) ) {
			return '';
		}

		$elementor = \Elementor\Plugin::instance();
		
		return $elementor->frontend->get_builder_content_for_display( $template_id, true );
	}

	/**
	 * Add compact class to post classes
	 *
	 * @param array $classes Post classes.
	 * @return array
	 */
	public function add_compact_class( $classes ) {
		$classes[] = 'compact';
		return $classes;
	}
}

