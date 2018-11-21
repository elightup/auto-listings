<?php
/**
 * Content wrappers
 *
 * This template can be overridden by copying it to yourtheme/listings/global/wrapper-start.php.
 *
 * @package Auto Listings.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( auto_listings_option( 'opening_html' ) ) {

	echo wp_kses_post( auto_listings_option( 'opening_html' ) );

} else {

	switch ( auto_listings_get_theme() ) {
		case 'genesis':
			echo '<div id="primary"><div id="content" role="main">';
			break;
		case 'divi':
			echo '<div id="main-content"><div class="container"><div id="content-area" class="clearfix"><div id="left-area">';
			break;
		case 'twentyeleven':
			echo '<div id="primary"><div id="content" role="main" class="twentyeleven">';
			break;
		case 'twentytwelve':
			echo '<div id="primary" class="site-content"><div id="content" role="main" class="twentytwelve">';
			break;
		case 'twentythirteen':
			echo '<div id="primary" class="site-content"><div id="content" role="main" class="entry-content twentythirteen">';
			break;
		case 'twentyfourteen':
			echo '<div id="primary" class="content-area"><div id="content" role="main" class="site-content twentyfourteen"><div class="tfwc">';
			break;
		case 'twentyfifteen':
			echo '<div id="primary" role="main" class="content-area twentyfifteen"><div id="main" class="site-main t15wc">';
			break;
		case 'twentysixteen':
			echo '<div id="primary" class="content-area twentysixteen"><main id="main" class="site-main" role="main">';
			break;
		case 'twentyseventeen':
			echo '<div class="wrap"><div id="primary" class="content-area"><main id="main" class="site-main" role="main">';
			break;
		default:
			echo apply_filters( 'auto_listings_wrapper_start', '<div id="container" class="container"><div id="content" class="content" role="main">' ); // wpcs xss: ok.
			break;
	}
}
