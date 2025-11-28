<?php
namespace AutoListings\Elementor;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;

/**
 * Listings Filter Elementor Widget
 * Provides search and filter functionality for Listings Grid
 */
class ListingsFilter extends Base {
	/**
	 * Get widget name
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'auto-listings-listings-filter';
	}

	/**
	 * Get widget title
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( 'Listings Filter', 'auto-listings' );
	}

	/**
	 * Get widget icon
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-filter';
	}

	/**
	 * Register widget controls
	 */
	protected function register_controls() {
		$this->start_controls_section(
			'section_filter_options',
			[
				'label' => esc_html__( 'Filter Options', 'auto-listings' ),
			]
		);

		$this->add_control(
			'enable_search',
			[
				'label'        => esc_html__( 'Enable Search', 'auto-listings' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'auto-listings' ),
				'label_off'    => esc_html__( 'No', 'auto-listings' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'search_placeholder',
			[
				'label'       => esc_html__( 'Search Placeholder', 'auto-listings' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Search by title...', 'auto-listings' ),
				'condition'   => [
					'enable_search' => 'yes',
				],
			]
		);

		$this->add_control(
			'enable_sort',
			[
				'label'        => esc_html__( 'Enable Sort', 'auto-listings' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'auto-listings' ),
				'label_off'    => esc_html__( 'No', 'auto-listings' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'sort_label',
			[
				'label'       => esc_html__( 'Sort Label', 'auto-listings' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Sort by:', 'auto-listings' ),
				'condition'   => [
					'enable_sort' => 'yes',
				],
			]
		);

		$this->add_control(
			'layout',
			[
				'label'   => esc_html__( 'Layout', 'auto-listings' ),
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
			'section_container_style',
			[
				'label' => esc_html__( 'Container', 'auto-listings' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'container_background',
			[
				'label'     => esc_html__( 'Background Color', 'auto-listings' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .auto-listings-filter' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'container_padding',
			[
				'label'      => esc_html__( 'Padding', 'auto-listings' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em' ],
				'default'    => [
					'top'      => '20',
					'right'    => '20',
					'bottom'   => '20',
					'left'     => '20',
					'unit'     => 'px',
					'isLinked' => true,
				],
				'selectors'  => [
					'{{WRAPPER}} .auto-listings-filter' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'container_margin',
			[
				'label'      => esc_html__( 'Margin', 'auto-listings' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em' ],
				'default'    => [
					'top'      => '0',
					'right'    => '0',
					'bottom'   => '30',
					'left'     => '0',
					'unit'     => 'px',
					'isLinked' => false,
				],
				'selectors'  => [
					'{{WRAPPER}} .auto-listings-filter' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'container_border',
				'selector' => '{{WRAPPER}} .auto-listings-filter',
			]
		);

		$this->add_responsive_control(
			'container_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'auto-listings' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'default'    => [
					'top'      => '8',
					'right'    => '8',
					'bottom'   => '8',
					'left'     => '8',
					'unit'     => 'px',
					'isLinked' => true,
				],
				'selectors'  => [
					'{{WRAPPER}} .auto-listings-filter' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'container_box_shadow',
				'selector' => '{{WRAPPER}} .auto-listings-filter',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_search_style',
			[
				'label'     => esc_html__( 'Search Field', 'auto-listings' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'enable_search' => 'yes',
				],
			]
		);

		$this->add_control(
			'search_text_color',
			[
				'label'     => esc_html__( 'Text Color', 'auto-listings' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#333333',
				'selectors' => [
					'{{WRAPPER}} .listings-filter-search' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'search_background',
			[
				'label'     => esc_html__( 'Background Color', 'auto-listings' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#f8f8f8',
				'selectors' => [
					'{{WRAPPER}} .listings-filter-search' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'search_typography',
				'selector' => '{{WRAPPER}} .listings-filter-search',
			]
		);

		$this->add_responsive_control(
			'search_padding',
			[
				'label'      => esc_html__( 'Padding', 'auto-listings' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em' ],
				'default'    => [
					'top'      => '12',
					'right'    => '16',
					'bottom'   => '12',
					'left'     => '16',
					'unit'     => 'px',
					'isLinked' => false,
				],
				'selectors'  => [
					'{{WRAPPER}} .listings-filter-search' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'search_border',
				'selector' => '{{WRAPPER}} .listings-filter-search',
			]
		);

		$this->add_responsive_control(
			'search_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'auto-listings' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'default'    => [
					'top'      => '6',
					'right'    => '6',
					'bottom'   => '6',
					'left'     => '6',
					'unit'     => 'px',
					'isLinked' => true,
				],
				'selectors'  => [
					'{{WRAPPER}} .listings-filter-search' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_sort_style',
			[
				'label'     => esc_html__( 'Sort Dropdown', 'auto-listings' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'enable_sort' => 'yes',
				],
			]
		);

		$this->add_control(
			'sort_label_color',
			[
				'label'     => esc_html__( 'Label Color', 'auto-listings' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#333333',
				'selectors' => [
					'{{WRAPPER}} .listings-filter-sort-label' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'sort_label_typography',
				'selector' => '{{WRAPPER}} .listings-filter-sort-label',
			]
		);

		$this->add_control(
			'sort_select_color',
			[
				'label'     => esc_html__( 'Select Text Color', 'auto-listings' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#333333',
				'selectors' => [
					'{{WRAPPER}} .listings-filter-sort-select' => 'color: {{VALUE}};',
				],
				'separator' => 'before',
			]
		);

		$this->add_control(
			'sort_select_background',
			[
				'label'     => esc_html__( 'Select Background', 'auto-listings' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#f8f8f8',
				'selectors' => [
					'{{WRAPPER}} .listings-filter-sort-select' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'sort_select_typography',
				'selector' => '{{WRAPPER}} .listings-filter-sort-select',
			]
		);

		$this->add_responsive_control(
			'sort_select_padding',
			[
				'label'      => esc_html__( 'Padding', 'auto-listings' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em' ],
				'default'    => [
					'top'      => '12',
					'right'    => '16',
					'bottom'   => '12',
					'left'     => '16',
					'unit'     => 'px',
					'isLinked' => false,
				],
				'selectors'  => [
					'{{WRAPPER}} .listings-filter-sort-select' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'sort_select_border',
				'selector' => '{{WRAPPER}} .listings-filter-sort-select',
			]
		);

		$this->add_responsive_control(
			'sort_select_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'auto-listings' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'default'    => [
					'top'      => '6',
					'right'    => '6',
					'bottom'   => '6',
					'left'     => '6',
					'unit'     => 'px',
					'isLinked' => true,
				],
				'selectors'  => [
					'{{WRAPPER}} .listings-filter-sort-select' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Render widget output on the frontend
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();
		$layout   = $settings['layout'];
		?>
		<div class="auto-listings-filter auto-listings-filter-<?php echo esc_attr( $layout ); ?>">
			<?php if ( 'yes' === $settings['enable_search'] ) : ?>
				<div class="listings-filter-item listings-filter-search-wrapper">
					<input 
                        id="auto-listings-filter-search"
						type="text" 
						class="listings-filter-search" 
						placeholder="<?php echo esc_attr( $settings['search_placeholder'] ); ?>"
						data-filter-type="search"
					>
				</div>
			<?php endif; ?>

			<?php if ( 'yes' === $settings['enable_sort'] ) : ?>
				<div class="listings-filter-item listings-filter-sort-wrapper">
					<?php if ( ! empty( $settings['sort_label'] ) ) : ?>
						<span class="listings-filter-sort-label"><?php echo esc_html( $settings['sort_label'] ); ?></span>
					<?php endif; ?>
					<select id="auto-listings-filter-sort" class="listings-filter-sort-select" data-filter-type="sort">
						<option value="date-desc"><?php esc_html_e( 'Newest First', 'auto-listings' ); ?></option>
						<option value="date-asc"><?php esc_html_e( 'Oldest First', 'auto-listings' ); ?></option>
						<option value="price-desc"><?php esc_html_e( 'Price: High to Low', 'auto-listings' ); ?></option>
						<option value="price-asc"><?php esc_html_e( 'Price: Low to High', 'auto-listings' ); ?></option>
						<option value="title-asc"><?php esc_html_e( 'Title: A to Z', 'auto-listings' ); ?></option>
						<option value="title-desc"><?php esc_html_e( 'Title: Z to A', 'auto-listings' ); ?></option>
					</select>
				</div>
			<?php endif; ?>
		</div>

		<style>
			.auto-listings-filter {
				display: flex;
				gap: 20px;
				align-items: center;
			}

			.auto-listings-filter-vertical {
				flex-direction: column;
				align-items: stretch;
			}

			.auto-listings-filter-vertical .listings-filter-item {
				width: 100%;
			}

			.listings-filter-item {
				flex: 1;
				display: flex;
				align-items: center;
				gap: 10px;
			}

			.listings-filter-search-wrapper {
				flex: 2;
			}

			.listings-filter-search {
				width: 100%;
				border: 1px solid #e0e0e0;
				outline: none;
				transition: all 0.3s ease;
			}

			.listings-filter-search:focus {
				border-color: #246d6d;
				box-shadow: 0 0 0 3px rgba(36, 109, 109, 0.1);
			}

			.listings-filter-sort-wrapper {
				display: flex;
				align-items: center;
				gap: 10px;
			}

			.listings-filter-sort-label {
				white-space: nowrap;
				font-weight: 500;
			}

			.listings-filter-sort-select {
				flex: 1;
				min-width: 180px;
				border: 1px solid #e0e0e0;
				outline: none;
				cursor: pointer;
				transition: all 0.3s ease;
			}

			.listings-filter-sort-select:focus {
				border-color: #246d6d;
				box-shadow: 0 0 0 3px rgba(36, 109, 109, 0.1);
			}

			/* Responsive */
			@media (max-width: 767px) {
				.auto-listings-filter-horizontal {
					flex-direction: column;
					align-items: stretch;
				}

				.auto-listings-filter-horizontal .listings-filter-item {
					width: 100%;
				}

				.listings-filter-sort-select {
					min-width: auto;
				}
			}
		</style>

		<script>
		(function($) {
			'use strict';

			$(document).ready(function() {
				setTimeout(function() {
					initListingsFilter();
				}, 100);
			});

			function initListingsFilter() {
				var $filterContainer = $('.auto-listings-filter');
				if ($filterContainer.length === 0) return;

				var $searchInput = $filterContainer.find('.listings-filter-search');
				var $sortSelect = $filterContainer.find('.listings-filter-sort-select');
				
				var $listingsGrid = $filterContainer.closest('.elementor-section')
					.find('.auto-listings-items')
					.first();
				
				if ($listingsGrid.length === 0) {
					$listingsGrid = $('.auto-listings-items').first();
				}

				if ($listingsGrid.length === 0) {
					console.warn('Auto Listings Filter: No listings grid found on page');
					return;
				}

				var $listings = $listingsGrid.find('> li');
				var searchTimeout;
				var originalOrder = [];

				$listings.each(function(index) {
					var $listing = $(this);
					var $title = $listing.find('.listing__title, h2, h3');
					var $price = $listing.find('.listing__price');
					
					var postId = 0;
					var classes = $listing.attr('class') || '';
					var postMatch = classes.match(/post-(\d+)/);
					if (postMatch) {
						postId = parseInt(postMatch[1]);
					}
					
					$listing.data('title', $title.text().toLowerCase().trim());
					$listing.data('price', parsePrice($price.text()));
					$listing.data('post-id', postId);
					$listing.data('original-index', index);
					
					originalOrder.push($listing);
				});

				if ($searchInput.length > 0) {
					$searchInput.on('keyup', function() {
						clearTimeout(searchTimeout);
						searchTimeout = setTimeout(function() {
							filterListings();
						}, 300);
					});
				}

				if ($sortSelect.length > 0) {
					$sortSelect.on('change', function() {
						filterListings();
					});
				}

				function filterListings() {
					var searchTerm = $searchInput.length > 0 ? $searchInput.val().toLowerCase().trim() : '';
					var sortValue = $sortSelect.length > 0 ? $sortSelect.val() : 'date-desc';

					$listings.each(function() {
						var $listing = $(this);
						var title = $listing.data('title');

						if (searchTerm === '' || title.indexOf(searchTerm) !== -1) {
							$listing.css('display', '');
						} else {
							$listing.hide();
						}
					});

					var $visibleListings = $listings.filter(':visible');
					
					if (sortValue && $visibleListings.length > 0) {
						var sortedListings = Array.from($visibleListings).sort(function(a, b) {
							var $a = $(a);
							var $b = $(b);

							switch(sortValue) {
								case 'price-asc':
									var priceA = $a.data('price') || 0;
									var priceB = $b.data('price') || 0;
									return priceA - priceB;
								
								case 'price-desc':
									var priceA = $a.data('price') || 0;
									var priceB = $b.data('price') || 0;
									return priceB - priceA;
								
								case 'title-asc':
									var titleA = $a.data('title') || '';
									var titleB = $b.data('title') || '';
									return titleA.localeCompare(titleB);
								
								case 'title-desc':
									var titleA = $a.data('title') || '';
									var titleB = $b.data('title') || '';
									return titleB.localeCompare(titleA);
								
								case 'date-asc':
									var idA = $a.data('post-id') || 0;
									var idB = $b.data('post-id') || 0;
									return idA - idB;
								
								case 'date-desc':
								default:
									var idA = $a.data('post-id') || 0;
									var idB = $b.data('post-id') || 0;
									return idB - idA;
							}
						});

						$listings.detach();

						$.each(sortedListings, function(i, listing) {
							$listingsGrid.append(listing);
						});

						$listings.filter(':hidden').each(function() {
							$listingsGrid.append(this);
						});
					}

					showNoResultsMessage();
				}

				function parsePrice(priceString) {
					if (!priceString) return 0;
					
					var cleaned = priceString.replace(/[^0-9.]/g, '');
					var price = parseFloat(cleaned);
					
					return isNaN(price) ? 0 : price;
				}

				function showNoResultsMessage() {
					var $visibleListings = $listings.filter(':visible');
					var $noResults = $listingsGrid.siblings('.listings-no-results');

					if ($visibleListings.length === 0) {
						if ($noResults.length === 0) {
							$listingsGrid.after(
								'<div class="listings-no-results" style="padding: 40px 20px; text-align: center; color: #666; font-size: 16px;">' + 
								'<?php esc_html_e( 'No listings found matching your criteria.', 'auto-listings' ); ?>' + 
								'</div>'
							);
						}
						$listingsGrid.css('display', 'none');
					} else {
						$noResults.remove();
						$listingsGrid.css('display', '');
					}
				}
			}

			if (typeof elementorFrontend !== 'undefined') {
				elementorFrontend.hooks.addAction('frontend/element_ready/auto-listings-listings-filter.default', function() {
					setTimeout(initListingsFilter, 100);
				});
			}
		})(jQuery);
		</script>
		<?php
	}
}

