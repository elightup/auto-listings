<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists( 'Auto_Listings_Metaboxes_Listings' ) ) :


/**
 * CMB2 Theme Options
 * @version 0.1.0
 */
class Auto_Listings_Metaboxes_Listings {

	/**
	 * Post type
	 * @var string
	 */
	public $type = 'auto-listing';

	/**
	 * Metabox prefix
	 * @var string
	 */
	public $pre = '_al_listing_';

	public $listing_label = '';

	/**
	 * Holds an instance of the object
	 *
	 * @var Myprefix_Admin
	 **/
	public $instance = null;

	public function __construct() {
		$this->listing_label = __( 'Listing', 'auto-listings' );
	}

	/**
	 * Returns the running object
	 *
	 * @return Myprefix_Admin
	 **/
	public function get_instance() {
		if( is_null( $this->instance ) ) {
			$this->instance = new self();
			
			$this->instance->description();
			$this->instance->select();
			$this->instance->details();
			$this->instance->specs();
			$this->instance->images();

			$this->instance->address();
			$this->instance->settings();
		}
		return $this->instance;
	}


/* ======================================================================================
										Listing Description
   ====================================================================================== */
	public function description() {

		$box = new_cmb2_box( array(
			'id'            => $this->pre . 'description',
			'title'         => '<span class="dashicons dashicons-welcome-write-blog"></span> ' . sprintf( __( "%s Description", 'auto-listings' ), $this->listing_label ),
			'object_types'  => array( $this->type ), 
			'priority'  	=> 'high', 
		) );

		$fields = array();

		$fields[10] = array(
	        'name'          => __( 'Tagline', 'auto-listings' ),
	        'desc'    		=> __( '', 'auto-listings' ),
	        'id'            => $this->pre . 'tagline',
	        'type'          => 'text',
	    );

	   	$fields[20] = array(
	        'name'          => __( 'Main Description', 'auto-listings' ),
	        'desc'    		=> __( '', 'auto-listings' ),
	        'id'            => $this->pre . 'main_description',
	        'type'    => 'wysiwyg',
		    'options' => array(
		        'wpautop' => true, // use wpautop?
		        'media_buttons' => false, // show insert/upload button(s)
		        'textarea_rows' => get_option('default_post_edit_rows',3), // rows="..."
		        'teeny' => true, // output the minimal editor config used in Press This
		        'tinymce' => true, // load TinyMCE, can be used to pass settings directly to TinyMCE using an array()
		        'quicktags' => false // load Quicktags, can be used to pass settings directly to Quicktags using an array()
		    ),
	    );

	    // filter the fields
        $fields = apply_filters( 'auto_listings_metabox_description', $fields );

        // sort numerically
        ksort( $fields );

        // loop through ordered fields and add them to the metabox
        if( $fields ) {
        	foreach ($fields as $key => $value) {
        		$fields[$key] = $box->add_field( $value );
        	}
        }
	    

	}

/* ======================================================================================
										Vehicle Select
   ====================================================================================== */
	public function select() {
		$box = new_cmb2_box( array(
			'id'            => $this->pre . 'select',
			'title'         => '<span class="dashicons dashicons-move"></span> ' . __( "Vehicle Select", 'auto-listings' ),
			'object_types'  => array( $this->type ), 
		) );

	    $box->add_field( array(
			'name' => __( '', 'auto-listings' ),
			'id'   => 'select-model-button',
			'type' => 'title',
			'before_row' => 'auto_listings_select_model_button',
		) );

	    $a = $box->add_field( array(
			'name' => __( 'Years', 'auto-listings' ),
			'id'   => 'car-years',
			'type' => 'select',
		) );
	    $b = $box->add_field( array(
			'name' => __( 'Makes', 'auto-listings' ),
			'id'   => 'car-makes',
			'type' => 'select',
		) );
	    $c = $box->add_field( array(
			'name' => __( 'Models', 'auto-listings' ),
			'id'   => 'car-models',
			'type' => 'select',
		) );
	    $d = $box->add_field( array(
			'name' => __( 'Trims', 'auto-listings' ),
			'id'   => 'car-model-trims',
			'type' => 'select',
		) );

	    $box->add_field( array(
			'name' => __( '', 'auto-listings' ),
			'id'   => 'populate-button',
			'type' => 'title',
			'after_row' => 'auto_listings_populate_button',
		) );

        if( !is_admin() ) { return; }
		$cmb2Grid 	= new \Cmb2Grid\Grid\Cmb2Grid($box);
		$row1 		= $cmb2Grid->addRow();
		$row1->addColumns( array( $a, $b, $c, $d ) );

	}

	

/* ======================================================================================
										Listing Specs
   ====================================================================================== */
	public function specs() {

		// reset
		$fields 		= array();
		$spec_fields 	= auto_listings_spec_fields();
		$display 		= auto_listings_option( 'field_display' );

		// loop through all our fields
		$count = 1;
		if( $spec_fields && $display ) {
			foreach ( $spec_fields as $id => $value ) {

				// skip the ones we don't want to show
				if( is_array( $display ) && ! in_array( $id, $display ) )
					continue;

	    		$fields[$count]['name'] = $value['label'];
	    		$fields[$count]['id'] 	= $this->pre . $id;
	    		$fields[$count]['type'] = 'text';

	    	$count++;

	    	}
	    }

		// filter the fields
        $fields = apply_filters( 'auto_listings_metabox_specs', $fields );

        if( ! $fields || empty( $fields ) ) 
        	return;

        $box = new_cmb2_box( array(
			'id'            => $this->pre . 'specs',
			'title'         => '<span class="dashicons dashicons-yes"></span> ' . sprintf( __( "%s Specifications", 'auto-listings' ), $this->listing_label ),
			'object_types'  => array( $this->type ), 
		) );

    	// sort numerically
        ksort( $fields );

    	// loop through ordered fields and add them to the metabox
    	foreach ($fields as $key => $value) {
    		$fields[$key] = $box->add_field( $value );
    		$row_setup[] = $value['id'];
    	}

        //pp($row_setup);
        $chunked = array_chunk($row_setup, 4);
        // setup the columns
	    if( !is_admin() ) { return; }
		$cmb2Grid = new \Cmb2Grid\Grid\Cmb2Grid( $box );

		// define number of rows
        //$rows = apply_filters( 'auto_listings_metabox_features_rows', 6 ); 
        $rows = round( count( $fields ) / 4, PHP_ROUND_HALF_UP );
        
        // loop through number of rows
        for ($i=0; $i < $rows; $i++) { 

        	// add each row
        	$row[$i] = $cmb2Grid->addRow();

        	// reset the array for each row
        	$array = array();
        	$array = $chunked[$i];

    		//pp( $array );
    		// add the fields as columns
    		$row[$i]->addColumns( 
	        	apply_filters( "auto_listings_metabox_specs_row_{$i}_columns", $array )
	        );


        }
        //die;

	}

/* ======================================================================================
										Gallery
   ====================================================================================== */
	public function images() {

		$box = new_cmb2_box( array(
			'id'            => $this->pre . 'images',
			'title'         => '<span class="dashicons dashicons-images-alt2"></span> ' . __( "Images", 'auto-listings' ),
			'object_types'  => array( $this->type ), 
		) );

		$fields = array();

	    $fields[10] = array(
	        'name'          => __( 'Image Gallery', 'auto-listings' ),
	        'desc'    		=> __( 'The first image will be used as the main feature image. Drag and drop to re-order.', 'auto-listings' ),
	        'id'            => $this->pre . 'image_gallery',
	        'type'          => 'file_list',
	        'preview_size' => array( 150, 100 ), // Default: array( 50, 50 )
		    'text' => array(
		        'add_upload_files_text' => __( 'Add Images', 'auto-listings' ), 
		    ),
	    );

	    // filter the fields
        $fields = apply_filters( 'auto_listings_metabox_images', $fields );

        // sort numerically
        ksort( $fields );

        // loop through ordered fields and add them to the metabox
        if( $fields ) {
        	foreach ($fields as $key => $value) {
        		$fields[$key] = $box->add_field( $value );
        	}
        }


	}



/* ======================================================================================
										Listing Details
   ====================================================================================== */
	public function details() {

		$box = new_cmb2_box( array(
			'id'            => $this->pre . 'details',
			'title'         => '<span class="dashicons dashicons-dashboard"></span> ' . sprintf( __( "%s Details", 'auto-listings' ), $this->listing_label ),
			'object_types'  => array( $this->type ), 
			'context'       => 'side',
		) );


	    $fields = array();

		$fields[10] = array(
	        'name'          => __( 'Price', 'auto-listings' ),
	        'desc'    		=> __( '', 'auto-listings' ),
	        'id'            => $this->pre . 'price',
	        'type'          => 'text',
	        'attributes' => array(
	            'type'      => 'number',
	            'min'      	=> '0',
	            'step'      => '0.01',
	        ),
	    );
		$fields[11] = array(
	        'name'          => __( 'Suffix', 'auto-listings' ),
	        'desc'    		=> __( 'Optional text after price.', 'auto-listings' ),
	        'id'            => $this->pre . 'price_suffix',
	        'type'          => 'text',
	    );

	    $fields[20] = array(
	        'name'          => auto_listings_miles_kms_label(),
	        'desc'    		=> __( '', 'auto-listings' ),
	        'id'            => $this->pre . 'odometer',
	        'type'          => 'text',
	        'attributes' => array(
	            'type'      => 'number',
	            'min'      	=> '0',
	            'step'      => '0.01',
	        ),
	    );
	    $fields[30] = array(
	        'name'          => __( 'Color', 'auto-listings' ),
	        'desc'    		=> __( '', 'auto-listings' ),
	        'id'            => $this->pre . 'color',
	        'type'          => 'text',
	    );
	    $fields[40] = array(
	        'name'          => __( 'Registration', 'auto-listings' ),
	        'desc'    		=> __( '', 'auto-listings' ),
	        'id'            => $this->pre . 'registration',
	        'type'          => 'text',
	    );
	    $fields[50] = array(
	        'name'          => __( 'Status', 'auto-listings' ),
	        'desc'    		=> __( '', 'auto-listings' ),
	        'id'            => $this->pre . 'status',
	        'type'          => 'select',
	        'show_option_none' => true,
	        'options_cb'    => 'auto_listings_available_listing_statuses',
	    );
	    $fields[60] = array(
	        'name'          => __( 'Condition', 'auto-listings' ),
	        'desc'    		=> __( '', 'auto-listings' ),
	        'id'            => $this->pre . 'condition',
	        'type'          => 'select',
	        'options_cb'   	=> 'auto_listings_available_listing_conditions',
	    );


        // filter the fields
        $fields = apply_filters( 'auto_listings_metabox_details', $fields );

        // sort numerically
        ksort( $fields );

        // loop through ordered fields and add them to the metabox
        if( $fields ) {
        	foreach ($fields as $key => $value) {
        		$fields[$key] = $box->add_field( $value );
        	}
        }
	}

/* ======================================================================================
										Listing Address
   ====================================================================================== */
	public function address() {

		$box = new_cmb2_box( array(
			'id'            => $this->pre . 'address',
			'title'         => '<span class="dashicons dashicons-location"></span> ' . sprintf( __( "%s Address", 'auto-listings' ), $this->listing_label ),
			'object_types'  => array( $this->type ), 
			'context'       => 'side',
		) );

		$fields = array();

		$fields[10] = array(
	        'name'          => __( 'Vehicle Location', 'auto-listings' ),
	        'desc'    		=> '',
	        'id'            => "al-geocomplete",
	        'type'          => 'text',
	        'before_row'   	=> 'auto_listings_admin_listing_map_key_check',
	        'after_row'    	=> 'auto_listings_admin_listing_map',
	        'attributes'    => array( 
	        	'placeholder' => __( 'Start typing address...', 'auto-listings' ),
	        ),
	    );
		$fields[15] = array(
	        'name'          => __( 'Displayed Address', 'auto-listings' ),
	        'desc'    		=> __( 'The address that will be displayed.', 'auto-listings' ) . '<br>' . __( 'Fields below used for search purposes only.', 'auto-listings' ),
	        'id'            => $this->pre . 'displayed_address',
	        'type'          => 'text',
	        'attributes'    => array( 
	        	'data-geo' => 'formatted_address',
	        ),
	    );
		// $fields[20] = array(
	 //        'name'          => __( 'Street Number', 'auto-listings' ),
	 //        'desc'    		=> '',
	 //        'id'            => $this->pre . 'street_number',
	 //        'type'          => 'text',
	 //        'attributes'    => array( 
	 //        	'data-geo' => 'street_number',
	 //        ),
	 //    );
		// $fields[25] = array(
	 //        'name'          => __( 'Street Name', 'auto-listings' ),
	 //        'desc'    		=> '',
	 //        'id'            => $this->pre . 'route',
	 //        'type'          => 'text',
	 //        'attributes'    => array( 
	 //        	'data-geo' => 'route',
	 //        ),
	 //    );
		$fields[30] = array(
	        'name'          => __( 'City / Town / Locality', 'auto-listings' ),
	        'desc'    		=> '',
	        'id'            => $this->pre . 'city',
	        'type'          => 'text',
	        'attributes'    => array( 
	        	'data-geo' => 'locality',
	        ),
	    );
		$fields[35] = array(
	        'name'          => __( 'Zip / Postal Code', 'auto-listings' ),
	        'desc'    		=> '',
	        'id'            => $this->pre . 'zip',
	        'type'          => 'text',
	        'attributes'    => array( 
	        	'data-geo' => 'postal_code',
	        ),
	    );
		$fields[40] = array(
	        'name'          => __( 'State', 'auto-listings' ),
	        'desc'    		=> '',
	        'id'            => $this->pre . 'state',
	        'type'          => 'text',
	        'attributes'    => array( 
	        	'data-geo' => 'administrative_area_level_1',
	        ),
	    );
		$fields[45] = array(
	        'name'          => __( 'Country', 'auto-listings' ),
	        'desc'    		=> '',
	        'id'            => $this->pre . 'country',
	        'type'          => 'text',
	        'attributes'    => array( 
	        	'data-geo' => 'country',
	        ),
	    );
		$fields[50] = array(
	        'name'          => __( 'Latitude', 'auto-listings' ),
	        'desc'    		=> '',
	        'id'            => $this->pre . 'lat',
	        'type'          => 'text',
	        'attributes'    => array( 
	        	'data-geo' => 'lat',
	        ),
	    );
		$fields[55] = array(
	        'name'          => __( 'Longitude', 'auto-listings' ),
	        'desc'    		=> '',
	        'id'            => $this->pre . 'lng',
	        'type'          => 'text',
	        'attributes'    => array(
	        	'data-geo' => 'lng',
	        ),
	    );

	    // filter the fields
        $fields = apply_filters( 'auto_listings_metabox_address', $fields );

        // sort numerically
        ksort( $fields );

        // loop through ordered fields and add them to the metabox
        if( $fields ) {
        	foreach ($fields as $key => $value) {
        		$fields[$key] = $box->add_field( $value );
        	}
        }

	}

/* ======================================================================================
										Listing Settings
   ====================================================================================== */
	public function settings() {

		$box = new_cmb2_box( array(
			'id'            => $this->pre . 'settings',
			'title'         => '<span class="dashicons dashicons-admin-settings"></span> ' . sprintf( __( "%s Settings", 'auto-listings' ), $this->listing_label ),
			'object_types'  => array( $this->type ), 
			'context'       => 'side',
		) );

		$fields = array();

		$fields[10] = array(
	        'name'          => __( '', 'auto-listings' ),
	        'desc'    		=> '',
	        'id'            => '',
	        'type'          => 'title',
	        'after_row'    	=> 'auto_listings_admin_listing_status_area',
	    );

	    $fields[15] = array(
	        'name'          => __( 'Seller', 'auto-listings' ),
	        'desc'    		=> __( 'Adding a Seller will automatically insert the Contact Form on the listing and all enquiries will be sent to this seller.', 'auto-listings' ),
	        'id'            => $this->pre . 'seller',
	        'type'          => 'select',
	        'default' 		=> get_current_user_id(),
	        'options_cb' 	=> 'auto_listings_admin_get_sellers',
	    );

	    $fields[20] = array(
	        'name'          => __( 'Hide Items', 'auto-listings' ),
	        'desc'    		=> __( 'Hide items on the front, even if filled in.', 'auto-listings' ),
	        'id'            => $this->pre . 'hide',
	        'type'          => 'multicheck',
	        'select_all_button' => false,
	        'options' => array(
	            'price'     	=> __( 'Price', 'auto-listings' ),
	            'contact_form' 	=> __( 'Contact Form', 'auto-listings' ),
	            'map' 			=> __( 'Map', 'auto-listings' ),
	            'address' 		=> __( 'Address', 'auto-listings' ),
	        ),
	    );

	    // filter the fields
        $fields = apply_filters( 'auto_listings_metabox_settings', $fields );

        // sort numerically
        ksort( $fields );

        // loop through ordered fields and add them to the metabox
        if( $fields ) {
        	foreach ($fields as $key => $value) {
        		$fields[$key] = $box->add_field( $value );
        	}
        }

	}


}

endif;
