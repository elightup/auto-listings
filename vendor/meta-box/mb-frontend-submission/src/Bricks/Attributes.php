<?php
namespace MBFS\Bricks;

class Attributes {
	public function __construct() {
		add_filter( 'rwmb_frontend_dashboard_edit_page_atts', [ $this, 'get_attributes' ], 10, 2 );
	}

	public function get_attributes( array $attributes, int $post_id ): array {
		if ( ! empty( $attributes ) ) {
			return $attributes;
		}

		$data     = get_post_meta( $post_id, '_bricks_page_content_2', true ) ?: [];
		$data     = $data ?: [];
		$settings = $this->get_submit_form_settings( $data );

		return $settings ?: $attributes;
	}

	private function get_submit_form_settings( array $data ): array {
		foreach ( $data as $widget ) {
			$type = $widget['name'] ?? '';
			if ( $type === 'mbfs-form-submission' ) {
				return $widget['settings'];
			}
		}

		return [];
	}
}
