<?php
/**
 * Register listing statuses.
 *
 * @package Auto Listings.
 */

namespace AutoListings\Listing;

/**
 * Class Assets
 */
class PostStatuses {
	/**
	 * Add hooks when module is loaded.
	 */
	public function __construct() {
		add_action( 'init', [ $this, 'register_post_statuses' ] );
		add_action( 'admin_footer-post.php', [ $this, 'post_screen_js' ] );
		add_action( 'admin_footer-edit.php', [ $this, 'edit_screen_js' ] );
		add_filter( 'display_post_states', [ $this, 'display_post_states' ], 10, 2 );
	}

	/**
	 * Register Listing Status.
	 */
	public function register_post_statuses() {
		register_post_status(
			'archive',
			[
				'label'                     => _x( 'Archive', 'post', 'auto-listings' ),
				'public'                    => false,
				'private'                   => false,
				'exclude_from_search'       => false,
				'show_in_admin_all_list'    => false,
				'show_in_admin_status_list' => true,
				// translators: number of archived listings.
				'label_count'               => _n_noop( 'Archive <span class="count">(%s)</span>', 'Archived <span class="count">(%s)</span>', 'auto-listings' ),
			]
		);
	}

	/**
	 * Add listing status to publish box.
	 */
	public function post_screen_js() {
		global $post;

		if ( 'auto-listing' !== $post->post_type ) {
			return;
		}

		if ( 'draft' !== $post->post_status && 'pending' !== $post->post_status ) {
			?>
			<script>
				jQuery( function ( $ ) {
					$( '#post_status' ).append( '<option value="archive"><?php esc_html_e( 'Archived', 'auto-listings' ); ?></option>' );
				} );
			</script>
			<?php
		}

		if ( 'archive' === $post->post_status ) {
			?>
			<script>
				jQuery( function ( $ ) {
					$( '#post-status-display' ).text( '<?php esc_html_e( 'Archived', 'auto-listings' ); ?>' );
				} );
			</script>
			<?php
		}
	}

	/**
	 * Add listing status to listings edit screen.
	 */
	public function edit_screen_js() {
		global $typenow;

		if ( 'auto-listing' !== $typenow ) {
			return;
		}
		?>
		<script>
			jQuery( function ( $ ) {
				$( 'select[name="_status"]' ).append( '<option value="archive"><?php esc_html_e( 'Archived', 'auto-listings' ); ?></option>' );
				$( '.editinline' ).on( 'click', function () {
					var $row = $( this ).closest( 'tr' ),
						$option = $( '.inline-edit-row' ).find( 'select[name="_status"] option[value="archive"]' ),
						is_archived = $row.hasClass( 'status-archive' );

					$option.prop( 'selected', is_archived );
				} );
			} );
		</script>
		<?php
	}

	/**
	 * Display listing status in table of listings.
	 *
	 * @param array  $post_states post status array.
	 * @param object $post        post object.
	 */
	public function display_post_states( $post_states, $post ) {
		if (
			'auto-listing' !== $post->post_type ||
			'archive' !== $post->post_status ||
			'archive' === get_query_var( 'post_status' )
		) {
			return $post_states;
		}

		return array_merge(
			$post_states,
			[
				'archive' => '<span class="dashicons dashicons-portfolio"></span>',
			]
		);
	}
}
