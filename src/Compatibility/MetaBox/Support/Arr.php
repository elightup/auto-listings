<?php
/**
 * Fallback helpers for Meta Box support utilities.
 *
 * @package AutoListings
 */

namespace MetaBox\Support;

defined( 'ABSPATH' ) || exit;

/**
 * Array helper methods used by Meta Box extensions.
 */
class Arr {
	/**
	 * Set a value within a multidimensional array using dot notation.
	 *
	 * @param array  $array Array to modify (passed by reference).
	 * @param string $key   Array key in dot notation.
	 * @param mixed  $value Value to set.
	 *
	 * @return array
	 */
	public static function set( &$array, $key, $value ) {
		if ( null === $key ) {
			$array[] = $value;
			return $array;
		}

		$keys       = is_array( $key ) ? array_values( $key ) : explode( '.', (string) $key );
		$current    =& $array;
		$last_index = count( $keys ) - 1;

		foreach ( $keys as $index => $segment ) {
			if ( '' === $segment ) {
				continue;
			}

			$is_last = $index === $last_index;

			if ( $is_last ) {
				$current[ $segment ] = $value;
				break;
			}

			if ( ! isset( $current[ $segment ] ) || ! is_array( $current[ $segment ] ) ) {
				$current[ $segment ] = [];
			}

			$current =& $current[ $segment ];
		}

		return $array;
	}

	/**
	 * Rename an array key if it exists.
	 *
	 * @param array  $array   Array to modify (passed by reference).
	 * @param string $old_key Existing key name.
	 * @param string $new_key New key name.
	 *
	 * @return void
	 */
	public static function change_key( &$array, $old_key, $new_key ) {
		if ( $old_key === $new_key ) {
			return;
		}

		if ( is_array( $array ) && array_key_exists( $old_key, $array ) ) {
			$array[ $new_key ] = $array[ $old_key ];
			unset( $array[ $old_key ] );
		}
	}

	/**
	 * Convert a comma separated string (or array) to an array of trimmed values.
	 *
	 * @param mixed $value Value to convert.
	 *
	 * @return array
	 */
	public static function from_csv( $value ) {
		if ( is_array( $value ) ) {
			$items = $value;
		} elseif ( is_string( $value ) ) {
			$items = explode( ',', $value );
		} else {
			return [];
		}

		$items = array_map( 'trim', $items );
		$items = array_filter( $items, static function ( $item ) {
			return '' !== $item;
		} );

		return array_values( $items );
	}

	/**
	 * Ensure the provided value is an array with the desired depth.
	 *
	 * @param mixed $value Original value.
	 * @param int   $depth Desired depth (minimum 1).
	 *
	 * @return array
	 */
	public static function to_depth( $value, $depth ) {
		$depth = max( 1, (int) $depth );

		if ( ! is_array( $value ) ) {
			return self::to_depth( [ $value ], $depth );
		}

		if ( 1 === $depth ) {
			return $value;
		}

		$result = [];

		foreach ( $value as $key => $item ) {
			$result[ $key ] = self::to_depth( $item, $depth - 1 );
		}

		return $result;
	}
}


