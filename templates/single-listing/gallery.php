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

$gallery = rwmb_meta( '_al_listing_image_gallery', [ 'size' => 'al-lge' ] );
if ( empty( $gallery ) ) {
	return;
}

$gallery_options = [
	'gallery_mode'   => auto_listings_option( 'gallery_mode' ) ? auto_listings_option( 'gallery_mode' ) : 'fade',
	'auto_slide'     => auto_listings_option( 'auto_slide' ) === 'no' ? false : true,
	'slide_delay'    => auto_listings_option( 'slide_delay' ) ? auto_listings_option( 'slide_delay' ) : 3000,
	'slide_duration' => auto_listings_option( 'slide_duration' ) ? auto_listings_option( 'slide_duration' ) : 3000,
	'thumbs_shown'   => auto_listings_option( 'thumbs_shown' ) ? auto_listings_option( 'thumbs_shown' ) : 6,
	'thumb_margin'   => auto_listings_option( 'thumb_margin' ) ? auto_listings_option( 'thumb_margin' ) : 10,
];

$new = auto_listings_highlight_new();
?>

<div class="gallery-wrap"
	<?php
	foreach ( $gallery_options as $option_key => $option_value ) {
		printf( ' data-%1s="%2s"', $option_key, $option_value, 'ecar' );
	}
	?>
>

	<?php if ( $new ) : ?>
		<span style="background:<?php echo esc_attr( $new ); ?>;" class="highlight-new">
			<i class="fa fa-star"></i> <?php esc_html_e( 'New Listing', 'auto-listings' ); ?>
		</span>
	<?php endif; ?>

	<ul id="image-gallery">
		<?php foreach ( $gallery as $image_id => $image ) : ?>
			<?php $sml = wp_get_attachment_image_url( $image_id, 'al-sml' ); ?>
			<li data-thumb="<?php echo esc_url( $sml ); ?>" data-src="<?php echo esc_url( $image['url'] ); ?>">
				<img src="<?php echo esc_url( $image['url'] ); ?>">
			</li>
		<?php endforeach; ?>
	</ul>

</div>
