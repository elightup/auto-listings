<?php
/**
 * Template Loader.
 *
 * @package Auto Listings.
 */

namespace AutoListings\Frontend;

/**
 * Template Loader Class
 */
class TemplatePathLoader extends \Gamajo_Template_Loader {
	/**
	 * Prefix for filter names.
	 *
	 * @var string
	 */
	protected $filter_prefix = 'auto_listings';

	/**
	 * Directory name where custom templates for this plugin should be found in the theme.
	 *
	 * @var string
	 */
	protected $theme_template_directory = 'listings';

	/**
	 * Reference to the root directory path of this plugin.
	 * Can either be a defined constant, or a relative reference from where the subclass lives.
	 *
	 * @var string
	 */
	protected $plugin_directory = AUTO_LISTINGS_DIR;
}