<?php
/**
 * Enqueue scripts and styles on frontend.
 *
 * @package Auto Listings.
 */

namespace AutoListings;

/**
 * Class Installer
 */
class Installer {
	/**
	 * Add hooks when module is loaded.
	 */
	public function __construct() {
		register_activation_hook( AUTO_LISTINGS_FILE, [ $this, 'install' ] );
		add_action( 'admin_notices', [ $this, 'notice' ] );
	}

	/**
	 * Set up the post types, taxonomies, and creates sample data.
	 */
	public function install() {
		// install data.
		$this->install_plugin_options();
		wp_insert_term( 'SUV', 'body_type' );
		$this->install_listings_page();
		$this->install_sample_listing();

		// Add Upgraded From Option.
		$current_version = get_option( 'auto_listings_version' );
		if ( $current_version ) {
			update_option( 'auto_listings_version_upgraded_from', $current_version );
		}

		update_option( 'auto_listings_version', AUTO_LISTINGS_VERSION );

		// Create Auto_Listings roles.
		$roles = new Roles();
		$roles->add_roles();
		$roles->add_caps();

		// Bail if activating from network, or bulk.
		if ( is_network_admin() || isset( $_GET['activate-multi'] ) ) {
			return;
		}

		// Add the transient to redirect.
		set_transient( '_auto_listings_activation_redirect', true, 30 );

		flush_rewrite_rules( false );
	}

	/**
	 * Default options.
	 */
	protected function install_plugin_options() {
		$options = get_option( 'auto_listings_options' );
		if ( $options || ! empty( $options ) ) {
			return;
		}

		$options                   = [];
		$options['search_country'] = 'US';
		$options['map_zoom']       = '14';
		$options['map_height']     = '300';

		$options['display_condition']   = [
			'New',
			'Used',
		];
		$options['highlight_new_days']  = '3';
		$options['highlight_new_color'] = '#5ba533';

		$options['button_bg_color']   = '#337ab7';
		$options['button_text_color'] = '#ffffff';
		$options['price_color']       = '#337ab7';

		$options['grid_columns']        = '3';
		$options['delete_data']         = 'no';
		$options['archives_page_title'] = 'no';
		$options['listing_status']      = [
			[
				'status'     => 'Low Miles',
				'bg_color'   => '#1e73be',
				'text_color' => '#ffffff',
				'icon'       => 'auto-icon-odometer',
			],
			[
				'status'     => 'Fuel Efficient',
				'bg_color'   => '#dd3333',
				'text_color' => '#ffffff',
			],
		];
		$options['field_display']       = [
			'model_year',
			'make_display',
			'model_name',
			'model_vehicle',
			'model_seats',
			'model_doors',
			'model_drive',
			'model_transmission_type',
			'model_engine_fuel',
		];

		update_option( 'auto_listings_options', $options );
	}

	/**
	 * Default Archive Listing Page
	 */
	protected function install_listings_page() {
		global $wpdb;

		$page_content = '[auto_listings_search style="1"]';

		$page_data = [
			'post_status'    => 'publish',
			'post_type'      => 'page',
			'post_title'     => 'Listings',
			'post_content'   => $page_content,
			'comment_status' => 'closed',
		];

		$options = get_option( 'auto_listings_options' );
		$page    = get_post( $options['archives_page'] );
		if ( isset( $options['archives_page'] ) && isset( $page ) ) {
			if ( 'page' === $page->post_type && ! in_array(
				$page->post_status,
				[
					'pending',
					'trash',
					'future',
					'auto-draft',
				],
				true
			) ) {
				return;
			}
		}

		// Search for an existing page with the specified page content (typically a shortcode).
		$valid_page_found = $wpdb->get_var( $wpdb->prepare( "SELECT ID FROM $wpdb->posts WHERE post_type='page' AND post_status NOT IN ( 'pending', 'trash', 'future', 'auto-draft' ) AND post_content LIKE %s LIMIT 1;", "%{$page_content}%" ) );

		if ( $valid_page_found ) {
			$options                  = get_option( 'auto_listings_options' );
			$options['archives_page'] = $valid_page_found;
			update_option( 'auto_listings_options', $options );

			return;
		}

		// Search for an existing page with the specified page content (typically a shortcode).
		$trashed_page_found = $wpdb->get_var( $wpdb->prepare( "SELECT ID FROM $wpdb->posts WHERE post_type='page' AND post_status = 'trash' AND post_content LIKE %s LIMIT 1;", "%{$page_content}%" ) );

		if ( $trashed_page_found ) {
			$page_id   = $trashed_page_found;
			$page_data = [
				'ID'          => $page_id,
				'post_status' => 'publish',
			];
			wp_update_post( $page_data );
		} else {
			$page_id = wp_insert_post( $page_data );
		}

		$options                  = get_option( 'auto_listings_options' );
		$options['archives_page'] = $page_id;
		update_option( 'auto_listings_options', $options );
	}

	/**
	 * Create default listing
	 */
	protected function install_sample_listing() {
		global $wpdb;

		$listing_title = 'My Sample Listing';

		$listing_data = [
			'post_status'    => 'publish',
			'post_type'      => 'auto-listing',
			'post_title'     => $listing_title,
			'post_content'   => '<p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt.</p><p>Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur.</p>',
			'post_excerpt'   => 'Well looked after example!',
			'comment_status' => 'closed',
		];

		// Search for an existing page with the specified page content (typically a shortcode).
		$valid_page_found = $wpdb->get_var( $wpdb->prepare( "SELECT ID FROM $wpdb->posts WHERE post_type='auto-listing' AND post_status NOT IN ( 'pending', 'trash', 'future', 'auto-draft' ) AND post_title LIKE %s LIMIT 1;", "%{$listing_title}%" ) );

		if ( $valid_page_found ) {
			return;
		}

		// Search for an existing page with the specified page content (typically a shortcode).
		$trashed_page_found = $wpdb->get_var( $wpdb->prepare( "SELECT ID FROM $wpdb->posts WHERE post_type='auto-listing' AND post_status = 'trash' AND post_title LIKE %s LIMIT 1;", "%{$listing_title}%" ) );

		if ( $trashed_page_found ) {
			$listing_id   = $trashed_page_found;
			$listing_data = [
				'ID'          => $listing_id,
				'post_status' => 'publish',
			];
			wp_update_post( $listing_data );
		} else {
			$listing_id = wp_insert_post( $listing_data );
		}

		$prefix    = '_al_listing_';
		$save_meta = [
			$prefix . 'status'                  => 'Low Miles',
			$prefix . 'price'                   => '21000',
			$prefix . 'price_suffix'            => '',
			$prefix . 'odometer'                => '22590',
			$prefix . 'registration'            => 'DKW-202',
			$prefix . 'condition'               => 'Used',
			$prefix . 'displayed_address'       => 'Miami Shore Parade, Miami QLD 4220',
			$prefix . 'route'                   => 'Miami Shore Parade',
			$prefix . 'city'                    => 'Miami',
			$prefix . 'state'                   => 'Queensland',
			$prefix . 'zip'                     => '4220',
			$prefix . 'country'                 => 'Australia',
			$prefix . 'lat'                     => '-28.0710877',
			$prefix . 'lng'                     => '153.44109830000002',
			$prefix . 'model_year'              => '2017',
			$prefix . 'make_display'            => 'Jeep',
			$prefix . 'model_name'              => 'Cherokee',
			$prefix . 'model_vehicle'           => 'Latitude 4dr SUV (2.4L 4cyl 9A)',
			$prefix . 'model_seats'             => '7',
			$prefix . 'model_doors'             => '4',
			$prefix . 'model_drive'             => 'Front Wheel Drive',
			$prefix . 'model_transmission_type' => 'Automatic',
			$prefix . 'model_engine_fuel'       => 'Regular Unleaded',
			$prefix . 'model_engine_l'          => '2.4',
			$prefix . 'model_engine_type'       => 'Inline',
			$prefix . 'model_engine_cyl'        => '4',
			$prefix . 'make_country'            => 'USA',
			$prefix . 'seller'                  => get_current_user_id(),
		];

		// Save values from created array into db.
		foreach ( $save_meta as $meta_key => $meta_value ) {
			update_post_meta( $listing_id, $meta_key, $meta_value );
		}

		wp_set_object_terms( $listing_id, 'suv', 'body-type' );
	}

	/**
	 * Print notice.
	 */
	public function notice() {
		$redirected = get_transient( '_auto_listings_redirected' );
		if ( false === $redirected || ! isset( $_GET['page'] ) || 'auto_listings_options' !== $_GET['page'] ) {
			return;
		}

		$class    = 'notice notice-info is-dismissible';
		$message  = '<strong>' . __( 'Success!', 'auto-listings' ) . '</strong>' . __( ' A sample listing has been created: ', 'auto-listings' );
		$message .= '<a class="button button-small" target="_blank" href="' . home_url( '/listings' ) . '">' . __( 'View First Listing', 'auto-listings' ) . '</a><br><br>';
		$message .= __( 'Step 1. Please go through each tab below, configure the options and <strong>hit the save button</strong>.', 'auto-listings' ) . '<br>';
		$message .= __( 'Step 2. Add your first Listing by navigating to <strong>Listings > New Listing</strong>', 'auto-listings' ) . '<br><br>';
		// translators: %s is contact url.
		$message .= sprintf( __( '<em><strong>Please Note</strong>: When viewing listings, if things aren\'t looking quiet right, don\'t panic. <br>It is likely just a small theme compatibility issue which is easily resolved. <a href="%s">Contact us here</a> and we will be happy to help and make it look great with your theme.</em>', 'auto-listings' ), 'http://wpautolistings.com/submit-ticket/' ) . '<br>';

		// translators: %1 is tag class, %2 is the message.
		printf( '<div class="%1$s"><p>%2$s</p></div>', esc_attr( $class ), wp_kses_post( $message ) );
	}
}
