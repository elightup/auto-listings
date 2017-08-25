<?php
/**
 * @link http://webdevstudios.com/2015/03/30/use-cmb2-to-create-a-new-post-submission-form/ Original tutorial
 */

class Auto_Listings_Contact_Form {

	public $content_type 	= '';

	public $success_msg 	= '';

	public $error_msg 		= '';

	public $show_error 		= '';

	/**
	 * Constructor.
	 */
	public function __construct() {
		add_action( 'init', array( $this, 'init' ) );
		add_action( 'cmb2_init', array( $this, 'register_contact_form' ) );
		add_shortcode( 'auto_listings_contact_form', array( $this, 'contact_form_shortcode' ) );
		add_action( 'cmb2_after_init', array( $this, 'contact_form_submission' ) );
		add_filter( 'wp_mail_content_type', array( $this, 'set_content_type' ) );
	}
	
	/**
	 * init
	 */
	public function init() {
		$this->content_type = auto_listings_option( 'contact_form_email_type' );
		$this->success_msg 	= auto_listings_option( 'contact_form_success' );
		$this->error_msg 	= auto_listings_option( 'contact_form_error' );
		$this->show_error 	= auto_listings_option( 'contact_form_include_error' );
	}

	
	/**
	 * Set the email content type
	 */
	public function set_content_type( $content_type ) {
		$type = auto_listings_option( 'contact_form_email_type' );
		if( $type == 'html_email' ) {
			$return = 'text/html';	
		} else {
			$return = 'text/html';	
		} 
		return $return;
	}

	/**
	 * The success notice.
	 */
	public function success_notice() {
		return apply_filters( 'auto_listings_contact_form_success', '<p class="alert success alert-success">' . esc_html( $this->success_msg ) . '</p>' );
	}

	/**
	 * The error notice.
	 */
	public function error_notice( $error ) {
		$show = $this->show_error == 'yes' ? '<br><strong>' . $error->get_error_message() . '</strong>' : '';
		return apply_filters( 'auto_listings_contact_form_error', '<p class="alert error warning alert-warning alert-error">' . esc_html( $this->error_msg . $show ) . '</p>' );
	}

	/**
	 * Register the form and fields for our front-end submission form
	 */
	public function register_contact_form() {
		
		$metabox = new_cmb2_box( array(
			'id'           	=> 'auto_listings_contact_form',
			'title'         => __( 'Contact Form', 'auto-listings' ),
			'object_types' 	=> array( 'listing-enquiry' ),
			// 'hookup'       => false,
			//'save_fields'  	=> false,
			'cmb_styles' 	=> false,
			'context'       => 'normal',
			'priority'      => 'high',
			'show_names'    => true, // Show field names on the left
		) );

		$fields = array();

		$fields[0] = array(
			'name' => 'URL',
			'desc' => 'Do not fill this field in',
			'id'   => 'url',
			'type' => 'text',
			'attributes' => array( 
				'placeholder' => 'Anti spam field',
			)
		);
		$fields[1] = array(
			'name' => 'Comment',
			'desc' => 'Do not fill this field in',
			'id'   => 'comment',
			'type' => 'textarea_small',
			'attributes' => array( 
				'placeholder' => 'Anti spam field',
			)
		);

		$fields[10] = array(
			'name' => '',
			'desc' => '',
			'id'   => '_al_enquiry_name',
			'type' => 'text',
			'attributes' => array( 
				'required' => 'required',
				'placeholder' => __( 'Name', 'auto-listings' ),
			)
		);

		$fields[20] = array(
			'name' => '',
			'desc' => '',
			'id'   => '_al_enquiry_email',
			'type' => 'text_email',
			'attributes' => array( 
				'required' => 'required',
				'placeholder' => __( 'Email', 'auto-listings' ),
			)
		);

		$fields[30] = array(
			'name' => '',
			'desc' => '',
			'id'   => '_al_enquiry_phone',
			'type' => 'text',
			'attributes' => array( 
				'placeholder' => __( 'Phone', 'auto-listings' ),
			)
		);

		$fields[40] = array(
			'name'    => '',
			'id'      => '_al_enquiry_message',
			'type'    => 'textarea',
			'attributes' => array( 
				'required' => 'required',
				'placeholder' => __( 'Message', 'auto-listings' ),
				'rows' => 2,
			)
		);

		// filter the fields & sort numerically
        $fields = apply_filters( 'auto_listings_contact_fields', $fields );
        ksort( $fields ); 

        // loop through ordered fields and add them
        if( $fields ) {
        	foreach ($fields as $key => $value) {
        		$fields[$key] = $metabox->add_field( $value );
        	}
        }



	}

	/**
	 * Gets the front-end-post-form cmb instance
	 *
	 * @return CMB2 object
	 */
	public function form_instance() {
		// Use ID of metabox in wds_frontend_form_register
		$metabox_id = 'auto_listings_contact_form';
		// Post/object ID is not applicable since we're using this form for submission
		$object_id  = 'auto_listings_contact_form_object_id';
		// Get CMB2 metabox object
		return cmb2_get_metabox( $metabox_id, $object_id );
	}


	/**
	 * Handle the auto-listings-contact shortcode
	 *
	 * @param  array  $atts Array of shortcode attributes
	 * @return string       Form html
	 */
	public function contact_form_shortcode( $atts = array() ) {
		
		// Get CMB2 metabox object
		$cmb = $this->form_instance();

		// Parse attributes
		$atts = shortcode_atts( array(
			'post_title' 	=> sprintf( __( 'Enquiry on listing #%s', 'auto-listings' ), get_the_ID() ),
			'post_content' 	=> '',
			'post_author' 	=> auto_listings_meta( 'seller', get_the_ID() ) ? auto_listings_meta( 'seller', get_the_ID() ) : 1, 
			'post_status' 	=> 'publish',
			'post_type'   	=> 'listing-enquiry', 
			'listing_title' => get_the_title(), 
			'listing_id' 	=> get_the_ID(), 
			'listing_seller' => auto_listings_meta( 'seller', get_the_ID() ) ? auto_listings_meta( 'seller', get_the_ID() ) : '', 
		), $atts, 'auto-listings-contact-form' );
		
		/*
		 * Let's add these attributes as hidden fields to our cmb form
		 * so that they will be passed through to our form submission
		 */
		foreach ( $atts as $key => $value ) {
			$cmb->add_hidden_field( array(
				'field_args'  => array(
					'id'    => "atts[$key]",
					'type'  => 'hidden',
					'default' => $value,
				),
			) );
		}

		// Initiate our output variable
		$output = '';
		// Get any submission errors
		if ( ( $error = $cmb->prop( 'submission_error' ) ) && is_wp_error( $error ) ) {
			// If there was an error with the submission, add it to our ouput.
			$output .= $this->error_notice( $error );
		}

		// If the post was submitted successfully, notify the user.
		if ( isset( $_GET['success'] ) && ( $post = get_post( absint( $_GET['success'] ) ) ) ) {

			// Add notice of submission to our output
			$output .= $this->success_notice();
			
		}

		// Get our form
		$output .= cmb2_get_metabox_form( $cmb, 'auto_listings_contact_form_object_id', array( 'save_button' => __( 'Send Enquiry', 'auto-listings' ) ) );
		return $output;

	}
	

	/**
	 * Handles form submission on save. Redirects if save is successful, otherwise sets an error message as a cmb property
	 *
	 * @return void
	 */
	public function contact_form_submission() {

		// If no form submission, bail
		if ( empty( $_POST ) || ! isset( $_POST['submit-cmb'], $_POST['object_id'] ) ) {
			return false;
		}

		// If URL is filled in, it is spam
		if ( isset( $_POST['url'] ) && $_POST['url'] != '' ) {
			return false;
		}
		// If COMMENT is filled in, it is spam
		if ( isset( $_POST['comment'] ) && $_POST['comment'] != '' ) {
			return false;
		}
		
		// unset our spam fields
		unset( $_POST['url'] );
		unset( $_POST['comment'] );

		// Get CMB2 metabox object
		$cmb = $this->form_instance();
		$post_data = array();
		
		// Get our shortcode attributes and set them as our initial post_data args
		if ( isset( $_POST['atts'] ) ) {
			foreach ( (array) $_POST['atts'] as $key => $value ) {
				$post_data[ $key ] = sanitize_text_field( $value );
			}
			unset( $_POST['atts'] );
		}

		// Check security nonce
		if ( ! isset( $_POST[ $cmb->nonce() ] ) || ! wp_verify_nonce( $_POST[ $cmb->nonce() ], $cmb->nonce() ) ) {
			return $cmb->prop( 'submission_error', new WP_Error( 'security_fail', __( 'Security check failed.' ) ) );
		}

		/**
		 * Fetch remaining sanitized values
		 */
		$meta_values = $cmb->get_sanitized_values( $_POST );
		
		// set some meta values
		$meta_values['_al_enquiry_listing_title'] = $post_data['listing_title'];
		$meta_values['_al_enquiry_listing_id'] = $post_data['listing_id'];
		$meta_values['_al_enquiry_listing_seller'] = $post_data['listing_seller'];
		unset( $post_data['listing_title'] );
		unset( $post_data['listing_id'] );
		unset( $post_data['listing_seller'] );

		// Create the new post
		$new_submission_id = wp_insert_post( $post_data, true );
		
		// If we hit a snag, update the user
		if ( is_wp_error( $new_submission_id ) ) {
			return $cmb->prop( 'submission_error', $new_submission_id );
		}
		
		// Loop through remaining (sanitized) data, and save to post-meta
		foreach ( $meta_values as $key => $value ) {
			if ( is_array( $value ) ) {
				$value = array_filter( $value );
				if( ! empty( $value ) ) {
					update_post_meta( $new_submission_id, $key, $value );
				}
			} else {
				update_post_meta( $new_submission_id, $key, $value );
			}
		}

		$this->send_notification( $meta_values['_al_enquiry_listing_id'], $new_submission_id );

		/*
		 * Redirect back to the form page with a query variable with the new post ID.
		 * This will help double-submissions with browser refreshes
		 */
		wp_redirect( add_query_arg( 'success', $new_submission_id ) . '#auto-listings-contact' );
		exit;
	}


	/**
	 * Get email from
	 */
	public function email_from(){
		$from_email	= auto_listings_option( 'email_from' ) ? auto_listings_option( 'email_from' ) : get_bloginfo( 'admin_email' );
		$from_name 	= auto_listings_option( 'email_from_name' ) ? auto_listings_option( 'email_from_name' ) : get_bloginfo( 'name' );
		return apply_filters( 'auto_listings_email_from', wp_specialchars_decode( esc_html( $from_name ), ENT_QUOTES ) . ' <' . sanitize_email( $from_email ) . '>' );
	}

	/**
	 * Email recipient (the seller)
	 */
	public function recipient( $listing_ID ){
		$seller_id		= auto_listings_meta( 'seller', $listing_ID );
		$seller_email	= get_the_author_meta( 'email', $seller_id ) ? get_the_author_meta( 'email', $seller_id ) : get_bloginfo( 'admin_email' );
		return apply_filters( 'auto_listings_contact_form_recipient', sanitize_email( $seller_email ) );
	}

	/**
	 * Email Cc
	 */
	public function cc(){
		$return = auto_listings_option( 'contact_form_cc' );
		return apply_filters( 'auto_listings_contact_form_cc', $return );
	}

	/**
	 * Email Bcc
	 */
	public function bcc(){
		$return = auto_listings_option( 'contact_form_bcc' );
		return apply_filters( 'auto_listings_contact_form_bcc', $return );
	}

	/**
	 * Email headers
	 */
	public function headers( $enquiry_email ){
		$headers[] = 'From: ' . $this->email_from();
        $headers[] = 'Reply-To: ' . $enquiry_email;
        if( $this->cc() ) {
        	$headers[] = 'Cc: ' . $this->cc();
        }
        if( $this->bcc() ) {
        	$headers[] = 'Bcc: ' . $this->bcc();
        }
		return apply_filters( 'auto_listings_contact_form_headers', $headers );
	}


	/**
	 * Email Subject
	 */
	public function subject(){
		$subject = auto_listings_option( 'contact_form_subject' );
		if( ! isset( $subject ) || empty( $subject ) ) {
			$subject = __( 'New enquiry on listing #{listing_id}', 'auto-listings' );
		}
		return apply_filters( 'auto_listings_contact_form_subject', $subject );
	}

	/**
	 * Email Message
	 */
	public function message(){
		$message = auto_listings_option( 'contact_form_message' );
		if( ! isset( $message ) || empty( $message ) ) {
			$message = 	__( 'Hi {seller_name},', 'auto-listings' ) . "\r\n" .
        				__( 'There has been a new enquiry on <strong>{listing_title}</strong>', 'auto-listings' ) . "\r\n" .
        				__( 'Name: {enquiry_name}', 'auto-listings' ) . "\r\n" .
        				__( 'Email: {enquiry_email}', 'auto-listings' ) . "\r\n" .
        				__( 'Phone: {enquiry_phone}', 'auto-listings' ) . "\r\n" .
        				__( 'Message: {enquiry_message}', 'auto-listings' ) . "\r\n";
		}
		return apply_filters( 'auto_listings_contact_form_message', wpautop( wp_kses_post( $message ) ) );
	}

	/**
	 * Find
	 */
	public function find() {
		$find = array();
		$find['seller_name']      	= '{seller_name}';
		$find['listing_title']    	= '{listing_title}';
		$find['listing_id']    		= '{listing_id}';
		$find['enquiry_name']    	= '{enquiry_name}';
		$find['enquiry_email']    	= '{enquiry_email}';
		$find['enquiry_phone']    	= '{enquiry_phone}';
		$find['enquiry_message']  	= '{enquiry_message}';
		return apply_filters( 'auto_listings_contact_form_find', $find );
	}

	/**
	 * Replace
	 */
	public function replace( $listing_ID, $enquiry_ID ) {
		$replace = array();
		$replace['seller_name']      = get_the_author_meta( 'display_name', get_post_meta( $enquiry_ID, '_al_enquiry_listing_seller', true ) );
		$replace['listing_title']   = get_the_title( $listing_ID );
		$replace['listing_id']    	= $listing_ID;
		$replace['enquiry_name']    = get_post_meta( $enquiry_ID, '_al_enquiry_name', true );
		$replace['enquiry_email']   = get_post_meta( $enquiry_ID, '_al_enquiry_email', true );
		$replace['enquiry_phone']   = get_post_meta( $enquiry_ID, '_al_enquiry_phone', true );
		$replace['enquiry_message'] = get_post_meta( $enquiry_ID, '_al_enquiry_message', true );
		return apply_filters( 'auto_listings_contact_form_replace', $replace );
	}

	/**
	 * Format email string.
	 *
	 */
	public function format_string( $string, $listing_ID, $enquiry_ID ) {
		return str_replace( $this->find(), $this->replace( $listing_ID, $enquiry_ID ), __( $string ) );
	}

	/**
	 * Notify sellers by sending them an email
	 *
	 */
	public function send_notification( $listing_ID, $enquiry_ID ){

		// to
		$to = $this->recipient( $listing_ID );

		// subject
		$subject = $this->format_string( $this->subject(), $listing_ID, $enquiry_ID );

		// message
		$message = $this->format_string( $this->message(), $listing_ID, $enquiry_ID );

        // set headers
		$headers = $this->headers( get_post_meta( $enquiry_ID, '_al_enquiry_email', true ) );

        if( $sent = wp_mail( $to, $subject, $message, $headers ) ) {

	    	$existing_enquiries 	= get_post_meta( $listing_ID, '_al_listing_enquiries', true );
	    	$existing_enquiries[] 	= $enquiry_ID;
	    	update_post_meta( $listing_ID, '_al_listing_enquiries', $existing_enquiries );

	    } else {
	    	//pp( 'no worky' );
	    }

	}


}

return new Auto_Listings_Contact_Form();