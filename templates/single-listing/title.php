<?php
/**
 * Single listing address
 *
 * This template can be overridden by copying it to yourtheme/listings/single-listing/address.php.
 *
 * @package Auto Listings.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

$listing_status = auto_listings_get_status();
$condition      = auto_listings_meta( 'condition' );
?>

<h1 class="title entry-title"><?php the_title(); ?></h1>

<?php if ( $listing_status ) { ?>

	<span style="background:<?php echo esc_attr( $listing_status['bg_color'] ); ?>;color:<?php echo esc_attr( $listing_status['text_color'] ); ?>" class="status <?php echo esc_attr( $listing_status['status'] ); ?>">

		<?php if ( $listing_status['icon'] ) { ?>
			<i class="<?php echo esc_attr( $listing_status['icon'] ); ?>"></i>
		<?php } ?>

		<?php echo esc_html( $listing_status['status'] ); ?>

	</span>

<?php } ?>
