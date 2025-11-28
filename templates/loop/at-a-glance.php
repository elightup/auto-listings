<?php
/**
 * Single listing at a glance
 *
 * This template can be overridden by copying it to yourtheme/listings/single-listing/at-a-glance.php.
 *
 * @package Auto Listings.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

$odometer     = auto_listings_odometer();
$transmission = auto_listings_transmission();
?>

<div class="listing__details">
	<?php if ( $odometer ) { ?>
		<span class="listing__detail-item"><?php echo esc_html( $odometer ); ?></span>
	<?php } ?>
	<?php if ( $odometer && $transmission ) { ?>
		<span class="listing__detail-separator">•</span>
	<?php } ?>
	<?php if ( $transmission ) { ?>
		<span class="listing__detail-item"><?php echo esc_html( $transmission ); ?></span>
	<?php } ?>
</div>
