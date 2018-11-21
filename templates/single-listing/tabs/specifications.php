<?php
/**
 * Specifications tab
 *
 * This template can be overridden by copying it to yourtheme/listings/single-listing/tabs/specifications.php.
 *
 * @package Auto Listings.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

$specs = auto_listings_get_specs_for_output();
$specs = apply_filters( 'auto_listings_specs_for_output', $specs );

if ( ! $specs || empty( $specs ) ) {
	return;
}

$heading = apply_filters( 'auto_listings_specifications_heading', __( 'Specifications', 'auto-listings' ) );

?>

<?php if ( $heading ) : ?>
	<h4><?php echo esc_html( $heading ); ?></h4>
<?php endif; ?>


<table class="table table-striped">
	<tbody>

		<?php foreach ( $specs as $field => $value ) { ?>
			<tr>
				<th><?php echo esc_html( $field ); ?></th>
				<td><?php echo wp_kses_post( $value ); ?></td>
			</tr>

		<?php } ?>

	</tbody>
</table>
