<?php
namespace eLightUp\PluginSearch;

defined( 'ABSPATH' ) || die;

if ( ! is_admin() ) {
	return;
}

new Recommend;
new Search;
