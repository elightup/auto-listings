<?php
/**
 * Single listing tagline
 *
 * @package Auto Listings.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

$address = auto_listings_meta( 'displayed_address' );
if ( empty( $address ) ) {
	return;
}

?>
<div class="map">
	<div id="auto-listings-map" width="500" height="<?php echo esc_attr( auto_listings_map_height() ); ?>" style="height:<?php echo esc_attr( auto_listings_map_height() ); ?>px;"></div>
</div>
