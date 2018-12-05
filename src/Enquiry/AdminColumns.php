<?php
/**
 * Add columns to Enquiry page.
 *
 * @package Auto Listings.
 */

namespace AutoListings\Enquiry;

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
		'listing_title'  => 'listings',
		'listing_seller' => 'sellers',
		'name'           => 'names',
		'email'          => 'emails',
	];

	/**
	 * Add hooks when module is loaded.
	 */
	public function __construct() {
		add_filter( 'manage_listing-enquiry_posts_columns', [ $this, 'columns' ] );
		add_action( 'manage_listing-enquiry_posts_custom_column', [ $this, 'show' ], 10, 2 );

		// sorting.
		add_filter( 'manage_edit-listing-enquiry_sortable_columns', [ $this, 'sortable_columns' ] );
		add_filter( 'request', [ $this, 'orderby_listing' ] );
		add_filter( 'request', [ $this, 'orderby_seller' ] );
		add_filter( 'request', [ $this, 'orderby_name' ] );
		add_filter( 'request', [ $this, 'orderby_email' ] );

		// filtering.
		add_action( 'restrict_manage_posts', [ $this, 'show_filters' ] );
		add_action( 'parse_query', [ $this, 'filter' ] );
	}

	/**
	 * Add columns.
	 *
	 * @param array $columns array of columns.
	 */
	public function columns( $columns ) {
		$post_type = filter_input( INPUT_GET, 'post_type' );
		$post_type = sanitize_text_field( $post_type );

		/* Get taxonomies that should appear in the manage posts table. */
		$taxonomies = get_object_taxonomies( $post_type, 'objects' );
		$taxonomies = wp_filter_object_list( $taxonomies, [ 'show_admin_column' => true ], 'and', 'name' );

		/* Allow to filter the taxonomy columns. */
		$taxonomies = apply_filters( "manage_taxonomies_for_auto_listings_{$post_type}_columns", $taxonomies, $post_type );
		$taxonomies = array_filter( $taxonomies, 'taxonomy_exists' );

		/* Loop through each taxonomy and add it as a column. */
		foreach ( $taxonomies as $taxonomy ) {
			$columns[ 'taxonomy-' . $taxonomy ] = get_taxonomy( $taxonomy )->labels->name;
		}

		$columns['listing'] = __( 'Listing', 'auto-listings' );
		$columns['seller']  = __( 'Seller', 'auto-listings' );
		$columns['name']    = __( 'From Name', 'auto-listings' );
		$columns['email']   = __( 'From Email', 'auto-listings' );

		return $columns;
	}

	/**
	 * Display output of custom columns.
	 *
	 * @param string $column_name Column name.
	 * @param int    $post_id     ID of the currently-listed post.
	 */
	public function show( $column_name, $post_id ) {
		$listing_id = auto_listings_enquiry_meta( 'listing_id', $post_id );

		if ( 'listing' === $column_name ) {
			if ( ! $listing_id ) {
				return;
			}

			echo '<a title="' . esc_html__( 'Edit Listing', 'auto-listings' ) . '" target="_blank" href="' . esc_url( get_edit_post_link( $listing_id ) ) . '">' . esc_html( get_the_title( $listing_id ) ) . ' <span class="dashicons dashicons-external"></span></a><br>';
			echo esc_html( auto_listings_meta( 'displayed_address', $listing_id ) );
		}

		if ( 'seller' === $column_name ) {
			$seller = auto_listings_enquiry_meta( 'listing_seller', $post_id );
			if ( ! $seller ) {
				return;
			}

			echo esc_html( get_the_author_meta( 'display_name', $seller ) );
		}

		if ( 'name' === $column_name ) {
			$name = auto_listings_enquiry_meta( 'name', $post_id );
			if ( ! $name ) {
				return;
			}

			echo esc_html( $name );
		}

		if ( 'email' === $column_name ) {
			$email = auto_listings_enquiry_meta( 'email', $post_id );
			if ( ! $email ) {
				return;
			}

			echo esc_html( $email );
		}
	}

	/**
	 * Sortable columns.
	 *
	 * @param array $columns array of columns.
	 */
	public function sortable_columns( $columns ) {
		$columns['listing'] = 'listing_title';
		$columns['seller']  = 'listing_seller';
		$columns['name']    = 'name';
		$columns['email']   = 'email';
		return $columns;
	}

	/**
	 * Order by status.
	 *
	 * @param array $vars query vars.
	 */
	public function orderby_listing( $vars ) {
		if ( isset( $vars['orderby'] ) && 'listing' === $vars['orderby'] ) {
			$vars = array_merge(
				$vars,
				[
					'meta_key' => '_al_enquiry_listing_title',
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
					'meta_key' => '_al_enquiry_listing_seller',
					'orderby'  => 'meta_value',
				]
			);
		}
		return $vars;
	}

	/**
	 * Order by name.
	 *
	 * @param array $vars query vars.
	 */
	public function orderby_name( $vars ) {
		if ( isset( $vars['orderby'] ) && 'name' === $vars['orderby'] ) {
			$vars = array_merge(
				$vars,
				[
					'meta_key' => '_al_enquiry_name',
					'orderby'  => 'meta_value',
				]
			);
		}
		return $vars;
	}

	/**
	 * Order by email.
	 *
	 * @param array $vars query vars.
	 */
	public function orderby_email( $vars ) {
		if ( isset( $vars['orderby'] ) && 'email' === $vars['orderby'] ) {
			$vars = array_merge(
				$vars,
				[
					'meta_key' => '_al_enquiry_email',
					'orderby'  => 'meta_value',
				]
			);
		}
		return $vars;
	}

	/**
	 * Output the filters
	 */
	public function show_filters() {
		global $pagenow;
		$type = get_post_type() ? get_post_type() : 'listing-enquiry';
		if ( isset( $_GET['post_type'] ) ) {
			$type = sanitize_text_field( $_GET['post_type'] );
		}

		// only add filter to post type you want.
		if ( 'listing-enquiry' === $type && is_admin() && 'edit.php' === $pagenow ) {

			$fields = $this->build_fields();
			if ( $fields ) {

				foreach ( $fields as $field => $values ) {
					asort( $values ); // sort our values.
					$values = array_unique( $values ); // make them unique.

					?>
					<select name='<?php echo esc_attr( $field ); ?>' id='<?php echo esc_attr( $field ); ?>' class='postform'>
						<option value=''>
							<?php
							/* translators: field value. */
							echo wp_kses_post( sprintf( __( 'Show all %s', 'auto-listings' ), $field ) );
							?>
						</option>

						<?php
						foreach ( $values as $val => $text ) :
							$text = 'sellers' === $field ? get_the_author_meta( 'display_name', $val ) : $text;
							if ( empty( $val ) ) {
								continue;
							}
							?>
							<option value="<?php echo esc_attr( $val ); ?>" <?php ( isset( $_GET[ $field ] ) ) ? selected( $_GET[ $field ], $val ) : ''; ?>><?php echo esc_html( $text ); ?></option>

						<?php endforeach; ?>

					</select>

					<?php
					reset( $values );
				}
			}
		}
	}

	/**
	 * Build the dropdown field values for the filtering
	 */
	private function build_fields() {
		$fields = '';

		// The Query args.
		$args = [
			'post_type'      => 'listing-enquiry',
			'posts_per_page' => '-1',
			'post_status'    => 'publish',
		];

		$listings = new \WP_Query( $args );

		if ( $listings->posts ) {
			$fields = [];
			foreach ( $listings->posts as $listing ) {
				foreach ( $this->filter_fields as $field => $text ) {
					$val                     = auto_listings_enquiry_meta( $field, $listing->ID );
					$fields[ $text ][ $val ] = $val;
				}
			}
		}

		/* Restore original Post Data */
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
		$type = get_post_type() ? get_post_type() : 'listing-enquiry';
		if ( isset( $_GET['post_type'] ) ) {
			$type = sanitize_text_field( $_GET['post_type'] );
		}
		if ( 'listing-enquiry' !== $type || ! is_admin() || 'edit.php' !== $pagenow ) {
			return;
		}

		foreach ( $this->filter_fields as $field => $text ) {
			if ( isset( $_GET[ $text ] ) && '' !== $_GET[ $text ] ) {
				$query->query_vars['meta_key']   = '_al_enquiry_' . $field;
				$query->query_vars['meta_value'] = sanitize_text_field( $_GET[ $text ] );
			}
		}
	}
}
