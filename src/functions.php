<?php
/**
 * Returns the listing statuses as set in the options.
 *
 * @return array
 */
function auto_listings_available_listing_statuses() {
	$data  = auto_listings_option( 'listing_status' );
	$array = [];
	if ( $data ) {
		foreach ( $data as $d ) {
			$array[ $d['status'] ] = $d['status'];
		}
	}
	return $array;
}

/**
 * Returns the listing conditions as set in the options.
 *
 * @return array
 */
function auto_listings_available_listing_conditions() {
	$data  = auto_listings_option( 'display_condition' );
	$array = [];
	if ( $data ) {
		foreach ( $data as $d ) {
			$array[ $d ] = $d;
		}
	}
	return $array;
}

/**
 * Returns array of all sellers.
 * For use in dropdowns.
 */
function auto_listings_admin_get_sellers( $field ) {
	$args = apply_filters( 'auto_listings_sellers_as_dropdown', [
		'role'         => '',
		'role__in'     => [ 'auto_listings_seller', 'administrator' ],
		'role__not_in' => [],
		'meta_key'     => '',
		'meta_value'   => '',
		'meta_compare' => '',
		'meta_query'   => [],
		'date_query'   => [],
		'include'      => [],
		'exclude'      => [],
		'orderby'      => 'display_name',
		'order'        => 'ASC',
		'offset'       => '',
		'search'       => '',
		'number'       => '',
		'count_total'  => false,
		'fields'       => [ 'display_name', 'ID' ],
		'who'          => '',
	] );

	$sellers = get_users( $args );
	$array   = [ '' => __( 'No Seller', 'auto-listings' ) ];
	if ( $sellers ) {
		foreach ( $sellers as $seller ) {
			$array[ $seller->ID ] = $seller->display_name;
		}
	}

	return $array;
}

/**
 * Returns array of all pages.
 * For use in dropdowns.
 */
function auto_listings_get_pages() {
	$frontpage_id = get_option( 'page_on_front' );

	$args = [
		'sort_order'   => 'asc',
		'sort_column'  => 'post_title',
		'hierarchical' => 1,
		'exclude'      => $frontpage_id,
		'include'      => '',
		'meta_key'     => '',
		'meta_value'   => '',
		'authors'      => '',
		'child_of'     => 0,
		'parent'       => - 1,
		'exclude_tree' => '',
		'number'       => '',
		'offset'       => 0,
		'post_type'    => 'page',
		'post_status'  => 'publish',
	];

	$pages = get_pages( $args );
	$array = [];
	if ( $pages ) {
		foreach ( $pages as $page ) {
			$array[ $page->ID ] = $page->post_title;
		}
	}

	return $array;
}

/**
 * Output the map on the admin edit listing
 *
 * @param  object $field_args Current field args
 * @param  object $field      Current field object
 */
function auto_listings_admin_listing_map( $field_args, $field ) {
	?>
	<div class="cmb-row">
		<div class="cmb-th">&nbsp</div>
		<div class="cmb-td">
			<button id="al-find" type="button" class="al-button button button-small"><?php _e( 'Find', 'auto-listings' ); ?></button>
			<button id="al-reset" type="button" class="al-button button button-small"><?php _e( 'Reset', 'auto-listings' ); ?></button>
		</div>
	</div>

	<div class="cmb-row">
		<div class="cmb-th">&nbsp</div>
		<div class="cmb-td">
			<div class="al-admin-map" style="width: 400px; height: 220px;"></div>
			<p class="cmb2-metabox-description map-desc"><?php _e( 'Modify the marker\'s position by dragging it.', 'auto-listings' ); ?></p>
		</div>
	</div>

	<?php

}

/**
 * Output the archive button.
 */
function auto_listings_admin_listing_status_area() {
	$post_id = 0;
	if ( isset( $_GET['post'] ) ) {
		$post_id = intval( $_GET['post'] );
	} elseif ( isset( $_POST['post_ID'] ) ) {
		$post_id = intval( $_POST['post_ID'] );
	}
	$post_type = get_post_type( $post_id );
	$label     = get_post_type_object( $post_type );
	$enquiries = auto_listings_meta( 'enquiries', $post_id );
	$count     = ! empty( $enquiries ) ? count( $enquiries ) : 0;
	$latest    = is_array( $enquiries ) ? end( $enquiries ) : null;

	// listing enquiries section
	if ( $post_type == 'auto-listing' ) {
		echo '<div class="listing-enquiries">';

		echo '<span class="dashicons dashicons-admin-comments"></span> <a target="_blank" href="' . esc_url( admin_url( 'edit.php?post_type=listing-enquiry&listings=' . get_the_title( $post_id ) ) ) . '"><span>' . sprintf( _n( '%s Enquiry', '%s Enquiries', $count, 'auto-listings' ), $count ) . '</a></span>';

		if ( $latest ) {
			echo '<p class="cmb2-metabox-description most-recent">' . __( 'Most Recent:', 'auto-listings' ) . ' ' . sprintf( _x( '%s ago', '%s = human-readable time difference', 'auto-listings' ), human_time_diff( get_the_date( 'U', $latest ), current_time( 'timestamp' ) ) ) . '</p>';
		}
		echo '</div>';
	}


	if ( 'archive' !== get_post_status( $post_id ) ) {
		// archive button
		$button = ' <button id="archive-item" type="button" class="button button-small">' . sprintf( __( 'Archive This %s', 'auto-listings' ), ucwords( $label->labels->singular_name ) ) . '</button>';

		echo $button;
	} else {
		echo '<div class="archived-text warning">' . sprintf( __( 'This %s is archived.', 'auto-listings' ), $label->labels->singular_name ) . '<br>' . __( 'Hit the Publish button to un-archive it.', 'auto-listings' ) . '</div>';
	}
	?>

	<script type="text/javascript">
		jQuery( function ( $ ) {
			$( "#archive-item" ).on( 'click', function () {
				var btn = $( this );
				var data = {
					'action': 'auto_listings_ajax_archive_item',
					'post_id': <?php echo (int) $post_id; ?>,
					'nonce': '<?php echo wp_create_nonce( 'al-archive-' . $post_id ); ?>',
				};

				$.post( ajaxurl, data, function ( response ) {
					var obj = $.parseJSON( response );

					$( btn ).hide();
					$( btn ).after( '<div class="archived-text ' + obj.result + '">' + obj.string + '</div>' );

					// change the select input to be archived (in case listing is updated after our actions)
					$( '#post-status-display' ).text( '<?php esc_html_e( 'Archived', 'auto-listings' ) ?>' );
				} );
			} );
		} );
	</script>
	<?php
}

// Ajax Handler for archiving a listings
add_action( 'wp_ajax_auto_listings_ajax_archive_item', 'auto_listings_ajax_archive_item' );
function auto_listings_ajax_archive_item() {
	// Get the Post ID
	$post_id   = (int) $_REQUEST['post_id'];
	$post_type = get_post_type( $post_id );
	$label     = get_post_type_object( $post_type );
	$response  = false;

	// Proceed, again we are checking for permissions
	if ( wp_verify_nonce( $_REQUEST['nonce'], 'al-archive-' . $post_id ) ) {
		$updated = wp_update_post( [
			'ID'          => $post_id,
			'post_status' => 'archive',
		] );

		if ( is_wp_error( $updated ) ) {
			$response = false;
		} else {
			$response = true;
		}
	}

	if ( $response == true ) {
		$return = [
			'string' => sprintf( __( 'This %s is now archived.', 'auto-listings' ), $label->labels->singular_name ),
			'result' => 'warning',
		];
	} else {
		$return = [
			'string' => sprintf( __( 'There was an error archiving this %s', 'auto-listings' ), $label->labels->singular_name ),
			'result' => 'error',
		];
	}

	// Whatever the outcome, send the Response back
	echo json_encode( $return );

	// Always exit when doing Ajax
	exit();
}
