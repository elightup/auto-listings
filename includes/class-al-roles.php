<?php
 
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

 
/**
 * Auto_Listings_Roles Class
 *
 * This class handles the role creation and assignment of capabilities for those roles.
 *
 *
 * @since 1.0.0
 */
class Auto_Listings_Roles {
 
    /**
     * Add new shop roles with default WP caps
     * Called during installation
     *
     * @access public
     * @since 1.0.0
     * @return void
     */
    public function add_roles() {
        add_role( 'auto_listings_seller', __( 'Auto Listings Seller', 'auto-listings' ), array(
            'read'                      => true,
            'edit_posts'                => true,
            'delete_posts'              => true,
            'unfiltered_html'           => true,
            'upload_files'              => true,
            'delete_others_posts'       => true,
            'delete_private_posts'      => true,
            'delete_published_posts'    => true,
            'edit_others_posts'         => true,
            'edit_private_posts'        => true,
            'edit_published_posts'      => true,
            'publish_posts'             => true,
            'read_private_posts'        => true
        ) );
 
    }
 
    /**
     * Add new Auto_Listings specific capabilities
     * Called during installation
     *
     * @access public
     * @since  1.0.0
     * @global WP_Roles $wp_roles
     * @return void
     */
    public function add_caps() {
        global $wp_roles;
 
        if ( class_exists('WP_Roles') ) {
            if ( ! isset( $wp_roles ) ) {
                $wp_roles = new WP_Roles();
            }
        }
 
        if ( is_object( $wp_roles ) ) {
 
            // Add the main post type capabilities
            $capabilities = $this->get_auto_listings_seller_caps();
            foreach ( $capabilities as $cap_group ) {
                foreach ( $cap_group as $cap ) {
                    $wp_roles->add_cap( 'auto_listings_seller', $cap );
                    $wp_roles->add_cap( 'administrator', $cap );
                }
            }
 
        }
    }
 
    /**
     * Gets the core post type capabilities
     *
     * @access public
     * @since  1.0.0
     * @return array $capabilities Core post type capabilities
     */
    public function get_auto_listings_seller_caps() {
        $capabilities = array();
 
        $capabilities[ 'listing'] = array(
            // Users
            "list_users",
            "create_users",
            "edit_users",

            // Listings
            "edit_listing",
            "read_listing",
            "delete_listing",
            "edit_listings",
            "edit_others_listings",
            "publish_listings",
            "read_private_listings",
            "delete_listings",
            "delete_private_listings",
            "delete_published_listings",
            "delete_others_listings",
            "edit_private_listings",
            "edit_published_listings",

            // Enquiries use post capability
        );

        return $capabilities;
    }
 
    /**
     * Remove core post type capabilities (called on uninstall)
     *
     * @access public
     * @since 1.5.2
     * @return void
     */
    public function remove_caps() {
 
        global $wp_roles;
 
        if ( class_exists( 'WP_Roles' ) ) {
            if ( ! isset( $wp_roles ) ) {
                $wp_roles = new WP_Roles();
            }
        }
 
        if ( is_object( $wp_roles ) ) {
 
            // Add the main post type capabilities
            $seller_caps   = $this->get_auto_listings_seller_caps();
            $seller_role   = get_role( 'auto_listings_seller' );
            $admin_role   = get_role( 'administrator' );

            //pp( $seller_role );
            foreach ( $seller_caps as $post_type ) {
                foreach ( $post_type as $index => $cap ) {
                    if( $seller_role ) {
                        $seller_role->remove_cap( $cap );
                    }
                    if( $admin_role ) {
                        $admin_role->remove_cap( $cap );
                    }
                }
            }
 
        }
 
    }
}