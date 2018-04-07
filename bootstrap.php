<?php
include 'vendor/autoload.php';

use AutoListings\Plugin;
use AutoListings\Installer;
use AutoListings\PostTypes;
use AutoListings\PostStatuses;
use AutoListings\Shortcodes;
use AutoListings\Query;
use AutoListings\SearchForm;

$plugin        = new Plugin( __DIR__ . '/auto-listings.php' );
$installer     = new Installer();
$post_types    = new PostTypes();
$post_statuses = new PostStatuses();
$shortcodes    = new Shortcodes();
$query         = new Query();
$search_form   = new SearchForm();
