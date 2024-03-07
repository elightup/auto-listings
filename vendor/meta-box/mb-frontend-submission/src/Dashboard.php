<?php
namespace MBFS;

class Dashboard {
	private $dashboard_renderer;

	public function __construct( DashboardRenderer $dashboard_renderer ) {
		$this->dashboard_renderer = $dashboard_renderer;

		add_shortcode( 'mb_frontend_dashboard', [ $this, 'shortcode' ] );
	}

	public function shortcode( $atts ) {
		/*
		 * Do not render the shortcode in the admin.
		 * Prevent errors with enqueue assets in Gutenberg where requests are made via REST to preload the post content.
		 */
		return is_admin() ? '' : $this->dashboard_renderer->render( $atts );
	}
}
