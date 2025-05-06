<?php
/**
 * Plugin Name: MB Columns
 * Plugin URI:  https://metabox.io/plugins/meta-box-columns/
 * Description: Display fields more beautiful by putting them into 12-columns grid.
 * Version:     1.2.16
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

// Prevent loading this file directly.
if ( ! defined( 'ABSPATH' ) ) {
	return;
}

if ( ! function_exists( 'mb_columns_add_markup' ) ) {
	if ( file_exists( __DIR__ . '/vendor' ) ) {
		require __DIR__ . '/vendor/autoload.php';
	}

	add_filter( 'rwmb_meta_box_settings', 'mb_columns_add_markup' );

	/**
	 * Modify meta box settings to add column markup.
	 *
	 * @param array $meta_box Meta Box settings.
	 *
	 * @return array
	 */
	function mb_columns_add_markup( $meta_box ) {
		$processor = new MetaBox\Columns\Processor( $meta_box );
		$processor->process();
		return $processor->get_meta_box();
	}

	add_action( 'rwmb_enqueue_scripts', 'mb_columns_enqueue' );

	function mb_columns_enqueue() {
		list( , $url ) = RWMB_Loader::get_path( __DIR__ );
		wp_enqueue_style( 'rwmb-columns', $url . 'columns.css', [], '1.2.16' );
	}
}
