<?php defined( 'ABSPATH' ) OR die( 'This script cannot be accessed directly.' );

/**
 * Shortcode: vc_row_inner
 *
 * Overloaded by UpSolution custom implementation.
 *
 * Dev note: if you want to change some of the default values or acceptable attributes, overload the shortcodes config.
 *
 * @var $shortcode         string Current shortcode name
 * @var $shortcode_base    string The original called shortcode name (differs if called an alias)
 * @var $content           string Shortcode's inner content
 *
 * @var $content_placement string Columns Content Position: 'top' / 'middle' / 'bottom'
 * @var $columns_type      string Columns type: 'default' / 'boxes'
 * @var $gap               string gap class for columns
 * @var $el_id             string
 * @var $el_class          string
 * @var $disable_element   string
 * @var $css               string
 */

$atts = us_shortcode_atts( $atts, $shortcode_base );

if ( $disable_element === 'yes' ) {
	if ( function_exists( 'vc_is_page_editable' ) AND vc_is_page_editable() ) {
		$classes .= ' vc_hidden-lg vc_hidden-xs vc_hidden-sm vc_hidden-md';
	} else {
		return '';
	}
}

$class_name = 'type_' . $columns_type;

if ( ! empty( $content_placement ) ) {
	$class_name .= ' valign_' . $content_placement;
}
if ( ! empty( $gap ) ) {
	$class_name .= ' vc_column-gap-' . $gap;
}

// Preserving additional class for inner VC rows
if ( $shortcode_base == 'vc_row_inner' ) {
	$class_name .= ' vc_inner';
}

// Additional class set by a user in a shortcode attributes
if ( ! empty( $el_class ) ) {
	$class_name .= ' ' . $el_class;
}

if ( function_exists( 'vc_shortcode_custom_css_class' ) ) {
	$class_name .= ' ' . vc_shortcode_custom_css_class( $css, ' ' );
}
$class_name = apply_filters( 'vc_shortcodes_css_class', $class_name, $shortcode_base, $atts );

$row_id_param = '';

$output = '<div class="g-cols wpb_row ' . $class_name . '"';
if ( ! empty( $el_id ) ) {
	$output .= ' id="' . $el_id . '"';
}
$output .= '>';
$output .= do_shortcode( $content );
$output .= '</div>';

echo $output;
