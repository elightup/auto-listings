<?php
include 'vendor/autoload.php';

use AutoListings\Plugin;
use AutoListings\Installer;
use AutoListings\Upgrade\Version200;
use AutoListings\Shortcodes;
use AutoListings\Query;
use AutoListings\SearchForm;
use AutoListings\SearchQuery;
use AutoListings\Listing\PostType as ListingPostType;
use AutoListings\Listing\PostStatuses;
use AutoListings\Listing\Fields as ListingFields;
use AutoListings\Listing\AdminColumns as ListingColumns;
use AutoListings\Enquiry\PostType as EnquiryPostType;
use AutoListings\Enquiry\Fields as EnquiryFields;
use AutoListings\Enquiry\AdminColumns as EnquiryColumns;
use AutoListings\Enquiry\ContactForm;
use AutoListings\Admin\Main as AdminMain;
use AutoListings\Admin\Assets as AdminAssets;
use AutoListings\Admin\SellerColumns;
use AutoListings\Admin\Settings;
use AutoListings\Frontend\Main as FrontendMain;
use AutoListings\Frontend\TemplateLoader;
use AutoListings\Frontend\Assets as FrontendAssets;

require 'src/functions.php';
require 'src/functions-conditionals.php';
require 'src/functions-enquiry.php';
require 'src/functions-formatting.php';
require 'src/functions-general.php';
require 'src/functions-listing.php';
require 'src/functions-sidebars.php';
require 'src/updater/class-auto-listings-license.php';

$al_plugin     = new Plugin( __DIR__ . '/auto-listings.php' );
$al_installer  = new Installer();
$al_version200 = new Version200();

$al_listing_post_type = new ListingPostType();
$al_post_statuses     = new PostStatuses();
$al_listing_fields    = new ListingFields();

$al_enquiry_post_type = new EnquiryPostType();
$al_enquiry_fields    = new EnquiryFields();
$al_contact_form      = new ContactForm();

$al_shortcodes   = new Shortcodes();
$al_query        = new Query();
$al_search_form  = new SearchForm();
$al_search_query = new SearchQuery();

if ( is_admin() ) {
	$al_admin           = new AdminMain();
	$al_admin_assets    = new AdminAssets();
	$al_listing_columns = new ListingColumns();
	$al_enquiry_columns = new EnquiryColumns();
	$al_seller_columns  = new SellerColumns();
	$al_settings        = new Settings();
}
if ( ( ! is_admin() || wp_doing_ajax() ) && ! wp_doing_cron() ) {
	$al_frontend        = new FrontendMain();
	$al_template_loader = new TemplateLoader();
	$al_frontend_assets = new FrontendAssets();

	require 'src/Frontend/template-hooks.php';
	require 'src/Frontend/template-tags.php';
}
