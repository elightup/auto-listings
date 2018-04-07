<?php
namespace AutoListings\Admin;

class Menu {
	public function __construct() {
		add_action( 'admin_head', [ $this, 'menu_highlight' ], 9 );
	}

	public function menu_highlight() {
		global $parent_file, $submenu_file;
		if ( isset( $_GET['post_type'] ) && $_GET['post_type'] == 'listing-enquiry' || get_post_type() == 'listing-enquiry' ) {
			$parent_file  = 'edit.php?post_type=auto-listing';
			$submenu_file = 'edit.php?post_type=listing-enquiry';
		}
	}
}
