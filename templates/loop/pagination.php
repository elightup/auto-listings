<?php
/**
 * Pagination
 *
 * This template can be overridden by copying it to yourtheme/listings/loop/pagination.php.
 *
 * @package Auto Listings.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

global $wp_query;
$query = ( empty( $data->query ) ) ? $wp_query : $data->query ;
if ( $query->max_num_pages <= 1 ) {
	return;
}
?>
<nav class="auto-listings-pagination">
	<?php
	$pagination = paginate_links(
		apply_filters(
			'auto_listings_pagination_args',
			array(
				'base'      => @add_query_arg( 'paged','%#%' ),
				'format'    => '?paged=%#%',
				'mid-size'  => 1,
				'add_args'  => false,
				'current'   => ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1,
				'total'     => $query->max_num_pages,
				'prev_text' => '&larr;',
				'next_text' => '&rarr;',
				'type'      => 'list',
				'end_size'  => 3,
			)
		)
	);
	echo $pagination; // wpcs xss: ok.
	?>
</nav>
