<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists( 'Auto_Listings_Admin_Listing_Columns' ) ) :

/**
 * Admin columns
 * @version 0.1.0
 */
class Auto_Listings_Admin_Listing_Columns {

    /**
     * fields used for the filter dropdowns
     */
    public $filter_fields = array(
        'status'    => 'statuses',
        'seller'    => 'sellers',
        'condition' => 'conditions',
    );

    /**
     * Constructor
     * @since 0.1.0
     */
    public function __construct() {
        return $this->hooks();
    }


    public function hooks() {
        add_filter( 'manage_auto-listing_posts_columns', array( $this, 'listing_columns' ) );
        add_action( 'manage_auto-listing_posts_custom_column', array( $this, 'listing_data' ), 10, 2 );
        
        add_action( 'manage_body-type_custom_column', array( $this, 'body_type_data' ), 10, 3 );
        
        // sorting
        add_filter( 'manage_edit-auto-listing_sortable_columns', array( $this, 'table_sorting' ) );
        add_filter( 'request', array( $this, 'listing_orderby_status' ) );
        add_filter( 'request', array( $this, 'listing_orderby_seller' ) );
        add_filter( 'request', array( $this, 'listing_orderby_price' ) );

        // filtering
        add_action( 'restrict_manage_posts', array( $this, 'table_filtering' ) );
        add_action( 'parse_query', array( $this, 'filter' ) );
    }

    /**
     * Set columns for listing
     */
    public function listing_columns( $defaults ) {

        $post_type  = sanitize_text_field( $_GET['post_type'] );
        $columns    = array();
        
        $defaults['vehicle']    = __( 'Vehicle', 'auto-listings' );
        $defaults['price']      = __( 'Price', 'auto-listings' );
        $defaults['condition']  = __( 'Condition', 'auto-listings' );
        $defaults['status']     = __( 'Status', 'auto-listings' );
        $defaults['seller']     = __( 'Seller', 'auto-listings' );
        $defaults['address']    = __( 'Address', 'auto-listings' );
        $defaults['image']      = '<span class="dashicons dashicons-images-alt2"></span>';
        $defaults['enquiries']  = __( 'Enquiries', 'auto-listings' );

        return $defaults;
    }


    public function listing_data( $column_name, $post_id ) {


        // if ( $column_name == 'taxonomy-body-type' ) {
        //     echo '<span class="id">#' . esc_html( $post_id ) . '</div>'; 
        // }

        if ( $column_name == 'status' ) {
            $status = auto_listings_meta( 'status', $post_id );            
            if( ! $status )
                return;

            echo '<span class="btn status ' . esc_attr( strtolower( $status ) ) . '">' . esc_html( $status ) . '</div>'; 

        }

        if ( $column_name == 'seller' ) {
            $seller_id   = auto_listings_meta( 'seller', $post_id );            
            $seller      = get_the_author_meta( 'display_name', $seller_id );            
            if( ! $seller || ! $seller_id )
                return;
            echo esc_html( $seller ); 
        }

        if ( $column_name == 'condition' ) {
            $condition = auto_listings_meta( 'condition', $post_id );            
            if( ! $condition )
                return;

            echo esc_html( $condition ); 
        }

        if ( $column_name == 'vehicle' ) {
            echo auto_listings_year_make_model() . '<br>'; 
            if( has_term( '', 'body-type') ) { ?>
                <i class="auto-icon-trunk"></i> <?php echo get_the_term_list( get_the_ID(), 'body-type', '', ', ' ); ?>
            <?php }
        }

        if ( $column_name == 'price' ) {
            $price = auto_listings_meta( 'price', $post_id );            
            echo auto_listings_price( $price );
        }

        if ( $column_name == 'address' ) {
            $address = auto_listings_meta( 'displayed_address', $post_id );            
            if( ! $address )
                return;

            echo esc_html( $address ); 
        }

        if ( $column_name == 'image' ) {
            $images = auto_listings_meta( 'image_gallery', $post_id );            
            if( ! $images )
                return;
            $image  = array_keys( $images );
            $img    = wp_get_attachment_image_src( $image[0], 'thumbnail' );
            if ( $img ) :
                echo '<img src="' . esc_url( $img[0] ) . '" width="50" height="50" />';
            endif; 
        }

        if ( $column_name == 'enquiries' ) {
            $enquiries = auto_listings_meta( 'enquiries', $post_id );  
            $count = ! empty( $enquiries ) ? count( $enquiries ) : 0;
            if( $count > 0 ) {
                echo '<a href="' . esc_url( admin_url( 'edit.php?post_type=listing-enquiry' ) ) . '"><span>' . esc_html( $count ) . '</a></span>';
            } else {
                echo '—';
            }

        }


    }


    /*
     * Sorting the table
     */
    function table_sorting( $columns ) {
        $columns['status']     = 'status';
        $columns['condition']  = 'condition';
        $columns['seller']     = 'seller';
        $columns['price']      = 'price';
        return $columns;
    }


    function listing_orderby_status( $vars ) {
        if ( isset( $vars['orderby'] ) && 'status' == $vars['orderby'] ) {
            $vars = array_merge( $vars, array(
                'meta_key' => '_al_listing_status',
                'orderby' => 'meta_value'
            ) );
        }
        return $vars;
    }
    function listing_orderby_condition( $vars ) {
        if ( isset( $vars['orderby'] ) && 'condition' == $vars['orderby'] ) {
            $vars = array_merge( $vars, array(
                'meta_key' => '_al_listing_condition',
                'orderby' => 'meta_value'
            ) );
        }
        return $vars;
    }
    function listing_orderby_seller( $vars ) {
        if ( isset( $vars['orderby'] ) && 'seller' == $vars['orderby'] ) {
            $vars = array_merge( $vars, array(
                'meta_key' => '_al_listing_seller',
                'orderby' => 'meta_value'
            ) );
        }
        return $vars;
    }

    function listing_orderby_price( $vars ) {
        if ( isset( $vars['orderby'] ) && 'price' == $vars['orderby'] ) {
            $vars = array_merge( $vars, array(
                'meta_key' => '_al_listing_price',
                'orderby' => 'meta_value'
            ) );
        }
        return $vars;
    }




    function table_filtering() {
        global $pagenow;
        $type = get_post_type() ? get_post_type() : 'auto-listing';
        if ( isset( $_GET['post_type'] ) ) {
            $type = sanitize_text_field( $_GET['post_type'] );
        }

        //only add filter to post type you want
        if ( 'auto-listing' == $type && is_admin() && $pagenow == 'edit.php' ) {

            $fields = $this->build_fields();

            if( $fields ) {

                foreach ( $fields as $field => $values ) {
                    asort( $values ); // sort our values
                    $values = array_unique( $values ); // make them unique
                    $values = array_filter( $values ); // remove empties
                    
                    ?>
                        <select name='<?php echo esc_attr( $field ); ?>' id='<?php echo esc_attr( $field ); ?>' class='postform'>
                            
                            <option value=''><?php printf( __( 'All %s', 'auto-listings' ), $field ) ?></option>

                            <?php foreach ( $values as $val => $text ) { 

                                $text = $field == 'sellers' ? get_the_author_meta( 'display_name', $val ) : $text; ?>
                                <option value="<?php echo esc_attr( $val ) ?>" <?php isset( $_GET[$field] ) ? selected( $_GET[$field], $val ) : ''; ?>><?php echo esc_html( $text ) ?></option>

                            <?php } ?>

                        </select>

                    <?php 
                    
                    reset( $values );
                }

            }

        }

    }


    /**
     * Build the dropdown field values for the filtering
     *
     */
    private function build_fields(){

        $fields = '';
        $output = '';

        // The Query args
        $args = array( 
            'post_type'         => 'auto-listing', 
            'posts_per_page'    => '-1', 
            'post_status'       => 'publish',
        );

        $listings = query_posts( $args );

        // The Loop
        if ( $listings ) {

            $fields = array();

            foreach ( $listings as $listing ) {
                foreach ( $this->filter_fields as $field => $text ) {
                    
                    $val = auto_listings_meta( $field, $listing->ID );
                    $fields[$text][$val] = $val;    

                }

            }
        }

        /* Restore original Post Data */
        wp_reset_query();

        return $fields;

    }



    function filter( $query ){
        global $pagenow;
        $type = get_post_type() ? get_post_type() : 'auto-listing';
        if (isset($_GET['post_type'])) {
            $type = sanitize_text_field( $_GET['post_type'] );
        }
        if ( 'auto-listing' == $type && is_admin() && $pagenow == 'edit.php' ) {
            
            foreach ( $this->filter_fields as $field => $text ) {

                if( isset( $_GET[$text] ) && $_GET[$text] != '' ) {
                    $query->query_vars['meta_key'] = '_al_listing_' . $field;
                    $query->query_vars['meta_value'] = sanitize_text_field( $_GET[$text] );
                }

            }

        }
    }


}

new Auto_Listings_Admin_Listing_Columns;

endif;