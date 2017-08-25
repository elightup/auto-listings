<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;
add_action( 'cmb2_admin_init', 'auto_listings_options_page' );

function auto_listings_options_page() {
	
	$listing_label     = __( 'Listing', 'auto-listings' );
	$listings_label    = __( 'Listings', 'auto-listings' );
    // the options key fields will be saved under
    $opt_key = 'auto_listings_options';

    // the show_on parameter for configuring the CMB2 box, this is critical!
    $show_on = array( 'key' => 'options-page', 'value' => array( $opt_key ) );

    // an array to hold our boxes
    $boxes = array();

    // an array to hold some tabs
    $tabs = array();

    /* 
     * Tabs - an array of configuration arrays.
     */
    $tabs[] = array(
        'id'    => 'general',
        'title' => 'General',
        'desc'  => '',
        'boxes' => array(
            'units',
            'price_format',
            'maps_search',
        ),
    );

    $tabs[] = array(
        'id'    => 'listings',
        'title' => sprintf( __( '%s', 'auto-listings' ), $listings_label ),
        'desc'  => '',
        'boxes' => array(
            'listing_setup',
            'listing_statuses',
         ),
    );

    $tabs[] = array(
        'id'    => 'fields',
        'title' => 'Fields',
        'desc'  => '',
        'boxes' => array(
            'display_fields',
         ),
    );

    $tabs[] = array(
        'id'    => 'display',
        'title' => 'Display',
        'desc'  => '',
        'boxes' => array(
            'columns',
            'colors',
            'gallery_settings',
            
        ),
    );

    $tabs[] = array(
        'id'    => 'contact',
        'title' => 'Contact Form',
        'desc'  => '',
        'boxes' => array(
            'contact_form',
            'contact_form_email',
            'contact_form_messages',
        ),
    );

    $tabs[] = array(
        'id'    => 'advanced',
        'title' => 'Advanced',
        'desc'  => '',
        'boxes' => array(
            'theme_compatibility',
            'uninstall',
        ),
    );

    $tabs[] = array(
        'id'    => 'extensions',
        'title' => 'Extensions',
        'desc'  => '',
        'boxes' => array(
             'extensions',
        ),
    );

/* ======================================================================================
                                        General Options
   ====================================================================================== */

    // maps and search
    $cmb = new_cmb2_box( array(
        'id'        => 'units',
        'title'     => __( 'Measurements', 'auto-listings' ),
        'show_on'   => $show_on,
    ));
    $cmb->add_field( array(
        'name'       => __( 'Metric or Imperial', 'auto-listings' ),
        'desc'       => __( '', 'auto-listings' ),
        'id'         => 'metric',
        'type'       => 'select',
        'options'    => array(
            'yes'   => __( 'Metric', 'auto-listings' ),
            'no'    => __( 'Imperial', 'auto-listings' ),
        ),
    ));


    $cmb->object_type( 'options-page' );
    $boxes[] = $cmb;


    // maps and search
    $cmb = new_cmb2_box( array(
        'id'        => 'maps_search',
        'title'     => __( 'Maps & Search', 'auto-listings' ),
        'show_on'   => $show_on,
    ));
    $cmb->add_field( array(
        'name'       => __( 'Google API Key', 'auto-listings' ),
        'before_row' => sprintf( __( 'A Google Maps API Key is required for Radius Searching and to show the maps on individual listing pages.<br>You can get yours %s.', 'auto-listings' ), '<strong><a target="_blank" href="https://developers.google.com/maps/documentation/javascript/get-api-key">here</a></strong>' ) . '<br>' .
            __( 'If you don\'t add an API Key, the "within x miles" field will be disabled for search and the search query will default to a keyword based location search, meaning that it will only search address fields within each listing for the keyword that the user has entered. Maps on the listing page will also be disabled.', 'auto-listings' ),
        'desc'       => __( 'Your users will have a better search experience by adding an API key.', 'auto-listings' ),
        'id'         => 'maps_api_key',
        'type'       => 'text',
    ));
    $cmb->add_field( array(
        'name'       => __( 'Country', 'auto-listings' ),
        'desc'       => __( 'This will help return more relevant results within search.', 'auto-listings' ) . '<br>' . sprintf( __( 'Country name or two letter %s country code.', 'auto-listings' ), '<a target="_blank" href="https://en.wikipedia.org/wiki/ISO_3166-1">ISO 3166-1</a>' ),
        'id'         => 'search_country',
        'type'       => 'text',
    ));
    $cmb->add_field( array(
        'name'       => __( 'Map Zoom', 'auto-listings' ),
        'desc'       => __( '', 'auto-listings' ),
        'id'         => 'map_zoom',
        'type'       => 'text',
        'default'    => '14',
        'attributes'    => array(
            'type' => 'number',
        ),
    ));
    $cmb->add_field( array(
        'name'       => __( 'Map Height', 'auto-listings' ),
        'desc'       => __( '', 'auto-listings' ),
        'id'         => 'map_height',
        'type'       => 'text',
        'default'    => '300',
        'attributes'    => array(
            'type' => 'number',
        ),
    ));
    
    $cmb->object_type( 'options-page' );
    $boxes[] = $cmb;


    // price_format
    $cmb = new_cmb2_box( array(
        'id'        => 'price_format',
        'title'     => __( 'Price Format', 'auto-listings' ),
        'show_on'   => $show_on,
    ));
    $cmb->add_field( array(
        'name'       => __( 'Currency Position', 'auto-listings' ),
        'desc'       => __( '', 'auto-listings' ),
        'id'         => 'currency_position',
        'type'       => 'select',
        'options' => array(
            'left'          => __( 'Left ($100)', 'auto-listings' ),
            'right'         => __( 'Right (100$)', 'auto-listings' ),
            'left_space'    => __( 'Left with space ($ 100)', 'auto-listings' ),
            'right_space'   => __( 'Right with space (100 $)', 'auto-listings' ),
        ),
    ));
    $cmb->add_field( array(
        'name'       => __( 'Currency Symbol', 'auto-listings' ),
        'desc'       => __( '', 'auto-listings' ),
        'id'         => 'currency_symbol',
        'type'       => 'text',
        'default'    => '$',
    ));
    $cmb->add_field( array(
        'name'       => __( 'Thousand Separator', 'auto-listings' ),
        'desc'       => __( '', 'auto-listings' ),
        'id'         => 'thousand_separator',
        'type'       => 'text',
        'default'    => ',',
    ));
    $cmb->add_field( array(
        'name'       => __( 'Include Decimals', 'auto-listings' ),
        'desc'       => __( '', 'auto-listings' ),
        'id'         => 'include_decimals',
        'type'       => 'select',
        'options' => array(
            'no'      => __( 'No, do not include decimals in price', 'auto-listings' ),
            'yes'     => __( 'Yes, include decimals in price', 'auto-listings' ),
        ),
        'default'    => 'no',
    ));
    $cmb->add_field( array(
        'name'       => __( 'Decimal Separator', 'auto-listings' ),
        'desc'       => __( '', 'auto-listings' ),
        'id'         => 'decimal_separator',
        'type'       => 'text',
        'default'    => '.',
    ));
    $cmb->add_field( array(
        'name'       => __( 'Number of Decimals', 'auto-listings' ),
        'desc'       => __( '', 'auto-listings' ),
        'id'         => 'decimals',
        'type'       => 'text',
        'default'    => '2',
    ));
    $cmb->object_type( 'options-page' );
    $boxes[] = $cmb;


/* ======================================================================================
                                        Listing Options
   ====================================================================================== */
    
    // listings setup
    $cmb = new_cmb2_box( array(
        'id'        => 'listing_setup',
        'title'     => __( 'Listing Setup', 'auto-listings' ),
        'show_on'   => $show_on,
    ));
    $cmb->add_field( array(
        'name'       => __( 'Condition', 'auto-listings' ),
        'desc'       => __( 'What type of condition vehicles are you selling?', 'auto-listings' ),
        'id'         => 'display_condition',
        'type'       => 'multicheck',
        'options' => array(
            'New'           => __( 'New', 'auto-listings' ),
            'Used'          => __( 'Used', 'auto-listings' ),
            'Certified'     => __( 'Certified', 'auto-listings' ),
        ),
    ));

    $cmb->add_field( array(
        'name'       => __( 'Highlight New Listings', 'auto-listings' ),
        'desc'       => __( 'How many days to highlight new listings for? Leave blank for no highlight.', 'auto-listings' ),
        'id'         => 'highlight_new_days',
        'type'       => 'text',
    ));

    $cmb->add_field( array(
        'name'       => __( 'Default List/Grid View', 'auto-listings' ),
        'desc'       => __( 'Set the default view for listings', 'auto-listings' ),
        'id'         => 'list_grid_view',
        'type'       => 'select',
        'options' => array(
            'list'          => __( 'List', 'auto-listings' ),
            'grid'          => __( 'Grid', 'auto-listings' ),
        ),
    ));
    $cmb->add_field( array(
        'name'       => __( 'Highlight Color', 'auto-listings' ),
        'desc'       => __( 'The background color of the new listing highlight. (Icon & text are white)', 'auto-listings' ),
        'id'         => 'highlight_new_color',
        'type'       => 'colorpicker',
    ));

    $cmb->add_field( array(
        'name'       => __( 'Listings Page', 'auto-listings' ),
        'desc'       => __( 'The main page to display your listings (not the front page).', 'auto-listings' ) . '<br>' . 
        sprintf( __( 'Please visit %s if this options is changed.', 'auto-listings' ), '<a target="_blank" href="' . admin_url( 'options-permalink.php' ) . '">Settings -> Permalinks</a>' ),
        'id'         => 'archives_page',
        'type'       => 'select',
        'options_cb'    => 'auto_listings_get_pages',
    ));

    $cmb->add_field( array(
        'name'       => __( 'Single Listing URL', 'auto-listings' ),
        'desc'       => __( 'The single listing URL (or slug).', 'auto-listings' ) . '<br>' . 
        sprintf( __( 'Please visit %s if this options is changed.', 'auto-listings' ), '<a target="_blank" href="' . admin_url( 'options-permalink.php' ) . '">Settings -> Permalinks</a>' ),
        'id'         => 'single_url',
        'type'       => 'text',
        'default'    => 'listing',
    ));

    $cmb->object_type( 'options-page' );
    $boxes[] = $cmb;


    $cmb = new_cmb2_box( array(
        'id'        => 'listing_statuses',
        'title'     => sprintf( __( '%s Statuses', 'auto-listings' ), $listing_label ),
        'show_on'   => $show_on,
    ));

    // listing statuses
    $group_field_id = $cmb->add_field( array(
        'type'        => 'group',
        'name'        => __( '', 'auto-listings' ),
        'before_group'  => __( 'Once Statuses have been added here, they are then available in the Status dropdown field when adding or editing a listing.', 'auto-listings' ) . '<br>' . __( 'Statuses appear in a styled box over the listing\'s image and are used primarily to attract attention.', 'auto-listings' ),
        'id'          => 'listing_status',
        // 'repeatable'  => false, // use false if you want non-repeatable group
        'options'     => array(
            'group_title'   => __( 'Status {#}', 'auto-listings' ), // since version 1.1.4, {#} gets replaced by row number
            'add_button'    => __( 'Add Another Status', 'auto-listings' ),
            'remove_button' => __( 'Remove Status', 'auto-listings' ),
            'sortable'      => false, // beta
            // 'closed'     => true, // true to have the groups closed by default
        ),
    ) );

    $cmb->add_group_field( $group_field_id, array(
        'name'          => __( 'Status', 'auto-listings' ),
        'id'            => 'status',
        'type'          => 'text',
    ));
    $cmb->add_group_field( $group_field_id, array(
        'name'          => __( 'Background Color', 'auto-listings' ),
        'id'            => 'bg_color',
        'type'          => 'colorpicker',
    ));
    $cmb->add_group_field( $group_field_id, array(
        'name'      	=> __( 'Text Color', 'auto-listings' ),
        'id'         	=> 'text_color',
        'type'       	=> 'colorpicker',
    ));
    $cmb->add_group_field( $group_field_id, array(
        'name'          => __( 'Icon Class', 'auto-listings' ),
        'id'            => 'icon',
        'type'          => 'text',
        'attributes'    => array( 
            'placeholder' => 'auto-icon-odometer',
        ),
        'desc'          => sprintf( __( 'Add icon class to display an icon. See %s for available icons.', 'auto-listings' ), '<a target="_blank" href="http://www.wpautolistings.com/docs/icons?utm_source=plugin&utm_medium=settings_page&utm_content=icon_docs">icon docs</a>' ) . '<br>' . __( 'Can also use FontAwesome icon classes such as "fa fa-caret-left".', 'auto-listings' ),
    ));


    $cmb->object_type( 'options-page' );
    $boxes[] = $cmb;


/* ======================================================================================
                                        Fields
   ====================================================================================== */
    
    // fields
    $cmb = new_cmb2_box( array(
        'id'        => 'display_fields',
        'title'     => __( 'Listing Spec Fields', 'auto-listings' ),
        'show_on'   => $show_on,
    ));
    $cmb->add_field( array(
        'name'       => __( 'Spec Fields to Display', 'auto-listings' ),
        'before_row'       => __( 'The specification fields you would like to display in the admin and frontend.', 'auto-listings' ),
        'id'         => 'field_display',
        'type'       => 'multicheck',
        'options_cb' => 'auto_listings_admin_field_display_checkboxes',
    ));

    $cmb->object_type( 'options-page' );
    $boxes[] = $cmb;

/* ======================================================================================
                                        Display Options
   ====================================================================================== */

    // columns
    $cmb = new_cmb2_box( array(
        'id'        => 'columns',
        'title'     => __( 'Columns', 'auto-listings' ),
        'show_on'   => $show_on,
    ));
    $cmb->add_field( array(
        'name'          => __( 'Number of Columns', 'auto-listings' ),
        'desc'          => __( 'The number of columns to display on the archive page, when viewing listings in grid mode.', 'auto-listings' ),
        'id'            => 'grid_columns',
        'type'          => 'select',
        'default'       => '3',
        'options' => array(
            '2'     => __( '2 Column', 'auto-listings' ),
            '3'     => __( '3 Column', 'auto-listings' ),
            '4'     => __( '4 Column', 'auto-listings' ),
        ),
    ));

    $cmb->object_type( 'options-page' );
    $boxes[] = $cmb;

    // gallery_settings
    $cmb = new_cmb2_box( array(
        'id'        => 'gallery_settings',
        'title'     => __( 'Gallery Settings', 'auto-listings' ),
        'show_on'   => $show_on,
    ));

    $cmb->add_field( array(
        'name'          => __( 'Auto Slide Images', 'auto-listings' ),
        'desc'          => __( 'Should images start to slide automatically?', 'auto-listings' ),
        'id'            => 'auto_slide',
        'type'          => 'select',
        'default'       => 'yes',
        'options' => array(
            'yes'     => 'Yes',
            'no'      => 'No',
        ),
    ));
    $cmb->add_field( array(
        'name'          => __( 'Transition Delay', 'auto-listings' ),
        'desc'          => __( 'The time (in ms) between each auto transition', 'auto-listings' ),
        'id'            => 'slide_delay',
        'type'          => 'text',
        'default'       => '2000',
        'attributes' => array(
            'type'          => 'number',
            'placeholder'   => '2000',
        ),
    ));
    $cmb->add_field( array(
        'name'          => __( 'Transition Duration', 'auto-listings' ),
        'desc'          => __( 'Transition duration (in ms)', 'auto-listings' ),
        'id'            => 'slide_duration',
        'type'          => 'text',
        'default'       => '1000',
        'attributes' => array(
            'type'          => 'number',
            'placeholder'   => '1000',
        ),
    ));
    $cmb->add_field( array(
        'name'          => __( 'Thumbnails Shown', 'auto-listings' ),
        'desc'          => sprintf( __( 'Number of thumbnails shown below main image', 'auto-listings' ), $listing_label ),
        'id'            => 'thumbs_shown',
        'type'          => 'text',
        'default'       => '6',
        'attributes' => array(
            'type'          => 'number',
            'placeholder'   => '6',
        ),
    ));
    $cmb->add_field( array(
        'name'          => __( 'Transition Type', 'auto-listings' ),
        'desc'          => __( 'Should images slide or fade?', 'auto-listings' ),
        'id'            => 'gallery_mode',
        'type'          => 'select',
        'default'       => 'fade',
        'options' => array(
            'fade'     => 'Fade',
            'slide'    => 'Slide',
        ),
    ));

    $cmb->object_type( 'options-page' );
    $boxes[] = $cmb;


    // colors
    $cmb = new_cmb2_box( array(
        'id'        => 'colors',
        'title'     => __( 'Colors', 'auto-listings' ),
        'show_on'   => $show_on,
    ));
    $cmb->add_field( array(
        'name'          => __( 'Button Background', 'auto-listings' ),
        'desc'          => __( 'Background color for buttons. Also used as highlight color in search field, tabs and image gallery.', 'auto-listings' ),
        'id'            => 'button_bg_color',
        'type'          => 'colorpicker',
    ));
    $cmb->add_field( array(
        'name'          => __( 'Button Text', 'auto-listings' ),
        'desc'          => __( '', 'auto-listings' ),
        'id'            => 'button_text_color',
        'type'          => 'colorpicker',
    ));
    $cmb->add_field( array(
        'name'          => __( 'Price', 'auto-listings' ),
        'desc'          => __( '', 'auto-listings' ),
        'id'            => 'price_color',
        'type'          => 'colorpicker',
    ));
    $cmb->add_field( array(
        'name'          => __( 'Contact Icons', 'auto-listings' ),
        'desc'          => __( '', 'auto-listings' ),
        'id'            => 'contact_icon_color',
        'type'          => 'colorpicker',
    ));
    $cmb->add_field( array(
        'name'          => __( 'Listing Icons', 'auto-listings' ),
        'desc'          => __( '', 'auto-listings' ),
        'id'            => 'listing_icon_color',
        'type'          => 'colorpicker',
    ));

    $cmb->object_type( 'options-page' );
    $boxes[] = $cmb;

/* ======================================================================================
                                        Contact Form
   ====================================================================================== */

    // contact form
    $cmb = new_cmb2_box( array(
        'id'        => 'contact_form',
        'title'     => __( 'Contact Form Settings', 'auto-listings' ),
        'show_on'   => $show_on,
        
    ));
    $cmb->add_field( array(
        'name'       => __( 'Email From', 'auto-listings' ),
        'desc'       => __( 'The "from" address for all enquiry emails that are sent to Sellers.', 'auto-listings' ),
        'id'         => 'email_from',
        'type'       => 'text_email',
        'default'   => get_bloginfo( 'admin_email' ),
        'before_row'      => '<p class="cmb2-metabox-description">' . __( 'Contact form enquiries are sent directly to the selected Seller on that listing.', 'auto-listings' ) . '<br>' . __( 'Therefore, it is important to include the seller on each listing.', 'auto-listings' ) . '</p>',
    ));
    $cmb->add_field( array(
        'name'       => __( 'Email From Name', 'auto-listings' ),
        'desc'       => __( 'The "from" name for all enquiry emails that are sent to Sellers.', 'auto-listings' ),
        'id'         => 'email_from_name',
        'type'       => 'text',
        'default'   => get_bloginfo( 'name' ),
    ));
    $cmb->add_field( array(
        'name'       => __( 'CC', 'auto-listings' ),
        'desc'       => __( 'Extra email addresses that are CC\'d on every enquiry (comma separated).', 'auto-listings' ),
        'id'         => 'contact_form_cc',
        'type'       => 'text',
        'attributes' => array( 
            'placeholder' => 'somebody@somewhere.com',
        ),
    ));
    $cmb->add_field( array(
        'name'       => __( 'BCC', 'auto-listings' ),
        'desc'       => __( 'Extra email addresses that are BCC\'d on every enquiry (comma separated).', 'auto-listings' ),
        'id'         => 'contact_form_bcc',
        'type'       => 'text',
        'attributes' => array( 
            'placeholder' => 'somebody@somewhere.com',
        ),
    ));
    
    $cmb->object_type( 'options-page' );
    $boxes[] = $cmb;



    // contact form email
    $cmb = new_cmb2_box( array(
        'id'        => 'contact_form_email',
        'title'     => __( 'Contact Form Email', 'auto-listings' ),
        'show_on'   => $show_on,
        'desc'      => __( '', 'auto-listings' ),
    ));
    
    $cmb->add_field( array(
        'name'       => __( 'Email Type', 'auto-listings' ),
        'desc'       => __( '', 'auto-listings' ),
        'id'         => 'contact_form_email_type',
        'type'       => 'select',
        'options' => array(
            'html_email'     => __( 'HTML', 'auto-listings' ),
            'text_email'     => __( 'Plain Text', 'auto-listings' ),
        ),
        'default'    => 'html_email',
    ));
    $cmb->add_field( array(
        'name'       => __( 'Email Subject', 'auto-listings' ),
        'desc'       => __( '', 'auto-listings' ),
        'id'         => 'contact_form_subject',
        'type'       => 'text',
        'default'    => __( 'New enquiry on listing #{listing_id}', 'auto-listings' ),
    ));
    $cmb->add_field( array(
        'name'       => __( 'Email Message', 'auto-listings' ),
        'desc'       => __( 'Content of the email that is sent to the seller (and other email addresses above). ' .
            'Available tags are:<br>' . 
            '{seller_name}<br>' . 
            '{listing_title}<br>' . 
            '{listing_id}<br>' . 
            '{enquiry_name}<br>' . 
            '{enquiry_email}<br>' . 
            '{enquiry_phone}<br>' . 
            '{enquiry_message}<br>'
            , 'auto-listings' ),
        'default'    => __( 'Hi {seller_name},', 'auto-listings' ) . "\r\n" .
                        __( 'There has been a new enquiry on <strong>{listing_title}</strong>', 'auto-listings' ) . "\r\n" .
                        '<hr>' . "\r\n" .
                        __( 'Name: {enquiry_name}', 'auto-listings' ) . "\r\n" .
                        __( 'Email: {enquiry_email}', 'auto-listings' ) . "\r\n" .
                        __( 'Phone: {enquiry_phone}', 'auto-listings' ) . "\r\n" .
                        __( 'Message: {enquiry_message}', 'auto-listings' ) . "\r\n" .
                        '<hr>',
        'id'         => 'contact_form_message',
        'type'       => 'textarea',
    ));
    
    $cmb->object_type( 'options-page' );
    $boxes[] = $cmb;


    // contact form messages
    $cmb = new_cmb2_box( array(
        'id'        => 'contact_form_messages',
        'title'     => __( 'Contact Form Messages', 'auto-listings' ),
        'show_on'   => $show_on,
        'desc'      => __( '', 'auto-listings' ),
    ));
    
    $cmb->add_field( array(
        'name'       => __( 'Success Message', 'auto-listings' ),
        'desc'       => __( 'The message that is displayed to users upon successfully sending a message.', 'auto-listings' ),
        'id'         => 'contact_form_success',
        'type'       => 'text',
        'default'    => __( 'Thank you, we will be in touch with you soon.', 'auto-listings' ),
    ));
    $cmb->add_field( array(
        'name'       => __( 'Error Message', 'auto-listings' ),
        'desc'       => __( 'The message that is displayed if there is an error sending the message.', 'auto-listings' ),
        'id'         => 'contact_form_error',
        'type'       => 'text',
        'default'    => __( 'There was an error. Please try again.', 'auto-listings' ),
    ));
    $cmb->add_field( array(
        'name'       => __( 'Include Error Code', 'auto-listings' ),
        'desc'       => __( 'Should the error code be shown with the error. Can be helpful for troubleshooting.', 'auto-listings' ),
        'id'         => 'contact_form_include_error',
        'type'       => 'select',
        'options' => array(
            'yes'    => __( 'Yes', 'auto-listings' ),
            'no'     => __( 'No', 'auto-listings' ),
        ),
        'default'    => 'yes',
    ));

    $cmb->object_type( 'options-page' );
    $boxes[] = $cmb;


/* ======================================================================================
                                        Advanced Options
   ====================================================================================== */
    // template html
    $cmb = new_cmb2_box( array(
        'id'        => 'theme_compatibility',
        'title'     => __( 'Theme Compatibility', 'auto-listings' ),
        
        'show_on'   => $show_on,
    ));
    $cmb->add_field( array(
        'name'          => __( 'Opening HTML Tag(s)', 'auto-listings' ),
        'desc'          => __( 'Override the opening HTML tags for all Listings pages.', 'auto-listings' ) . '<br>' .
        __( 'This can help you to match the HTML with your current theme.', 'auto-listings' ),
        'id'            => 'opening_html',
        'type'          => 'textarea',
        'attributes' => array(
            'placeholder'   => '<div class=&quot;container&quot;><div class=&quot;main-content&quot;>',
            'rows'   => 2,
        ),
        'before_row'     => '<p class="cmb2-metabox-description">' . __( '', 'auto-listings' ) . '</p>',
    ));
    $cmb->add_field( array(
        'name'          => __( 'Closing HTML Tag(s)', 'auto-listings' ),
        'desc'          => __( 'Override the closing HTML tags for all Listings pages.', 'auto-listings' ) . '<br>' .
        __( 'This can help you to match the HTML with your current theme.', 'auto-listings' ),
        'id'            => 'closing_html',
        'type'          => 'textarea',
        'attributes' => array(
            'placeholder'   => '</div></div>',
            'rows'   => 2,
        ),
    )); 

    $cmb->add_field( array(
        'name'       => __( 'Force Listings Page Title', 'auto-listings-related' ),
        'desc'       => __( 'Some themes may be using incorrect template tags to display the archive page title.' ) . '<br>' . __( 'If your page title is not displaying on the listings page, you can force the page title here.', 'auto-listings-related' ),
        'id'         => 'archives_page_title',
        'type'       => 'select',
        'default'    => 'no',
        'options'    => array(
            'no'    => __( 'No', 'auto-listings' ),
            'yes'   => __( 'Yes', 'auto-listings' ),
        ),
    ));

    $cmb->object_type( 'options-page' );
    $boxes[] = $cmb;

    // uninstall
    $cmb = new_cmb2_box( array(
        'id'        => 'uninstall',
        'title'     => __( 'Uninstall', 'auto-listings' ),
        
        'show_on'   => $show_on,
    ));
    $cmb->add_field( array(
        'name'          => __( 'Delete Data', 'auto-listings' ),
        'desc'          => __( 'Should all plugin data be deleted upon uninstalling this plugin?', 'auto-listings' ),
        'id'            => 'delete_data',
        'type'          => 'select',
        'default'       => 'yes',
        'options' => array(
            'yes'   => __( 'Yes', 'auto-listings' ),
            'no'    => __( 'No', 'auto-listings' ),
        ),
    ));


    $cmb->object_type( 'options-page' );
    $boxes[] = $cmb;



    // extensions
    $cmb = new_cmb2_box( array(
        'id'        => 'extensions',
        'title'     => __( 'Extensions', 'auto-listings' ),
        'show_on'   => $show_on,
    ));
    $cmb->add_field( array(
        'name'       => __( '', 'auto-listings' ),
        'after'      => '<p class="">' . __( 'There are a number of premium extensions available at <a href="http://wpautolistings.com/documentation?utm_source=plugin&utm_medium=settings_page&utm_content=extensions" target="_blank">www.wpautolistings.com</a> that will take your automotive website to the next level.', 'auto-listings' ) . '</p>',
        'id'         => 'intro',
        'type'       => 'title',
    ));
    $cmb->object_type( 'options-page' );
    $boxes[] = $cmb;

    // box 3, in sidebar of our two-column layout
    $cmb = new_cmb2_box( array(
        'id'        => 'side_metabox',
        'title'     => __( 'Save', 'auto-listings' ),
        'show_on'   => $show_on,
        'context'    => 'side',
    ));
    $cmb->add_field( array(
        'name'       => __( 'Publish?', 'auto-listings' ),
        'desc'       => __( 'Save These Options', 'auto-listings' ),
        'id'         => 'my_save_button',
        'type'       => 'options_save_button',
        'show_names' => false,
        'after_row' => 'auto_listings_show_options_banners',
    ));
    $cmb->object_type( 'options-page' );
    $boxes[] = $cmb;



    // Arguments array. See the arguments page for more detail
    $args = array(
        'key'        => $opt_key,
        'title'      => __( 'Auto Listings', 'auto-listings' ),
        'topmenu'    => 'options-general.php',
        'boxes'      => $boxes,
        'tabs'       => $tabs,
        'cols'       => 2,
        'savetxt'    => '',
    );

    new Cmb2_Metatabs_Options( apply_filters( 'auto_listings_admin_options', $args, $cmb ) );
}


function auto_listings_show_options_banners() {
    echo '<a target="_blank" href="http://wpautolistings.com/submit-ticket?utm_source=plugin&utm_medium=banner&utm_content=support"><img src="' . AUTOLISTINGS_PLUGIN_URL . '/includes/admin/assets/images/support-banner.jpg" class="banner1" /></a>';

    echo '<a target="_blank" href="https://wordpress.org/support/plugin/auto-listings/reviews/?filter=5"><img src="' . AUTOLISTINGS_PLUGIN_URL . '/includes/admin/assets/images/review-banner.jpg" class="banner2" /></a>';

    echo '<a target="_blank" href="http://wpautolistings.com/extensions?utm_source=plugin&utm_medium=banner&utm_content=extensions"><img src="' . AUTOLISTINGS_PLUGIN_URL . '/includes/admin/assets/images/extensions-banner.jpg" class="banner3" /></a>';
}