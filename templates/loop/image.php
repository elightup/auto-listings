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
?>

<div class="image">
	<a href="<?php echo esc_url( get_permalink() ); ?>" title="<?php echo esc_attr( get_the_title() ); ?>">
		<?php if ( $listing_status ) { ?>
			<span
				style="background:<?php echo esc_attr( $listing_status['bg_color'] ); ?>;color:<?php echo esc_attr( $listing_status['text_color'] ); ?>"
				class="status <?php echo esc_attr( $listing_status['status'] ); ?>">
				<?php if ( $listing_status['icon'] ) { ?>
					<i class="<?php echo esc_attr( $listing_status['icon'] ); ?>"></i>
				<?php } ?>
				<?php echo esc_html( $listing_status['status'] ); ?>
			</span>
		<?php } ?>

		<?php if ( $new ) { ?>
			<span style="background:<?php echo esc_attr( $new ); ?>;" class="highlight-new">
				<i class="fa fa-star"></i>
				<?php esc_html_e( 'New Listing', 'auto-listings' ); ?>
			</span>
		<?php } ?>

		<?php if ( $image && isset ( $image['alt'] ) && isset ( $image['sml'] ) ) {
			$image_alt = is_string( $image['alt'] ) ? esc_attr( $image['alt'] ) : '';
			$image_src = is_string( $image['sml'] ) ? esc_url( $image['sml'] ) : '';
			var_dump( $image_alt );
			var_dump( $image_src );
			?>
			<img alt="<?php echo $image_alt; ?>" src="<?php echo $image_src; ?>" />
		<?php } ?>
		<!-- <img alt="< ?php echo esc_attr( $image['alt'] ); ?>" src="< ?php echo esc_url( $image['sml'] ); ?>" /> -->

	</a>
</div>