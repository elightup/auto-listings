<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;


add_action( 'widgets_init', 'auto_listings_register_sidebars' );

function auto_listings_register_sidebars() {
    register_sidebar( array(
        'name' 			=> __( 'Auto Listings', 'auto-listings' ),
        'id' 			=> 'auto-listings',
        'description' 	=> __( 'Widgets in this area will be shown on all listings pages.', 'theme-slug' ),
        'before_widget' => '<li id="%1$s" class="widget %2$s">',
    'after_widget'  => '</li>',
    'before_title'  => '<h2 class="widgettitle">',
    'after_title'   => '</h2>',
    ) );
}