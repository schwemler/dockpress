<?php
/**
 * Jetpack Compatibility File
 * See: http://jetpack.me/
 *
 * @package Car Fix Lite
 */

/**
 * Add theme support for Infinite Scroll.
 * See: http://jetpack.me/support/infinite-scroll/
 */
function car_fix_lite_jetpack_setup() {
	add_theme_support( 'infinite-scroll', array(
		'container' => 'main',
		'footer'    => 'page',
	) );
}
add_action( 'after_setup_theme', 'car_fix_lite_jetpack_setup' );
