<?php
/**
 * Ordering
 *
 * This template can be overridden by copying it to yourtheme/listings/loop/orderby.php.
 *
 * @package Auto Listings.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

global $wp_query;

if ( 1 === $wp_query->found_posts ) {
	return;
}

$orderby = isset( $_GET['orderby'] ) ? esc_html( $_GET['orderby'] ) : 'date';
$orderby_options = apply_filters(
	'auto_listings_listings_orderby',
	array(
		'date'       => __( 'Newest Listings', 'auto-listings' ),
		'date-old'   => __( 'Oldest Listings', 'auto-listings' ),
		'price'      => __( 'Price (Low to High)', 'auto-listings' ),
		'price-high' => __( 'Price (High to Low)', 'auto-listings' ),
	)
);

?>
<form class="auto-listings-ordering" method="get">

	<div class="select-wrap">
		<select name="orderby" class="orderby">
			<?php foreach ( $orderby_options as $option_id => $name ) : ?>
				<option value="<?php echo esc_attr( $option_id ); ?>" <?php selected( $orderby, $option_id ); ?>><?php echo esc_html( $name ); ?></option>
			<?php endforeach; ?>
		</select>
	</div>
	<?php
	// Keep query string vars intact.
	foreach ( $_GET as $key => $val ) {

		if ( 'orderby' === $key || 'submit' === $key ) {
			continue;
		}
		if ( is_array( $val ) ) {
			foreach ( $val as $inner_val ) {
				echo '<input type="hidden" name="' . esc_attr( $key ) . '[]" value="' . esc_attr( $inner_val ) . '" />';
			}
		} else {
			echo '<input type="hidden" name="' . esc_attr( $key ) . '" value="' . esc_attr( $val ) . '" />';
		}
	}
	?>

</form>
