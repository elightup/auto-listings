<?php
namespace eLightUp\PluginSearch;

class Recommend extends Base {
	public function suggests() {
		$data = $this->data();
		foreach ( $data as $plugin ) {
			$this->insert( $plugin['slug'], $plugin['position'] );
		}
	}

	private function data(): array {
		return apply_filters( 'eps_recommend', [
			[
				'slug'     => 'slim-seo',
				'position' => 3,
			],
			[
				'slug'     => 'falcon',
				'position' => 4,
			],
		] );
	}

	protected function validate(): bool {
		global $tab;
		return in_array( $tab, [ 'featured', 'recommended' ], true );
	}
}
