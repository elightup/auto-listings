<?php
/**
 * Plugin Name: Auto Listings
 * Description: An Automotive Listings plugin for WordPress.
 * Author: WP Auto Listings
 * Author URI: http://wpautolistings.com
 * Plugin URI: http://wpautolistings.com
 * Version: 1.1.6
 * Text Domain: auto-listings
 * Domain Path: languages
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists( 'Auto_Listings' ) ) :

/*
 * Helper function for quick debugging
 */
if (!function_exists('pp')) {
	function pp( $array ) {
		echo '<pre style="white-space:pre-wrap;">';
			print_r( $array );
		echo '</pre>';
	}
}

/**
 * Main Auto_Listings Class.
 *
 * @since 1.0.0
 */
final class Auto_Listings {

	/**
	 * @var Auto_Listings The one true Auto_Listings
	 * @since 1.0.0
	 */
	protected static $_instance = null;

	/**
	 * Query instance.
	 * @since 1.0.0 
	 */
	public $query = null;

	/**
	 * Main Auto_Listings Instance.
	 * @since 1.0.0
	 */
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	public function __clone() {
		_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', 'auto-listings' ), '1.0.0' );
	}

	public function __wakeup() {
		_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', 'auto-listings' ), '1.0.0' );
	}

	public function __construct() {
		$this->define_constants();
		$this->includes();
		$this->init_hooks();

		do_action( 'auto_listings_loaded' );
	}

	/**
	 * Hook into actions and filters.
	 * @since  1.0.0
	 */
	private function init_hooks() {
		add_action( 'init', array( $this, 'init' ), 0 );
		add_filter( 'plugin_row_meta', array( $this, 'plugin_row_meta' ), 10, 2 );
	}

	/**
	 * Define Constants.
	 * @since  1.0.0
	 */
	private function define_constants() {
		$upload_dir = wp_upload_dir();
		$this->define( 'AUTOLISTINGS_PLUGIN_FILE', __FILE__ );
		$this->define( 'AUTOLISTINGS_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
		$this->define( 'AUTOLISTINGS_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
		$this->define( 'AUTOLISTINGS_PLUGIN_BASENAME', plugin_basename( __FILE__ ) );
		$this->define( 'AUTOLISTINGS_VERSION', '1.1.6' );
	}

	/**
	 * Define constant if not already set.
	 * @since  1.0.0
	 */
	private function define( $name, $value ) {
		if ( ! defined( $name ) ) {
			define( $name, $value );
		}
	}

	/**
	 * What type of request is this?
	 * @since  1.0.0
	 */
	private function is_request( $type ) {
		switch ( $type ) {
			case 'admin' :
				return is_admin();
			case 'frontend' :
				return ( ! is_admin() || defined( 'DOING_AJAX' ) ) && ! defined( 'DOING_CRON' );
		}
	}

	/**
	 * Include required core files used in admin and on the frontend.
	 * @since  1.0.0
	 */
	public function includes() {

		// metaboxes
		include_once( 'includes/class-al-metaboxes.php' );
		include_once( 'includes/metaboxes/class-al-metaboxes-listing.php' );
		include_once( 'includes/metaboxes/class-al-metaboxes-listing-enquiry.php' );
		include_once( 'includes/metaboxes/functions.php' );

		include_once( 'includes/libraries/cmb2/init.php' );
		include_once( 'includes/libraries/cmb2-grid/Cmb2GridPlugin.php' );
		include_once( 'includes/libraries/cmb2-metatabs/cmb2_metatabs_options.php' );

		include_once( 'includes/install.php' );
		include_once( 'includes/class-al-roles.php' );
		include_once( 'includes/class-al-post-types.php' );
		include_once( 'includes/class-al-post-status.php' );
		include_once( 'includes/class-al-shortcodes.php' );
		include_once( 'includes/class-al-query.php' );
		include_once( 'includes/class-al-search-form.php' );
		include_once( 'includes/class-al-search-query.php' );
		include_once( 'includes/class-al-contact-form.php' );
				
		if ( $this->is_request( 'admin' ) ) {
			include_once( 'includes/admin/class-al-admin.php' );		
		}

		if ( $this->is_request( 'frontend' ) ) {
			include_once( 'includes/frontend/class-al-frontend.php' );
		}

		include_once( 'includes/functions-conditionals.php' );
		include_once( 'includes/functions-enquiry.php' );
		include_once( 'includes/functions-formatting.php' );
		include_once( 'includes/functions-general.php' );
		include_once( 'includes/functions-listing.php' );
		include_once( 'includes/functions-sidebars.php' );
		
		
	}

	/**
	 * Init Auto_Listings when WordPress Initialises.
	 * @since 1.0.0
	 */
	public function init() {
		// Before init action.
		do_action( 'before_auto_listings_init' );
		// Set up localisation.
		$this->load_plugin_textdomain();

		// Load class instances.
		$this->query = new Auto_Listings_Query();
	
		// Init action.
		do_action( 'auto_listings_init' );
	}


	/**
	 * Load Localisation files.
	 * @since 1.0.0
	 */
	public function load_plugin_textdomain() {
		$locale = apply_filters( 'plugin_locale', get_locale(), 'auto-listings' );

		load_textdomain( 'auto-listings', WP_LANG_DIR . '/auto-listings-' . $locale . '.mo' );
		load_plugin_textdomain( 'auto-listings', false, plugin_basename( dirname( __FILE__ ) ) . '/languages' );
	}


	/**
	 * Show row meta on the plugin screen.
	 * @since 1.0.0
	 */
	public function plugin_row_meta( $links, $file ) {
		
		if ( $file == AUTOLISTINGS_PLUGIN_BASENAME ) {
			
			$row_meta = array(

				'docs' => '<a href="' . esc_url( 'http://wpautolistings.com/documentation?utm_source=plugin&utm_medium=plugins_page&utm_content=docs' ) . '" title="' . esc_attr( __( 'View Documentation', 'auto-listings' ) ) . '">' . __( 'Help', 'auto-listings' ) . '</a>',

			);

			return array_merge( $links, $row_meta );
		}

		return (array) $links;
	}

}

endif;


/**
 * Main instance of Auto_Listings.
 *
 * @since  1.0.0
 * @return Auto_Listings
 */
function Auto_Listings() {
	return Auto_Listings::instance();
}

Auto_Listings();