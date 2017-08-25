<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Auto_Listings_Admin class.
 */
class Auto_Listings_Post_Status {

	/**
	 * Constructor.
	 */
	public function __construct() {
		add_action( 'init', array( $this, 'archive_post_status' ) );
		add_action( 'admin_footer-post.php', array( $this, 'post_screen_js' ) );
		add_action( 'admin_footer-edit.php', array( $this, 'edit_screen_js' ) );
		add_filter( 'display_post_states', array( $this, 'display_post_states' ), 10, 2 );

	}


	function archive_post_status(){
	    register_post_status( 'archive', array(
			'label'                     => _x( 'Archive', 'post' ),
			'public'                    => false,
			'private'                   => false,
			'exclude_from_search'       => false,
			'show_in_admin_all_list'    => false,
			'show_in_admin_status_list' => true,
			'label_count'               => _n_noop( 'Archive <span class="count">(%s)</span>', 'Archived <span class="count">(%s)</span>', 'auto-listings' ),
		) );
	}


	function post_screen_js(){

		global $post;

		if( $post->post_type !== 'auto-listing' )
			return;

	    if ( 'draft' !== $post->post_status && 'pending' !== $post->post_status ) {

			?>
			<script>
			jQuery( document ).ready( function( $ ) {
				$( '#post_status' ).append( '<option value="archive"><?php esc_html_e( 'Archived', 'auto-listings' ) ?></option>' );
			} );
			</script>
			<?php

		}

		if ( 'archive' === $post->post_status ) {

			?>
			<script>
			jQuery( document ).ready( function( $ ) {
				$( '#post-status-display' ).text( '<?php esc_html_e( 'Archived', 'auto-listings' ) ?>' );
			} );
			</script>
			<?php

		}

	}

	function edit_screen_js() {

		global $typenow;

		if( $typenow !== 'auto-listing' )
			return;


		?>
		<script>
		jQuery( document ).ready( function( $ ) {

			$( 'select[name="_status"]' ).append( '<option value="archive"><?php esc_html_e( 'Archived', 'auto-listings' ) ?></option>' );

			$( '.editinline' ).on( 'click', function() {
				var $row        = $( this ).closest( 'tr' ),
				    $option     = $( '.inline-edit-row' ).find( 'select[name="_status"] option[value="archive"]' ),
				    is_archived = $row.hasClass( 'status-archive' );

				$option.prop( 'selected', is_archived );
			} );

		} );
		</script>
		<?php

	}


	function display_post_states( $post_states, $post ) {

		if (
			$post->post_type !== 'auto-listing'
			||
			'archive' !== $post->post_status
			||
			'archive' === get_query_var( 'post_status' )
		) {

			return $post_states;

		}

		return array_merge(
			$post_states,
			array(
				'archive' => '<span class="dashicons dashicons-portfolio"></span>',
			)
		);

	}


}

return new Auto_Listings_Post_Status();