<?php
namespace AutoListings;

/**
 * Single Template Settings Management
 * Separate from main settings to handle custom Elementor templates for single listings
 */
class TemplateSettings {
	/**
	 * Settings page slug
	 *
	 * @var string
	 */
	const PAGE_SLUG = 'auto-listings-template-settings';

	/**
	 * Option group name
	 *
	 * @var string
	 */
	const OPTION_GROUP = 'auto_listings_template_settings';

	/**
	 * Option name for settings
	 *
	 * @var string
	 */
	const OPTION_NAME = 'auto_listings_template_settings';

	/**
	 * Constructor
	 */
	public function __construct() {
		add_action( 'admin_menu', [ $this, 'add_settings_page' ] );
		add_action( 'admin_init', [ $this, 'register_settings' ] );
		add_action( 'template_redirect', [ $this, 'remove_default_listing_hooks_early' ], 1 );
		add_filter( 'auto_listings_template_file', [ $this, 'prevent_default_template' ], 5 );
		add_filter( 'template_include', [ $this, 'override_single_template' ], 999 );
		add_filter( 'body_class', [ $this, 'add_custom_template_body_class' ] );
	}

	/**
	 * Add settings page to WordPress admin
	 */
	public function add_settings_page() {
		add_submenu_page(
			'edit.php?post_type=auto-listing',
			esc_html__( 'Single Listing Settings', 'auto-listings' ),
			esc_html__( 'Single Listing Settings', 'auto-listings' ),
			'manage_options',
			self::PAGE_SLUG,
			[ $this, 'render_settings_page' ]
		);
	}

	/**
	 * Register plugin settings
	 */
	public function register_settings() {
		register_setting(
			self::OPTION_GROUP,
			self::OPTION_NAME,
			[
				'type'              => 'array',
				'sanitize_callback' => [ $this, 'sanitize_settings' ],
				'default'           => $this->get_default_settings(),
			]
		);

		add_settings_section(
			'single_template',
			esc_html__( 'Single Listing Template', 'auto-listings' ),
			[ $this, 'render_single_template_section' ],
			self::PAGE_SLUG
		);

		add_settings_field(
			'enable_custom_template',
			esc_html__( 'Use Custom Template', 'auto-listings' ),
			[ $this, 'render_toggle_field' ],
			self::PAGE_SLUG,
			'single_template',
			[
				'label_for'   => 'enable_custom_template',
				'name'        => 'enable_custom_template',
				'description' => esc_html__( 'Enable to use a custom Elementor page as the single listing template', 'auto-listings' ),
			]
		);

		add_settings_field(
			'custom_template_page',
			esc_html__( 'Select Template Page', 'auto-listings' ),
			[ $this, 'render_page_selector_field' ],
			self::PAGE_SLUG,
			'single_template',
			[
				'label_for'   => 'custom_template_page',
				'name'        => 'custom_template_page',
				'description' => esc_html__( 'Choose the page/template to use for single listings. This page should be built with Elementor and use dynamic tags.', 'auto-listings' ),
			]
		);
	}

	/**
	 * Get default settings
	 *
	 * @return array
	 */
	protected function get_default_settings() {
		return [
			'enable_custom_template' => false,
			'custom_template_page'   => 0,
		];
	}

	/**
	 * Sanitize settings before saving
	 *
	 * @param array $input Raw input data.
	 * @return array
	 */
	public function sanitize_settings( $input ) {
		$sanitized = [];

		$sanitized['enable_custom_template'] = ! empty( $input['enable_custom_template'] );
		$sanitized['custom_template_page']   = absint( $input['custom_template_page'] ?? 0 );

		return $sanitized;
	}

	/**
	 * Get settings value
	 *
	 * @param string $key     Setting key.
	 * @param mixed  $default Default value.
	 * @return mixed
	 */
	public static function get( $key, $default = null ) {
		$settings = get_option( self::OPTION_NAME, [] );
		return $settings[ $key ] ?? $default;
	}

	/**
	 * Render settings page
	 */
	public function render_settings_page() {
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}

		if ( isset( $_GET['settings-updated'] ) ) {
			add_settings_error(
				self::OPTION_NAME,
				'settings_updated',
				esc_html__( 'Settings saved successfully!', 'auto-listings' ),
				'success'
			);
		}

		?>
		<div class="wrap">
			<h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
			
			<?php settings_errors( self::OPTION_NAME ); ?>

			<form action="options.php" method="post">
				<?php
				settings_fields( self::OPTION_GROUP );
				do_settings_sections( self::PAGE_SLUG );
				submit_button( esc_html__( 'Save Settings', 'auto-listings' ) );
				?>
			</form>

			<div class="auto-listings-help-section" style="margin-top: 40px; padding: 20px; background: #fff; border-left: 4px solid #2271b1;">
				<h2><?php esc_html_e( '💡 How to Use Custom Templates', 'auto-listings' ); ?></h2>
				
				<div style="line-height: 1.8;">
					<h3><?php esc_html_e( 'Step 1: Create Your Template', 'auto-listings' ); ?></h3>
					<ol style="margin-left: 20px;">
						<li><?php esc_html_e( 'Go to Pages → Add New (or use an existing page)', 'auto-listings' ); ?></li>
						<li><?php esc_html_e( 'Design your single listing layout with Elementor', 'auto-listings' ); ?></li>
						<li><?php esc_html_e( 'Use Dynamic Tags to display listing data:', 'auto-listings' ); ?>
							<ul style="margin: 10px 0 10px 20px;">
								<li><strong><?php esc_html_e( 'Post → Title', 'auto-listings' ); ?></strong> - <?php esc_html_e( 'Listing title', 'auto-listings' ); ?></li>
								<li><strong><?php esc_html_e( 'Post → Featured Image', 'auto-listings' ); ?></strong> - <?php esc_html_e( 'Main image', 'auto-listings' ); ?></li>
								<li><strong><?php esc_html_e( 'Post → Excerpt', 'auto-listings' ); ?></strong> - <?php esc_html_e( 'Description', 'auto-listings' ); ?></li>
								<li><strong><?php esc_html_e( 'Post Custom Field', 'auto-listings' ); ?></strong> - <?php esc_html_e( 'Use field keys like:', 'auto-listings' ); ?>
									<code>_price</code>, <code>_year</code>, <code>_make</code>, <code>_model</code>, <code>_odometer</code>
								</li>
							</ul>
						</li>
						<li><?php esc_html_e( 'Publish your page', 'auto-listings' ); ?></li>
					</ol>

					<h3><?php esc_html_e( 'Step 2: Enable Custom Template', 'auto-listings' ); ?></h3>
					<ol style="margin-left: 20px;">
						<li><?php esc_html_e( 'Toggle "Use Custom Template" to ON above', 'auto-listings' ); ?></li>
						<li><?php esc_html_e( 'Select your template page from the dropdown', 'auto-listings' ); ?></li>
						<li><?php esc_html_e( 'Click "Save Settings"', 'auto-listings' ); ?></li>
					</ol>

					<h3><?php esc_html_e( 'Step 3: Test', 'auto-listings' ); ?></h3>
					<ol style="margin-left: 20px;">
						<li><?php esc_html_e( 'Visit any single listing page', 'auto-listings' ); ?></li>
						<li><?php esc_html_e( 'Your custom template will be displayed!', 'auto-listings' ); ?></li>
					</ol>

					<div style="margin-top: 20px; padding: 15px; background: #001010; border-radius: 4px;">
						<strong><?php esc_html_e( '⚠️ Important Notes:', 'auto-listings' ); ?></strong>
						<ul style="margin: 10px 0 0 20px;">
							<li><?php esc_html_e( 'The selected page will be used for ALL single listings', 'auto-listings' ); ?></li>
							<li><?php esc_html_e( 'Make sure to use Dynamic Tags so data updates for each listing', 'auto-listings' ); ?></li>
							<li><?php esc_html_e( 'You can switch back to the default template anytime by toggling OFF', 'auto-listings' ); ?></li>
							<li><?php esc_html_e( 'Test thoroughly before going live', 'auto-listings' ); ?></li>
						</ul>
					</div>

					<div style="margin-top: 20px; padding: 15px; background: #e8f5e9; border-radius: 4px;">
						<strong><?php esc_html_e( '💡 Pro Tip:', 'auto-listings' ); ?></strong>
						<p style="margin: 10px 0 0 0;">
							<?php esc_html_e( 'For a complete list of available field keys, refer to your listing edit screen. Common fields include: _price, _year, _make, _model, _odometer, _transmission, _fuel, _condition', 'auto-listings' ); ?>
						</p>
					</div>
				</div>
			</div>
		</div>

		<style>
			.auto-listings-help-section h2 {
				margin-top: 0;
				color: #1d2327;
			}
			.auto-listings-help-section h3 {
				margin-top: 20px;
				margin-bottom: 10px;
				color: #2c3338;
			}
			.auto-listings-help-section code {
				background: #f0f0f1;
				padding: 2px 6px;
				border-radius: 3px;
				font-family: Consolas, Monaco, monospace;
				font-size: 13px;
			}
		</style>
		<?php
	}

	/**
	 * Render single template section description
	 */
	public function render_single_template_section() {
		?>
		<p>
			<?php esc_html_e( 'Customize how single listing pages are displayed. Enable custom template to use an Elementor page design instead of the default theme template.', 'auto-listings' ); ?>
		</p>
		<?php
	}

	/**
	 * Render toggle field
	 *
	 * @param array $args Field arguments.
	 */
	public function render_toggle_field( $args ) {
		$settings = get_option( self::OPTION_NAME, $this->get_default_settings() );
		$value    = ! empty( $settings[ $args['name'] ] );
		$name     = self::OPTION_NAME . '[' . $args['name'] . ']';
		?>
		<label class="auto-listings-toggle">
			<input 
				type="checkbox" 
				id="<?php echo esc_attr( $args['label_for'] ); ?>"
				name="<?php echo esc_attr( $name ); ?>"
				value="1"
				<?php checked( $value, true ); ?>
				class="auto-listings-toggle-checkbox"
			>
		</label>
		<?php if ( ! empty( $args['description'] ) ) : ?>
			<p class="description"><?php echo esc_html( $args['description'] ); ?></p>
		<?php endif; ?>

		<style>
			.auto-listings-toggle {
				display: inline-flex;
				align-items: center;
				gap: 10px;
				cursor: pointer;
			}
			.auto-listings-toggle-checkbox {
				display: none;
			}
			.auto-listings-toggle-switch {
				position: relative;
				width: 50px;
				height: 26px;
				background: #ddd;
				border-radius: 13px;
				transition: background 0.3s;
			}
			.auto-listings-toggle-switch::before {
				content: '';
				position: absolute;
				width: 22px;
				height: 22px;
				border-radius: 50%;
				background: white;
				top: 2px;
				left: 2px;
				transition: transform 0.3s;
				box-shadow: 0 2px 4px rgba(0,0,0,0.2);
			}
			.auto-listings-toggle-checkbox:checked + .auto-listings-toggle-switch {
				background: #2271b1;
			}
			.auto-listings-toggle-checkbox:checked + .auto-listings-toggle-switch::before {
				transform: translateX(24px);
			}
			.auto-listings-toggle-label {
				font-weight: 500;
			}
		</style>
		<?php
	}

	/**
	 * Render page selector field
	 *
	 * @param array $args Field arguments.
	 */
	public function render_page_selector_field( $args ) {
		$settings = get_option( self::OPTION_NAME, $this->get_default_settings() );
		$value    = absint( $settings[ $args['name'] ] ?? 0 );
		$name     = self::OPTION_NAME . '[' . $args['name'] . ']';

		$pages = $this->get_available_pages();
		?>
		<select 
			id="<?php echo esc_attr( $args['label_for'] ); ?>"
			name="<?php echo esc_attr( $name ); ?>"
			class="regular-text"
		>
			<option value="0"><?php esc_html_e( '-- Select a page --', 'auto-listings' ); ?></option>
			<?php foreach ( $pages as $page ) : ?>
				<option value="<?php echo esc_attr( $page['id'] ); ?>" <?php selected( $value, $page['id'] ); ?>>
					<?php echo esc_html( $page['title'] ); ?>
					<?php if ( $page['is_elementor'] ) : ?>
						★
					<?php endif; ?>
				</option>
			<?php endforeach; ?>
		</select>
		
		<?php if ( ! empty( $args['description'] ) ) : ?>
			<p class="description">
				<?php echo esc_html( $args['description'] ); ?>
				<br>
				★ = <?php esc_html_e( 'Built with Elementor', 'auto-listings' ); ?>
			</p>
		<?php endif; ?>

		<?php if ( $value > 0 && get_post_status( $value ) === 'publish' ) : ?>
			<p>
				<a href="<?php echo esc_url( get_permalink( $value ) ); ?>" target="_blank" class="button button-secondary">
					<?php esc_html_e( 'Preview Template', 'auto-listings' ); ?>
				</a>
				<a href="<?php echo esc_url( get_edit_post_link( $value ) ); ?>" target="_blank" class="button button-secondary">
					<?php esc_html_e( 'Edit Template', 'auto-listings' ); ?>
				</a>
			</p>
		<?php endif; ?>
		<?php
	}

	/**
	 * Get available pages for template selection
	 *
	 * @return array
	 */
	protected function get_available_pages() {
		$pages_query = get_posts( [
			'post_type'      => [ 'page', 'elementor_library' ],
			'posts_per_page' => -1,
			'post_status'    => 'publish',
			'orderby'        => 'title',
			'order'          => 'ASC',
		] );

		$pages = [];
		foreach ( $pages_query as $page ) {
			$is_elementor = get_post_meta( $page->ID, '_elementor_edit_mode', true ) === 'builder';
			
			$pages[] = [
				'id'           => $page->ID,
				'title'        => $page->post_title . ' (ID: ' . $page->ID . ')',
				'is_elementor' => $is_elementor,
			];
		}

		return $pages;
	}

	/**
	 * Prevent default Auto Listings template from loading
	 *
	 * @param string $file Template file name.
	 * @return string
	 */
	public function prevent_default_template( $file ) {
		if ( ! is_singular( 'auto-listing' ) ) {
			return $file;
		}

		$enabled = self::get( 'enable_custom_template', false );
		if ( ! $enabled ) {
			return $file;
		}

		$page_id = absint( self::get( 'custom_template_page', 0 ) );
		if ( ! $page_id || get_post_status( $page_id ) !== 'publish' ) {
			return $file;
		}

		if ( ! did_action( 'elementor/loaded' ) ) {
			return $file;
		}

		return '';
	}

	/**
	 * Override single listing template
	 *
	 * @param string $template Current template path.
	 * @return string
	 */
	public function override_single_template( $template ) {
		if ( ! is_singular( 'auto-listing' ) ) {
			return $template;
		}

		$enabled = self::get( 'enable_custom_template', false );
		if ( ! $enabled ) {
			return $template;
		}

		$page_id = absint( self::get( 'custom_template_page', 0 ) );
		if ( ! $page_id || get_post_status( $page_id ) !== 'publish' ) {
			return $template;
		}

		if ( ! did_action( 'elementor/loaded' ) ) {
			return $template;
		}

		return $this->render_custom_single_template( $page_id );
	}

	/**
	 * Render custom single template
	 *
	 * @param int $template_id Template page ID.
	 * @return string Path to custom template file.
	 */
	protected function render_custom_single_template( $template_id ) {
		global $auto_listings_custom_template_id;
		$auto_listings_custom_template_id = $template_id;

		$plugin_dir = dirname( dirname( __DIR__ ) );
		$template_path = $plugin_dir . '/templates/single-listing-custom.php';
		
		if ( ! file_exists( $template_path ) ) {
			if ( defined( 'AUTO_LISTINGS_DIR' ) ) {
				$template_path = AUTO_LISTINGS_DIR . '/templates/single-listing-custom.php';
			} else {
				$template_path = WP_PLUGIN_DIR . '/auto-listings-merto/templates/single-listing-custom.php';
			}
		}
		
		if ( ! file_exists( $template_path ) || ! is_readable( $template_path ) ) {
			return get_query_template( 'single' );
		}
		
		return $template_path;
	}

	/**
	 * Remove default listing hooks early in the request
	 */
	public function remove_default_listing_hooks_early() {
		if ( ! is_singular( 'auto-listing' ) ) {
			return;
		}

		$enabled = self::get( 'enable_custom_template', false );
		if ( ! $enabled ) {
			return;
		}

		$page_id = absint( self::get( 'custom_template_page', 0 ) );
		if ( ! $page_id || get_post_status( $page_id ) !== 'publish' ) {
			return;
		}

		$this->remove_default_listing_hooks();
	}

	/**
	 * Remove default listing content hooks when using custom template
	 */
	protected function remove_default_listing_hooks() {
		remove_all_actions( 'auto_listings_before_main_content' );
		remove_all_actions( 'auto_listings_after_main_content' );
		remove_all_actions( 'auto_listings_single_listing' );
		remove_all_actions( 'auto_listings_before_single_listing' );
		remove_all_actions( 'auto_listings_after_single_listing' );
		remove_all_actions( 'auto_listings_single_upper_full_width' );
		remove_all_actions( 'auto_listings_single_gallery' );
		remove_all_actions( 'auto_listings_single_content' );
		remove_all_actions( 'auto_listings_single_sidebar' );
		remove_all_actions( 'auto_listings_single_lower_full_width' );
		remove_all_actions( 'auto_listings_template_single_title' );
		remove_all_actions( 'auto_listings_template_single_gallery' );
		remove_all_actions( 'auto_listings_template_single_tagline' );
		remove_all_actions( 'auto_listings_template_single_description' );
		remove_all_actions( 'auto_listings_template_single_price' );
		remove_all_actions( 'auto_listings_template_single_at_a_glance' );
		remove_all_actions( 'auto_listings_template_single_address' );
		remove_all_actions( 'auto_listings_template_single_map' );
		remove_all_actions( 'auto_listings_template_single_contact_form' );
		remove_all_actions( 'auto_listings_output_listing_tabs' );
	}

	/**
	 * Add body class when using custom template
	 *
	 * @param array $classes Body classes.
	 * @return array
	 */
	public function add_custom_template_body_class( $classes ) {
		if ( ! is_singular( 'auto-listing' ) ) {
			return $classes;
		}

		$enabled = self::get( 'enable_custom_template', false );
		$page_id = absint( self::get( 'custom_template_page', 0 ) );

		if ( $enabled && $page_id && get_post_status( $page_id ) === 'publish' ) {
			$classes[] = 'auto-listings-custom-template';
			$classes[] = 'elementor-page';
			$classes[] = 'elementor-page-' . $page_id;
		}

		return $classes;
	}
}

