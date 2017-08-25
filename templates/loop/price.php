<?php
/**
 * Loop price
 *
 * This template can be overridden by copying it to yourtheme/listings/loop/price.php.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$price = auto_listings_meta( 'price' );
?>

<div class="price"><?php echo auto_listings_price( $price ); ?></div>