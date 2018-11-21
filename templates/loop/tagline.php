<?php
/**
 * Loop tagline
 *
 * This template can be overridden by copying it to yourtheme/listings/loop/tagline.php.
 *
 * @package Auto Listings.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! has_excerpt() ) {
	return;
}
?>

<h4 class="tagline"><?php the_excerpt(); ?></h4>
