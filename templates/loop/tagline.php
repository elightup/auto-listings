<?php
/**
 * Loop tagline
 *
 * This template can be overridden by copying it to yourtheme/listings/loop/tagline.php.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$tagline = auto_listings_meta( 'tagline' );
if( empty( $tagline ) )
	return;
?>

<h4 class="tagline"><?php echo esc_html( $tagline ); ?></h4>