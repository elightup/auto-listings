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

	protected function init_hooks() {
		add_action( 'init', [ $this, 'init' ], 0 );
		add_filter( 'plugin_row_meta', [ $this, 'plugin_row_meta' ], 10, 2 );
		add_action( 'tgmpa_register', [ $this, 'register_plugins' ] );
	}

	/**
	 * Init Auto_Listings when WordPress Initialises.
	 * @since 1.0.0
	 */
	public function init() {
		do_action( 'before_auto_listings_init' );

		$this->load_plugin_textdomain();

		do_action( 'auto_listings_init' );
	}

	public function load_plugin_textdomain() {
		load_plugin_textdomain( 'auto-listings', false, basename( __DIR__ ) . '/languages' );
	}

	/**
	 * Add plugin extra links on the plugin screen.
	 *
	 * @param array  $links List of plugin actions.
	 * @param string $file  Plugin file.
	 *
	 * @return array
	 */
	public function plugin_row_meta( $links, $file ) {
		if ( $file !== AUTO_LISTINGS_BASENAME ) {
			return $links;
		}

		$links[] = '<a href="' . esc_url( 'http://wpautolistings.com/documentation?utm_source=plugin&utm_medium=plugins_page&utm_content=docs' ) . '" title="' . esc_attr__( 'View Documentation', 'auto-listings' ) . '">' . esc_html__( 'Documentation', 'auto-listings' ) . '</a>';

		return $links;
	}

	public function register_plugins() {
		$plugins = [
			[
				'name'     => 'Meta Box',
				'slug'     => 'meta-box',
				'required' => true,
			],
		];
		$config  = [
			'id'          => 'auto-listings',
			'menu'        => 'tgmpa-install-plugins',
			'parent_slug' => 'plugins.php',
			'capability'  => 'install_plugins',
		];

		tgmpa( $plugins, $config );
	}
}
