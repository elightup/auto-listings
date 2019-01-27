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
$state = auto_listings_get_state();
$state_ouput = sprintf( '<span class="state" style="font-size: 30px; font-weight: bold; color: %s">%s</span>', esc_attr( $state['text_color'] ), esc_html( $state['state'] ) );

if ( empty( $state ) ) : ?>
	<span class="price"><?php echo auto_listings_price( $price ); // wpcs xss: ok. ?></span>
<?php else : ?>
	<span class="state" style="font-size: 30px; font-weight: bold; color: <?php echo esc_attr( $state['text_color'] ); ?>"><?php echo esc_html( $state['state'] ); ?></span>
<?php
endif;
