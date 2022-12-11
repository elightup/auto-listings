<?php
namespace SlimSEO\Updater;

use eLightUp\PluginUpdater\Settings as PluginUpdaterSettings;

class Settings extends PluginUpdaterSettings {
	public function setup() {
		add_action( 'slim_seo_settings_license', [ $this, 'render' ] );
		add_action( 'slim_seo_save', [ $this, 'save' ] );
	}

	public function render() {
		?>
		<table class="form-table">
			<tr>
				<th scope="row"><?= esc_html( $this->manager->plugin->Name ); ?></th>
				<td>
					<?php $this->render_input() ?>
				</td>
			</tr>
		</table>
		<?php
	}
}
