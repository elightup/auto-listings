<?php
/**
 * Single listing price
 *
 * This template can be overridden by copying it to yourtheme/listings/single-listing/price.php.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$price = auto_listings_meta( 'price' );
$condition = auto_listings_meta( 'condition' );

?>

<div class="price">
	<h4><?php echo auto_listings_price( $price ); ?></h4>
	 <span class="condition"><?php echo $condition ? esc_html( $condition . __( ' Vehicle', 'auto-listings' ) ) : ''; ?></span>
</div>