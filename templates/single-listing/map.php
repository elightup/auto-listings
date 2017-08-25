<?php
/**
 * Single listing tagline
 *
 * This template can be overridden by copying it to yourtheme/listings/single-listing/tagline.php.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$address = auto_listings_meta( 'displayed_address' );
if( empty( $address ) )
	return;

?>
<div class="map">
	<div id="auto-listings-map" width="500" height="<?php esc_attr_e( auto_listings_map_height() ); ?>" style="height:<?php esc_attr_e( auto_listings_map_height() ); ?>px;"></div>
</div>