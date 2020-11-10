<?php
// TODO: bỏ hết các function này, chuyển thành các method của Shortcode.
function auto_listings_search_mileage_max() {
	$miles_kms = auto_listings_miles_kms_label_short();
	$numbers   = array(
		'10000',
		'20000',
		'30000',
		'40000',
		'50000',
		'75000',
		'100000',
		'150000',
		'200000',
	);

	foreach ( $numbers as $val ) {
		// translators: %1 is the mileage value, %2 is the unit.
		$options[ $val ] = sprintf( __( '%1$1s %2$2s or less', 'auto-listings' ), number_format_i18n( $val ), strtolower( $miles_kms ) );
	}

	return apply_filters( 'auto_listings_search_mileage_max', $options );
}

function auto_listings_search_within_radius() {
	$key = auto_listings_option( 'maps_api_key' );
	if ( empty( $key ) ) {
		return [];
	}

	$miles_kms = auto_listings_miles_kms_label_short();
	$numbers   = array(
		'10',
		'20',
		'30',
		'40',
		'50',
		'100',
		'150',
		'250',
		'500',
	);

	foreach ( $numbers as $val ) {
		// translators: %1 is the radius value, %2 is the unit.
		$options[ $val ] = sprintf( __( '%1$1s %2$2s of', 'auto-listings' ), $val, strtolower( $miles_kms ) );
	}

	return apply_filters( 'auto_listings_search_within_radius', $options );
}

function auto_listings_search_price_min_max() {
	$price_range = auto_listings_option( 'price_range' );
	$options = array(
		'3000'   => auto_listings_raw_price( '3000' ),
		'5000'   => auto_listings_raw_price( '5000' ),
		'10000'  => auto_listings_raw_price( '10000' ),
		'15000'  => auto_listings_raw_price( '15000' ),
		'20000'  => auto_listings_raw_price( '20000' ),
		'25000'  => auto_listings_raw_price( '25000' ),
		'30000'  => auto_listings_raw_price( '30000' ),
		'35000'  => auto_listings_raw_price( '35000' ),
		'40000'  => auto_listings_raw_price( '40000' ),
		'45000'  => auto_listings_raw_price( '45000' ),
		'50000'  => auto_listings_raw_price( '50000' ),
		'60000'  => auto_listings_raw_price( '60000' ),
		'80000'  => auto_listings_raw_price( '80000' ),
		'100000' => auto_listings_raw_price( '100000' ),
		'125000' => auto_listings_raw_price( '125000' ),
		'150000' => auto_listings_raw_price( '150000' ),
	);
	$options = empty( $price_range ) ? $options : auto_listings_get_price_from_price_range( $price_range );
	return apply_filters( 'auto_listings_search_price_min_max', $options );
}

function auto_listings_get_price_from_price_range( $price_range ) {
	$prices = explode( ',', $price_range );
	$prices = array_values( $prices );
	sort( $prices );

	$raw_prices = array_map( function( $price ) {
		return auto_listings_raw_price( $price );
	}, $prices );

	$options = array_combine( $prices, $raw_prices );
	return $options;
}

function auto_listings_search_city() {
	$city = auto_listings_option( '_al_listing_city' ) ? auto_listings_option( '_al_listing_city' ) : '';
	return apply_filters( 'auto_listings_search_city', $city );
}

function auto_listings_search_get_vehicle_data() {
	static $data = [];

	if ( $data ) {
		return $data;
	}

	$args = apply_filters(
		'auto_listings_search_get_vehicle_data_args',
		array(
			'post_type'              => 'auto-listing',
			'posts_per_page'         => -1,
			'post_status'            => array( 'publish' ),
			'fields'                 => 'ids',
			'no_found_rows'          => true,
			'update_post_term_cache' => false,
		)
	);
	$items = new WP_Query( $args );

	if ( ! $items->have_posts() ) {
		return [];
	}
	update_postmeta_cache( $items->posts );

	foreach( $items->posts as $id ) {
		$data['the_year'][]     = auto_listings_meta( 'model_year', $id );
		$data['make'][]         = auto_listings_meta( 'make_display', $id );
		$data['model'][]        = auto_listings_meta( 'model_name', $id );
		$data['transmission'][] = auto_listings_meta( 'model_transmission_type', $id );
		$data['model_drive'][]  = auto_listings_meta( 'model_drive', $id );
		$data['engine'][]       = auto_listings_meta( 'model_engine_type', $id );
		$data['fuel_type'][]    = auto_listings_meta( 'model_engine_fuel', $id );
	}

	$data = apply_filters( 'auto_listings_search_get_vehicle_data', $data, $items->posts );

	// remove empties and make unique.
	foreach ( $data as $key => $value ) {
		$data[ $key ] = array_map( 'trim', $data[ $key ] );
		$data[ $key ] = array_filter( $data[ $key ] );
		$data[ $key ] = array_unique( $data[ $key ] );
		if ( 'year' === $key ) {
			rsort( $data[ $key ] );
		} else {
			sort( $data[ $key ] );
		}
	}
	$data['total'] = count( $items->posts );
	return $data;
}

function get_body_type_options() {
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

function get_price_options() {
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
