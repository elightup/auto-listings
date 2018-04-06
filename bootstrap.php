<?php

use AutoListings\Plugin;
use AutoListings\Installer;
use AutoListings\PostTypes;

include 'vendor/autoload.php';

$plugin = new Plugin( __DIR__ . '/auto-listings.php' );
$installer = new Installer();
$post_types = new PostTypes();
