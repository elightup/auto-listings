<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;



/**
 * Auto_Listings_Enqueues class.
 */
class Auto_Listings_Enqueues {

	/**
	 * @var Listings_Wp The one true Listings_Wp Customizer Output 
	 * @since 1.0.0
	 */
	protected static $_instance = null;


	/**
	 * @since 1.0.0
	 */
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	public function __construct() {
		$this->init_hooks();
	}

	/**
	 * Hook into actions and filters.
	 * @since  1.0.0
	 */
	private function init_hooks() {
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_styles_scripts' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'add_inline_css' ), 11 );
	}


	/**
	 * All Stylesheets And Scripts
	 * 
	 * @return void
	 */
	public function enqueue_styles_scripts(){
		
		global $post;

		$url = AUTOLISTINGS_PLUGIN_URL;
		$ver = AUTOLISTINGS_VERSION;

		$css_dir 	= 'assets/css/';
		$js_dir 	= 'assets/js/';

		$api_url 	= auto_listings_google_maps_url();

		if( is_auto_listings() ) {

			/*
			 * Enqueue styles
			 */
			wp_enqueue_style( 'auto-listings-icons', AUTOLISTINGS_PLUGIN_URL . 'assets/css/auto-listings-icons.css', array(), $ver, 'all' );
			wp_enqueue_style( 'auto-listings-fontawesome', AUTOLISTINGS_PLUGIN_URL . 'assets/css/font-awesome.min.css', array(), $ver, 'all' );
		    wp_enqueue_style( 'auto-listings-sumoselect', $url . $css_dir . 'sumoselect.min.css', array(), $ver, 'all' );


			if( is_listing() ) {
				wp_enqueue_style( 'auto-listings-lightslider', $url . $css_dir . 'lightslider.css', array(), $ver, 'all' );
				wp_enqueue_style( 'auto-listings-lightgallery', $url . $css_dir . 'lightgallery.css', array(), $ver, 'all' );
			}

			wp_enqueue_style( 'auto-listings', $url . $css_dir . 'auto-listings.css', array(), $ver, 'all' );


			/*
			 * Enqueue scripts
			 */
		    wp_enqueue_script( 'auto-listings-sumoselect', $url . $js_dir . 'sumoselect.min.js', array( 'jquery' ), $ver, true );

			if( is_listing() ) {
				if( $api_url && ! auto_listings_hide_item( 'map' ) ) {
					wp_enqueue_script( 'al-google-maps', $api_url );
				}
				wp_enqueue_script( 'auto-listings-lightslider', $url . $js_dir . 'lightslider.js', array( 'jquery' ), $ver, true );
				wp_enqueue_script( 'auto-listings-lightgallery', $url . $js_dir . 'lightgallery.js', array( 'jquery' ), $ver, true );
			}
			
			wp_enqueue_script( 'auto-listings', $url . $js_dir . 'auto-listings.js', array( 'jquery' ), $ver, true );
			
			/*
			 * Localize our script
			 */
			$localized_array = array();

			$gallery_array = array(
				'gallery_mode' 	=> auto_listings_option( 'gallery_mode' ) ? auto_listings_option( 'gallery_mode' ) : 'fade',
				'auto_slide' 	=> auto_listings_option( 'auto_slide' ) == 'no' ? false : true,
				'slide_delay' 	=> auto_listings_option( 'slide_delay' ) ? auto_listings_option( 'slide_delay' ) : 3000,
				'slide_duration'=> auto_listings_option( 'slide_duration' ) ? auto_listings_option( 'slide_duration' ) : 3000,
				'thumbs_shown' 	=> auto_listings_option( 'thumbs_shown' ) ? auto_listings_option( 'thumbs_shown' ) : 6,
			);

			$map_array = array(
				'map_width' 	=> auto_listings_option( 'map_width' ),
				'map_height' 	=> auto_listings_option( 'map_height' ),
				'map_zoom' 		=> auto_listings_option( 'map_zoom' ),
				'lat' 			=> auto_listings_meta( 'lat', auto_listings_get_ID() ),
				'lng' 			=> auto_listings_meta( 'lng', auto_listings_get_ID() ),
				'address' 		=> auto_listings_meta( 'displayed_address', auto_listings_get_ID() ),
			);

			$general_array = array(
				'list_grid_view'=> auto_listings_option( 'list_grid_view' ),
			);

			$localized_array = array_merge( $gallery_array, $map_array, $general_array );

			wp_localize_script( 'auto-listings', 'auto_listings', apply_filters( 'auto_listings_localized_script', $localized_array ) );

		}

	}
	

	/**
	 * Add some inline CSS
	 *
	 */
	public function add_inline_css() {

		$options = get_option( 'auto_listings_options' );

		if( ! $options )
			return;

		$css = '';

		foreach ( $options as $key => $value ) {
			
			if( $key == 'button_bg_color' ) {
				$css .= '.auto-listings .al-button, .auto-listings .contact-form .button-primary { background-color: ' . esc_html( $value ) . '; border-color: ' . esc_html( $value ) . '}';
				$css .= '.auto-listings .al-button:hover, .auto-listings .contact-form .button-primary:hover { color: ' . esc_html( $value ) . '; }';
				$css .= '.auto-listings-single .image-gallery .lSPager.lSGallery li.active, .auto-listings-single .image-gallery .lSPager.lSGallery li:hover, .auto-listings-search .area-wrap .area:focus, .auto-listings-search .area-wrap .area:active { border-color: ' . esc_html( $value ) . '; }';
				$css .= '.auto-listings .auto-listings-tabs ul.tabs li.active { box-shadow: 0 3px 0 ' . esc_html( $value ) . ' inset; }';
			}
			if( $key == 'button_text_color' ) {
				$css .= '.auto-listings .al-button, .auto-listings .contact-form .button-primary { color: ' . esc_html( $value ) . '; }';
				$css .= '.auto-listings .al-button:hover, .auto-listings .contact-form .button-primary:hover { background-color: ' . esc_html( $value ) . '; }';
			}
			if( $key == 'price_color' ) {
				$css .= '.auto-listings .price { color: ' . esc_html( $value ) . '; }';
			}
			if( $key == 'contact_icon_color' ) {
				$css .= '.auto-listings .contact i { color: ' . esc_html( $value ) . '; }';
			}
			if( $key == 'listing_icon_color' ) {
				$css .= '.auto-listings .at-a-glance li i { color: ' . esc_html( $value ) . '; }';
			}
		}
		
		//Add the above custom CSS via wp_add_inline_style
		wp_add_inline_style( 'auto-listings', apply_filters( 'auto_listings_inline_css_output', $css ) ); 

	}


}


return new Auto_Listings_Enqueues();