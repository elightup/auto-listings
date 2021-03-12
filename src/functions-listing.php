<?php
/**
 * Listings functions.
 *
 * @package Auto Listings.
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Listings spec fields.
 */
function auto_listings_spec_fields() {
	$spec_fields = [

		'model_year'              => [
			'label' => __( 'Year', 'auto-listings' ),
			'desc'  => __( ' (Recommended)', 'auto-listings' ),
		],
		'make_display'            => [
			'label' => __( 'Make', 'auto-listings' ),
			'desc'  => __( ' (Recommended)', 'auto-listings' ),
		],
		'model_name'              => [
			'label' => __( 'Model', 'auto-listings' ),
			'desc'  => __( ' (Recommended)', 'auto-listings' ),
		],
		'model_vehicle'           => [
			'label' => __( 'Vehicle', 'auto-listings' ),
			'desc'  => __( ' (Recommended)', 'auto-listings' ),
		],
		'model_seats'             => [
			'label' => __( 'Seats', 'auto-listings' ),
			'desc'  => __( ' (Recommended)', 'auto-listings' ),
		],
		'model_doors'             => [
			'label' => __( 'Doors', 'auto-listings' ),
			'desc'  => __( ' (Recommended)', 'auto-listings' ),
		],

		// transmission.
		'model_drive'             => [
			'label' => __( 'Drive Type', 'auto-listings' ),
			'desc'  => __( ' (Recommended)', 'auto-listings' ),
		],
		'model_transmission_type' => [
			'label' => __( 'Transmission Type', 'auto-listings' ),
			'desc'  => __( ' (Recommended)', 'auto-listings' ),
		],

		// fuel.
		'model_engine_fuel'       => [
			'label' => __( 'Fuel Type', 'auto-listings' ),
			'desc'  => __( ' (Recommended)', 'auto-listings' ),
		],

	];

	$metric_fields = [
		// fuel.
		'model_lkm_hwy'       => [
			'label' => __( 'Fuel Economy Highway (l/100km)', 'auto-listings' ),
		],
		'model_lkm_mixed'     => [
			'label' => __( 'Fuel Economy Mixed (l/100km)', 'auto-listings' ),
		],
		'model_lkm_city'      => [
			'label' => __( 'Fuel Economy City (l/100km)', 'auto-listings' ),
		],
		'model_fuel_cap_l'    => [
			'label' => __( 'Fuel Capacity (l):', 'auto-listings' ),
		],

		// dimensions.
		'model_weight_kg'     => [
			'label' => __( 'Weight (kg)', 'auto-listings' ),
		],
		'model_length_mm'     => [
			'label' => __( 'Length (mm)', 'auto-listings' ),
		],
		'model_width_mm'      => [
			'label' => __( 'Width (mm)', 'auto-listings' ),
		],
		'model_height_mm'     => [
			'label' => __( 'Height (mm)', 'auto-listings' ),
		],
		'model_wheelbase_mm'  => [
			'label' => __( 'Wheelbase (mm)', 'auto-listings' ),
		],

		// performance.
		'model_0_to_100_kph'  => [
			'label' => __( '0-100 kph', 'auto-listings' ),
		],
		'model_top_speed_kph' => [
			'label' => __( 'Top Speed (KPH)', 'auto-listings' ),
		],

		// engine.
		'model_engine_cc'     => [
			'label' => __( 'Engine Displacement (cc)', 'auto-listings' ),
		],

	];

	$imperial_fields = [
		// fuel.
		'model_mpg_hwy'       => [
			'label' => __( 'Fuel Economy Highway (mpg)', 'auto-listings' ),
		],
		'model_mpg_city'      => [
			'label' => __( 'Fuel Economy City (mpg)', 'auto-listings' ),
		],
		'model_mpg_mixed'     => [
			'label' => __( 'Fuel Economy Mixed (mpg)', 'auto-listings' ),
		],
		'model_fuel_cap_g'    => [
			'label' => __( 'Fuel Capacity (g)', 'auto-listings' ),
		],

		// dimensions.
		'model_weight_lbs'    => [
			'label' => __( 'Weight (lbs)', 'auto-listings' ),
		],
		'model_length_in'     => [
			'label' => __( 'Length (in)', 'auto-listings' ),
		],
		'model_width_in'      => [
			'label' => __( 'Width (in)', 'auto-listings' ),
		],
		'model_height_in'     => [
			'label' => __( 'Height (in)', 'auto-listings' ),
		],
		'model_wheelbase_in'  => [
			'label' => __( 'Wheelbase (in)', 'auto-listings' ),
		],

		// performance.
		'model_0_to_100_kph'  => [
			'label' => __( '0-62 mph', 'auto-listings' ),
		],
		'model_top_speed_mph' => [
			'label' => __( 'Top Speed (mph)', 'auto-listings' ),
		],

		// engine.
		'model_engine_ci'     => [
			'label' => __( 'Engine Displacement (ci)', 'auto-listings' ),
		],
	];

	$engine_fields = [

		// engine.
		'model_engine_position'       => [
			'label' => __( 'Engine Location', 'auto-listings' ),
		],
		'model_engine_type'           => [
			'label' => __( 'Engine Type', 'auto-listings' ),
			'desc'  => __( ' (Recommended)', 'auto-listings' ) . '<br>' . __( 'Data from this field is used for the "Engine" icon text', 'auto-listings' ),
		],
		'model_engine_l'              => [
			'label' => __( 'Engine (l)', 'auto-listings' ),
			'desc'  => __( ' (Recommended)', 'auto-listings' ) . '<br>' . __( 'Data from this field is used for the "Engine" icon text', 'auto-listings' ),
		],
		'model_engine_cyl'            => [
			'label' => __( 'Engine Cylinders', 'auto-listings' ),
			'desc'  => __( ' (Recommended)', 'auto-listings' ) . '<br>' . __( 'Data from this field is used for the "Engine" icon text', 'auto-listings' ),
		],
		'model_engine_valves'         => [
			'label' => __( 'Engine Valves', 'auto-listings' ),
		],
		'model_engine_valves_per_cyl' => [
			'label' => __( 'Engine Valves Per Cyl', 'auto-listings' ),
		],
		'model_engine_power_hp'       => [
			'label' => __( 'Engine Max Power (HP)', 'auto-listings' ),
		],
		'model_engine_power_kw'       => [
			'label' => __( 'Engine Max Power (kW)', 'auto-listings' ),
		],
		'model_engine_power_ps'       => [
			'label' => __( 'Engine Max Power (PS)', 'auto-listings' ),
		],
		'model_engine_power_rpm'      => [
			'label' => __( 'Engine Max Power RPM', 'auto-listings' ),
		],
		'model_engine_torque_nm'      => [
			'label' => __( 'Engine Max Torque (NM)', 'auto-listings' ),
		],
		'model_engine_torque_lbft'    => [
			'label' => __( 'Engine Max Torque (Lb-Ft)', 'auto-listings' ),
		],
		'model_engine_torque_kgm'     => [
			'label' => __( 'Engine Max Torque (kgf-m)', 'auto-listings' ),
		],
		'model_engine_torque_rpm'     => [
			'label' => __( 'Engine Max Torque RPM', 'auto-listings' ),
		],
		'model_engine_bore_mm'        => [
			'label' => __( 'Engine Bore (mm)', 'auto-listings' ),
		],
		'model_engine_stroke_mm'      => [
			'label' => __( 'Engine Stroke (mm)', 'auto-listings' ),
		],
		'model_engine_compression'    => [
			'label' => __( 'Engine Compression Ratio', 'auto-listings' ),
		],
		'make_country'                => [
			'label' => __( 'Country', 'auto-listings' ),
		],

	];

	$fields = array_merge( $spec_fields, $metric_fields, $imperial_fields, $engine_fields );

	return apply_filters( 'auto_listings_spec_fields', $fields );
}

/**
 * Output the listing specs.
 */
function auto_listings_get_specs_for_output() {
	$fields      = [];
	$spec_fields = auto_listings_spec_fields();
	$display     = auto_listings_option( 'field_display' );

	// loop through all our fields.
	foreach ( $spec_fields as $id => $value ) {
		// skip the ones we don't want to show.
		if ( is_array( $display ) && ! in_array( $id, $display, true ) ) {
			continue;
		}

		$val = auto_listings_meta( $id );
		if ( ! $val ) {
			continue;
		}

		$label            = str_replace( ' *', '', $value['label'] );
		$fields[ $label ] = $val;
	}

	return $fields;
}

/**
 * Post classes for listings.
 *
 * @param array  $classes post class.
 * @param string $class class  name.
 * @param int    $post_id      post ID.
 */
function auto_listings_listing_post_class( $classes, $class = '', $post_id = '' ) {
	if ( ! $post_id || 'auto-listing' !== get_post_type( $post_id ) ) {
		return $classes;
	}

	$listing = get_post( $post_id );

	if ( $listing ) {
		$classes[] = 'auto-listing';
		$classes[] = 'auto-listing-' . $listing->ID;

		$images = get_post_meta( $post_id, '_al_listing_image_gallery', false );
		if ( $images ) {
			$classes[] = strtolower( 'has-thumbnail' );
		}
	}
	$key = array_search( 'hentry', $classes, true );
	if ( false !== $key ) {
		unset( $classes[ $key ] );
	}

	return $classes;
}

/**
 * Get the URL of the first image of a listing
 */
function auto_listings_get_first_image() {
	$gallery = rwmb_meta( '_al_listing_image_gallery', [ 'size' => 'al-sml' ] );

	if ( empty( $gallery ) ) {
		$sml = apply_filters( 'auto_listings_default_no_image', AUTO_LISTINGS_URL . 'assets/images/no-image.jpg' );
		$alt = '';
	} else {
		$image = reset( $gallery );
		$sml   = $image['url'];
		$alt   = $image['alt'];
	}

	return [
		'alt' => $alt,
		'sml' => $sml,
	];
}

/**
 * Get the listing status
 */
function auto_listings_get_status() {
	$listing_status = auto_listings_meta( 'status' );
	$option_status  = auto_listings_option( 'listing_status' );

	if ( ! $listing_status ) {
		return;
	}

	$status = null;
	if ( $option_status ) {
		foreach ( $option_status as $key => $value ) {
			if ( in_array( $listing_status, $value, true ) ) {
				$status     = isset( $value['status'] ) ? $value['status'] : null;
				$bg_color   = isset( $value['bg_color'] ) ? $value['bg_color'] : '#ffffff';
				$text_color = isset( $value['text_color'] ) ? $value['text_color'] : '#444444';
				$icon       = isset( $value['icon'] ) ? $value['icon'] : null;
			}
		}
	}

	if ( ! $status ) {
		$status     = $listing_status;
		$bg_color   = '#ffffff';
		$text_color = '#444444';
		$icon       = '';
	}

	return [
		'status'     => $status,
		'bg_color'   => $bg_color,
		'text_color' => $text_color,
		'icon'       => $icon,
	];
}

/**
 * Get the listing state
 */
function auto_listings_get_state() {
	$listing_state = auto_listings_meta( 'listing_state' );
	$option_state  = auto_listings_option( 'listing_state' );

	if ( ! $listing_state ) {
		return;
	}

	$state = null;
	if ( $option_state ) {
		foreach ( $option_state as $key => $value ) {
			if ( in_array( $listing_state, $value, true ) ) {
				$state      = isset( $value['state'] ) ? $value['state'] : null;
				$text_color = isset( $value['text_color'] ) ? $value['text_color'] : null;
				$hide_price = isset( $value['hide_price'] ) ? $value['hide_price'] : null;
			}
		}
	}

	if ( ! $state ) {
		$state      = $listing_state;
		$text_color = '#444444';
		$hide_price = true;
	}
	return [
		'state'      => $state,
		'text_color' => $text_color,
		'hide_price' => $hide_price,
	];
}

/**
 * Highlight new
 */
function auto_listings_highlight_new() {
	$days = auto_listings_option( 'highlight_new_days' );
	if ( ! $days ) {
		return;
	}

	// see if it should still be displayed.
	$listed_time = get_the_time( 'U' );
	$timestamp   = strtotime( '+' . $days . ' days', $listed_time );
	if ( $timestamp < time() ) {
		return;
	}

	$color = auto_listings_option( 'highlight_new_color' );
	return $color;
}


/*
======================================================================================
									Template Functions
======================================================================================
*/

/**
 * Outputs the price HTML
 *
 * @param string $price Listing Price.
 */
function auto_listings_price( $price = null ) {
	if ( ! $price ) {
		$price = auto_listings_meta( 'price' );
	}
	$state        = auto_listings_get_state();
	$price        = apply_filters( 'auto_listings_filter_price', $price );
	$suffix       = auto_listings_meta( 'price_suffix' );
	$price_output = auto_listings_format_price( $price ) . ' ' . $suffix;
	if ( is_admin() ) {
		return $price_output;
	}
	$state_output = '';
	if ( ! empty( $state ) ) {
		$state_output = '<span class="state" style="color: ' . esc_attr( $state['text_color'] ) . '">' . esc_html( $state['state'] ) . '</span>';
	}
	$output = $state && $state['hide_price'] ? $state_output : $price_output . $state_output;
	return apply_filters( 'auto_listings_price_html', $output );
}

/**
 * Outputs the vehicle
 */
function auto_listings_vehicle() {
	$output = auto_listings_meta( 'model_vehicle' );
	return $output;
}

/**
 * Outputs the make, model & year
 */
function auto_listings_year_make_model() {
	$year  = auto_listings_meta( 'model_year' );
	$make  = auto_listings_meta( 'make_display' );
	$model = auto_listings_meta( 'model_name' );
	return $year . ' ' . $make . ' ' . $model;
}

/**
 * Outputs the engine
 */
function auto_listings_engine() {
	$cylinders   = auto_listings_meta( 'model_engine_cyl' ) ? auto_listings_meta( 'model_engine_cyl' ) . __( ' cylinder ', 'auto-listings' ) : '';
	$engine_type = auto_listings_meta( 'model_engine_type' ) ? auto_listings_meta( 'model_engine_type' ) . ' ' : '';
	$engine_l    = auto_listings_meta( 'model_engine_l' ) ? auto_listings_meta( 'model_engine_l' ) : '';

	if ( $cylinders || $engine_type || $engine_l ) {
		$output = $cylinders . $engine_type . $engine_l . 'L';
	} else {
		$output = null;
	}
	return $output;
}

/**
 * Outputs the fuel economy
 */
function auto_listings_fuel_economy() {
	if ( auto_listings_metric() === 'yes' ) {
		$output = auto_listings_meta( 'model_lkm_mixed' ) ? auto_listings_meta( 'model_lkm_mixed' ) . __( 'L/km', 'auto-listings' ) : null;
	} else {
		$output = auto_listings_meta( 'model_mpg_mixed' ) ? auto_listings_meta( 'model_mpg_mixed' ) . __( 'mpg', 'auto-listings' ) : null;
	}
	return $output;
}

/**
 * Outputs the fuel economy
 */
function auto_listings_odometer() {
	$odometer = auto_listings_meta( 'odometer' );
	if ( ! $odometer ) {
		$output = __( 'n/a', 'auto-listings' );
	} else {
		$output = number_format_i18n( $odometer ) . ' ' . auto_listings_miles_kms_label_short();
	}
	return $output;
}

function auto_listings_condition() {
	$condition_options = auto_listings_conditions();
	$condition         = auto_listings_meta( 'condition' );

	if ( empty( $condition_options[ $condition ] ) ) {
		return '';
	}
	return $condition_options[ $condition ];
}

/**
 * Outputs the transmission
 */
function auto_listings_transmission() {
	$output = auto_listings_meta( 'model_transmission_type' );
	return $output;
}

/**
 * Outputs the drive type
 */
function auto_listings_drive_type() {
	$output = auto_listings_meta( 'model_drive' );
	return $output;
}

/**
 * Outputs a body type link
 */
function auto_listings_body_type() {
	if ( has_term( '', 'body-type' ) ) {
		return get_the_term_list( get_the_ID(), 'body-type', '', ', ' );
	}
}
