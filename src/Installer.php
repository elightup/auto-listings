<?php
namespace AutoListings;

class Installer {
	public function __construct( $file ) {
		register_activation_hook( $file, [ $this, 'install' ] );
	}

	public function install() {
		$this->install_plugin_options();
		wp_insert_term( 'SUV', 'body-type' );
		$this->install_listings_page();
		$this->install_sample_listing();

		// Create Auto_Listings roles.
		$roles = new Roles();
		$roles->add_roles();
		$roles->add_caps();

		flush_rewrite_rules( false );
	}

	private function install_plugin_options() {
		$options = get_option( 'auto_listings_options' );
		if ( ! empty( $options ) ) {
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
		$options['listing_state']       = [
			[
				'state'      => 'Sold',
				'text_color' => '#1e73be',
				'hide_price' => true,
			],
			[
				'state'      => 'Reserved',
				'text_color' => '#dd3333',
				'hide_price' => true,
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

	private function install_listings_page() {
		$options = get_option( 'auto_listings_options' );
		if ( ! empty( $options['archives_page'] ) ) {
			return;
		}

		$page_content = '[auto_listings_search style="1"]';
		$page_data    = [
			'post_status'    => 'publish',
			'post_type'      => 'page',
			'post_title'     => 'Listings',
			'post_content'   => $page_content,
			'comment_status' => 'closed',
		];

		// Search for an existing page with the specified page content (typically a shortcode).
		global $wpdb;
		$valid_page_found = $wpdb->get_var( $wpdb->prepare( "SELECT ID FROM $wpdb->posts WHERE post_type='page' AND post_content LIKE %s LIMIT 1;", "%{$page_content}%" ) );
		if ( $valid_page_found ) {
			$options['archives_page'] = $valid_page_found;
			update_option( 'auto_listings_options', $options );
			return;
		}

		$page_id = wp_insert_post( $page_data );

		$options['archives_page'] = $page_id;
		update_option( 'auto_listings_options', $options );
	}

	private function install_sample_listing() {
		// Search for an existing page with the specified page content (typically a shortcode).
		global $wpdb;
		$listing_id = $wpdb->get_var( "SELECT ID FROM $wpdb->posts WHERE post_type='auto-listing' LIMIT 1" );
		if ( $listing_id ) {
			return;
		}

		$listing_title = 'My Sample Listing';
		$listing_data  = [
			'post_status'    => 'publish',
			'post_type'      => 'auto-listing',
			'post_title'     => $listing_title,
			'post_content'   => '<p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt.</p><p>Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur.</p>',
			'post_excerpt'   => 'Well looked after example!',
			'comment_status' => 'closed',
		];
		$listing_id = wp_insert_post( $listing_data );

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
}
