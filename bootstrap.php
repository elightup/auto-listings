<?php
namespace AutoListings;

new Plugin( __DIR__ . '/auto-listings.php' );

new Listing\PostType;
new Listing\PostStatuses;
new Listing\Fields;

new Enquiry\PostType;
new Enquiry\Fields;
new Enquiry\ContactForm;

new SearchForm\PostType;
new SearchForm\Ajax;

new Shortcodes;
new Query;
new SearchForm;
new SearchQuery;
new Upgrade\Manager;

if ( is_admin() ) {
	new Admin\Main;
	new Admin\Assets;
	new Admin\SellerColumns;
	new Admin\Settings;

	new Listing\AdminColumns;
	new Enquiry\AdminColumns;

	new SearchForm\AdminColumns;
    new SearchForm\Editor;
}
if ( ( ! is_admin() || wp_doing_ajax() ) && ! wp_doing_cron() ) {
	new Frontend\Main;
	new Frontend\TemplateLoader;
	new Frontend\Assets;

	new SearchForm\Shortcode\Form;
    $control = new SearchForm\Shortcode\Control;
    new SearchForm\Shortcode\Field( $control );
    new SearchForm\Shortcode\Extras;
    new SearchForm\Shortcode\Button;
}
