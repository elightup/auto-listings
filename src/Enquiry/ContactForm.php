<?php
/**
 * Add columns to Listings page.
 *
 * @package Auto Listings.
 */

namespace AutoListings\Enquiry;

/**
 * Class Contact Form
 */
class ContactForm {
	/**
	 * Add hooks when module is loaded.
	 */
	public function __construct() {
		add_shortcode( 'auto_listings_contact_form', [ $this, 'contact_form_shortcode' ] );
		add_action( 'rwmb_frontend_before_submit_button', [ $this, 'listing_fields' ] );
		add_filter( 'rwmb_frontend_insert_post_data', [ $this, 'post_data' ], 10, 2 );
		add_action( 'rwmb_frontend_after_save_post', [ $this, 'add_listing_data' ] );
		add_action( 'rwmb_frontend_after_save_post', [ $this, 'send_notification' ] );
		add_filter( 'rwmb_frontend_field_value_confirmation', [ $this, 'confirmation_message' ], 10, 2 );
	}

	/**
	 * Output the shortcode.
	 */
	public function contact_form_shortcode() {
		$submit_button      = __( 'Send Enquiry', 'auto-listings' );
		$recaptcha_site_key = auto_listings_option( 'captcha_site_key' );
		$recaptcha_secret   = auto_listings_option( 'captcha_secret_key' );
		$is_ajax            = auto_listings_option( 'contact_form_ajax' ) ? 'true' : 'false';
		$shortcode          = sprintf( '[mb_frontend_form id="auto_listings_contact_form" ajax="%s" submit_button="%s" recaptcha_key="%s" recaptcha_secret="%s"]', $is_ajax, $submit_button, $recaptcha_site_key, $recaptcha_secret );
		return do_shortcode( $shortcode );
	}

	/**
	 * Add hidden input before submit button.
	 *
	 * @param array $config frontend submission configuration.
	 */
	public function listing_fields( $config ) {
		if ( 'auto_listings_contact_form' !== $config['id'] ) {
			return;
		}
		echo '<input type="hidden" name="listing_id" value="' . get_the_ID() . '">';
	}

	/**
	 * Add data before create post.
	 *
	 * @param array $data post data.
	 * @param array $config frontend submission configuration.
	 */
	public function post_data( $data, $config ) {
		if ( 'auto_listings_contact_form' !== $config['id'] ) {
			return $data;
		}
		$listing_id          = filter_input( INPUT_POST, 'listing_id', FILTER_SANITIZE_NUMBER_INT );
		$listing_seller      = auto_listings_meta( 'seller', $listing_id );
		$data['post_author'] = $listing_seller;

		// Translators: % is listing id.
		$data['post_title'] = sprintf( __( 'Enquiry on listing #%s', 'auto-listings' ), $listing_id );
		return $data;
	}

	/**
	 * Add listing data after saving post.
	 *
	 * @param object $enquiry post object.
	 */
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

	/**
	 * Send notification after saving post.
	 *
	 * @param object $enquiry post object.
	 */
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
		$enquiries   = empty( $enquiries ) || ! is_array( $enquiries ) ? [] : $enquiries;
		$enquiries[] = $enquiry->post_id;
		update_post_meta( $listing_id, '_al_listing_enquiries', $enquiries );
	}

	/**
	 * Notification recipient.
	 *
	 * @param int $listing_id listing ID.
	 */
	protected function recipient( $listing_id ) {
		$seller_id    = auto_listings_meta( 'seller', $listing_id );
		$seller_email = get_the_author_meta( 'email', $seller_id ) ? get_the_author_meta( 'email', $seller_id ) : get_bloginfo( 'admin_email' );
		return apply_filters( 'auto_listings_contact_form_recipient', sanitize_email( $seller_email ), $listing_id );
	}

	/**
	 * Notification subject.
	 */
	protected function subject() {
		$subject = auto_listings_option( 'contact_form_subject' );
		if ( ! isset( $subject ) || empty( $subject ) ) {
			$subject = __( 'New enquiry on listing #{listing_id}', 'auto-listings' );
		}
		return apply_filters( 'auto_listings_contact_form_subject', $subject );
	}

	/**
	 * Notification message.
	 */
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

	/**
	 * Notification subject.
	 *
	 * @param string $enquiry_email enquiry email.
	 */
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

	/**
	 * Email from.
	 */
	protected function email_from() {
		$from_email = auto_listings_option( 'email_from' ) ? auto_listings_option( 'email_from' ) : get_bloginfo( 'admin_email' );
		$from_name  = auto_listings_option( 'email_from_name' ) ? auto_listings_option( 'email_from_name' ) : get_bloginfo( 'name' );
		return apply_filters( 'auto_listings_email_from', wp_specialchars_decode( esc_html( $from_name ), ENT_QUOTES ) . ' <' . sanitize_email( $from_email ) . '>' );
	}

	/**
	 * Email cc.
	 */
	protected function cc() {
		$return = auto_listings_option( 'contact_form_cc' );
		return apply_filters( 'auto_listings_contact_form_cc', $return );
	}

	/**
	 * Email bcc.
	 */
	protected function bcc() {
		$return = auto_listings_option( 'contact_form_bcc' );
		return apply_filters( 'auto_listings_contact_form_bcc', $return );
	}

	/**
	 * Email content type.
	 */
	protected function content_type() {
		$type = auto_listings_option( 'contact_form_email_type' );
		return 'html_email' === $type ? 'text/html' : 'text/plain';
	}

	/**
	 * Replace the placeholder with data.
	 *
	 * @param string $string placeholder.
	 * @param int    $listing_id Listing ID.
	 * @param int    $enquiry_id Enquiry ID.
	 */
	protected function replace_placeholders( $string, $listing_id, $enquiry_id ) {
		return str_replace( $this->placeholders(), $this->replacements( $listing_id, $enquiry_id ), $string );
	}

	/**
	 * Contact form placeholder.
	 */
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

	/**
	 * Enquiry Data.
	 *
	 * @param int $listing_id Listing ID.
	 * @param int $enquiry_id Enquiry ID.
	 */
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

	/**
	 * Confirmation Message
	 *
	 * @param int $message confimation message
	 */
	public function confirmation_message( $message, $args ) {
		if ( $args['id'] !== 'auto_listings_contact_form' ) {
			return $message;
		}
		$success_message = auto_listings_option( 'contact_form_success' );
		if ( empty( $success_message ) ) {
			return $message;
		}
		return $success_message;
	}
}
