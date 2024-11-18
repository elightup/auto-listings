<?php
namespace AutoListings\Updater;

class Tab {
	public function __construct() {
		add_action( 'init', [ $this, 'setup' ], 0 );
	}

	public function setup() {
		if ( ! $this->is_premium() ) {
			return;
		}
		add_filter( 'mb_settings_pages', [ $this, 'add_tab' ] );
		add_filter( 'rwmb_meta_boxes', [ $this, 'add_pane' ], 99 );
	}

	public function add_tab( array $settings_pages ): array {
		$settings_pages['auto-listings']['tabs']['license'] = __( 'License', 'auto-listings' );
		return $settings_pages;
	}

	public function add_pane( array $meta_boxes ): array {
		$meta_boxes[] = [
			'title'          => __( 'License', 'auto-listings' ),
			'id'             => 'auto-listings-license',
			'settings_pages' => [ 'auto-listings' ],
			'tab'            => 'license',
			'fields'         => [
				[
					'type'     => 'custom_html',
					'callback' => [ $this, 'render' ],
				],
			],
		];

		return $meta_boxes;
	}

	public function render() {
		ob_start();
		?>
		<p>
			<?php
			printf(
				// Translators: %s - Account page URL.
				wp_kses_post( __( 'Please enter your <a href="%s">license key</a> to enable automatic updates for Auto Listings plugins.', 'auto-listings' ) ),
				'https://wpautolistings.com/my-account/'
			);
			?>
		</p>
		<?php
		do_action( 'auto_listings_settings_license' );
		return ob_get_clean();
	}

	private function is_premium(): bool {
		return apply_filters( 'auto_listings_premium', false );
	}
}
