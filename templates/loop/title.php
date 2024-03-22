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
	<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
		<?php the_title(); ?>
	</a>
</h3>