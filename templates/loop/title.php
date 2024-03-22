<?php
/**
 * Loop title
 *
 * This template can be overridden by copying it to yourtheme/listings/loop/title.php.
 *
 * @package Auto Listings.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

?>

<h3 class="title">
	<a href="<?php echo esc_url( get_permalink() ); ?>" title="<?php echo esc_attr( get_the_title() ); ?>">
		<?php the_title(); ?>
	</a>
</h3>