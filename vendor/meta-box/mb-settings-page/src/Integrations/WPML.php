<?php
namespace MBSP\Integrations;

class WPML {
	public function __construct() {
		if ( ! defined( 'ICL_SITEPRESS_VERSION' ) ) {
			return;
		}

		add_action( 'mb_settings_page_register', [ $this, 'register_options' ] );
	}

	public function register_options( array $args ): void {
		if ( empty( $args['option_name'] ) ) {
			return;
		}

		do_action( 'wpml_multilingual_options', $args['option_name'] );
	}
}