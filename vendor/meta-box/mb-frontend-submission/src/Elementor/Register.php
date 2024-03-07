<?php
namespace MBFS\Elementor;

class Register {
	public function __construct() {
		add_action( 'elementor/widgets/register', [ $this, 'register' ] );
	}

	public function register( $widgets_manager ) {
		if ( ! defined( 'ELEMENTOR_VERSION' ) ) {
			return;
		}
		$widgets_manager->register( new SubmissionForm() );
		$widgets_manager->register( new UserDashboard() );

		new Attributes();
	}
}
