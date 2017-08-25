<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;


function auto_listings_spec_fields() {

	//$option = auto_listings_option( '' );

	$spec_fields = array(

		'model_year' => array( 
			'label' => __( 'Year', 'auto-listings' ),
			'type' => 'model',
			'desc' => __( ' (Recommended)', 'auto-listings' ),
		),
		'make_display' => array( 
			'label' => __( 'Make', 'auto-listings' ),
			'type' => 'general',
			'desc' => __( ' (Recommended)', 'auto-listings' ),
		),
		'model_name' => array( 
			'label' => __( 'Model', 'auto-listings' ),
			'type' => 'model',
			'desc' => __( ' (Recommended)', 'auto-listings' ),
		),
		'model_vehicle' => array( 
			'label' => __( 'Vehicle', 'auto-listings' ),
			'type' 	=> 'model',
			'desc' => __( ' (Recommended)', 'auto-listings' ),
		),
		'model_seats' => array( 
			'label' => __( 'Seats', 'auto-listings' ),
			'type' => 'general',
			'desc' => __( ' (Recommended)', 'auto-listings' ),
		),
		'model_doors' => array( 
			'label' => __( 'Doors', 'auto-listings' ),
			'type' => 'general',
			'desc' => __( ' (Recommended)', 'auto-listings' ),
		),

		// transmission
		'model_drive' => array( 
			'label' => __( 'Drive Type', 'auto-listings' ),
			'type' => 'transmission',
			'desc' => __( ' (Recommended)', 'auto-listings' ),
		),
		'model_transmission_type' => array( 
			'label' => __( 'Transmission Type', 'auto-listings' ),
			'type' => 'transmission',
			'desc' => __( ' (Recommended)', 'auto-listings' ),
		),

		// fuel
		'model_engine_fuel' => array( 
			'label' => __( 'Fuel Type', 'auto-listings' ),
			'type' => 'fuel',
			'desc' => __( ' (Recommended)', 'auto-listings' ),
		),

	);

	$metric_fields = array(
		// fuel
		'model_lkm_hwy' => array( 
			'label' => __( 'Fuel Economy Highway (l/100km)', 'auto-listings' ),
			'type' => 'fuel',
		),
		'model_lkm_mixed' => array( 
			'label' => __( 'Fuel Economy Mixed (l/100km)', 'auto-listings' ),
			'type' => 'fuel',
		),
		'model_lkm_city' => array( 
			'label' => __( 'Fuel Economy City (l/100km)', 'auto-listings' ),
			'type' => 'fuel',
		),
		'model_fuel_cap_l' => array( 
			'label' => __( 'Fuel Capacity (l):', 'auto-listings' ),
			'type' => 'fuel',
		),

		// dimensions
		'model_weight_kg' => array( 
			'label' => __( 'Weight (kg)', 'auto-listings' ),
			'type' => 'weight_dimensions',
		),
		'model_length_mm' => array( 
			'label' => __( 'Length (mm)', 'auto-listings' ),
			'type' => 'weight_dimensions',
		),
		'model_width_mm' => array( 
			'label' => __( 'Width (mm)', 'auto-listings' ),
			'type' => 'weight_dimensions',
		),
		'model_height_mm' => array( 
			'label' => __( 'Height (mm)', 'auto-listings' ),
			'type' => 'weight_dimensions',
		),
		'model_wheelbase_mm' => array( 
			'label' => __( 'Wheelbase (mm)', 'auto-listings' ),
			'type' => 'weight_dimensions',
		),

		// performance
		'model_0_to_100_kph' => array( 
			'label' => __( '0-100 kph', 'auto-listings' ),
			'type' => 'performance',
		),
		'model_top_speed_kph' => array( 
			'label' => __( 'Top Speed (KPH)', 'auto-listings' ),
			'type' => 'performance',
		),

		// engine
		'model_engine_cc' => array( 
			'label' => __( 'Engine Displacement (cc)', 'auto-listings' ),
			'type' => 'engine',
		),
		
		
	);

	$imperial_fields = array(
		// fuel
		'model_mpg_hwy' => array( 
			'label' => __( 'Fuel Economy Highway (mpg)', 'auto-listings' ),
			'type' => 'fuel',
		),
		'model_mpg_city' => array( 
			'label' => __( 'Fuel Economy City (mpg)', 'auto-listings' ),
			'type' => 'fuel',
		),
		'model_mpg_mixed' => array( 
			'label' => __( 'Fuel Economy Mixed (mpg)', 'auto-listings' ),
			'type' => 'fuel',
		),
		'model_fuel_cap_g' => array( 
			'label' => __( 'Fuel Capacity (g)', 'auto-listings' ),
			'type' => 'fuel',
		),

		// dimensions
		'model_weight_lbs' => array( 
			'label' => __( 'Weight (lbs)', 'auto-listings' ),
			'type' => 'weight_dimensions',
		),
		'model_length_in' => array( 
			'label' => __( 'Length (in)', 'auto-listings' ),
			'type' => 'weight_dimensions',
		),
		'model_width_in' => array( 
			'label' => __( 'Width (in)', 'auto-listings' ),
			'type' => 'weight_dimensions',
		),
		'model_height_in' => array( 
			'label' => __( 'Height (in)', 'auto-listings' ),
			'type' => 'weight_dimensions',
		),
		'model_wheelbase_in' => array( 
			'label' => __( 'Wheelbase (in)', 'auto-listings' ),
			'type' => 'weight_dimensions',
		),

		// performance
		'model_0_to_100_kph' => array( 
			'label' => __( '0-62 mph', 'auto-listings' ),
			'type' => 'performance',
		),
		'model_top_speed_mph' => array( 
			'label' => __( 'Top Speed (mph)', 'auto-listings' ),
			'type' => 'performance',
		),

		// engine
		'model_engine_ci' => array( 
			'label' => __( 'Engine Displacement (ci)', 'auto-listings' ),
			'type' => 'engine',
		),
	);

	$engine_fields = array(

		// engine
		'model_engine_position' => array( 
			'label' => __( 'Engine Location', 'auto-listings' ),
			'type' => 'engine',
		),
		'model_engine_type' => array( 
			'label' => __( 'Engine Type', 'auto-listings' ),
			'type' => 'engine',	
			'desc' => __( ' (Recommended)', 'auto-listings' ) . '<br>' . __( 'Data from this field is used for the "Engine" icon text', 'auto-listings' ),
		),
		'model_engine_l' => array( 
			'label' => __( 'Engine (l)', 'auto-listings' ),
			'type' => 'engine',
			'desc' => __( ' (Recommended)', 'auto-listings' ) . '<br>' . __( 'Data from this field is used for the "Engine" icon text', 'auto-listings' ),
		),
		'model_engine_cyl' => array( 
			'label' => __( 'Engine Cylinders', 'auto-listings' ),
			'type' => 'engine',
			'desc' => __( ' (Recommended)', 'auto-listings' ) . '<br>' . __( 'Data from this field is used for the "Engine" icon text', 'auto-listings' ),
		),
		'model_engine_valves' => array( 
			'label' => __( 'Engine Valves', 'auto-listings' ),
			'type' => 'engine',
		),
		'model_engine_valves_per_cyl' => array( 
			'label' => __( 'Engine Valves Per Cyl', 'auto-listings' ),
			'type' => 'engine',
		),
		'model_engine_power_hp' => array( 
			'label' => __( 'Engine Max Power (HP)', 'auto-listings' ),
			'type' => 'engine',
		),
		'model_engine_power_kw' => array( 
			'label' => __( 'Engine Max Power (kW)', 'auto-listings' ),
			'type' => 'engine',
		),
		'model_engine_power_ps' => array( 
			'label' => __( 'Engine Max Power (PS)', 'auto-listings' ),
			'type' => 'engine',
		),
		'model_engine_power_rpm' => array( 
			'label' => __( 'Engine Max Power RPM', 'auto-listings' ),
			'type' => 'engine',
		),
		'model_engine_torque_nm' => array( 
			'label' => __( 'Engine Max Torque (NM)', 'auto-listings' ),
			'type' => 'engine',
		),
		'model_engine_torque_lbft' => array( 
			'label' => __( 'Engine Max Torque (Lb-Ft)', 'auto-listings' ),
			'type' => 'engine',
		),
		'model_engine_torque_kgm' => array( 
			'label' => __( 'Engine Max Torque (kgf-m)', 'auto-listings' ),
			'type' => 'engine',
		),
		'model_engine_torque_rpm' => array( 
			'label' => __( 'Engine Max Torque RPM', 'auto-listings' ),
			'type' => 'engine',
		),
		'model_engine_bore_mm' => array( 
			'label' => __( 'Engine Bore (mm)', 'auto-listings' ),
			'type' => 'engine',
		),
		'model_engine_stroke_mm' => array( 
			'label' => __( 'Engine Stroke (mm)', 'auto-listings' ),
			'type' => 'engine',
		),
		'model_engine_compression' => array( 
			'label' => __( 'Engine Compression Ratio', 'auto-listings' ),
			'type' => 'engine',
		),
		
		'make_country' => array( 
			'label' => __( 'Country', 'auto-listings' ),
			'type' => 'general',
		),

	);

	$fields = array_merge( $spec_fields, $metric_fields, $imperial_fields, $engine_fields );

	return $fields;

}
function auto_listings_get_specs_for_output(){

	$fields 		= array();
	$spec_fields 	= auto_listings_spec_fields();
	$display 		= auto_listings_option( 'field_display' );

	// loop through all our fields
	foreach ( $spec_fields as $id => $value ) {

		// skip the ones we don't want to show
		if( is_array( $display ) && ! in_array( $id, $display ) )
			continue;

		$val = auto_listings_meta( $id );
		if( ! $val )
			continue;

		$label = str_replace( ' *', '', $value['label']);
		$fields[ $label ] = $val;
	}
	
	return $fields;

}

/**
 * Post classes for listings.
 */
function auto_listings_listing_post_class( $classes, $class = '', $post_id = '' ) {
	
	if ( ! $post_id || 'auto-listing' !== get_post_type( $post_id ) ) {
		return $classes;
	}

	$listing = get_post( $post_id );

	if ( $listing ) {

		$classes[] = 'auto-listing';
		$classes[] = 'auto-listing-' . $listing->ID;

		$images = auto_listings_meta( 'image_gallery' );
		if ( $images ) {
			foreach ( $images as $key => $url ) {
				if( ! empty( $url ) ) {
					$classes[] = strtolower( 'has-thumbnail' );
					break;
				}
			}
		}
	}

	if ( false !== ( $key = array_search( 'hentry', $classes ) ) ) {
		unset( $classes[ $key ] );
	}

	return $classes;
}

/*
 * Show Archive Page title within page content area
 */
function auto_listings_force_page_title() {
	$force = auto_listings_option( 'archives_page_title' ) ? auto_listings_option( 'archives_page_title' ) : 'no';
	return $force;
}

/*
 * Get the URL of the first image of a listing
 */
function auto_listings_get_first_image() {
	
	$gallery = auto_listings_meta( 'image_gallery' );

	if( empty( $gallery ) ) {
		$sml 	= apply_filters( 'auto_listings_default_no_image', AUTOLISTINGS_PLUGIN_URL . 'assets/images/no-image.jpg' );
		$alt 	= '';
	} else {
		$id 	= key( $gallery );
		$sml 	= wp_get_attachment_image_url( $id, 'al-sml' );
		$alt 	= get_post_meta( $id, '_wp_attachment_image_alt', true );
	}	

	return array(
		'alt' => $alt,
		'sml' => $sml,
	);
}

/*
 * Get the listing status
 */
function auto_listings_get_status() {
	
	$listing_status = auto_listings_meta( 'status' );
	$option_status 	= auto_listings_option( 'listing_status' );

	if( ! $listing_status )
		return;

	$status = null;
	if( $option_status ) {
		foreach ($option_status as $key => $value) {
			if( in_array( $listing_status, $value ) ) {
				$status 	= isset( $value['status'] ) ? $value['status'] : null;
				$bg_color 	= isset( $value['bg_color'] ) ? $value['bg_color'] : null;
				$text_color = isset( $value['text_color'] ) ? $value['text_color'] : null;
				$icon 		= isset( $value['icon'] ) ? $value['icon'] : null;
			}
		}
	}

	if( ! $status ){
		$status 	= $listing_status;
		$bg_color 	= '#ffffff';
		$text_color = '#444444';
		$icon 		= '';
	}

	return array(
		'status' 		=> $status,
		'bg_color' 		=> $bg_color,
		'text_color' 	=> $text_color,
		'icon' 	=> $icon,
	);
}

/*
 * Highlight new
 */
function auto_listings_highlight_new() {
	
	$days = auto_listings_option( 'highlight_new_days' );
	if( ! $days )
		return;

	// see if it should still be displayed
	$listed_time 	= get_the_time( 'U' );
	$timestamp 		= strtotime( '+' . $days . ' days', $listed_time );
	if( $timestamp < time() )
		return;

	$color = auto_listings_option( 'highlight_new_color' );
	return $color;

}



/* ======================================================================================
										Template Functions
   ====================================================================================== */

/*
 * Outputs the price HTML
 */
function auto_listings_price( $price = null ) {
	if( ! $price )
		$price = auto_listings_meta( 'price' );
	$suffix = auto_listings_meta( 'price_suffix' );
	return auto_listings_format_price( $price ) . ' ' . $suffix;
}

/*
 * Outputs the vehicle
 */
function auto_listings_vehicle() {
	$output = auto_listings_meta( 'model_vehicle' );
	return $output;
}

/*
 * Outputs the make, model & year
 */
function auto_listings_year_make_model() {
	$year 	= auto_listings_meta( 'model_year' );
	$make 	= auto_listings_meta( 'make_display' );
	$model 	= auto_listings_meta( 'model_name' );
	return $year . ' ' . $make . ' ' . $model;
}

/*
 * Outputs the engine
 */
function auto_listings_engine() {
	$cylinders = auto_listings_meta( 'model_engine_cyl' ) ? auto_listings_meta( 'model_engine_cyl' ) . __( ' cylinder ', 'auto-listings' ) : '';
	$engine_type = auto_listings_meta( 'model_engine_type' ) ? auto_listings_meta( 'model_engine_type' ) . ' ' : '';
	$engine_l = auto_listings_meta( 'model_engine_l' ) ? auto_listings_meta( 'model_engine_l' ) : '';

	if( $cylinders || $engine_type || $engine_l ) {
		$output = $cylinders . $engine_type . $engine_l . 'L';
	} else {
		$output = null;
	}
	return $output;
}

/*
 * Outputs the fuel economy
 */
function auto_listings_fuel_economy() {
	if( auto_listings_metric() == 'yes' ) {
		$output = auto_listings_meta( 'model_lkm_mixed' ) ? auto_listings_meta( 'model_lkm_mixed' ) . __( 'L/km', 'auto-listings' ) : null;
	} else {
		$output = auto_listings_meta( 'model_mpg_mixed' ) ? auto_listings_meta( 'model_mpg_mixed' ) . __( 'mpg', 'auto-listings' ) : null;
	}
	return $output;
}

/*
 * Outputs the fuel economy
 */
function auto_listings_odometer() {
	$odometer = auto_listings_meta( 'odometer' );
	if( ! $odometer ) {
		$output = __( 'n/a', 'auto-listings' );
	} else {
		$output = number_format_i18n( $odometer ) . ' ' . auto_listings_miles_kms_label_short();
	}
	return $output;
}

/*
 * Outputs the transmission
 */
function auto_listings_transmission() {
	$output = auto_listings_meta( 'model_transmission_type' );
	return $output;
}
/*
 * Outputs the drive type
 */
function auto_listings_drive_type() {
	$output = auto_listings_meta( 'model_drive' );
	return $output;
}

/*
 * Outputs a body type link
 */
function auto_listings_body_type() {
	if( has_term( '', 'body-type') ) {
		return get_the_term_list( get_the_ID(), 'body-type', '', ', ' );
	}
}


/*
 * Filter the_content on single listing page.
 * This allows us to add the main_description meta to the_content(),
 * which is good to have in place for other plugins such as sharing plugins.
 */
function auto_listings_filter_the_content( $content ) {
	if( is_listing() ) {
		$description = auto_listings_meta( 'main_description' );
		$content .= wp_kses_post( wpautop( $description ) );
	}	
	return $content;
}
add_filter('the_content', 'auto_listings_filter_the_content', 99 );