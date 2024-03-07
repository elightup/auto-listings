<?php
namespace eLightUp\PluginUpdater;

class Option {
	private $manager;

	public function __construct( Manager $manager ) {
		$this->manager = $manager;
	}

	public function get( string $name, $fallback = '' ) {
		$option = get_option( $this->manager->option_name, [] );
		return $option[ $name ] ?? $fallback;
	}

	public function get_license_key(): string {
		return $this->get_license_key_constant() ?: $this->get( 'api_key' );
	}

	public function get_license_key_constant(): string {
		$const = strtoupper( str_replace( '-', '_', $this->manager->slug ) ) . '_KEY';
		return defined( $const ) ? constant( $const ) : '';
	}

	public function get_license_status(): string {
		return $this->get_license_key() ? $this->get( 'status', 'active' ) : 'no_key';
	}

	public function update( $option ): void {
		$old_option = (array) get_option( $this->manager->option_name, [] );
		$option     = array_merge( $old_option, $option );
		update_option( $this->manager->option_name, $option );
	}
}
