<?php

namespace AutoListings;

class Plugin {
	/**
	 * Plugin base file.
	 * @var string
	 */
	protected $file;

	/**
	 * Query instance.
	 * @since 1.0.0
	 */
	public $query = null;

	/**
	 * Plugin constructor.
	 *
	 * @param string $file Plugin base file
	 */
	public function __construct( $file ) {
		$this->file = $file;
		$this->define_constants();
		$this->includes();
		$this->init_hooks();

		do_action( 'auto_listings_loaded' );
	}

	protected function define_constants() {
		define( 'AUTO_LISTINGS_FILE', $this->file );
		define( 'AUTO_LISTINGS_DIR', plugin_dir_path( $this->file ) );
		define( 'AUTO_LISTINGS_URL', plugin_dir_url( $this->file ) );
		define( 'AUTO_LISTINGS_BASENAME', plugin_basename( $this->file ) );
		define( 'AUTO_LISTINGS_VERSION', '1.1.6' );
	}

	protected function includes() {
		require AUTO_LISTINGS_DIR . 'includes/class-al-metaboxes.php';
		require AUTO_LISTINGS_DIR . 'includes/metaboxes/class-al-metaboxes-listing.php';
		require AUTO_LISTINGS_DIR . 'includes/metaboxes/class-al-metaboxes-listing-enquiry.php';
		require AUTO_LISTINGS_DIR . 'includes/metaboxes/functions.php';

		require AUTO_LISTINGS_DIR . 'includes/libraries/cmb2/init.php';
		require AUTO_LISTINGS_DIR . 'includes/libraries/cmb2-grid/Cmb2GridPlugin.php';
		require AUTO_LISTINGS_DIR . 'includes/libraries/cmb2-metatabs/cmb2_metatabs_options.php';

		require AUTO_LISTINGS_DIR . 'includes/install.php';
		require AUTO_LISTINGS_DIR . 'includes/class-al-roles.php';
		require AUTO_LISTINGS_DIR . 'includes/class-al-post-types.php';
		require AUTO_LISTINGS_DIR . 'includes/class-al-post-status.php';
		require AUTO_LISTINGS_DIR . 'includes/class-al-shortcodes.php';
		require AUTO_LISTINGS_DIR . 'includes/class-al-query.php';
		require AUTO_LISTINGS_DIR . 'includes/class-al-search-form.php';
		require AUTO_LISTINGS_DIR . 'includes/class-al-search-query.php';
		require AUTO_LISTINGS_DIR . 'includes/class-al-contact-form.php';

		if ( $this->is_request( 'admin' ) ) {
			require AUTO_LISTINGS_DIR . 'includes/admin/class-al-admin.php';
		}

		if ( $this->is_request( 'frontend' ) ) {
			require AUTO_LISTINGS_DIR . 'includes/frontend/class-al-frontend.php';
		}

		require AUTO_LISTINGS_DIR . 'includes/functions-conditionals.php';
		require AUTO_LISTINGS_DIR . 'includes/functions-enquiry.php';
		require AUTO_LISTINGS_DIR . 'includes/functions-formatting.php';
		require AUTO_LISTINGS_DIR . 'includes/functions-general.php';
		require AUTO_LISTINGS_DIR . 'includes/functions-listing.php';
		require AUTO_LISTINGS_DIR . 'includes/functions-sidebars.php';
	}

	protected function init_hooks() {
		add_action( 'init', [ $this, 'init' ], 0 );
		add_filter( 'plugin_row_meta', [ $this, 'plugin_row_meta' ], 10, 2 );
	}

	/**
	 * Check if a request is in admin or frontend.
	 *
	 * @param string $type Request type
	 *
	 * @return bool
	 */
	protected function is_request( $type ) {
		switch ( $type ) {
			case 'admin' :
				return is_admin();
			case 'frontend' :
				return ( ! is_admin() || wp_doing_ajax() ) && ! wp_doing_cron();
		}

		return false;
	}

	/**
	 * Init Auto_Listings when WordPress Initialises.
	 * @since 1.0.0
	 */
	public function init() {
		do_action( 'before_auto_listings_init' );

		$this->load_plugin_textdomain();

		// Load class instances.
		$this->query = new \Auto_Listings_Query();

		do_action( 'auto_listings_init' );
	}

	public function load_plugin_textdomain() {
		load_plugin_textdomain( 'auto-listings', false, basename( __DIR__ ) . '/languages' );
	}

	/**
	 * Add plugin extra links on the plugin screen.
	 */
	public function plugin_row_meta( $links, $file ) {
		if ( $file !== AUTO_LISTINGS_BASENAME ) {
			return $links;
		}

		$links[] = '<a href="' . esc_url( 'http://wpautolistings.com/documentation?utm_source=plugin&utm_medium=plugins_page&utm_content=docs' ) . '" title="' . esc_attr__( 'View Documentation', 'auto-listings' ) . '">' . esc_html__( 'Documentation', 'auto-listings' ) . '</a>';

		return $links;
	}
}
