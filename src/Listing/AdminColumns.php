<?php
/**
 * Add columns to Listings page.
 *
 * @package Auto Listings.
 */

namespace AutoListings\Listing;

/**
 * Admin Columns class.
 */
class AdminColumns {

	/**
	 * Filter fields.
	 *
	 * @var $filter_fields.
	 */
	public $filter_fields = [
		'status'    => 'statuses',
		'seller'    => 'sellers',
		'condition' => 'conditions',
	];

	/**
	 * Add hooks when module is loaded.
	 */
	public function __construct() {
		add_filter( 'manage_auto-listing_posts_columns', [ $this, 'columns' ] );
		add_action( 'manage_auto-listing_posts_custom_column', [ $this, 'show' ], 10, 2 );

		// sorting.
		add_filter( 'manage_edit-auto-listing_sortable_columns', [ $this, 'sortable_columns' ] );
		add_filter( 'request', [ $this, 'orderby_status' ] );
		add_filter( 'request', [ $this, 'orderby_seller' ] );
		add_filter( 'request', [ $this, 'orderby_price' ] );

		// filtering.
		add_action( 'restrict_manage_posts', [ $this, 'output_filters' ] );
		add_action( 'parse_query', [ $this, 'filter' ] );
	}

	/**
	 * Add columns.
	 *
	 * @param array $columns array of columns.
	 */
	public function columns( $columns ) {
		$columns['vehicle']   = __( 'Vehicle', 'auto-listings' );
		$columns['price']     = __( 'Price', 'auto-listings' );
		$columns['condition'] = __( 'Condition', 'auto-listings' );
		$columns['status']    = __( 'Status', 'auto-listings' );
		$columns['seller']    = __( 'Seller', 'auto-listings' );
		$columns['address']   = __( 'Address', 'auto-listings' );
		$columns['enquiries'] = __( 'Enquiries', 'auto-listings' );

		return $columns;
	}

	/**
	 * Display output of custom columns.
	 *
	 * @param string $column_name Column name.
	 * @param int    $post_id     ID of the currently-listed post.
	 */
	public function show( $column_name, $post_id ) {
		if ( 'status' === $column_name ) {
			$status = auto_listings_meta( 'status', $post_id );
			if ( ! $status ) {
				return;
			}
			echo '<span class="btn status ' . esc_attr( strtolower( $status ) ) . '">' . esc_html( $status ) . '</div>';
		}

		if ( 'seller' === $column_name ) {
			$seller_id = auto_listings_meta( 'seller', $post_id );
			$seller    = get_the_author_meta( 'display_name', $seller_id );
			if ( ! $seller || ! $seller_id ) {
				return;
			}
			echo esc_html( $seller );
		}

		if ( 'condition' === $column_name ) {
			echo esc_html( rwmb_the_value( '_al_listing_condition', '', $post_id, false ) );
		}

		if ( 'vehicle' === $column_name ) {
			echo auto_listings_year_make_model() . '<br>'; // wpcs xss: ok.
			if ( has_term( '', 'body-type' ) ) {
				?>
				<i class="auto-icon-trunk"></i> <?php echo get_the_term_list( get_the_ID(), 'body-type', '', ', ' ); ?>
				<?php
			}
		}

		if ( 'price' === $column_name ) {
			$price = auto_listings_meta( 'price', $post_id );
			echo auto_listings_price( $price ); // wpcs xss: ok.
		}

		if ( 'address' === $column_name ) {
			$address = auto_listings_meta( 'displayed_address', $post_id );
			if ( ! $address ) {
				return;
			}
			echo esc_html( $address );
		}

		if ( 'enquiries' === $column_name ) {
			$enquiries = auto_listings_meta( 'enquiries', $post_id );
			$count     = ! empty( $enquiries ) ? count( $enquiries ) : 0;
			if ( $count > 0 ) {
				echo '<a href="' . esc_url( admin_url( 'edit.php?post_type=listing-enquiry' ) ) . '"><span>' . esc_html( $count ) . '</a></span>';
			} else {
				echo '—';
			}
		}
	}

	/**
	 * Sortable columns.
	 *
	 * @param array $columns array of columns.
	 */
	public function sortable_columns( $columns ) {
		$columns['status']    = 'status';
		$columns['condition'] = 'condition';
		$columns['seller']    = 'seller';
		$columns['price']     = 'price';
		return $columns;
	}

	/**
	 * Order by status.
	 *
	 * @param array $vars query vars.
	 */
	public function orderby_status( $vars ) {
		if ( isset( $vars['orderby'] ) && 'status' === $vars['orderby'] ) {
			$vars = array_merge(
				$vars,
				[
					'meta_key' => '_al_listing_status',
					'orderby'  => 'meta_value',
				]
			);
		}
		return $vars;
	}

	/**
	 * Order by condition.
	 *
	 * @param array $vars query vars.
	 */
	public function orderby_condition( $vars ) {
		if ( isset( $vars['orderby'] ) && 'condition' === $vars['orderby'] ) {
			$vars = array_merge(
				$vars,
				[
					'meta_key' => '_al_listing_condition',
					'orderby'  => 'meta_value',
				]
			);
		}
		return $vars;
	}

	/**
	 * Order by seller.
	 *
	 * @param array $vars query vars.
	 */
	public function orderby_seller( $vars ) {
		if ( isset( $vars['orderby'] ) && 'seller' === $vars['orderby'] ) {
			$vars = array_merge(
				$vars,
				[
					'meta_key' => '_al_listing_seller',
					'orderby'  => 'meta_value',
				]
			);
		}
		return $vars;
	}

	/**
	 * Order by price.
	 *
	 * @param array $vars query vars.
	 */
	public function orderby_price( $vars ) {
		if ( isset( $vars['orderby'] ) && 'price' === $vars['orderby'] ) {
			$vars = array_merge(
				$vars,
				[
					'meta_key' => '_al_listing_price',
					'orderby'  => 'meta_value',
				]
			);
		}
		return $vars;
	}

	/**
	 * Output the filters
	 */
	public function output_filters() {
		global $pagenow;
		$type = get_post_type() ? get_post_type() : 'auto-listing';
		if ( isset( $_GET['post_type'] ) ) {
			$type = sanitize_text_field( $_GET['post_type'] );
		}
		if ( 'auto-listing' !== $type || ! is_admin() || 'edit.php' !== $pagenow ) {
			return;
		}

		$fields = $this->build_fields();

		if ( ! $fields ) {
			return;
		}

		foreach ( $fields as $field => $values ) {
			asort( $values ); // sort our values.
			$values = array_unique( $values ); // make them unique.
			$values = array_filter( $values ); // remove empties.

			$selected = isset( $_GET[ $field ] ) ? $_GET[ $field ] : '';
			?>
			<select name='<?php echo esc_attr( $field ); ?>' id='<?php echo esc_attr( $field ); ?>' class='postform'>

				<option value=''>
					<?php
					/* translators: field value. */
					printf( esc_html__( 'All %s', 'auto-listings' ), esc_html( $field ) );
					?>
				</option>

				<?php foreach ( $values as $val => $text ) : ?>
					<?php $text = 'sellers' === $field ? get_the_author_meta( 'display_name', $val ) : $text; ?>
					<option value="<?php echo esc_attr( $val ); ?>" <?php selected( $selected, $val ); ?>><?php echo esc_html( $text ); ?></option>
				<?php endforeach; ?>

			</select>
			<?php
			reset( $values );
		}
	}

	/**
	 * Build the dropdown field values for the filtering
	 */
	private function build_fields() {
		$fields = '';

		// The Query args.
		$args = [
			'post_type'      => 'auto-listing',
			'posts_per_page' => '-1',
			'post_status'    => 'publish',
		];

		$query = new \WP_Query( $args );

		if ( $query->posts ) {
			$fields = [];
			foreach ( $query->posts as $listing ) {
				foreach ( $this->filter_fields as $field => $text ) {
					$val                     = auto_listings_meta( $field, $listing->ID );
					$fields[ $text ][ $val ] = $val;
				}
			}
		}

		wp_reset_postdata();
		return $fields;
	}

	/**
	 * Filter the query
	 *
	 * @param WP_Query $query the query object.
	 */
	public function filter( $query ) {
		global $pagenow;
		$type = get_post_type() ? get_post_type() : 'auto-listing';
		if ( isset( $_GET['post_type'] ) ) {
			$type = sanitize_text_field( $_GET['post_type'] );
		}
		if ( 'auto-listing' !== $type || ! is_admin() || 'edit.php' !== $pagenow ) {
			return;
		}

		foreach ( $this->filter_fields as $field => $text ) {
			if ( isset( $_GET[ $text ] ) && '' !== $_GET[ $text ] ) {
				$query->query_vars['meta_key']   = '_al_listing_' . $field;
				$query->query_vars['meta_value'] = sanitize_text_field( $_GET[ $text ] );
			}
		}
	}
}
