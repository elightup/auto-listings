<div class="als-inserter">
	<?php
	/**
	 * Special fields
	 */
	$als_special_fields = [
		'total_listings' => 'Total Listings',
	];
	?>
	
	<div class="widefat">
		<h3><?php esc_html_e( 'Field list', 'auto-listings' ) ?></h3>
		<div class="als-fields" id="als-fields"></div>

		<hr>

		<div class="als-fields">
			<?php foreach ( $als_special_fields as $field => $name ) : ?>
				<span class="button btn-insert_field"
						data-tab="template-editor"
						data-field='<?php printf( '[als_%s]', $field, 'auto-listings' ) ?>'>
						<?php esc_html_e( $name, 'auto-listings' ) ?>
				</span>
			<?php endforeach; ?>
		</div>
	</div>
</div>