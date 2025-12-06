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
?>

<div class="listing__actions">
	<a class="listing__btn listing__btn-primary" href="<?php the_permalink(); ?>" title="<?php esc_html_e( 'View', 'auto-listings' ); ?> <?php the_title_attribute(); ?>">
		<?php esc_html_e( 'View Details', 'auto-listings' ); ?>
	</a>
	<a class="listing__btn listing__btn-secondary" href="<?php the_permalink(); ?>#contact" title="<?php esc_html_e( 'Contact about', 'auto-listings' ); ?> <?php the_title_attribute(); ?>">
		<?php esc_html_e( 'Contact Us', 'auto-listings' ); ?>
	</a>
</div>
