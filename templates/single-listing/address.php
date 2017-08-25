<?php
/**
 * Single listing address
 *
 * This template can be overridden by copying it to yourtheme/listings/single-listing/address.php.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$address = auto_listings_meta( 'displayed_address' );
if( empty( $address ) )
	return;

?>

<div class="address"><strong><?php _e( 'Listing Location:', 'auto-listings' ); ?></strong> <?php echo esc_html( $address ); ?></div>