<?php
namespace AutoListings\Elementor;

/**
 * Register Elementor Widgets
 */
class Register {
	/**
	 * Constructor
	 */
	public function __construct() {
		add_action( 'elementor/widgets/register', [ $this, 'register_widgets' ] );
		add_action( 'elementor/elements/categories_registered', [ $this, 'add_widget_category' ] );
	}

	/**
	 * Register widgets
	 *
	 * @param \Elementor\Widgets_Manager $widgets_manager Elementor widgets manager.
	 */
	public function register_widgets( $widgets_manager ) {
		if ( ! defined( 'ELEMENTOR_VERSION' ) ) {
			return;
		}

		$widgets = [
			'ContactForm',
			'Features',
			'Location',
			'SingleListing',
			'ListingsGrid',
			'SearchForm',
			'ListingsFilter',
			'ListingsQueryForm',
		];

		foreach ( $widgets as $widget_name ) {
			$widget_class = __NAMESPACE__ . '\\' . $widget_name;
			
			if ( class_exists( $widget_class ) ) {
				try {
					$widgets_manager->register( new $widget_class() );
				} catch ( \Exception $e ) {
					if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
						error_log( 'Auto Listings Elementor Widget Error (' . $widget_name . '): ' . $e->getMessage() );
					}
				}
			}
		}
	}

	/**
	 * Add Auto Listings widget category
	 *
	 * @param \Elementor\Elements_Manager $elements_manager Elementor elements manager.
	 */
	public function add_widget_category( $elements_manager ) {
		$elements_manager->add_category(
			'auto-listings',
			[
				'title' => esc_html__( 'Auto Listings', 'auto-listings' ),
				'icon'  => 'fa fa-car',
			]
		);
	}
}

