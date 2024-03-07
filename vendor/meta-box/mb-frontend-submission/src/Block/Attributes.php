<?php
namespace MBFS\Block;

use MBFS\Helper;

class Attributes {
	public function __construct() {
		add_filter( 'rwmb_frontend_dashboard_edit_page_atts', [ $this, 'get_attributes' ], 10, 2 );
	}

	public function get_attributes( array $attributes, int $edit_page_id ): array {
		if ( ! empty( $attributes ) || ! has_block( 'meta-box/submission-form', $edit_page_id ) ) {
			return $attributes;
		}

		$edit_page = get_post( $edit_page_id );
		$content   = Helper::get_post_content( $edit_page );
		$blocks    = parse_blocks( $content );

		foreach ( $blocks as $block ) {
			if ( $block['blockName'] === 'meta-box/submission-form' ) {
				return $block['attrs'];
			}
		}

		return $attributes;
	}
}
