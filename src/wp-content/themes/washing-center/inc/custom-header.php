<?php
/**
 * Custom header implementation
 */

function washing_center_custom_header_setup() {

	add_theme_support( 'custom-header', apply_filters( 'washing_center_custom_header_args', array(

		'default-text-color'     => 'fff',
		'header-text' 			 =>	false,
		'width'                  => 1600,
		'height'                 => 400,
		'wp-head-callback'       => 'washing_center_header_style',
	) ) );
}

add_action( 'after_setup_theme', 'washing_center_custom_header_setup' );

if ( ! function_exists( 'washing_center_header_style' ) ) :
/**
 * Styles the header image and text displayed on the blog
 *
 * @see washing_center_custom_header_setup().
 */
add_action( 'wp_enqueue_scripts', 'washing_center_header_style' );
function washing_center_header_style() {
	//Check if user has defined any header image.
	if ( get_header_image() ) :
	$custom_css = "
        .header-box {
			background-image:url('".esc_url(get_header_image())."');
			background-position: center top;
		}";
	   	wp_add_inline_style( 'washing-center-basic-style', $custom_css );
	endif;
}
endif; // washing_center_header_style