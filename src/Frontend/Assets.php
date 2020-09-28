<?php
/**
 * Enqueue scripts and styles on frontend.
 *
 * @package Auto Listings.
 */

namespace AutoListings\Frontend;

/**
 * Class Assets
 */
class Assets {

	/**
	 * Add hooks when module is loaded.
	 */
	public function __construct() {
		add_action( 'wp_enqueue_scripts', [ $this, 'enqueue' ] );
		add_action( 'wp_enqueue_scripts', [ $this, 'add_inline_css' ], 11 );
	}

	/**
	 * Enqueue script on frontend.
	 */
	public function enqueue() {
		if ( ! is_auto_listings() ) {
			return;
		}
		$ver = AUTO_LISTINGS_VERSION;

		$css_url = AUTO_LISTINGS_URL . 'assets/css/';
		$js_url  = AUTO_LISTINGS_URL . 'assets/js/';

		$api_url = auto_listings_google_maps_url();

		wp_enqueue_style( 'auto-listings-icons', $css_url . 'auto-listings-icons.css', [], $ver );
		wp_enqueue_style( 'auto-listings-fontawesome', $css_url . 'font-awesome.min.css', [], $ver );
		wp_enqueue_style( 'auto-listings-sumoselect', $css_url . 'sumoselect.min.css', [], $ver );

		wp_enqueue_style( 'auto-listings', $css_url . 'auto-listings.css', [], $ver );

		wp_enqueue_script( 'auto-listings-sumoselect', $js_url . 'sumoselect.min.js', [ 'jquery' ], $ver, true );

		if ( is_listing() ) {
			if ( $api_url && ! auto_listings_hide_item( 'map' ) ) {
				wp_enqueue_script( 'auto-listings-google-maps', $api_url, [], $ver, true );
			}
			wp_enqueue_script( 'auto-listings-lightslider', $js_url . 'lightslider.js', [ 'jquery' ], $ver, true );
			wp_enqueue_style( 'auto-listings-lightslider', $css_url . 'lightslider.css', [], $ver );
		}

		wp_enqueue_script( 'auto-listings', $js_url . 'auto-listings.js', [ 'jquery' ], $ver, true );

		$map_array = [
			'map_width'  => auto_listings_option( 'map_width' ),
			'map_height' => auto_listings_option( 'map_height' ),
			'map_zoom'   => auto_listings_option( 'map_zoom' ),
			'lat'        => auto_listings_meta( 'lat', auto_listings_get_ID() ),
			'lng'        => auto_listings_meta( 'lng', auto_listings_get_ID() ),
			'address'    => auto_listings_meta( 'displayed_address', auto_listings_get_ID() ),
		];

		$general_array = [
			'ajaxUrl'        => admin_url( 'admin-ajax.php' ),
			'list_grid_view' => auto_listings_option( 'list_grid_view' ),
		];

		$localized_array = array_merge( $map_array, $general_array );

		wp_localize_script( 'auto-listings', 'auto_listings', apply_filters( 'auto_listings_localized_script', $localized_array ) );
	}

	/**
	 * Add inline CSS.
	 */
	public function add_inline_css() {
		$options = get_option( 'auto_listings_options' );
		if ( ! $options ) {
			return;
		}

		$css = '';
		foreach ( $options as $key => $value ) {
			if ( 'button_bg_color' === $key ) {
				$css .= '.auto-listings .al-button, .auto-listings .contact-form .button-primary { background-color: ' . esc_html( $value ) . '; border-color: ' . esc_html( $value ) . '}';
				$css .= '.auto-listings .al-button:hover, .auto-listings .contact-form .button-primary:hover { color: ' . esc_html( $value ) . '; }';
				$css .= '.auto-listings-single .image-gallery .lSPager.lSGallery li.active, .auto-listings-single .image-gallery .lSPager.lSGallery li:hover, .auto-listings-search .area-wrap .area:focus, .auto-listings-search .area-wrap .area:active { border-color: ' . esc_html( $value ) . '; }';
				$css .= '.auto-listings .auto-listings-tabs ul.tabs li.active { box-shadow: 0 3px 0 ' . esc_html( $value ) . ' inset; }';
			}
			if ( 'button_text_color' === $key ) {
				$css .= '.auto-listings .al-button, .auto-listings .contact-form .button-primary { color: ' . esc_html( $value ) . '; }';
				$css .= '.auto-listings .al-button:hover, .auto-listings .contact-form .button-primary:hover { background-color: ' . esc_html( $value ) . '; }';
			}
			if ( 'price_color' === $key ) {
				$css .= '.auto-listings .price { color: ' . esc_html( $value ) . '; }';
			}
			if ( 'contact_icon_color' === $key ) {
				$css .= '.auto-listings .contact i { color: ' . esc_html( $value ) . '; }';
			}
			if ( 'listing_icon_color' === $key ) {
				$css .= '.auto-listings .at-a-glance li i { color: ' . esc_html( $value ) . '; }';
			}
		}

		// Add the above custom CSS via wp_add_inline_style.
		wp_add_inline_style( 'auto-listings', apply_filters( 'auto_listings_inline_css_output', $css ) );
	}
}
