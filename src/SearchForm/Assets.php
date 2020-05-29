<?php
namespace AutoListings\SearchForm;

class Assets {
	public function __construct() {
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue' ), 99 );
		add_action( 'wp_enqueue_scripts', array( $this, 'frontend_enqueue' ) );
	}

	public function frontend_enqueue() {
		// TODO: đổi tên file thành search-form.scss, include vào file CSS chính và bỏ enqueue này đi.
		wp_enqueue_style( 'als-frontend', AUTO_LISTINGS_URL . 'assets/css/frontend.css', array(), AUTO_LISTINGS_VERSION );
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
		wp_enqueue_style( 'als-admin', AUTO_LISTINGS_URL . 'assets/admin/css/searchform.css', AUTO_LISTINGS_VERSION );
		wp_enqueue_script( 'als-admin', AUTO_LISTINGS_URL . 'assets/admin/js/searchform.js', array( 'code-editor', 'underscore', 'wp-element' ), AUTO_LISTINGS_VERSION, true );
	}

	private function is_screen() {
		return 'auto-listings-search' === get_current_screen()->id;
	}
}
