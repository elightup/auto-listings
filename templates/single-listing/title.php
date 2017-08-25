<?php
/**
 * Single listing address
 *
 * This template can be overridden by copying it to yourtheme/listings/single-listing/address.php.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$status 	= auto_listings_get_status();
$condition 	= auto_listings_meta( 'condition' );
?>

<h1 class="title entry-title"><?php the_title(); ?></h1>

<?php if( $status ) { ?>

<span style="background:<?php echo esc_attr( $status['bg_color'] ); ?>;color:<?php echo esc_attr( $status['text_color'] ); ?>" class="status <?php echo esc_attr( $status['status'] ); ?>">
	
	<?php if( $status['icon'] ) { ?>
		<i class="<?php echo esc_attr( $status['icon'] ); ?>"></i>
	<?php } ?>

	<?php echo esc_html( $status['status'] ); ?>

</span>

<?php } ?>