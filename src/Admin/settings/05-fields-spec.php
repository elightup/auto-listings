<?php
$spec_fields = [
	'model_year'              => [
		'label' => __( 'Year', 'auto-listings' ),
		'type'  => 'model',
		'desc'  => __( '(Recommended)', 'auto-listings' ),
	],
	'make_display'            => [
		'label' => __( 'Make', 'auto-listings' ),
		'type'  => 'general',
		'desc'  => __( '(Recommended)', 'auto-listings' ),
	],
	'model_name'              => [
		'label' => __( 'Model', 'auto-listings' ),
		'type'  => 'model',
		'desc'  => __( '(Recommended)', 'auto-listings' ),
	],
	'model_vehicle'           => [
		'label' => __( 'Vehicle', 'auto-listings' ),
		'type'  => 'model',
		'desc'  => __( '(Recommended)', 'auto-listings' ),
	],
	'model_seats'             => [
		'label' => __( 'Seats', 'auto-listings' ),
		'type'  => 'general',
		'desc'  => __( '(Recommended)', 'auto-listings' ),
	],
	'model_doors'             => [
		'label' => __( 'Doors', 'auto-listings' ),
		'type'  => 'general',
		'desc'  => __( '(Recommended)', 'auto-listings' ),
	],

	// transmission
	'model_drive'             => [
		'label' => __( 'Drive Type', 'auto-listings' ),
		'type'  => 'transmission',
		'desc'  => __( '(Recommended)', 'auto-listings' ),
	],
	'model_transmission_type' => [
		'label' => __( 'Transmission Type', 'auto-listings' ),
		'type'  => 'transmission',
		'desc'  => __( '(Recommended)', 'auto-listings' ),
	],

	// fuel
	'model_engine_fuel'       => [
		'label' => __( 'Fuel Type', 'auto-listings' ),
		'type'  => 'fuel',
		'desc'  => __( '(Recommended)', 'auto-listings' ),
	],
];

$metric_fields = [
	// fuel
	'model_lkm_hwy'       => [
		'label' => __( 'Fuel Economy Highway (l/100km)', 'auto-listings' ),
		'type'  => 'fuel',
	],
	'model_lkm_mixed'     => [
		'label' => __( 'Fuel Economy Mixed (l/100km)', 'auto-listings' ),
		'type'  => 'fuel',
	],
	'model_lkm_city'      => [
		'label' => __( 'Fuel Economy City (l/100km)', 'auto-listings' ),
		'type'  => 'fuel',
	],
	'model_fuel_cap_l'    => [
		'label' => __( 'Fuel Capacity (l):', 'auto-listings' ),
		'type'  => 'fuel',
	],

	// dimensions
	'model_weight_kg'     => [
		'label' => __( 'Weight (kg)', 'auto-listings' ),
		'type'  => 'weight_dimensions',
	],
	'model_length_mm'     => [
		'label' => __( 'Length (mm)', 'auto-listings' ),
		'type'  => 'weight_dimensions',
	],
	'model_width_mm'      => [
		'label' => __( 'Width (mm)', 'auto-listings' ),
		'type'  => 'weight_dimensions',
	],
	'model_height_mm'     => [
		'label' => __( 'Height (mm)', 'auto-listings' ),
		'type'  => 'weight_dimensions',
	],
	'model_wheelbase_mm'  => [
		'label' => __( 'Wheelbase (mm)', 'auto-listings' ),
		'type'  => 'weight_dimensions',
	],

	// performance
	'model_0_to_100_kph'  => [
		'label' => __( '0-100 kph', 'auto-listings' ),
		'type'  => 'performance',
	],
	'model_top_speed_kph' => [
		'label' => __( 'Top Speed (KPH)', 'auto-listings' ),
		'type'  => 'performance',
	],

	// engine
	'model_engine_cc'     => [
		'label' => __( 'Engine Displacement (cc)', 'auto-listings' ),
		'type'  => 'engine',
	],


];

$imperial_fields = [
	// fuel
	'model_mpg_hwy'       => [
		'label' => __( 'Fuel Economy Highway (mpg)', 'auto-listings' ),
		'type'  => 'fuel',
	],
	'model_mpg_city'      => [
		'label' => __( 'Fuel Economy City (mpg)', 'auto-listings' ),
		'type'  => 'fuel',
	],
	'model_mpg_mixed'     => [
		'label' => __( 'Fuel Economy Mixed (mpg)', 'auto-listings' ),
		'type'  => 'fuel',
	],
	'model_fuel_cap_g'    => [
		'label' => __( 'Fuel Capacity (g)', 'auto-listings' ),
		'type'  => 'fuel',
	],

	// dimensions
	'model_weight_lbs'    => [
		'label' => __( 'Weight (lbs)', 'auto-listings' ),
		'type'  => 'weight_dimensions',
	],
	'model_length_in'     => [
		'label' => __( 'Length (in)', 'auto-listings' ),
		'type'  => 'weight_dimensions',
	],
	'model_width_in'      => [
		'label' => __( 'Width (in)', 'auto-listings' ),
		'type'  => 'weight_dimensions',
	],
	'model_height_in'     => [
		'label' => __( 'Height (in)', 'auto-listings' ),
		'type'  => 'weight_dimensions',
	],
	'model_wheelbase_in'  => [
		'label' => __( 'Wheelbase (in)', 'auto-listings' ),
		'type'  => 'weight_dimensions',
	],

	// performance
	'model_0_to_100_kph'  => [
		'label' => __( '0-62 mph', 'auto-listings' ),
		'type'  => 'performance',
	],
	'model_top_speed_mph' => [
		'label' => __( 'Top Speed (mph)', 'auto-listings' ),
		'type'  => 'performance',
	],

	// engine
	'model_engine_ci'     => [
		'label' => __( 'Engine Displacement (ci)', 'auto-listings' ),
		'type'  => 'engine',
	],
];

$engine_fields = [

	// engine
	'model_engine_position'       => [
		'label' => __( 'Engine Location', 'auto-listings' ),
		'type'  => 'engine',
	],
	'model_engine_type'           => [
		'label' => __( 'Engine Type', 'auto-listings' ),
		'type'  => 'engine',
		'desc'  => __( '(Recommended)', 'auto-listings' ) . '<br>' . __( 'Data from this field is used for the "Engine" icon text', 'auto-listings' ),
	],
	'model_engine_l'              => [
		'label' => __( 'Engine (l)', 'auto-listings' ),
		'type'  => 'engine',
		'desc'  => __( '(Recommended)', 'auto-listings' ) . '<br>' . __( 'Data from this field is used for the "Engine" icon text', 'auto-listings' ),
	],
	'model_engine_cyl'            => [
		'label' => __( 'Engine Cylinders', 'auto-listings' ),
		'type'  => 'engine',
		'desc'  => __( '(Recommended)', 'auto-listings' ) . '<br>' . __( 'Data from this field is used for the "Engine" icon text', 'auto-listings' ),
	],
	'model_engine_valves'         => [
		'label' => __( 'Engine Valves', 'auto-listings' ),
		'type'  => 'engine',
	],
	'model_engine_valves_per_cyl' => [
		'label' => __( 'Engine Valves Per Cyl', 'auto-listings' ),
		'type'  => 'engine',
	],
	'model_engine_power_hp'       => [
		'label' => __( 'Engine Max Power (HP)', 'auto-listings' ),
		'type'  => 'engine',
	],
	'model_engine_power_kw'       => [
		'label' => __( 'Engine Max Power (kW)', 'auto-listings' ),
		'type'  => 'engine',
	],
	'model_engine_power_ps'       => [
		'label' => __( 'Engine Max Power (PS)', 'auto-listings' ),
		'type'  => 'engine',
	],
	'model_engine_power_rpm'      => [
		'label' => __( 'Engine Max Power RPM', 'auto-listings' ),
		'type'  => 'engine',
	],
	'model_engine_torque_nm'      => [
		'label' => __( 'Engine Max Torque (NM)', 'auto-listings' ),
		'type'  => 'engine',
	],
	'model_engine_torque_lbft'    => [
		'label' => __( 'Engine Max Torque (Lb-Ft)', 'auto-listings' ),
		'type'  => 'engine',
	],
	'model_engine_torque_kgm'     => [
		'label' => __( 'Engine Max Torque (kgf-m)', 'auto-listings' ),
		'type'  => 'engine',
	],
	'model_engine_torque_rpm'     => [
		'label' => __( 'Engine Max Torque RPM', 'auto-listings' ),
		'type'  => 'engine',
	],
	'model_engine_bore_mm'        => [
		'label' => __( 'Engine Bore (mm)', 'auto-listings' ),
		'type'  => 'engine',
	],
	'model_engine_stroke_mm'      => [
		'label' => __( 'Engine Stroke (mm)', 'auto-listings' ),
		'type'  => 'engine',
	],
	'model_engine_compression'    => [
		'label' => __( 'Engine Compression Ratio', 'auto-listings' ),
		'type'  => 'engine',
	],

	'make_country' => [
		'label' => __( 'Country', 'auto-listings' ),
		'type'  => 'general',
	],

];

$fields = array_merge( $spec_fields, $metric_fields, $imperial_fields, $engine_fields );

$options = [];
foreach ( $fields as $id => $field ) {
	$label = $field['label'];
	if ( isset( $field['desc'] ) ) {
		$label .= ' <span class="description">' . $field['desc'] . '</span>';
	}
	$options[ $id ] = $label;
}

return [
	'id'             => 'display_fields',
	'title'          => __( 'Listing Spec Fields', 'auto-listings' ),
	'settings_pages' => 'auto-listings',
	'tab'            => 'fields',
	'fields'         => [
		[
			'name'            => __( 'Spec Fields to Display', 'auto-listings' ),
			'before'          => '<p>' . __( 'The specification fields you would like to display in the admin and frontend.', 'auto-listings' ) . '</p>',
			'id'              => 'field_display',
			'type'            => 'checkbox_list',
			'options'         => $options,
			'select_all_none' => true,
		],
	],
];
