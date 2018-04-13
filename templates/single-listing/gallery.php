<?php
/**
 * Single listing gallery
 *
 * This template can be overridden by copying it to yourtheme/listings/single-listing/gallery.php.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$gallery = rwmb_meta( '_al_listing_image_gallery', [ 'size' => 'al-lge' ] );
if ( empty( $gallery ) ) {
	return;
}
$new = auto_listings_highlight_new();
?>

<div class="gallery-wrap">

	<?php if ( $new ) : ?>
		<span style="background:<?= esc_attr( $new ); ?>;" class="highlight-new">
			<i class="fa fa-star"></i> <?php _e( 'New Listing', 'auto-listings' ); ?>
		</span>
	<?php endif; ?>

	<ul id="image-gallery">
		<?php foreach ( $gallery as $id => $image ) : ?>
			<?php $sml = wp_get_attachment_image_url( $id, 'al-sml' ); ?>
			<li data-thumb="<?= esc_url( $sml ); ?>" data-src="<?= esc_url( $image['url'] ); ?>">
				<img src="<?= esc_url( $image['url'] ); ?>">
			</li>
		<?php endforeach; ?>
	</ul>

</div>
