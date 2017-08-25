<?php
/**
 * Single listing tagline
 *
 * This template can be overridden by copying it to yourtheme/listings/single-listing/tagline.php.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$tagline = auto_listings_meta( 'tagline' );
if( empty( $tagline ) )
	return;
?>

<h3 class="tagline"><?php echo esc_html( $tagline ); ?></h3>