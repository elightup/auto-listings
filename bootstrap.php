<?php
namespace AutoListings;

new Plugin( __DIR__ . '/auto-listings.php' );

new Listing\PostType;
new Listing\PostStatuses;
new Listing\Fields;

new Enquiry\PostType;
new Enquiry\Fields;
new Enquiry\ContactForm;

new Shortcodes;
new Query;
new SearchForm;
new SearchQuery;
new Upgrade\Manager;

if ( is_admin() ) {
	new Admin\Main;
	new Admin\Assets;
	new Listing\AdminColumns;
	new Enquiry\AdminColumns;
	new Admin\SellerColumns;
	new Admin\Settings;

	// Update.
	$update_option  = new Update\Option();
	$update_checker = new Update\Checker( $update_option );
	$update_checker->init();
	$update_settings = new Update\Settings( $update_checker, $update_option );
	$update_settings->init();
	$update_notification = new Update\Notification( $update_checker, $update_option );
	$update_notification->init();
}
if ( ( ! is_admin() || wp_doing_ajax() ) && ! wp_doing_cron() ) {
	new Frontend\Main;
	new Frontend\TemplateLoader;
	new Frontend\TemplatePathLoader;
	new Frontend\Assets;
}
