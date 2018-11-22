<?php
/**
 * Single listing price
 *
 * This template can be overridden by copying it to yourtheme/listings/single-listing/price.php.
 *
 * @package Auto Listings.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

$price = auto_listings_meta( 'price' );
$condition = auto_listings_meta( 'condition' );

?>

<div class="price">
	<h4><?php echo auto_listings_price( $price ); // wpcs xss: ok. ?></h4>
	 <span class="condition"><?php echo $condition ? esc_html( $condition . __( ' Vehicle', 'auto-listings' ) ) : ''; ?></span>
</div>
