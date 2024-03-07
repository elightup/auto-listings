<?php
namespace MBFS\Bricks;

class Register {
	public function __construct() {
		add_action( 'init', [ $this, 'register' ], 99 );
	}

	public function register() {
		if ( ! defined( 'BRICKS_VERSION' ) ) {
			return;
		}

		$elements = [
			__DIR__ . '/SubmissionForm.php',
			__DIR__ . '/UserDashboard.php',
		];

		foreach ( $elements as $element ) {
			\Bricks\Elements::register_element( $element );
		}

		new Attributes();
	}
}
