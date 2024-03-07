<?php
namespace eLightUp\PluginSearch;

if ( defined( 'ABSPATH' ) ) {
	if ( ! is_admin() ) {
		return;
	}

	new Recommend;
	new Search;
}
