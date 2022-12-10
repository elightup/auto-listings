<?php
namespace MBFS;

class HideFields {
	public function __construct() {
		add_action( 'rwmb_frontend_before_form', [ $this, 'add_hook_to_hide_fields' ] );
		add_action( 'rwmb_frontend_after_form', [ $this, 'remove_hook_to_hide_fields' ] );

		add_action( 'rwmb_frontend_before_process', [ $this, 'add_hook_to_bypass_save' ] );
		add_action( 'rwmb_frontend_after_process', [ $this, 'remove_hook_to_bypass_save' ] );
	}

	public function add_hook_to_hide_fields() {
		add_filter( 'rwmb_outer_html', [ $this, 'hide_fields' ], 10, 2 );
	}

	public function remove_hook_to_hide_fields() {
		remove_filter( 'rwmb_outer_html', [ $this, 'hide_fields' ], 10 );
	}

	public function hide_fields( $output, $field ) {
		return empty( $field['hide_from_front'] ) ? $output : '';
	}

	public function add_hook_to_bypass_save() {
		add_filter( 'rwmb_field', [ $this, 'bypass_save' ] );
	}

	public function remove_hook_to_bypass_save() {
		remove_filter( 'rwmb_field', [ $this, 'bypass_save' ] );
	}

	public function bypass_save( $field ) {
		if ( ! empty( $field['hide_from_front'] ) ) {
			$field['save_field'] = false;
		}
		return $field;
	}
}
