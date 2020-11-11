<?php
/**
 * Price format setting fields.
 *
 * @package Auto Listings.
 */

return [
	'id'             => 'price_format',
	'title'          => __( 'Price Format', 'auto-listings' ),
	'settings_pages' => 'auto-listings',
	'tab'            => 'general',
	'fields'         => apply_filters( 'auto_listings_price_format_fields', [
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
			'desc' => '',
			'id'   => 'thousand_separator',
			'type' => 'text',
			'std'  => ',',
		],
		[
			'name'    => __( 'Include Decimals', 'auto-listings' ),
			'desc'    => '',
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
			'desc' => '',
			'id'   => 'decimal_separator',
			'type' => 'text',
			'std'  => '.',
		],
		[
			'name' => __( 'Number of Decimals', 'auto-listings' ),
			'desc' => '',
			'id'   => 'decimals',
			'type' => 'number',
			'std'  => 2,
		],
		[
			'id'          => 'price_range',
			'name'        => __( 'Price Range', 'auto-listings' ),
			'type'        => 'text',
			'desc' => __( 'Enter your price range here, from lowest to highest, seperated by the comma. If this is left empty, our default price range will be used.', 'auto-listings' ),
		],
	] ),
];
