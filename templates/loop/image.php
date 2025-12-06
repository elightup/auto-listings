<?php
/**
 * Loop single image
 *
 * This template can be overridden by copying it to yourtheme/listings/loop/image.php.
 *
 * @package Auto Listings.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

$image          = auto_listings_get_first_image();
$listing_status = auto_listings_get_status();
$new            = auto_listings_highlight_new();
$year           = auto_listings_meta( 'year' );
?>

<div class="listing-card-image">
	<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
		<div class="listing-badges">
			<?php if ( $new ) { ?>
				<span class="listing-badge listing-badge-new">
					<?php esc_html_e( 'New Listing', 'auto-listings' ); ?>
				</span>
			<?php } ?>
			
			<?php if ( $listing_status ) { ?>
				<span
					style="background:<?php echo esc_attr( $listing_status['bg_color'] ); ?>;color:<?php echo esc_attr( $listing_status['text_color'] ); ?>"
					class="listing-badge listing-badge-status <?php echo esc_attr( $listing_status['status'] ); ?>">
					<?php if ( $listing_status['icon'] ) { ?>
						<i class="<?php echo esc_attr( $listing_status['icon'] ); ?>"></i>
					<?php } ?>
					<?php echo esc_html( $listing_status['status'] ); ?>
				</span>
			<?php } ?>

			<?php if ( $year ) { ?>
				<span class="listing-badge listing-badge-year">
					<?php echo esc_html( $year ); ?>
				</span>
			<?php } ?>
		</div>

		<?php
		if ( $image && isset( $image['alt'] ) && isset( $image['sml'] ) ) :
			$image_alt = $image['alt'] ?? '';
			$image_src = $image['sml'] ?? '';
			?>
			<img class="listing-card-img" alt="<?php echo esc_attr( $image_alt ); ?>" src="<?php echo esc_url( $image_src ); ?>" />
		<?php endif; ?>

	</a>
</div>