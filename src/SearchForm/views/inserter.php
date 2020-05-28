<div class="als-inserter">
	<?php
	/**
	 * Field list
	 */
	$als_fields = [
		'condition'       => 'Condition',
		'make'            => 'Make',
		'model'           => 'Model',
		'price'           => 'Price',
		'min_price'       => 'Min Price',
		'max_price'       => 'Max Price',
		'year'            => 'Year',
		'body_type'       => 'Body Type',
		'odometer'        => 'Odometer',
		'transmission'    => 'Transmission',
		'drivetrain'      => 'Drivetrain',
		'engine'          => 'Engine',
		'fuel_type'       => 'Fuel Type',
		'exterior_colors' => 'Exterior Colors'
	];

	asort( $als_fields );

	/**
	 * Special fields
	 */
	$als_special_fields = [
		'total_listings' => 'Total Listings',
	];
	?>
	
	<div class="widefat">
		<h3><?php esc_html_e( 'Field list', 'auto-listings' ) ?></h3>
		<div class="als-fields">
			<?php foreach ( $als_fields as $field => $name ) : ?>
				<span class="button btn-insert_modal"
						data-tab="template-editor"
						data-field='<?php esc_html_e( $field, 'auto-listings' ) ?>'
						data-type="field">
						<?php esc_html_e( $name, 'auto-listings' ) ?>
				</span>
			<?php endforeach; ?>
		</div>

		<hr>

		<div class="als-fields">
			<?php foreach ( $als_special_fields as $field => $name ) : ?>
				<span class="button btn-insert_field"
						data-tab="template-editor"
						data-field='<?php printf( '[als_%s]', $field, 'auto-listings' ) ?>'>
						<?php esc_html_e( $name, 'auto-listings' ) ?>
				</span>
			<?php endforeach; ?>

			<span class="button btn-insert_modal"
					data-tab="template-editor"
					data-field='<?php echo '[als_button]'; ?>'
					data-type="button">
					<?php esc_html_e( 'Button', 'auto-listings' ) ?>
			</span>
		</div>
	</div>
</div>

<div id="als-fields"></div>