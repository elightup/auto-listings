<?php
/**
 * The Template for displaying all single listings
 *
 * This template can be overridden by copying it to yourtheme/listings/single-listing.php.
 *
 * @package Auto Listings.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header( 'listings' );

	/**
	 * @hooked auto_listings_output_content_wrapper (outputs opening divs for the content)
	 */
	do_action( 'auto_listings_before_main_content' ); ?>

		<?php

		while ( have_posts() ) :

			the_post();

			auto_listings_get_part( 'content-single-listing.php' );

		endwhile;

		?>

	<?php
	/**
	 * @hooked auto_listings_output_content_wrapper_end (outputs closing divs for the content)
	 */
	do_action( 'auto_listings_after_main_content' );


get_footer( 'listings' );
