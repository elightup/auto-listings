<?php
/**
 * Register meta boxes and setting page.
 *
 * @package Auto Listings.
 */

namespace AutoListings\Admin;

/**
 * Settings class.
 */
class Settings {
	/**
	 * Add hooks when module is loaded.
	 */
	public function __construct() {
		add_filter( 'mb_settings_pages', [ $this, 'register_settings_pages' ] );
		add_filter( 'rwmb_meta_boxes', [ $this, 'register_settings_fields' ] );
		add_action( 'admin_print_styles-settings_page_auto-listings', [ $this, 'enqueue' ] );
	}

	/**
	 * Register setting pages.
	 *
	 * @param array $settings_pages array of setting pages.
	 */
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

	/**
	 * Register meta boxes.
	 *
	 * @param array $meta_boxes array of meta boxes.
	 */
	public function register_settings_fields( $meta_boxes ) {
		$files = glob( __DIR__ . '/settings/*.php' );
		foreach ( $files as $file ) {
			$meta_boxes[] = include $file;
		}

		return $meta_boxes;
	}

	/**
	 * Enqueue setting page css.
	 */
	public function enqueue() {
		wp_enqueue_style( 'auto-listings-settings', AUTO_LISTINGS_URL . 'assets/admin/css/settings.css', '', AUTO_LISTINGS_VERSION );
	}
}
