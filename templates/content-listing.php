<?php
/**
 * The Template for displaying listing content in the single-listing.php template
 *
 * This template can be overridden by copying it to yourtheme/listings/content-single-listing.php.
 *
 * @package Auto Listings.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

$cols = auto_listings_columns();
?>

<li <?php post_class( 'col-' . $cols ); ?>>

	<?php
	/**
	 * @hooked auto_listings_template_loop_image
	 */
	do_action( 'auto_listings_before_listings_loop_item_summary' );
	?>

	<div class="summary">

		<?php

		do_action( 'auto_listings_before_listings_loop_item' );

		/**
		 * @hooked auto_listings_template_loop_title
		 * @hooked auto_listings_template_loop_at_a_glance
		 * @hooked auto_listings_template_loop_address
		 * @hooked auto_listings_template_loop_price
		 * @hooked auto_listings_template_loop_description
		 * @hooked auto_listings_template_loop_bottom
		 */
		do_action( 'auto_listings_listings_loop_item' );

		do_action( 'auto_listings_after_listings_loop_item' );

		?>

	</div>

	<?php do_action( 'auto_listings_after_listings_loop_item_summary' ); ?>

</li>
