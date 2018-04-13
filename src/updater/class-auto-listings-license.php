<?php
/**
 * License handler for Easy Digital Downloads
 *
 * This class should simplify the process of adding license information
 * to new EDD extensions.
 *
 * @version 1.1
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists( 'Auto_Listings_License_Handler' ) ) :

/**
 * EDD_License Class
 */
class Auto_Listings_License_Handler {
	private $file;
	private $license;
	private $item_name;
	private $item_shortname;
	private $version;
	private $author;
	private $api_url = 'http://wpautolistings.com';

	private $api_data = array();

	protected $key_name       = '';
	protected $status_name    = '';
	protected $license_key    = '';
	protected $license_status = '';
	/**
	 * Class constructor
	 *
	 * @global  array $edd_options
	 * @param string  $_file
	 * @param string  $_item_name
	 * @param string  $_version
	 * @param string  $_author
	 * @param string  $_optname
	 * @param string  $_api_url
	 */
	function __construct( $_file, $_item_name, $_version, $_author, $_optname = null, $_api_url = null ) {

		$this->file           = $_file;
		$this->item_name      = $_item_name;
		$this->item_shortname = 'auto_listings_' . preg_replace( '/[^a-zA-Z0-9_\s]/', '', str_replace( ' ', '_', strtolower( $this->item_name ) ) );
		$this->version        = $_version;
		$this->license        = null !== auto_listings_option( $this->item_shortname ) ? trim( auto_listings_option( $this->item_shortname ) ) : '';
		$this->author         = $_author;
		$this->api_url        = is_null( $_api_url ) ? $this->api_url : $_api_url;

		$status = get_option( $this->item_shortname . '_license_active' );
		$this->license_status = isset( $status ) ? trim( $status ) : '';

		// Setup hooks
		$this->includes();
		$this->hooks();
		$this->auto_updater();
		$this->reload();

	}

	/**
	 * Include the updater class
	 *
	 * @access  private
	 * @return  void
	 */
	public function reload() {
		if ( isset( $_POST['submit-cmb'] ) ) { 
			wp_redirect($_SERVER['HTTP_REFERER']);
		}
	}

	/**
	 * Include the updater class
	 *
	 * @access  private
	 * @return  void
	 */
	private function includes() {
		if ( ! class_exists( 'Auto_Listings_Extension_Updater' ) ) require_once 'class-auto-listings-updater.php';
	}

	/**
	 * Setup hooks
	 *
	 * @access  private
	 * @return  void
	 */
	private function hooks() {

		// Register settings
		//add_filter( 'al_extensions_licenses', array( $this, 'settings' ), 1 );
		add_filter( 'auto_listings_admin_options', array( $this, 'license_field' ), 10, 2 );

		// Activate license key on settings save
		if ( isset( $_POST[ $this->item_shortname . '_license_activate'] ) ) {
			add_action( 'admin_init', array( $this, 'activate_license' ) );
		}

		// Deactivate license key
		if ( isset( $_POST[ $this->item_shortname . '_license_deactivate'] ) ) {
			add_action( 'admin_init', array( $this, 'deactivate_license' ) );
		}
	}

	/**
	 * Auto updater
	 *
	 * @access  private
	 * @global  array $edd_options
	 * @return  void
	 */
	private function auto_updater() {
		// Setup the updater
		$edd_updater = new Auto_Listings_Extension_Updater(
			$this->api_url,
			$this->file,
			array(
				'version'   => $this->version,
				'license'   => $this->license,
				'item_name' => $this->item_name,
				'author'    => $this->author
			)
		);
	}


	/**
	 * Activate the license key
	 *
	 * @access  public
	 * @return  void
	 */
	public function activate_license() {
		
		// run a quick security check
		if ( ! check_admin_referer( 'al_license_nonce', 'al_license_nonce_' . $this->item_shortname ) ) {
			return; // get out if we didn't click the Activate button
		}

		if ( ! isset( $_POST[$this->item_shortname] ) )
			return;

		// if ( 'valid' == get_option( $this->item_shortname . '_license_active' ) )
		// 	return;

		$license = sanitize_text_field( $_POST[$this->item_shortname] );

		// Data to send to the API
		$api_params = array(
			'edd_action' => 'activate_license',
			'license'    => $license,
			'item_name'  => urlencode( $this->item_name )
		);

		// Call the API
		$response = wp_remote_get(
			esc_url_raw( add_query_arg( $api_params, $this->api_url ) ),
			array(
				'timeout'   => 15,
				'body'      => $api_params,
				'sslverify' => false
			)
		);

		// Make sure there are no errors
		if ( is_wp_error( $response ) )
			return;

		// Decode license data
		$license_data = json_decode( wp_remote_retrieve_body( $response ) );
		// pp( $license_data );
		// die;
		//update_option( $this->item_shortname . '_license_data', $license_data );
		update_option( $this->item_shortname . '_license_active', $license_data->license );

		wp_redirect($_SERVER['HTTP_REFERER']);

	}


	/**
	 * Deactivate the license key
	 *
	 * @access  public
	 * @return  void
	 */
	public function deactivate_license() {
		
		// run a quick security check
		if ( ! check_admin_referer( 'al_license_nonce', 'al_license_nonce_' . $this->item_shortname ) ) {
			return; // get out if we didn't click the Activate button
		}

		if ( ! isset( $_POST[$this->item_shortname] ) ){
			return;
		}

		// Run on deactivate button press
		if ( isset( $_POST[ $this->item_shortname . '_license_deactivate' ] ) ) {
			
			// Data to send to the API
			$api_params = array(
				'edd_action' => 'deactivate_license',
				'license'    => $this->license,
				'item_name'  => urlencode( $this->item_name )
			);

			// Call the API
			$response = wp_remote_get(
				esc_url_raw( add_query_arg( $api_params, $this->api_url ) ),
				array(
					'timeout'   => 15,
					'sslverify' => false
				)
			);
			
			// Make sure there are no errors
			if ( is_wp_error( $response ) ){
				return;
			}

			// Decode the license data
			$license_data = json_decode( wp_remote_retrieve_body( $response ) );

			if ( $license_data->license == 'deactivated' || $license_data->license == 'failed' ){
				delete_option( $this->item_shortname . '_license_active' );
			}

			wp_redirect($_SERVER['HTTP_REFERER']);
		}

	}

	public function license_field( $options, $cmb ) {

		$ext_key = 0;
        foreach ( $options['tabs'] as $key => $value ) {
            if( $value['id'] == 'extensions' ) {
                $ext_key = $key;
            }
        }

        $options['tabs'][$ext_key]['boxes'][] = $this->item_shortname;

        // license
        $cmb = new_cmb2_box( array(
            'id'        => $this->item_shortname,
            'title'     => sprintf( __( '%1$s Extension', 'edd' ), $this->item_name ),
            'show_on'   => array( 'key' => 'options-page', 'value' => array( 'auto_listings_options' ) )
        ));
        $cmb->add_field( array(
            'name'        => sprintf( __( '%1$s License Key', 'edd' ), $this->item_name ),
			'desc'        => __( '1. Enter the License Key for this extension<br />2. Click the blue "Save These Options" button on the right<br />3. Click the "Activate License" button that will appear below', 'auto-listings' ),
			'id'          => $this->item_shortname,
			'type'        => 'text',
			'after_field' => array( $this, 'after_field' ),
        ));

        $cmb->object_type( 'options-page' );
        $options['boxes'][] = $cmb;    

        return $options;

	}

	public function after_field( $args, $field ) {

		// make sure the license is saved before displaying the activate button
		if ( ! $this->license )
			return;

		$status = '';
		if ( $this->license_status ) {
			$status = 'valid' === $this->license_status ? 'active' : $this->license_status;
			$status = '<span class="updated notice notice-success license-status license-'. $status .'">' . sprintf( esc_html__( 'License: %s', 'auto-listings' ), $status ) . '</span>';
		}

		$nonce = wp_nonce_field( 'al_license_nonce', 'al_license_nonce_' . $this->item_shortname, false, false );

		$id = $this->item_shortname . ( 'valid' === $this->license_status ? '_license_deactivate' : '_license_activate' );

		$label = 'valid' === $this->license_status
			? esc_html__( 'Deactivate License', 'auto-listings' )
			: esc_html__( 'Activate License', 'auto-listings' );

		printf(
			'<p>%1$s%2$s<input type="submit" class="button-secondary" name="%3$s" value="%4$s"/></p>',
			$status,
			$nonce,
			$id,
			$label
		);

	}

}

endif; // end class_exists check



// function edd_sample_theme_check_license() {
// 	$store_url = 'http://auto-listings.com';
// 	// $item_name = 'Frontend Edit';
// 	// $license = '401ed5db3aa899798b9e27831c2fda5d';
// 	$item_name = 'Project Timeline';
// 	$license = '1973db178fd094905499a021b68765b1';
// 	$api_params = array(
// 		'edd_action' => 'check_license',
// 		'license' => $license,
// 		'item_name' => urlencode( $item_name ),
// 		'url' => home_url()
// 	);
// 	$response = wp_remote_post( $store_url, array( 'body' => $api_params, 'timeout' => 15, 'sslverify' => false ) );
//   	if ( is_wp_error( $response ) ) {
// 		return false;
//   	}

// 	$license_data = json_decode( wp_remote_retrieve_body( $response ) );
// 	pp($license_data);
// 	if( $license_data->license == 'valid' ) {
// 		echo 'valid';
// 		exit;
// 		// this license is still valid
// 	} else {
// 		echo 'invalid';
// 		exit;
// 		// this license is no longer valid
// 	}
// }
// edd_sample_theme_check_license();