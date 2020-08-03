<?php
namespace AutoListings\Admin;

class Settings {
	public function __construct() {
		add_filter( 'mb_settings_pages', [ $this, 'register_settings_pages' ] );
		add_filter( 'rwmb_meta_boxes', [ $this, 'register_settings_fields' ] );
		add_action( 'admin_print_styles-auto-listing_page_auto-listings', [ $this, 'enqueue' ] );
	}

	public function register_settings_pages( $settings_pages ) {
		$settings_pages['auto-listings'] = [
			'id'          => 'auto-listings',
			'option_name' => 'auto_listings_options',
			'menu_title'  => __( 'Settings', 'auto-listings' ),
			'parent'      => 'edit.php?post_type=auto-listing',
			'tabs'        => [
				'general'    => __( 'General', 'auto-listings' ),
				'listings'   => __( 'Listings', 'auto-listings' ),
				'fields'     => __( 'Fields', 'auto-listings' ),
				'display'    => __( 'Display', 'auto-listings' ),
				'contact'    => __( 'Contact Form', 'auto-listings' ),
				'advanced'   => __( 'Advanced', 'auto-listings' ),
				'extensions' => __( 'Extensions', 'auto-listings' ),
			],
		];
		return $settings_pages;
	}

	public function register_settings_fields( $meta_boxes ) {
		$files = glob( __DIR__ . '/settings/*.php' );
		foreach ( $files as $file ) {
			$meta_box = include $file;
			$meta_boxes[ $meta_box['id'] ] = $meta_box;
		}

		return $meta_boxes;
	}

	public function enqueue() {
		wp_enqueue_style( 'auto-listings-settings', AUTO_LISTINGS_URL . 'assets/admin/css/settings.css', '', AUTO_LISTINGS_VERSION );
	}
}
