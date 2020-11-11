<?php
/**
 * Map Setting Fields.
 *
 * @package Auto Listings.
 */

return [
	'id'             => 'maps_search',
	'title'          => __( 'Maps &amp; Search', 'auto-listings' ),
	'settings_pages' => 'auto-listings',
	'tab'            => 'general',
	'fields'         => apply_filters( 'auto_listings_map_search_fields', [
		[
			'name'   => __( 'Google Maps API Key', 'auto-listings' ),
			/* translators: url */
			'before' => '<p>' . sprintf( __( 'A Google Maps API Key is required for Radius Searching and to show the maps on individual listing pages. You can get yours <strong><a target="_blank" href="%s">here</a></strong>.', 'auto-listings' ), 'https://developers.google.com/maps/documentation/javascript/get-api-key' ) . '<p>' . __( 'If you don\'t add an API Key, the "within x miles" field will be disabled for search and the search query will default to a keyword based location search, meaning that it will only search address fields within each listing for the keyword that the user has entered. Maps on the listing page will also be disabled.', 'auto-listings' ) . '</p>',
			'desc'   => __( 'Your users will have a better search experience by adding an API key.', 'auto-listings' ),
			'id'     => 'maps_api_key',
			'type'   => 'text',
		],
		[
			'name' => __( 'Country', 'auto-listings' ),
			/* translators: link */
			'desc' => __( 'This will help return more relevant results within search.', 'auto-listings' ) . '<br>' . sprintf( __( 'Country name or two letter %s country code.', 'auto-listings' ), '<a target="_blank" href="https://en.wikipedia.org/wiki/ISO_3166-1">ISO 3166-1</a>' ),
			'id'   => 'search_country',
			'type' => 'text',
		],
		[
			'name' => __( 'Map Zoom', 'auto-listings' ),
			'id'   => 'map_zoom',
			'type' => 'number',
			'std'  => 14,
		],
		[
			'name' => __( 'Map Height (px)', 'auto-listings' ),
			'id'   => 'map_height',
			'type' => 'number',
			'std'  => 300,
		],
	] ),
];
