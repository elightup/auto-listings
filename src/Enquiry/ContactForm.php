<?php
namespace AutoListings\Enquiry;

class ContactForm {
	public function __construct() {
		add_shortcode( 'auto_listings_contact_form', [ $this, 'contact_form_shortcode' ] );
		add_action( 'rwmb_frontend_before_submit_button', [ $this, 'listing_fields' ] );
		add_filter( 'rwmb_frontend_insert_post_data', [ $this, 'post_data' ], 10, 2 );
		add_action( 'rwmb_frontend_after_save_post', [ $this, 'add_listing_data' ] );
		add_action( 'rwmb_frontend_after_save_post', [ $this, 'send_notification' ] );
	}

	public function contact_form_shortcode() {
		$shortcode = "[mb_frontend_form id='auto_listings_contact_form' submit_button='" . __( 'Send Enquiry', 'auto-listings' ) . "']";
		return do_shortcode( $shortcode );
	}

	public function listing_fields( $config ) {
		if ( 'auto_listings_contact_form' !== $config['id'] ) {
			return;
		}
		echo '<input type="hidden" name="listing_id" value="' . get_the_ID() . '">';
	}

	public function post_data( $data, $config ) {
		if ( 'auto_listings_contact_form' !== $config['id'] ) {
			return $data;
		}
		$listing_id          = filter_input( INPUT_POST, 'listing_id', FILTER_SANITIZE_NUMBER_INT );
		$listing_seller      = auto_listings_meta( 'seller', $listing_id );
		$data['post_author'] = $listing_seller;
		$data['post_title']  = sprintf( __( 'Enquiry on listing #%s', 'auto-listings' ), $listing_id );
		return $data;
	}

	public function add_listing_data( $enquiry ) {
		if ( 'auto_listings_contact_form' !== $enquiry->config['id'] ) {
			return;
		}
		$listing_id = filter_input( INPUT_POST, 'listing_id', FILTER_SANITIZE_NUMBER_INT );
		if ( ! $listing_id ) {
			return;
		}
		$listing_title  = get_the_title( $listing_id );
		$listing_seller = auto_listings_meta( 'seller', $listing_id );
		update_post_meta( $enquiry->post_id, '_al_enquiry_listing_id', $listing_id );
		update_post_meta( $enquiry->post_id, '_al_enquiry_listing_title', $listing_title );
		update_post_meta( $enquiry->post_id, '_al_enquiry_listing_seller', $listing_seller );
	}

	public function send_notification( $enquiry ) {
		if ( 'auto_listings_contact_form' !== $enquiry->config['id'] ) {
			return;
		}
		$listing_id = get_post_meta( $enquiry->post_id, '_al_enquiry_listing_id', true );

		$to      = $this->recipient( $listing_id );
		$subject = $this->replace_placeholders( $this->subject(), $listing_id, $enquiry->post_id );
		$message = $this->replace_placeholders( $this->message(), $listing_id, $enquiry->post_id );
		$headers = $this->headers( get_post_meta( $enquiry->post_id, '_al_enquiry_email', true ) );

		wp_mail( $to, $subject, $message, $headers );
		$enquiries   = get_post_meta( $listing_id, '_al_listing_enquiries', true );
		$enquiries[] = $enquiry->post_id;
		update_post_meta( $listing_id, '_al_listing_enquiries', $enquiries );
	}

	protected function recipient( $listing_id ) {
		$seller_id    = auto_listings_meta( 'seller', $listing_id );
		$seller_email = get_the_author_meta( 'email', $seller_id ) ? get_the_author_meta( 'email', $seller_id ) : get_bloginfo( 'admin_email' );
		return apply_filters( 'auto_listings_contact_form_recipient', sanitize_email( $seller_email ) );
	}

	protected function subject() {
		$subject = auto_listings_option( 'contact_form_subject' );
		if ( ! isset( $subject ) || empty( $subject ) ) {
			$subject = __( 'New enquiry on listing #{listing_id}', 'auto-listings' );
		}
		return apply_filters( 'auto_listings_contact_form_subject', $subject );
	}

	protected function message() {
		$message = auto_listings_option( 'contact_form_message' );
		if ( ! isset( $message ) || empty( $message ) ) {
			$message = __( 'Hi {seller_name},', 'auto-listings' ) . "\r\n" .
			           __( 'There has been a new enquiry on <strong>{listing_title}</strong>', 'auto-listings' ) . "\r\n" .
			           __( 'Name: {enquiry_name}', 'auto-listings' ) . "\r\n" .
			           __( 'Email: {enquiry_email}', 'auto-listings' ) . "\r\n" .
			           __( 'Phone: {enquiry_phone}', 'auto-listings' ) . "\r\n" .
			           __( 'Message: {enquiry_message}', 'auto-listings' ) . "\r\n";
		}
		return apply_filters( 'auto_listings_contact_form_message', wpautop( wp_kses_post( $message ) ) );
	}

	protected function headers( $enquiry_email ) {
		$headers[] = 'From: ' . $this->email_from();
		$headers[] = 'Reply-To: ' . $enquiry_email;
		if ( $this->cc() ) {
			$headers[] = 'Cc: ' . $this->cc();
		}
		if ( $this->bcc() ) {
			$headers[] = 'Bcc: ' . $this->bcc();
		}
		$headers[] = 'Content-type: ' . $this->content_type();
		return apply_filters( 'auto_listings_contact_form_headers', $headers );
	}

	protected function email_from() {
		$from_email = auto_listings_option( 'email_from' ) ? auto_listings_option( 'email_from' ) : get_bloginfo( 'admin_email' );
		$from_name  = auto_listings_option( 'email_from_name' ) ? auto_listings_option( 'email_from_name' ) : get_bloginfo( 'name' );
		return apply_filters( 'auto_listings_email_from', wp_specialchars_decode( esc_html( $from_name ), ENT_QUOTES ) . ' <' . sanitize_email( $from_email ) . '>' );
	}

	protected function cc() {
		$return = auto_listings_option( 'contact_form_cc' );
		return apply_filters( 'auto_listings_contact_form_cc', $return );
	}

	protected function bcc() {
		$return = auto_listings_option( 'contact_form_bcc' );
		return apply_filters( 'auto_listings_contact_form_bcc', $return );
	}

	protected function content_type() {
		$type = auto_listings_option( 'contact_form_email_type' );
		return 'html_email' === $type ? 'text/html' : 'text/html';
	}

	protected function replace_placeholders( $string, $listing_id, $enquiry_id ) {
		return str_replace( $this->placeholders(), $this->replacements( $listing_id, $enquiry_id ), __( $string ) );
	}

	protected function placeholders() {
		$find                    = [];
		$find['seller_name']     = '{seller_name}';
		$find['listing_title']   = '{listing_title}';
		$find['listing_id']      = '{listing_id}';
		$find['enquiry_name']    = '{enquiry_name}';
		$find['enquiry_email']   = '{enquiry_email}';
		$find['enquiry_phone']   = '{enquiry_phone}';
		$find['enquiry_message'] = '{enquiry_message}';
		return apply_filters( 'auto_listings_contact_form_find', $find );
	}

	protected function replacements( $listing_id, $enquiry_id ) {
		$replace                    = [];
		$replace['seller_name']     = get_the_author_meta( 'display_name', get_post_meta( $enquiry_id, '_al_enquiry_listing_seller', true ) );
		$replace['listing_title']   = get_the_title( $listing_id );
		$replace['listing_id']      = $listing_id;
		$replace['enquiry_name']    = get_post_meta( $enquiry_id, '_al_enquiry_name', true );
		$replace['enquiry_email']   = get_post_meta( $enquiry_id, '_al_enquiry_email', true );
		$replace['enquiry_phone']   = get_post_meta( $enquiry_id, '_al_enquiry_phone', true );
		$replace['enquiry_message'] = get_post_meta( $enquiry_id, '_al_enquiry_message', true );
		return apply_filters( 'auto_listings_contact_form_replace', $replace );
	}
}
