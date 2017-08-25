<?php
/**
 * Uninstall Auto_Listings
 */

// Exit if accessed directly.
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) exit;

// Load Auto_Listings file.
include_once( 'auto-listings.php' );

global $wpdb, $wp_roles;

$remove = auto_listings_option( 'delete_data' );

if( $remove == 'yes' ) {

	/** Delete All the Custom Post Types */
	$auto_listings_post_types = array( 'auto-listing', 'listing-enquiry' );
	foreach ( $auto_listings_post_types as $post_type ) {

		$items = get_posts( array( 'post_type' => $post_type, 'numberposts' => -1, 'post_status' => array('publish', 'pending', 'draft', 'auto-draft', 'future', 'private', 'inherit', 'trash'), 'fields' => 'ids' ) );

		if ( $items ) {
			foreach ( $items as $item ) {
				wp_delete_post( $item, true);
			}
		}
	}



	/** Delete all the Plugin Options */
	delete_option( 'auto_listings_options' );
	delete_option( 'auto_listings_version' );
	delete_option( 'auto_listings_version_upgraded_from' );

	/** Delete Capabilities */
	$roles = new Auto_Listings_Roles;
	$roles->remove_caps();

	/** Delete the Roles */
	$auto_listings_roles = array( 'auto_listings_seller' );
	foreach ( $auto_listings_roles as $role ) {
		remove_role( $role );
	}

}
