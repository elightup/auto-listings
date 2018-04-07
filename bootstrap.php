<?php
include 'vendor/autoload.php';

use AutoListings\Plugin;
use AutoListings\Installer;
use AutoListings\PostTypes;
use AutoListings\PostStatuses;
use AutoListings\Shortcodes;
use AutoListings\Query;
use AutoListings\SearchForm;
use AutoListings\SearchQuery;
use AutoListings\Frontend\Main;
use AutoListings\Frontend\TemplateLoader;
use AutoListings\Frontend\Assets;

$plugin        = new Plugin( __DIR__ . '/auto-listings.php' );
$installer     = new Installer();
$post_types    = new PostTypes();
$post_statuses = new PostStatuses();
$shortcodes    = new Shortcodes();
$query         = new Query();
$search_form   = new SearchForm();
$search_query  = new SearchQuery();

require 'src/functions-conditionals.php';
require 'src/functions-enquiry.php';
require 'src/functions-formatting.php';
require 'src/functions-general.php';
require 'src/functions-listing.php';
require 'src/functions-sidebars.php';

if ( is_admin() ) {

}
if ( ( ! is_admin() || wp_doing_ajax() ) && ! wp_doing_cron() ) {
	$main = new Main();
	$template_loader = new TemplateLoader();
	$assets = new Assets();

	require 'src/Frontend/template-hooks.php';
	require 'src/Frontend/template-tags.php';
}
