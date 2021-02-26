<?php
/**
 * Test for OSM field type.
 */
add_filter('rwmb_meta_boxes', function ($meta_boxes) {
	$meta_boxes[] = [
		'id'     => 'geolocation',
		'title'  => 'GeoLocation',
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
						'id'   => 'address',
					],
					[
						'type'          => 'text',
						'name'          => 'City',
						'id'            => 'city',
						'address_field' => 'address',
					],
					[
						'type'          => 'text',
						'name'          => 'Country',
						'id'            => 'country',
						'address_field' => 'address',
					],
					[
						'type'          => 'text',
						'name'          => 'Latitude',
						'id'            => 'lat',
						'address_field' => 'address',
					],
					[
						'type'          => 'text',
						'name'          => 'Longitude',
						'id'            => 'lng',
						'address_field' => 'address',
					],
					[
						'id'            => 'map',
						'type'          => 'osm',
						'name'          => 'Map',
						'address_field' => 'address',
						'language'      => 'en',
					],
				],
			],

			// Another group of fields in the same meta box.
			[
				'type' => 'text',
				'name' => 'Address2',
				'id'   => 'address2',
			],
			[
				'type'          => 'text',
				'name'          => 'City2',
				'id'            => 'city2',
				'binding'       => 'city',
				'address_field' => 'address2'
			],
			[
				'type'          => 'text',
				'name'          => 'Latitude2',
				'id'            => 'lat2',
				'binding'       => 'lat',
				'address_field' => 'address2',
			],
			[
				'type'          => 'text',
				'name'          => 'Longitude2',
				'id'            => 'lng2',
				'binding'       => 'lng',
				'address_field' => 'address2',
			],
			[
				'id'            => 'map2',
				'type'          => 'osm',
				'name'          => 'Map2',
				'language'      => 'en',
				'address_field' => 'address2',
			],
			[
				'id'      => 'non_binding',
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
		'id'     => 'geolocation2',
		'title'  => 'GeoLocation2',
		'geo'    => true,
		'fields' => [
			[
				'type' => 'text',
				'name' => 'Address3',
				'id'   => 'address3',
			],
			[
				'type'    => 'text',
				'name'    => 'Latitude3',
				'id'      => 'lat3',
				'binding' => 'lat',
			],
			[
				'type'    => 'text',
				'name'    => 'Longitude3',
				'id'      => 'lng3',
				'binding' => 'lng',
			],
			[
				'id'            => 'map3',
				'type'          => 'osm',
				'name'          => 'Map3',
				'address_field' => 'address3',
			],
		],
	];

	return $meta_boxes;
} );
