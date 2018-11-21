<?php
/**
 * Listing map fields.
 *
 * @package Auto Listings.
 */

$prefix = '_al_listing_';

$key = auto_listings_option( 'maps_api_key' );
if ( ! $key ) {
	// translators: link to setting page.
	$warning = '<div class="archived-text warning">' . sprintf( __( 'No Google Maps API key found.<br>Please <a href="%s">add one here</a>', 'auto-listings' ), admin_url( 'options-general.php?page=auto-listings' ) ) . '</div>';
}

$fields     = [];
$fields[10] = [
	'name'        => __( 'Vehicle Location', 'auto-listings' ),
	'id'          => 'address',
	'type'        => 'text',
	'placeholder' => __( 'Start typing address...', 'auto-listings' ),
];
$fields[20] = [
	'id'            => 'map',
	'type'          => 'map',
	'address_field' => 'address',
	'api_key'       => auto_listings_option( 'maps_api_key' ),
];
$fields[30] = [
	'name'    => __( 'Displayed Address', 'auto-listings' ),
	'desc'    => __( 'The address that will be displayed.', 'auto-listings' ) . '<br>' . __( 'Fields below used for search purposes only.', 'auto-listings' ),
	'id'      => $prefix . 'displayed_address',
	'type'    => 'text',
	'binding' => 'formatted_address',
];
$fields[40] = [
	'name'    => __( 'City / Town / Locality', 'auto-listings' ),
	'id'      => $prefix . 'city',
	'type'    => 'text',
	'binding' => 'locality',
];
$fields[50] = [
	'name'    => __( 'Zip / Postal Code', 'auto-listings' ),
	'id'      => $prefix . 'zip',
	'type'    => 'text',
	'binding' => 'postal_code',
];
$fields[60] = [
	'name'    => __( 'State', 'auto-listings' ),
	'id'      => $prefix . 'state',
	'type'    => 'text',
	'binding' => 'administrative_area_level_1',
];
$fields[70] = [
	'name'    => __( 'Country', 'auto-listings' ),
	'id'      => $prefix . 'country',
	'type'    => 'text',
	'binding' => 'country',
];
$fields[80] = [
	'name'    => __( 'Latitude', 'auto-listings' ),
	'id'      => $prefix . 'lat',
	'type'    => 'text',
	'binding' => 'lat',
];
$fields[90] = [
	'name'    => __( 'Longitude', 'auto-listings' ),
	'id'      => $prefix . 'lng',
	'type'    => 'text',
	'binding' => 'lng',
];

$fields = apply_filters( 'auto_listings_metabox_address', $fields );

ksort( $fields );

return [
	'id'         => $prefix . 'address',
	'title'      => __( 'Address', 'auto-listings' ),
	'post_types' => 'auto-listing',
	'fields'     => $fields,
	'context'    => 'side',
	'geo'        => [
		'api_key' => auto_listings_option( 'maps_api_key' ),
	],
];
