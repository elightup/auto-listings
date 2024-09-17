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

$gallery = rwmb_meta( '_al_listing_image_gallery', [ 'size' => 'al-sml' ] );
if ( empty( $gallery ) ) {
	return;
}

$new   = auto_listings_highlight_new();
$auto  = auto_listings_option( 'slider_auto' );
$speed = auto_listings_option( 'slider_speed' );
?>

<div class="gallery-wrap">

	<?php if ( $new ) : ?>
		<span style="background:<?= esc_attr( $new ); ?>;" class="highlight-new">
			<i class="fa fa-star"></i>
			<?php esc_html_e( 'New Listing', 'auto-listings' ); ?>
		</span>
	<?php endif; ?>

	<ul id="image-gallery" data-auto="<?= $auto ? 'true' : 'false'; ?>" data-speed="<?= esc_attr( $speed ); ?>">
		<?php foreach ( $gallery as $image_id => $image ) : ?>
			<li data-thumb="<?= esc_url( $image['url'] ); ?>" data-src="<?= esc_url( $image['full_url'] ); ?>">
				<img src="<?= esc_url( $image['full_url'] ); ?>">
			</li>
		<?php endforeach; ?>
	</ul>

</div>