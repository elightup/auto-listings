<?php
namespace AutoListings\SearchForm\Shortcode;

class Field {
	private $control;
	private $placeholders;
	private $labels;

	public function __construct( $control ) {
		$this->control = $control;

		$this->placeholders = [
			'body_type'    => __( 'All body types', 'auto-listings' ),
			'condition'    => __( 'All conditions', 'auto-listings' ),
			'model_drive'  => __( 'All drive types', 'auto-listings' ),
			'engine'       => __( 'All engines', 'auto-listings' ),
			'fuel_type'    => __( 'All fuel types', 'auto-listings' ),
			'make'         => __( 'All makes', 'auto-listings' ),
			'max_price'    => __( 'All prices', 'auto-listings' ),
			'min_price'    => __( 'All prices', 'auto-listings' ),
			'model'        => __( 'All models', 'auto-listings' ),
			'odometer'     => __( 'All mileages', 'auto-listings' ),
			'price'        => __( 'All prices', 'auto-listings' ),
			'transmission' => __( 'All transmissions', 'auto-listings' ),
			'within'       => __( 'All areas', 'auto-listings' ),
			'the_year'     => __( 'All years', 'auto-listings' ),
		];

		$this->labels = [
			'body_type'    => __( 'Body Type', 'auto-listings' ),
			'condition'    => __( 'Condition', 'auto-listings' ),
			'model_drive'  => __( 'Drive Types', 'auto-listings' ),
			'engine'       => __( 'Engine', 'auto-listings' ),
			'fuel_type'    => __( 'Fuel Type', 'auto-listings' ),
			'make'         => __( 'Make', 'auto-listings' ),
			'max_price'    => __( 'Max Price', 'auto-listings' ),
			'min_price'    => __( 'Min Price', 'auto-listings' ),
			'model'        => __( 'Model', 'auto-listings' ),
			'odometer'     => __( 'Mileage', 'auto-listings' ),
			'price'        => __( 'Price', 'auto-listings' ),
			'transmission' => __( 'Transmission', 'auto-listings' ),
			'within'       => __( 'Within', 'auto-listings' ),
			'the_year'     => __( 'Year', 'auto-listings' ),
		];

		add_shortcode( 'als_field', array( $this, 'render' ) );
	}

	public function render( $atts ) {
		if ( empty( $atts['name'] ) ) {
			return;
		}

		$this->placeholders = apply_filters( 'als_field_placeholders', $this->placeholders );
		$this->labels       = apply_filters( 'als_field_labels', $this->labels );

		$default_label = ! empty( $this->labels[ $atts['name'] ] ) ? $this->labels[ $atts['name'] ] : '';
		$default_placeholder = ! empty( $this->placeholders[ $atts['name'] ] ) ? $this->placeholders[ $atts['name'] ] : '';

		$atts = shortcode_atts(
			apply_filters( 'als_field_shortcode_atts', [
				'name'        => '',
				'type'        => 'select', // 'radio'
				'multiple'    => 'false',
				'disabled'    => 'false',
				'prefix'      => '',
				'suffix'      => '',
				'label'       => $default_label,
				'default'     => '',
				'placeholder' => $default_placeholder,
			] ),
			$atts
		);

		$atts = apply_filters( 'als_field_atts', $atts );

		if ( ! in_array( $atts['name'], array_keys( $this->placeholders ) ) ) {
			return;
		}

		$method = "get_{$atts['name']}_options";

		// TODO: move all functions to get search options to this class.
		// $method = method_exists( $this, $method ) ? $method : 'get_default_options';
		// $options = $this->{$method}();
		$options = [];

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
			case 'within':
				$options = auto_listings_search_within_radius();
				break;
			default:
				$options = $this->get_default_options( $atts['name'] );
			break;
		}

		$options = apply_filters( 'als_field_options', $options, $atts );

		// Insert placeholder option for normal select field
		$placeholder_option = [];
		if ( $atts[ 'multiple' ] === 'false' ) {
			$placeholder_option[''] = $atts['placeholder'];
			$options = $placeholder_option + $options;
		}

		$output = $this->control->render( $options, $atts );

		if ( 'price' === $atts['name'] ) {
			$output .= '<input type="hidden" name="min_price" value="">';
			$output .= '<input type="hidden" name="max_price" value="">';
		}

		return $output;
	}

	private function get_default_options( $name ) {
		switch ( $name ) {
			case 'condition' :
				$data = auto_listings_available_listing_conditions();
				break;
			default:
				$data = auto_listings_search_get_vehicle_data();
				$data = $data[ $name ];
				break;
		}

		if ( ! $data ) {
			return [];
		}

		$options = array();
		if ( $name === 'condition' ) {
			foreach ( $data as $value => $label ) {
				$options[ $value ] = $label;
			}
		} else {
			foreach ( $data as $label ) {
				$options[ $label ] = $label;
			}
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
