<?php
namespace AutoListings\SearchForm\Shortcode;

class Field {
	private $control;
	private $placeholder;

	public function __construct( $control ) {
		$this->control = $control;

		$this->placeholder = array(
			'year'            => __( 'All years', 'auto-listings' ),
			'make'            => __( 'All makes', 'auto-listings' ),
			'transmission'    => __( 'All transmissions', 'auto-listings' ),
			'drivetrain'      => __( 'All drivetrains', 'auto-listings' ),
			'engine'          => __( 'All engines', 'auto-listings' ),
			'fuel_type'       => __( 'All fuel types', 'auto-listings' ),
			'exterior_colors' => __( 'All colors', 'auto-listings' ),
			'model'           => __( 'All models', 'auto-listings' ),
			'condition'       => __( 'All conditions', 'auto-listings' ),
			'body_type'       => __( 'All body types', 'auto-listings' ),
			'price'           => __( 'All prices', 'auto-listings' ),
			'min_price'       => __( 'All prices', 'auto-listings' ),
			'max_price'       => __( 'All prices', 'auto-listings' ),
			'odometer'        => __( 'All mileages', 'auto-listings' ),
		);

		add_shortcode( 'als_field', array( $this, 'render' ) );
	}

	public function render( $atts ) {
		$atts = shortcode_atts(
			array(
				'name'        => '',
				'type'        => 'select', // 'radio'
				'multiple'    => 'false',
				'prefix'      => '',
				'suffix'      => '',
				'label'       => '',
				'placeholder' => '',
			),
			$atts
		);

		$method = "get_{$atts['name']}_options";

		// TODO: move all functions to get search options to this class.
		// $method = method_exists( $this, $method ) ? $method : 'get_default_options';
		// $options = $this->{$method}();

		switch ( $atts['name'] ) {
			case 'odometer':
				$options = auto_listings_search_mileage_max();
				break;
			case 'body_type':
			case 'price':
				$options = $this->{$method}();
				break;
			case 'min_price':
			case 'max_price':
				$options = auto_listings_search_price_min_max();
				break;
			default:
				$options = $this->get_default_options( $atts['name'] );
				break;
		}

		$atts['placeholder'] = $atts['placeholder'] ?: $this->placeholder[ $atts['name'] ];

		$output = $this->control->render( $options, $atts );

		if ( 'price' === $atts['name'] ) {
			$output .= '<input type="hidden" name="min_price" value="">';
			$output .= '<input type="hidden" name="max_price" value="">';
		}

		return $output;
	}

	private function get_default_options( $name ) {
		if ( 'condition' === $name ) {
			$data = auto_listings_available_listing_conditions();
		} else {
			$data = auto_listings_search_get_vehicle_data();
			$data = $data[ $name ];
		}

		if ( ! $data ) {
			return [];
		}

		$options = array();
		foreach ( $data as $d ) {
			$options[ $d ] = $d;
		}

		return $options;
	}

	private function get_body_type_options() {
		$terms = get_terms(
			array(
				'taxonomy'   => 'body-type',
				'hide_empty' => true,
			)
		);
		if ( ! $terms || is_wp_error( $terms ) ) {
			return [];
		}

		$options = array();
		foreach ( $terms as $term ) {
			$options[ $term->slug ] = $term->name;
		}

		return $options;
	}

	private function get_price_options() {
		$data = auto_listings_search_price_min_max();

		$price_chunks = array_chunk( $data, 2, true );
		$options = [];
		foreach ( $price_chunks as $chunk ) {
			$keys  = array_keys( $chunk );
			$value = $keys[0] . '-' . $keys[1];
			$label = $chunk[ $keys[0] ] . esc_html__( '-', 'auto-listings' ) . $chunk[ $keys[1] ];
			$options[ $value ] = $label;
		}

		return $options;
	}
}