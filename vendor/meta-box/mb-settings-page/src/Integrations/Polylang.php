<?php
namespace MBSP\Integrations;

class Polylang {
	public function __construct() {
		if ( ! class_exists( 'PLL_Translate_Option' ) ) {
			return;
		}

		add_action( 'mb_settings_page_register', [ $this, 'create_translations' ] );
	}

	public function create_translations( array $args ): void {
		if ( empty( $args['option_name'] ) ) {
			return;
		}

		$keys = [ '*' => 1 ];

		new \PLL_Translate_Option( $args['option_name'], $keys, [ 'context' => 'MB Settings Page' ] );
	}
}