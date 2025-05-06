<?php
/**
 * Plugin Name: MB Geolocation
 * Plugin URI:  https://metabox.io/plugins/meta-box-geolocation/
 * Description: Auto fill location data with details from Google Maps / Open Street Map
 * Version:     1.3.6
 * Author:      MetaBox.io
 * Author URI:  https://metabox.io
 * License:     GPL2+
 *
 * Copyright (C) 2010-2025 Tran Ngoc Tuan Anh. All rights reserved.
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <http://www.gnu.org/licenses/>.
 */

// Prevent loading this file directly
if ( ! defined( 'ABSPATH' ) ) {
	return;
}

if ( ! function_exists( 'meta_box_geolocation_load' ) ) {
	/**
	 * Hook to 'init' with priority 5 to make sure all actions are registered before Meta Box 4.9.0 runs
	 */
	add_action( 'init', 'meta_box_geolocation_load', 5 );

	/**
	 * Load plugin files after Meta Box is loaded
	 */
	function meta_box_geolocation_load() {
		if ( ! defined( 'RWMB_VER' ) ) {
			return;
		}

		require 'geolocation.php';
		new MB_Geolocation();
	}
}
