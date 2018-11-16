<?php
/**
 * Listing spec fields to display.
 *
 * @package Auto Listings.
 */

$fields = auto_listings_spec_fields();

$options = [];
foreach ( $fields as $field_id => $field ) {
	$label = $field['label'];
	if ( isset( $field['desc'] ) ) {
		$label .= ' <span class="description">' . $field['desc'] . '</span>';
	}
	$options[ $field_id ] = $label;
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
