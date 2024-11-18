<?php
namespace AutoListings\Updater;

use eLightUp\PluginUpdater\Settings as PluginUpdaterSettings;

class Settings extends PluginUpdaterSettings {
	public function setup() {
		add_action( 'auto_listings_settings_license', [ $this, 'render' ] );
		add_action( 'rwmb_auto-listings-license_after_save_post', [ $this, 'save' ] );
	}

	public function render() {
		?>
		<table class="form-table">
			<tr>
				<th scope="row"><?php echo esc_html( $this->manager->plugin->Name ); ?></th>
				<td>
					<?php $this->render_input() ?>
				</td>
			</tr>
		</table>
		<?php
	}
}
