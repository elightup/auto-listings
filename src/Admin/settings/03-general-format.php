<?php
return [
	'id'             => 'price_format',
	'title'          => __( 'Price Format', 'auto-listings' ),
	'settings_pages' => 'auto-listings',
	'tab'            => 'general',
	'fields'         => [
		[
			'name'    => __( 'Currency Position', 'auto-listings' ),
			'id'      => 'currency_position',
			'type'    => 'select',
			'options' => [
				'left'        => __( 'Left ($100)', 'auto-listings' ),
				'right'       => __( 'Right (100$)', 'auto-listings' ),
				'left_space'  => __( 'Left with space ($ 100)', 'auto-listings' ),
				'right_space' => __( 'Right with space (100 $)', 'auto-listings' ),
			],
		],
		[
			'name' => __( 'Currency Symbol', 'auto-listings' ),
			'id'   => 'currency_symbol',
			'type' => 'text',
			'std'  => '$',
		],
		[
			'name' => __( 'Thousand Separator', 'auto-listings' ),
			'desc' => __( '', 'auto-listings' ),
			'id'   => 'thousand_separator',
			'type' => 'text',
			'std'  => ',',
		],
		[
			'name'    => __( 'Include Decimals', 'auto-listings' ),
			'desc'    => __( '', 'auto-listings' ),
			'id'      => 'include_decimals',
			'type'    => 'select',
			'options' => [
				'no'  => __( 'No, do not include decimals in price', 'auto-listings' ),
				'yes' => __( 'Yes, include decimals in price', 'auto-listings' ),
			],
			'std'     => 'no',
		],
		[
			'name' => __( 'Decimal Separator', 'auto-listings' ),
			'desc' => __( '', 'auto-listings' ),
			'id'   => 'decimal_separator',
			'type' => 'text',
			'std'  => '.',
		],
		[
			'name' => __( 'Number of Decimals', 'auto-listings' ),
			'desc' => __( '', 'auto-listings' ),
			'id'   => 'decimals',
			'type' => 'number',
			'std'  => 2,
		],
	],
];
