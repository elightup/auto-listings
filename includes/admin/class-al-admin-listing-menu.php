<?php
/**
 * Setup menus in WP admin.
 *
 * @author   Auto_Listings
 * @category Admin
 * @package  Auto_Listings/Admin
 * @version  1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists( 'Auto_Listings_Admin_Listings_Menu' ) ) :

/**
 * Auto_Listings_Admin_Menus Class.
 */
class Auto_Listings_Admin_Listings_Menu {

	/**
	 * Hook in tabs.
	 */
	public function __construct() {
		//add_action( 'admin_menu', array( $this, 'listings_menu' ), 9 );
		add_action( 'admin_head', array( $this, 'menu_highlight' ), 9 );
	}

	/**
	 * Keep menu open.
	 *
	 * Highlights the wanted admin (sub-) menu items for the CPT.
	 */
	function menu_highlight() {
		global $parent_file, $submenu_file;
		if( isset( $_GET['post_type'] ) && $_GET['post_type'] == 'listing-enquiry' || get_post_type() == 'listing-enquiry' ) {
			$parent_file 	= 'edit.php?post_type=auto-listing';
			$submenu_file 	= 'edit.php?post_type=listing-enquiry';
		}
	}

}

endif;

return new Auto_Listings_Admin_Listings_Menu();
