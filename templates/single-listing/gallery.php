<?php
/**
 * Single listing gallery
 *
 * This template can be overridden by copying it to yourtheme/listings/single-listing/gallery.php.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$gallery 	= auto_listings_meta( 'image_gallery' );
$new 		= auto_listings_highlight_new();
if( empty( $gallery ) )
	return;
?>

<div class="gallery-wrap">

	<?php if( $new ) { ?>
	<span style="background:<?php echo esc_attr( $new ); ?>;" class="highlight-new">
		<i class="fa fa-star"></i> <?php _e( 'New Listing', 'auto-listings' ); ?>
	</span>
	<?php } ?>

	<ul id="image-gallery">

		<?php
			foreach ( $gallery as $id => $img_url ) { 

				$img 	= get_post( $id );
				$lge 	= wp_get_attachment_image_url( $id, 'al-lge' );
				$sml 	= wp_get_attachment_image_url( $id, 'al-sml' );

				?>
				<li data-thumb="<?php echo esc_url( $sml ); ?>" data-src="<?php echo esc_url( $lge ); ?>">
			        <img src="<?php echo esc_url( $lge ); ?>" />
			    </li>

				<?php
			} 
		?>

	</ul>

</div>