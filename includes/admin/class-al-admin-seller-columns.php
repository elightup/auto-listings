<?php

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) )
    exit;

if ( !class_exists( 'Auto_Listings_Admin_Seller_Columns' ) ): /**
 * Admin columns
 * @version 0.1.0
 */ 
    class Auto_Listings_Admin_Seller_Columns {
        
        /**
         * Constructor
         * @since 0.1.0
         */
        public function __construct() {
            return $this->hooks();
        }
        
        
        public function hooks() {
            if ( isset( $_GET['role'] ) && ( $_GET['role'] == 'auto_listings_seller' || $_GET['role'] == 'administrator' ) ) {
                add_filter( 'manage_users_columns', array(
                     $this,
                    'modify_user_table' 
                ) );
                add_filter( 'manage_users_custom_column', array(
                     $this,
                    'modify_user_table_row' 
                ), 10, 3 );
            }
        }
        
        
        public function modify_user_table( $column ) {
            if ( isset( $_GET['role'] ) && $_GET['role'] == 'auto_listings_seller' ) {
                unset( $column['posts'] );
                unset( $column['role'] );
            }
            $column['listings']     = __( 'Listings', 'auto-listings' );
            $column['mobile']       = __( 'Mobile', 'auto-listings' );
            $column['office_phone'] = __( 'Office Phone', 'auto-listings' );
            return $column;
        }
        
        
        function modify_user_table_row( $val, $column_name, $user_id ) {
            
            switch ( $column_name ) {
                
                case 'listings':
                    return '<a href="' . esc_url( admin_url( 'edit.php?post_type=listing&sellers=' . $user_id ) ) . '"><strong>' . auto_listings_seller_listings_count( $user_id ) . '</strong></a>';
                    break;
                
                case 'mobile':
                    return get_the_author_meta( 'mobile', $user_id );
                    break;
                
                case 'name':
                    return get_the_author_meta( 'display_name', $user_id ) . '<br>' . get_the_author_meta( 'title_position', $user_id );
                    break;
                
                case 'office_phone':
                    return get_the_author_meta( 'office_phone', $user_id );
                    break;
                
                default:
                    
            }
            
            return $val;
        }
        
        
        
        
    }
    
    new Auto_Listings_Admin_Seller_Columns;
endif;
