<?php
/**
 * Loop price
 *
 * This template can be overridden by copying it to yourtheme/listings/loop/price.php.
 *
 * @package Auto Listings.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

$price = auto_listings_meta( 'price' );
?>
<span class="price"><?php echo auto_listings_price( $price ); // wpcs xss: ok. ?></span>
