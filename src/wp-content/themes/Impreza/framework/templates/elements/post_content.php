<?php defined( 'ABSPATH' ) OR die( 'This script cannot be accessed directly.' );

/**
 * Output Post Content element
 *
 * @var $type string Show: 'excerpt_only' / 'excerpt_content' / 'part_content' / 'full_content'
 * @var $length int Amount of words
 * @var $design_options array
 *
 * @var $classes string
 * @var $id string
 */

global $us_full_content_running;
if ( isset( $us_full_content_running ) AND $us_full_content_running AND $type == 'full_content' ) {
	return FALSE;
}
if ( $type == 'full_content' ) {
	$us_full_content_running = TRUE;
}

$classes = isset( $classes ) ? $classes : '';
if ( ! empty( $css ) AND function_exists( 'vc_shortcode_custom_css_class' ) ) {
	$classes .= ' ' . vc_shortcode_custom_css_class( $css );
}
$classes .= ( ! empty( $el_class ) ) ? ( ' ' . $el_class ) : '';
$el_id = ( ! empty( $el_id ) AND $us_elm_context == 'shortcode' ) ? ( ' id="' . esc_attr( $el_id ) . '"' ) : '';

// Prepare inline CSS for shortcode
$inline_css = '';
if ( $us_elm_context == 'shortcode' ) {
	$inline_css .= us_prepare_inline_css(
		array(
			'font-family' => $font,
			'font-weight' => $font_weight,
			'text-transform' => $text_transform,
			'font-style' => $font_style,
			'font-size' => $font_size,
			'line-height' => $line_height,
		)
	);
}

// Post excerpt is not empty
if ( in_array( $type, array( 'excerpt_content', 'excerpt_only' ) ) AND has_excerpt() ) {
	$the_content = get_the_excerpt();

	// Either the excerpt is empty and we show the content instead or we show the content only
} elseif ( in_array( $type, array( 'excerpt_content', 'part_content', 'full_content' ) ) ) {
	if ( get_post_type() == 'attachment' ) {
		$the_content = get_the_content();
	} else {
		$the_content = get_the_content();

		// Remove video, audio, gallery from the content for relevant post formats
		us_get_post_preview( $the_content, TRUE );

		$the_content = apply_filters( 'the_content', $the_content );

		// Limit the amount of words for the corresponding types
		if ( in_array( $type, array( 'excerpt_content', 'part_content' ) ) AND intval( $length ) > 0 ) {
			$the_content = wp_trim_words( $the_content, intval( $length ) );
		}
	}

	// Post excerpt is empty and we show nothing in this case
} else {
	$the_content = '';
}

// Don't output the content for "Link" post format
if ( get_post_format() == 'link' OR $the_content == '' ) {
	return FALSE;
}

// Schema.org markup
$schema_markup = '';
if ( us_get_option( 'schema_markup' ) AND $us_elm_context == 'shortcode' ) {
	$schema_markup = ' itemprop="text"';
}

// Output the element
$output = '<div class="w-post-elm post_content' . $classes . '"' . $inline_css . $el_id . $schema_markup . '>';
$output .= $the_content;
$output .= '</div>';

echo $output;

$us_full_content_running = FALSE;
