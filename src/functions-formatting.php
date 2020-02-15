<?php
/**
 * Enqueue scripts and styles on frontend.
 *
 * @package Auto Listings.
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Metric and imperial formatting
 */
function auto_listings_metric() {
	$return = auto_listings_option( 'metric' ) ? auto_listings_option( 'metric' ) : 'yes';
	return $return;
}

/**
 * Listing miles and kms label
 */
function auto_listings_miles_kms_label() {
	$return = auto_listings_metric() === 'no' ? __( 'Miles', 'auto-listings' ) : __( 'Kilometers', 'auto-listings' );
	return $return;
}

/**
 * Short listing miles and kms label
 */
function auto_listings_miles_kms_label_short() {
	$return = auto_listings_metric() === 'no' ? __( 'mi', 'auto-listings' ) : __( 'km', 'auto-listings' );
	return $return;
}

/**
 * Listing per hour unit
 */
function auto_listings_per_hour_unit() {
	$return = auto_listings_metric() === 'yes' ? __( 'mph', 'auto-listings' ) : __( 'kph', 'auto-listings' );
	return $return;
}


/**
 * Run date formatting through here
 *
 * @param string $date date format.
 */
function auto_listings_format_date( $date ) {
	$timestamp = strtotime( $date );
	$date      = date_i18n( get_option( 'date_format' ), $timestamp, false );
	return apply_filters( 'auto_listings_format_date', $date, $timestamp );
}



/**
 * Do we include the decimals
 *
 * @since  1.0.0
 * @return string
 */
function auto_listings_include_decimals() {
	$option = get_option( 'auto_listings_options' );
	$return = isset( $option['include_decimals'] ) ? stripslashes( $option['include_decimals'] ) : 'no';
	return $return;
}

/**
 * Get the price format depending on the currency position.
 *
 * @return string
 */
function auto_listings_format_price_format() {
	$option       = get_option( 'auto_listings_options' );
	$currency_pos = isset( $option['currency_position'] ) ? $option['currency_position'] : 'left';
	$format       = '%1$s%2$s';

	switch ( $currency_pos ) {
		case 'left':
			$format = '%1$s%2$s';
			break;
		case 'right':
			$format = '%2$s%1$s';
			break;
		case 'left_space':
			$format = '%1$s&nbsp;%2$s';
			break;
		case 'right_space':
			$format = '%2$s&nbsp;%1$s';
			break;
	}

	return apply_filters( 'auto_listings_format_price_format', $format, $currency_pos );
}

/**
 * Return the currency_symbol for prices.
 *
 * @since  1.0.0
 * @return string
 */
function auto_listings_currency_symbol() {
	$option = get_option( 'auto_listings_options' );
	$return = isset( $option['currency_symbol'] ) ? stripslashes( $option['currency_symbol'] ) : '$';
	return $return;
}

/**
 * Return the thousand separator for prices.
 *
 * @since  1.0.0
 * @return string
 */
function auto_listings_thousand_separator() {
	$option = get_option( 'auto_listings_options' );
	$return = isset( $option['thousand_separator'] ) ? stripslashes( $option['thousand_separator'] ) : '';
	return $return;
}

/**
 * Return the decimal separator for prices.
 *
 * @since  1.0.0
 * @return string
 */
function auto_listings_decimal_separator() {
	$option = get_option( 'auto_listings_options' );
	$return = isset( $option['decimal_separator'] ) ? stripslashes( $option['decimal_separator'] ) : '.';
	return $return;
}

/**
 * Return the number of decimals after the decimal point.
 *
 * @since  1.0.0
 * @return int
 */
function auto_listings_decimals() {
	$option = get_option( 'auto_listings_options' );
	$return = isset( $option['decimals'] ) ? $option['decimals'] : 2;
	return absint( $return );
}

/**
 * Trim trailing zeros off prices.
 *
 * @param mixed $price listing price.
 * @return string
 */
function auto_listings_trim_zeros( $price ) {
	return preg_replace( '/' . preg_quote( auto_listings_decimal_separator(), '/' ) . '0++$/', '', $price );
}


/**
 * Format the price with a currency symbol.
 *
 * @param float $price listing price.
 * @param array $args (default: array()) format price arguments.
 * @return string
 */
function auto_listings_format_price( $price, $args = array() ) {
	extract(
		apply_filters(
			'auto_listings_format_price_args',
			wp_parse_args(
				$args,
				array(
					'currency_symbol'    => auto_listings_currency_symbol(),
					'decimal_separator'  => auto_listings_decimal_separator(),
					'thousand_separator' => auto_listings_thousand_separator(),
					'decimals'           => auto_listings_decimals(),
					'price_format'       => auto_listings_format_price_format(),
					'include_decimals'   => auto_listings_include_decimals(),
				)
			)
		)
	);

	$return   = null;
	$negative = $price < 0;
	$price    = apply_filters( 'auto_listings_raw_price', floatval( $negative ? $price * -1 : $price ) );
	$price    = apply_filters( 'auto_listings_formatted_price', number_format( $price, $decimals, $decimal_separator, $thousand_separator ), $price, $decimals, $decimal_separator, $thousand_separator );

	if ( 'no' === $include_decimals ) {
		$price = auto_listings_trim_zeros( $price );
	}

	$formatted_price = ( $negative ? '-' : '' ) . sprintf( $price_format, '<span class="currency-symbol">' . $currency_symbol . '</span>', $price );
	$return          = '<span class="price-amount">' . $formatted_price . '</span>';
	return apply_filters( 'auto_listings_format_price', $return, $price, $args );
}

/**
 * Format the price with a currency symbol.
 *
 * @param float $price Listing price.
 *
 * @return string
 */
function auto_listings_raw_price( $price ) {
	return wp_strip_all_tags( auto_listings_format_price( $price ) );
}
