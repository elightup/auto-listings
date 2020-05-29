<?php
namespace AutoListings\SearchForm;

class Assets {
	public function __construct() {
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue' ), 99 );
	}

	public function admin_enqueue() {
		if ( ! $this->is_screen() ) {
			return;
		}
		wp_enqueue_code_editor(
			array(
				'type' => 'application/x-httpd-php',
			)
		);

		// TODO: Đổi tên file thành search-form
		wp_enqueue_style( 'als-admin', AUTO_LISTINGS_URL . 'assets/admin/css/search-form.css', AUTO_LISTINGS_VERSION );
		wp_enqueue_script( 'als-admin', AUTO_LISTINGS_URL . 'assets/admin/js/search-form.js', array( 'code-editor', 'underscore', 'wp-element' ), AUTO_LISTINGS_VERSION, true );
	}

	private function is_screen() {
		return 'auto-listings-search' === get_current_screen()->id;
	}
}
