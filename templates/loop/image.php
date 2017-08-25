<?php
/**
 * Loop single image
 *
 * This template can be overridden by copying it to yourtheme/listings/loop/image.php.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$image 	= auto_listings_get_first_image();
$status = auto_listings_get_status();
$new 	= auto_listings_highlight_new();
?>

<div class="image">
	<a href="<?php esc_url( the_permalink() ); ?>" title="<?php esc_attr( the_title() ); ?>">
		
		<?php if( $status ) { ?>
		<span style="background:<?php echo esc_attr( $status['bg_color'] ); ?>;color:<?php echo esc_attr( $status['text_color'] ); ?>" class="status <?php echo esc_attr( $status['status'] ); ?>">
			<?php if( $status['icon'] ) { ?>
			<i class="<?php echo esc_attr( $status['icon'] ); ?>"></i>
			<?php } ?>
			<?php echo esc_html( $status['status'] ); ?>
		</span>
		<?php } ?>	

		<?php if( $new ) { ?>
		<span style="background:<?php echo esc_attr( $new ); ?>;" class="highlight-new">
			<i class="fa fa-star"></i> <?php _e( 'New Listing', 'auto-listings' ); ?>
		</span>
		<?php } ?>

		<img alt="<?php echo esc_attr( $image['alt'] ); ?>" src="<?php echo esc_url( $image['sml'] ); ?>" />

	</a>
</div>