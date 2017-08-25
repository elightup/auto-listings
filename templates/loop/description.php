<?php
/**
 * Loop description
 *
 * This template can be overridden by copying it to yourtheme/listings/loop/description.php.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$description = auto_listings_meta( 'main_description' );
// if no description or if the sidebar is active (purely for space saving)
if( empty( $description ) )
	return;
$trimmed = wp_trim_words( $description, 25, '...' );
?>

<div class="description"><?php echo wp_kses_post( $trimmed ); ?></div>