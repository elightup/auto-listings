<?php
namespace AutoListings;

include __DIR__ . '/vendor/autoload.php';

new Plugin( __DIR__ . '/auto-listings.php' );
new Installer;

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
}
if ( ( ! is_admin() || wp_doing_ajax() ) && ! wp_doing_cron() ) {
	new Frontend\Main;
	new Frontend\TemplateLoader;
	new Frontend\Assets;
}
