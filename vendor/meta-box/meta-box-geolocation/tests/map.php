<?php
/**
 * Test for map field type.
 */
add_filter('rwmb_meta_boxes', function ($meta_boxes) {
	$meta_boxes[] = [
		'id'     => 'geolocation6',
		'title'  => 'GeoLocation6',
		'geo'    => true,
		'fields' => [
			[
				// In cloneable groups.
				'type'   => 'group',
				'name'   => 'Locations',
				'id'     => 'g',
				'clone'  => true,
				'fields' => [
					[
						'type' => 'text',
						'name' => 'Address',
						'id'   => 'address6',
					],
					[
						'type'          => 'text',
						'name'          => 'City',
						'id'            => 'city',
						'address_field' => 'address6',
					],
					[
						'type'          => 'text',
						'name'          => 'Country',
						'id'            => 'country',
						'address_field' => 'address6',
					],
					[
						'type'          => 'text',
						'name'          => 'Latitude',
						'id'            => 'lat',
						'address_field' => 'address6',
					],
					[
						'type'          => 'text',
						'name'          => 'Longitude',
						'id'            => 'lng',
						'address_field' => 'address6',
					],
					[
						'id'            => 'map',
						'type'          => 'map',
						'name'          => 'Map',
						'address_field' => 'address6',
						'language'      => 'en',
						'api_key'       => 'AIzaSyBb56UrxiGrfXlVmtHPVaAoxt_8zDQcLws',
					],
				],
			],

			// Another group of fields in the same meta box.
			[
				'type' => 'text',
				'name' => 'Address7',
				'id'   => 'address7',
			],
			[
				'type'          => 'text',
				'name'          => 'City7',
				'id'            => 'city7',
				'binding'       => 'city',
				'address_field' => 'address7'
			],
			[
				'type'          => 'text',
				'name'          => 'Latitude7',
				'id'            => 'lat7',
				'binding'       => 'lat',
				'address_field' => 'address7',
			],
			[
				'type'          => 'text',
				'name'          => 'Longitude7',
				'id'            => 'lng7',
				'binding'       => 'lng',
				'address_field' => 'address7',
			],
			[
				'id'            => 'map7',
				'type'          => 'map',
				'name'          => 'Map7',
				'language'      => 'en',
				'address_field' => 'address7',
				'api_key'       => 'AIzaSyBb56UrxiGrfXlVmtHPVaAoxt_8zDQcLws',
			],
			[
				'id'      => 'non_binding8',
				'type'    => 'select',
				'name'    => 'Non binding field',
				'options' => [
					'a' => 'A',
					'b' => 'B',
				],
			],
		],
	];

	$meta_boxes[] = [
		'id'     => 'geolocation9',
		'title'  => 'GeoLocation9',
		'geo'    => true,
		'fields' => [
			[
				'type' => 'text',
				'name' => 'Address9',
				'id'   => 'address9',
			],
			[
				'type'          => 'text',
				'name'          => 'Latitude9',
				'id'            => 'lat9',
				'binding'       => 'lat',
				'address_field' => 'address9',
			],
			[
				'type'          => 'text',
				'name'          => 'Longitude9',
				'id'            => 'lng9',
				'binding'       => 'lng',
				'address_field' => 'address9',
			],
			[
				'id'            => 'map9',
				'type'          => 'map',
				'name'          => 'Map9',
				'language'      => 'en',
				'address_field' => 'address9',
				'api_key'       => 'AIzaSyBb56UrxiGrfXlVmtHPVaAoxt_8zDQcLws',
			],
		],
	];

	return $meta_boxes;
} );
