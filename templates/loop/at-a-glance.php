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

?>


<div class="at-a-glance">

	<ul>
		<li class="odomoter"><i class="auto-icon-odometer"></i> <?php echo esc_html( auto_listings_odometer() ); ?></li>
	<?php if ( auto_listings_transmission() ) { ?>
		<li class="transmission"><i class="auto-icon-transmission"></i> <?php echo esc_html( auto_listings_transmission() ); ?></li>
	<?php } ?>
	<?php if ( auto_listings_body_type() ) { ?>
		<li class="body"><i class="auto-icon-trunk"></i> <?php echo auto_listings_body_type(); // wpcs xss: ok. ?></li>
	<?php } ?>
	</ul>

</div>
