<?php
/**
 * Bottom section
 *
 * This template can be overridden by copying it to yourtheme/listings/loop/bottom.php.
 *
 * @package Auto Listings.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
$condition = auto_listings_condition();
?>

<div class="bottom-wrap">
	<a class="al-button" href="<?php esc_url( the_permalink() ); ?>" title="<?php esc_html_e( 'View', 'auto-listings' ); ?> <?php esc_attr( the_title() ); ?>"><?php esc_html_e( 'More Details', 'auto-listings' ); ?> &nbsp; <i class="fa fa-angle-right"></i></a>
	<?php if ( $condition ) { ?>
		<span class="condition"><?php echo esc_html( $condition ) . esc_html__( ' Vehicle', 'auto-listings' ); ?></span>
	<?php } ?>
</div>
