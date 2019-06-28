<?php defined( 'ABSPATH' ) OR die( 'This script cannot be accessed directly.' );

/**
 * Theme Meta Boxes
 *
 * @filter us_config_meta-boxes
 */

$misc = us_config( 'elements_misc' );
 
// Get CPTs
$public_cpt = array_keys( us_get_public_cpt() );

// Get Page Blocks
$us_page_blocks_list = us_get_posts_titles_for( 'us_page_block' );

// Get Sidebars
$sidebars_list = us_get_sidebars();

return array(

	// Page Layout
	array(
		'id' => 'us_page_settings',
		'title' => __( 'Page Layout', 'us' ),
		'post_types' => array_merge(
			array( 'post', 'page', 'us_portfolio', 'product' ), // predefined types
			$public_cpt
		),
		'context' => 'side',
		'priority' => 'low',
		'fields' => array(
		
			// Header options
			'us_title_1' => array(
				'title' => _x( 'Header', 'site top area', 'us' ),
				'type' => 'heading',
			),
			'us_header' => array(
				'type' => 'select',
				'options' => array(
					'' => __( 'Default (from Theme Options)', 'us' ),
					'custom' => __( 'Custom on this page', 'us' ),
					'hide' => __( 'Remove on this page', 'us' ),
				),
				'std' => '',
			),
			'us_header_sticky_pos' => array(
				'title' => __( 'Sticky Header Initial Position', 'us' ),
				'type' => 'select',
				'options' => array(
					'' => __( 'At the Top of this page', 'us' ),
					'bottom' => __( 'At the Bottom of the first content row', 'us' ),
					'above' => __( 'Above the first content row', 'us' ),
					'below' => __( 'Below the first content row', 'us' ),
				),
				'std' => '',
				'show_if' => array( 'us_header', '=', 'custom' ),
			),

			// Titlebar options
			'us_title_2' => array(
				'title' => __( 'Title Bar', 'us' ),
				'type' => 'heading',
			),
			'us_titlebar' => array(
				'type' => 'select',
				'options' => array(
					'' => __( 'Default (from Theme Options)', 'us' ),
					'custom' => __( 'Custom on this page', 'us' ),
					'hide' => __( 'Remove on this page', 'us' ),
				),
				'std' => '',
			),
			'us_titlebar_id' => array(
				'description' => $misc['titlebars_description'],
				'type' => 'select',
				'options' => $us_page_blocks_list,
				'std' => 'default-titlebar',
				'show_if' => array( 'us_titlebar', '=', 'custom' ),
			),

			// Content options
			'us_title_3' => array(
				'title' => us_translate( 'Content' ),
				'type' => 'heading',
			),
			'us_content' => array(
				'type' => 'select',
				'options' => array(
					'' => __( 'Default (from Theme Options)', 'us' ),
					'custom' => __( 'Custom on this page', 'us' ),
				),
				'std' => '',
			),
			'us_content_id' => array(
				'description' => $misc['content_description'],
				'type' => 'select',
				'options' => $us_page_blocks_list,
				'std' => '',
				'show_if' => array( 'us_content', '=', 'custom' ),
			),

			// Sidebar options
			'us_title_4' => array(
				'title' => __( 'Sidebar', 'us' ),
				'type' => 'heading',
			),
			'us_sidebar' => array(
				'type' => 'select',
				'options' => array(
					'' => __( 'Default (from Theme Options)', 'us' ),
					'custom' => __( 'Custom on this page', 'us' ),
					'hide' => __( 'Remove on this page', 'us' ),
				),
				'std' => '',
			),
			'us_sidebar_id' => array(
				'description' => $misc['sidebars_description'],
				'type' => 'select',
				'options' => $sidebars_list,
				'std' => 'default_sidebar',
				'show_if' => array( 'us_sidebar', '=', 'custom' ),
			),
			'us_sidebar_pos' => array(
				'title' => __( 'Sidebar Position', 'us' ),
				'type' => 'radio',
				'options' => array(
					'left' => us_translate( 'Left' ),
					'right' => us_translate( 'Right' ),
				),
				'std' => 'right',
				'classes' => 'width_full',
				'show_if' => array( 'us_sidebar', '=', 'custom' ),
			),

			// Footer options
			'us_title_5' => array(
				'title' => __( 'Footer', 'us' ),
				'type' => 'heading',
			),
			'us_footer' => array(
				'type' => 'select',
				'options' => array(
					'' => __( 'Default (from Theme Options)', 'us' ),
					'custom' => __( 'Custom on this page', 'us' ),
					'hide' => __( 'Remove on this page', 'us' ),
				),
				'std' => '',
			),
			'us_footer_id' => array(
				'description' => $misc['footers_description'],
				'type' => 'select',
				'options' => $us_page_blocks_list,
				'std' => 'default-footer',
				'show_if' => array( 'us_footer', '=', 'custom' ),
			),
		),
	),

	// Custom appearance in Grid
	array(
		'id' => 'us_portfolio_settings',
		'title' => __( 'Custom appearance in Grid', 'us' ),
		'post_types' => array_merge(
			array( 'post', 'page', 'us_portfolio', 'product' ), // predefined types
			$public_cpt
		),
		'context' => 'normal',
		'priority' => 'high',
		'fields' => array(
			'us_tile_bg_color' => array(
				'title' => __( 'Background Color', 'us' ),
				'type' => 'color',
				'classes' => 'clear_right',
			),
			'us_tile_text_color' => array(
				'title' => __( 'Text Color', 'us' ),
				'type' => 'color',
				'classes' => 'clear_right',
			),
			'us_tile_size' => array(
				'title' => __( 'Custom Size', 'us' ),
				'type' => 'radio',
				'options' => array(
					'1x1' => '1x1',
					'2x1' => '2x1',
					'1x2' => '1x2',
					'2x2' => '2x2',
				),
				'std' => '1x1',
			),
			'us_tile_link' => array(
				'title' => __( 'Custom Link', 'us' ),
				'type' => 'link',
				'placeholder' => us_translate( 'Enter the URL' ),
				'std' => '',
			),
			'us_tile_additional_image' => array(
				'title' => __( 'Additional Image', 'us' ),
				'type' => 'upload',
				'extension' => 'png,jpg,jpeg,gif,svg',
			),
		),
	),

	// Testimonials settings
	array(
		'id' => 'us_testimonials_settings',
		'title' => __( 'More Options', 'us' ),
		'post_types' => array( 'us_testimonial' ),
		'context' => 'normal',
		'priority' => 'high',
		'fields' => array(
			'us_testimonial_author' => array(
				'title' => __( 'Author Name', 'us' ),
				'type' => 'text',
				'std' => 'John Doe',
			),
			'us_testimonial_role' => array(
				'title' => __( 'Author Role', 'us' ),
				'type' => 'text',
				'std' => '',
			),
			'us_testimonial_company' => array(
				'title' => __( 'Author Company', 'us' ),
				'type' => 'text',
				'std' => '',
			),
			'us_testimonial_link' => array(
				'title' => __( 'Author Link', 'us' ),
				'type' => 'link',
				'placeholder' => us_translate( 'Enter the URL' ),
				'std' => '',
			),
			'us_testimonial_rating' => array(
				'title' => __( 'Rating', 'us' ),
				'type' => 'radio',
				'options' => array(
					'none' => us_translate( 'None' ),
					'1' => '1',
					'2' => '2',
					'3' => '3',
					'4' => '4',
					'5' => '5',
				),
				'std' => 'none',
			),
		),
	),
);
