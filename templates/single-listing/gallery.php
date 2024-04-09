<?php
/**
 * Single listing gallery
 *
 * This template can be overridden by copying it to yourtheme/listings/single-listing/gallery.php.
 *
 * @package Auto Listings.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

$gallery      = rwmb_meta( '_al_listing_image_gallery', [ 'size' => 'al-lge' ] );
$enable_auto  = auto_listings_option( 'enable_auto' );
$slider_speed = auto_listings_option( 'slider_speed' );

if ( empty( $gallery ) ) {
	return;
}
$new = auto_listings_highlight_new();
?>

<div class="gallery-wrap">

	<?php if ( $new ) : ?>
		<span style="background:<?php echo esc_attr( $new ); ?>;" class="highlight-new">
			<i class="fa fa-star"></i>
			<?php esc_html_e( 'New Listing', 'auto-listings' ); ?>
		</span>
	<?php endif; ?>

	<ul id="image-gallery" data-enable-auto="<?php echo $enable_auto ? 'true' : 'false'; ?>"
		data-slider-speed="<?php echo esc_attr( $slider_speed ); ?>">
		<?php foreach ( $gallery as $image_id => $image ) : ?>
			<?php $sml = wp_get_attachment_image_url( $image_id, 'al-sml' ); ?>
			<li data-thumb="<?php echo esc_url( $sml ); ?>" data-src="<?php echo esc_url( $image['url'] ); ?>">
				<img src="<?php echo esc_url( $image['url'] ); ?>">
			</li>
		<?php endforeach; ?>
	</ul>

</div>