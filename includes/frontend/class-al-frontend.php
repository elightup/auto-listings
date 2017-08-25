<?php
/**
 * Auto_Listings Frontend
 *
 * @version  1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Auto_Listings_Frontend class.
 */
class Auto_Listings_Frontend {

	/**
	 * Constructor.
	 */
	public function __construct() {
		add_action( 'init', array( $this, 'includes' ) );
		add_action( 'body_class', array( $this, 'body_class' ) );
	}

	/**
	 * Include any files we need within frontend.
	 */
	public function includes() {

		include_once( 'class-al-template-loader.php' );
		include_once( 'class-al-enqueues.php' );
		include_once( 'template-hooks.php' );
		include_once( 'template-tags.php' );
	}

	/**
	 * Add body classes for our pages.
	 *
	 * @param  array $classes
	 * @return array
	 */
	public function body_class( $classes ) {
		$classes = (array) $classes;

		if ( is_auto_listings() ) {
			$classes[] = 'auto-listings';
		}

		return array_unique( $classes );
	}


	
}

return new Auto_Listings_Frontend();