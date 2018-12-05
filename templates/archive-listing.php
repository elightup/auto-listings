<?php
/**
 * The Template for displaying the listings archive
 *
 * This template can be overridden by copying it to yourtheme/listings/archive-listing.php.
 *
 * @package Auto Listings
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header( 'listings' );

/**
 * @hooked auto_listings_output_content_wrapper (outputs opening divs for the content)
 */
do_action( 'auto_listings_before_main_content' ); ?>

	<div class="full-width upper">
		<?php
		/**
		 * @hooked auto_listings_listing_archive_description (displays any content, including shortcodes, within the main content editor of your chosen listing archive page)
		 */
		do_action( 'auto_listings_archive_page_upper_full_width' );
		?>
	</div>

	<?php if ( is_active_sidebar( 'auto-listings' ) ) : ?>

		<div class="has-sidebar">

	<?php endif; // endif is_active_sidebar. ?>

		<?php
		if ( have_posts() ) :

			/**
			 * @hooked auto_listings_ordering (the ordering dropdown)
			 * @hooked auto_listings_view_switcher (the view switcher)
			 * @hooked auto_listings_pagination (the pagination)
			 */
			do_action( 'auto_listings_before_listings_loop' );

			$cols  = auto_listings_columns();
			$count = 1;
			while ( have_posts() ) :
				the_post();

				// wrapper for our columns.
				if ( 1 === $count % $cols ) {
					echo '<ul class="auto-listings-items">';
				}
					auto_listings_get_part( 'content-listing.php' );

				// wrapper for our columns.
				if ( 0 === $count % $cols ) {
					echo '</ul>';
				}

				$count++;
			endwhile;

			if ( 1 !== $count % $cols ) {
				echo '</ul>';
			}

			/**
			 * @hooked auto_listings_pagination (the pagination)
			 */
			do_action( 'auto_listings_after_listings_loop' );

		else :
			$alert = __( 'Sorry, no listings were found.', 'auto-listings' );
			$alert = apply_filters( 'auto_listings_no_results', $alert );
			?>
			<p class="alert auto-listings-no-results"><?php echo wp_kses_post( $alert ); ?></p>

		<?php endif; // endif have_posts. ?>


	<?php if ( is_active_sidebar( 'auto-listings' ) ) : ?>

		</div><!-- has-sidebar -->

		<div class="sidebar">
			<?php dynamic_sidebar( 'auto-listings' ); ?>
		</div>

	<?php endif; // endif is_active_sidebar. ?>

	<div class="full-width lower">
		<?php do_action( 'auto_listings_archive_page_lower_full_width' ); ?>
	</div>

<?php
/**
 * @hooked auto_listings_output_content_wrapper_end (outputs closing divs for the content)
 */
do_action( 'auto_listings_after_main_content' );


get_footer( 'listings' ); ?>
