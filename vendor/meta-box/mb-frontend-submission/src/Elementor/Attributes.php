<?php
namespace MBFS\Elementor;

class Attributes {
	public function __construct() {
		add_filter( 'rwmb_frontend_dashboard_edit_page_atts', [ $this, 'get_attributes' ], 10, 2 );
	}

	public function get_attributes( array $attributes, int $post_id ): array {
		if ( ! empty( $attributes ) ) {
			return $attributes;
		}

		$data     = get_post_meta( $post_id, '_elementor_data', true ) ?: '';
		$data     = json_decode( $data, true ) ?: [];
		$settings = $this->get_submit_form_settings( $data );

		return $settings ?: $attributes;
	}

	private function get_submit_form_settings( array $data ) {
		foreach ( $data as $widget ) {
			$type = $widget['widgetType'] ?? '';
			if ( $type === 'mbfs_submission_form' ) {
				return $widget['settings'];
			}
			if ( empty( $widget['elements'] ) ) {
				continue;
			}
			$settings = $this->get_submit_form_settings( $widget['elements'] );
			if ( ! empty( $settings ) ) {
				return $settings;
			}
		}

		return [];
	}
}
