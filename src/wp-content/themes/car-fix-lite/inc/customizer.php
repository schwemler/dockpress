<?php    
/**
 *Car Fix Lite Theme Customizer
 *
 * @package Car Fix Lite
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function car_fix_lite_customize_register( $wp_customize ) {	
	
	function car_fix_lite_sanitize_dropdown_pages( $page_id, $setting ) {
	  // Ensure $input is an absolute integer.
	  $page_id = absint( $page_id );
	
	  // If $page_id is an ID of a published page, return it; otherwise, return the default.
	  return ( 'publish' == get_post_status( $page_id ) ? $page_id : $setting->default );
	}

	function car_fix_lite_sanitize_checkbox( $checked ) {
		// Boolean check.
		return ( ( isset( $checked ) && true == $checked ) ? true : false );
	}  
		
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	
	 //Panel for section & control
	$wp_customize->add_panel( 'car_fix_lite_panel_area', array(
		'priority' => null,
		'capability' => 'edit_theme_options',
		'theme_supports' => '',
		'title' => __( 'Theme Options Panel', 'car-fix-lite' ),		
	) );
	
	//Layout Options
	$wp_customize->add_section('car_fix_lite_layout_option',array(
		'title' => __('Site Layout','car-fix-lite'),			
		'priority' => 1,
		'panel' => 	'car_fix_lite_panel_area',          
	));		
	
	$wp_customize->add_setting('car_fix_lite_boxlayout',array(
		'sanitize_callback' => 'car_fix_lite_sanitize_checkbox',
	));	 

	$wp_customize->add_control( 'car_fix_lite_boxlayout', array(
    	'section'   => 'car_fix_lite_layout_option',    	 
		'label' => __('Check to Box Layout','car-fix-lite'),
		'description' => __('If you want to box layout please check the Box Layout Option.','car-fix-lite'),
    	'type'      => 'checkbox'
     )); //Layout Section 
	
	$wp_customize->add_setting('car_fix_lite_color_scheme',array(
		'default' => '#feca00',
		'sanitize_callback' => 'sanitize_hex_color'
	));
	
	$wp_customize->add_control(
		new WP_Customize_Color_Control($wp_customize,'car_fix_lite_color_scheme',array(
			'label' => __('Color Scheme','car-fix-lite'),			
			'description' => __('More color options in PRO Version','car-fix-lite'),
			'section' => 'colors',
			'settings' => 'car_fix_lite_color_scheme'
		))
	);	
	
	
	//Header Contact info
	$wp_customize->add_section('car_fix_lite_top_contactinfo_panel',array(
		'title' => __('Header Contact info','car-fix-lite'),				
		'priority' => null,
		'panel' => 	'car_fix_lite_panel_area',
	));	
	
	
	$wp_customize->add_setting('car_fix_lite_top_contact_emailid',array(
		'sanitize_callback' => 'sanitize_email'
	));
	
	$wp_customize->add_control('car_fix_lite_top_contact_emailid',array(
		'type' => 'text',
		'label' => __('Add email address here.','car-fix-lite'),
		'section' => 'car_fix_lite_top_contactinfo_panel'
	));	
	
		
	$wp_customize->add_setting('car_fix_lite_top_telphone_no',array(
		'default' => null,
		'sanitize_callback' => 'sanitize_text_field'	
	));
	
	$wp_customize->add_control('car_fix_lite_top_telphone_no',array(	
		'type' => 'text',
		'label' => __('Add phone number here','car-fix-lite'),
		'section' => 'car_fix_lite_top_contactinfo_panel',
		'setting' => 'car_fix_lite_top_telphone_no'
	));	
	
	$wp_customize->add_setting('car_fix_lite_show_top_contactinfo_section',array(
		'default' => false,
		'sanitize_callback' => 'car_fix_lite_sanitize_checkbox',
		'capability' => 'edit_theme_options',
	));	 
	
	$wp_customize->add_control( 'car_fix_lite_show_top_contactinfo_section', array(
	   'settings' => 'car_fix_lite_show_top_contactinfo_section',
	   'section'   => 'car_fix_lite_top_contactinfo_panel',
	   'label'     => __('Check To show This Section','car-fix-lite'),
	   'type'      => 'checkbox'
	 ));//Show Header Contact Info
	
	 
	 //Header Social icons
	$wp_customize->add_section('car_fix_lite_topsocial_panel',array(
		'title' => __('Header social icons','car-fix-lite'),
		'description' => __( 'Add social icons link here to display icons in header.', 'car-fix-lite' ),			
		'priority' => null,
		'panel' => 	'car_fix_lite_panel_area', 
	));
	
	$wp_customize->add_setting('car_fix_lite_fb_link',array(
		'default' => null,
		'sanitize_callback' => 'esc_url_raw'	
	));
	
	$wp_customize->add_control('car_fix_lite_fb_link',array(
		'label' => __('Add facebook link here','car-fix-lite'),
		'section' => 'car_fix_lite_topsocial_panel',
		'setting' => 'car_fix_lite_fb_link'
	));	
	
	$wp_customize->add_setting('car_fix_lite_twitt_link',array(
		'default' => null,
		'sanitize_callback' => 'esc_url_raw'
	));
	
	$wp_customize->add_control('car_fix_lite_twitt_link',array(
		'label' => __('Add twitter link here','car-fix-lite'),
		'section' => 'car_fix_lite_topsocial_panel',
		'setting' => 'car_fix_lite_twitt_link'
	));
	
	$wp_customize->add_setting('car_fix_lite_gplus_link',array(
		'default' => null,
		'sanitize_callback' => 'esc_url_raw'
	));
	
	$wp_customize->add_control('car_fix_lite_gplus_link',array(
		'label' => __('Add google plus link here','car-fix-lite'),
		'section' => 'car_fix_lite_topsocial_panel',
		'setting' => 'car_fix_lite_gplus_link'
	));
	
	$wp_customize->add_setting('car_fix_lite_linked_link',array(
		'default' => null,
		'sanitize_callback' => 'esc_url_raw'
	));
	
	$wp_customize->add_control('car_fix_lite_linked_link',array(
		'label' => __('Add linkedin link here','car-fix-lite'),
		'section' => 'car_fix_lite_topsocial_panel',
		'setting' => 'car_fix_lite_linked_link'
	));
	
	$wp_customize->add_setting('car_fix_lite_show_socialsection',array(
		'default' => false,
		'sanitize_callback' => 'car_fix_lite_sanitize_checkbox',
		'capability' => 'edit_theme_options',
	));	 
	
	$wp_customize->add_control( 'car_fix_lite_show_socialsection', array(
	   'settings' => 'car_fix_lite_show_socialsection',
	   'section'   => 'car_fix_lite_topsocial_panel',
	   'label'     => __('Check To show This Section','car-fix-lite'),
	   'type'      => 'checkbox'
	 ));//Show Header Social icons Section 			
	
	// Slider Section		
	$wp_customize->add_section( 'car_fix_lite_header_slide_section', array(
		'title' => __('Slider Section', 'car-fix-lite'),
		'priority' => null,
		'description' => __('Default image size for slider is 1400 x 786 pixel.','car-fix-lite'), 
		'panel' => 	'car_fix_lite_panel_area',           			
    ));
	
	$wp_customize->add_setting('car_fix_lite_top_slider_pageno1',array(
		'default' => '0',			
		'capability' => 'edit_theme_options',
		'sanitize_callback' => 'car_fix_lite_sanitize_dropdown_pages'
	));
	
	$wp_customize->add_control('car_fix_lite_top_slider_pageno1',array(
		'type' => 'dropdown-pages',
		'label' => __('Select page for slide one:','car-fix-lite'),
		'section' => 'car_fix_lite_header_slide_section'
	));	
	
	$wp_customize->add_setting('car_fix_lite_top_slider_pageno2',array(
		'default' => '0',			
		'capability' => 'edit_theme_options',
		'sanitize_callback' => 'car_fix_lite_sanitize_dropdown_pages'
	));
	
	$wp_customize->add_control('car_fix_lite_top_slider_pageno2',array(
		'type' => 'dropdown-pages',
		'label' => __('Select page for slide two:','car-fix-lite'),
		'section' => 'car_fix_lite_header_slide_section'
	));	
	
	$wp_customize->add_setting('car_fix_lite_top_slider_pageno3',array(
		'default' => '0',			
		'capability' => 'edit_theme_options',
		'sanitize_callback' => 'car_fix_lite_sanitize_dropdown_pages'
	));
	
	$wp_customize->add_control('car_fix_lite_top_slider_pageno3',array(
		'type' => 'dropdown-pages',
		'label' => __('Select page for slide three:','car-fix-lite'),
		'section' => 'car_fix_lite_header_slide_section'
	));	// Slider Section	
	
	$wp_customize->add_setting('car_fix_lite_top_slider_readmoretext',array(
		'default' => null,
		'sanitize_callback' => 'sanitize_text_field'	
	));
	
	$wp_customize->add_control('car_fix_lite_top_slider_readmoretext',array(	
		'type' => 'text',
		'label' => __('Add slider Read more button name here','car-fix-lite'),
		'section' => 'car_fix_lite_header_slide_section',
		'setting' => 'car_fix_lite_top_slider_readmoretext'
	)); // Slider Read More Button Text
	
	$wp_customize->add_setting('car_fix_lite_show_top_slidesection',array(
		'default' => false,
		'sanitize_callback' => 'car_fix_lite_sanitize_checkbox',
		'capability' => 'edit_theme_options',
	));	 
	
	$wp_customize->add_control( 'car_fix_lite_show_top_slidesection', array(
	    'settings' => 'car_fix_lite_show_top_slidesection',
	    'section'   => 'car_fix_lite_header_slide_section',
	     'label'     => __('Check To Show This Section','car-fix-lite'),
	   'type'      => 'checkbox'
	 ));//Show Slider Section	
	 
	 
	 // Our Services section
	$wp_customize->add_section('car_fix_lite_services_6column_panel', array(
		'title' => __('Our Services Section','car-fix-lite'),
		'description' => __('Select pages from the dropdown for our services section','car-fix-lite'),
		'priority' => null,
		'panel' => 	'car_fix_lite_panel_area',          
	));	
	
	$wp_customize->add_setting('car_fix_lite_section_tittle_bx',array(
		'default' => null,
		'sanitize_callback' => 'sanitize_text_field'	
	));
	
	$wp_customize->add_control('car_fix_lite_section_tittle_bx',array(	
		'type' => 'text',
		'label' => __('Add services title here','car-fix-lite'),
		'section' => 'car_fix_lite_services_6column_panel',
		'setting' => 'car_fix_lite_section_tittle_bx'
	)); 
	
	
	$wp_customize->add_setting('car_fix_lite_our_services_pgecolumn1',array(
		'default' => '0',			
		'capability' => 'edit_theme_options',
		'sanitize_callback' => 'car_fix_lite_sanitize_dropdown_pages'
	));
 
	$wp_customize->add_control(	'car_fix_lite_our_services_pgecolumn1',array(
		'type' => 'dropdown-pages',			
		'section' => 'car_fix_lite_services_6column_panel',
	));		
	
	$wp_customize->add_setting('car_fix_lite_our_services_pgecolumn2',array(
		'default' => '0',			
		'capability' => 'edit_theme_options',
		'sanitize_callback' => 'car_fix_lite_sanitize_dropdown_pages'
	));
 
	$wp_customize->add_control(	'car_fix_lite_our_services_pgecolumn2',array(
		'type' => 'dropdown-pages',			
		'section' => 'car_fix_lite_services_6column_panel',
	));
	
	$wp_customize->add_setting('car_fix_lite_our_services_pgecolumn3',array(
		'default' => '0',			
		'capability' => 'edit_theme_options',
		'sanitize_callback' => 'car_fix_lite_sanitize_dropdown_pages'
	));
 
	$wp_customize->add_control(	'car_fix_lite_our_services_pgecolumn3',array(
		'type' => 'dropdown-pages',			
		'section' => 'car_fix_lite_services_6column_panel',
	));
	
	$wp_customize->add_setting('car_fix_lite_our_services_pgecolumn4',array(
		'default' => '0',			
		'capability' => 'edit_theme_options',
		'sanitize_callback' => 'car_fix_lite_sanitize_dropdown_pages'
	));
 
	$wp_customize->add_control(	'car_fix_lite_our_services_pgecolumn4',array(
		'type' => 'dropdown-pages',			
		'section' => 'car_fix_lite_services_6column_panel',
	));
	
	$wp_customize->add_setting('car_fix_lite_our_services_pgecolumn5',array(
		'default' => '0',			
		'capability' => 'edit_theme_options',
		'sanitize_callback' => 'car_fix_lite_sanitize_dropdown_pages'
	));
 
	$wp_customize->add_control(	'car_fix_lite_our_services_pgecolumn5',array(
		'type' => 'dropdown-pages',			
		'section' => 'car_fix_lite_services_6column_panel',
	));
	
	$wp_customize->add_setting('car_fix_lite_our_services_pgecolumn6',array(
		'default' => '0',			
		'capability' => 'edit_theme_options',
		'sanitize_callback' => 'car_fix_lite_sanitize_dropdown_pages'
	));
 
	$wp_customize->add_control(	'car_fix_lite_our_services_pgecolumn6',array(
		'type' => 'dropdown-pages',			
		'section' => 'car_fix_lite_services_6column_panel',
	));
	
	
	$wp_customize->add_setting('car_fix_lite_show_services_6column_panel',array(
		'default' => false,
		'sanitize_callback' => 'car_fix_lite_sanitize_checkbox',
		'capability' => 'edit_theme_options',
	));	 
	
	$wp_customize->add_control( 'car_fix_lite_show_services_6column_panel', array(
	   'settings' => 'car_fix_lite_show_services_6column_panel',
	   'section'   => 'car_fix_lite_services_6column_panel',
	   'label'     => __('Check To Show This Section','car-fix-lite'),
	   'type'      => 'checkbox'
	 ));//Show Services Section	 
	 
	
	// Our Features Section
	$wp_customize->add_section('car_fix_lite_our_features_services_panel', array(
		'title' => __('Our Features Section','car-fix-lite'),
		'description' => __('Select pages from the dropdown for our features section','car-fix-lite'),
		'priority' => null,
		'panel' => 	'car_fix_lite_panel_area',          
	));	
	
	$wp_customize->add_setting('car_fix_lite_our_features_services_sectiontittle',array(
		'default' => null,
		'sanitize_callback' => 'sanitize_text_field'	
	));
	
	$wp_customize->add_control('car_fix_lite_our_features_services_sectiontittle',array(	
		'type' => 'text',
		'label' => __('Add services title here','car-fix-lite'),
		'section' => 'car_fix_lite_our_features_services_panel',
		'setting' => 'car_fix_lite_our_features_services_sectiontittle'
	)); 
	
	
	$wp_customize->add_setting('car_fix_lite_our_features_services_shortdescription',array(
		'default' => null,
		'sanitize_callback' => 'sanitize_text_field'	
	));
	
	$wp_customize->add_control('car_fix_lite_our_features_services_shortdescription',array(	
		'type' => 'text',
		'label' => __('Add services description here','car-fix-lite'),
		'section' => 'car_fix_lite_our_features_services_panel',
		'setting' => 'car_fix_lite_our_features_services_shortdescription'
	)); 
	
	
	$wp_customize->add_setting('car_fix_lite_features_services_pagebox1',array(
		'default' => '0',			
		'capability' => 'edit_theme_options',
		'sanitize_callback' => 'car_fix_lite_sanitize_dropdown_pages'
	));
 
	$wp_customize->add_control(	'car_fix_lite_features_services_pagebox1',array(
		'type' => 'dropdown-pages',			
		'section' => 'car_fix_lite_our_features_services_panel',
	));		
	
	$wp_customize->add_setting('car_fix_lite_features_services_pagebox2',array(
		'default' => '0',			
		'capability' => 'edit_theme_options',
		'sanitize_callback' => 'car_fix_lite_sanitize_dropdown_pages'
	));
 
	$wp_customize->add_control(	'car_fix_lite_features_services_pagebox2',array(
		'type' => 'dropdown-pages',			
		'section' => 'car_fix_lite_our_features_services_panel',
	));
	
	$wp_customize->add_setting('car_fix_lite_features_services_pagebox3',array(
		'default' => '0',			
		'capability' => 'edit_theme_options',
		'sanitize_callback' => 'car_fix_lite_sanitize_dropdown_pages'
	));
 
	$wp_customize->add_control(	'car_fix_lite_features_services_pagebox3',array(
		'type' => 'dropdown-pages',			
		'section' => 'car_fix_lite_our_features_services_panel',
	));
	
	
	$wp_customize->add_setting('car_fix_lite_show_features_services_panel',array(
		'default' => false,
		'sanitize_callback' => 'car_fix_lite_sanitize_checkbox',
		'capability' => 'edit_theme_options',
	));	 
	
	$wp_customize->add_control( 'car_fix_lite_show_features_services_panel', array(
	   'settings' => 'car_fix_lite_show_features_services_panel',
	   'section'   => 'car_fix_lite_our_features_services_panel',
	   'label'     => __('Check To Show This Section','car-fix-lite'),
	   'type'      => 'checkbox'
	 ));//Show Features Services Section 
	 
	 
	// Welcome Section 
	$wp_customize->add_section('car_fix_lite_aboutus_section', array(
		'title' => __('Welcome Section','car-fix-lite'),
		'description' => __('Select Pages from the dropdown for welcome section','car-fix-lite'),
		'priority' => null,
		'panel' => 	'car_fix_lite_panel_area',          
	));		
	
	$wp_customize->add_setting('car_fix_lite_site_welcome_pagecolumn',array(
		'default' => '0',			
		'capability' => 'edit_theme_options',
		'sanitize_callback' => 'car_fix_lite_sanitize_dropdown_pages'
	));
 
	$wp_customize->add_control(	'car_fix_lite_site_welcome_pagecolumn',array(
		'type' => 'dropdown-pages',			
		'section' => 'car_fix_lite_aboutus_section',
	));		
	
	$wp_customize->add_setting('car_fix_lite_show_site_welcome_pagecolumn',array(
		'default' => false,
		'sanitize_callback' => 'car_fix_lite_sanitize_checkbox',
		'capability' => 'edit_theme_options',
	));	 
	
	$wp_customize->add_control( 'car_fix_lite_show_site_welcome_pagecolumn', array(
	    'settings' => 'car_fix_lite_show_site_welcome_pagecolumn',
	    'section'   => 'car_fix_lite_aboutus_section',
	    'label'     => __('Check To Show This Section','car-fix-lite'),
	    'type'      => 'checkbox'
	));//Show WelCome Section 	 
	 
		 
}
add_action( 'customize_register', 'car_fix_lite_customize_register' );

function car_fix_lite_custom_css(){ 
?>
	<style type="text/css"> 					
        a, .recentpost_listing h2 a:hover,
        #sidebar ul li a:hover,								
        .recentpost_listing h3 a:hover,			
        .recent-post h6:hover,
		.header-socialicons a:hover,       						
        .postmeta a:hover,		
        .button:hover,			
		.six_column_box:hover h3 a,		
		.features_3box_services:hover h3 a,		           
		.footer-wrapper h2 span,
		.footer-wrapper ul li a:hover, 
		.footer-wrapper ul li.current_page_item a        				
            { color:<?php echo esc_html( get_theme_mod('car_fix_lite_color_scheme','#feca00')); ?>;}					 
            
        .pagination ul li .current, .pagination ul li a:hover, 
        #commentform input#submit:hover,		
        .nivo-controlNav a.active,				
        .learnmore,
		a.blogreadmore,
		.news-title,
		.header-navigation,
		.header-nav,		
		.topsitenav ul li ul,
		.features_imgbx,
		.six_column_box:hover .iconbox,
		.nivo-caption .slide_more, 		
		.features_3box_services .featurepagereadmore,												
        #sidebar .search-form input.search-submit,				
        .wpcf7 input[type='submit'],				
        nav.pagination .page-numbers.current,
        .toggle a	
            { background-color:<?php echo esc_html( get_theme_mod('car_fix_lite_color_scheme','#feca00')); ?>;}
			
		.nivo-caption .slide_more:hover,		
		.tagcloud a:hover,		
		.six_column_box .iconbox,
		h3.widget-title::after,
		blockquote	        
            { border-color:<?php echo esc_html( get_theme_mod('car_fix_lite_color_scheme','#feca00')); ?>;}	
			
         	
    </style> 
<?php 
}
         
add_action('wp_head','car_fix_lite_custom_css');	 

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function car_fix_lite_customize_preview_js() {
	wp_enqueue_script( 'car_fix_lite_customizer', get_template_directory_uri() . '/js/customize-preview.js', array( 'customize-preview' ), '20191002', true );
}
add_action( 'customize_preview_init', 'car_fix_lite_customize_preview_js' );