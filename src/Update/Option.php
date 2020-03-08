<?php
namespace AutoListings\Update;

class Option {
	private $option = 'auto_listings_options';

	public function get( $name = null, $default = null ) {
		$option = get_option( $this->option, array() );
		return null === $name ? $option : ( isset( $option[ $name ] ) ? $option[ $name ] : $default );
	}

	public function get_license_key() {
		return $this->get( 'license_key' );
	}

	public function get_license_status() {
		return $this->get_license_key() ? $this->get( 'license_status', 'active' ) : 'no_key';
	}

	public function update( $option ) {
		$old_option = (array) $this->get();

		$option = array_merge( $old_option, $option );
		update_option( $this->option, $option );
	}
}
