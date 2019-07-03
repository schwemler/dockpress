<?php
/**
 * washing-center: Customizer
 *
 * @package WordPress
 * @subpackage washing-center
 * @since 1.0
 */

function washing_center_customize_register( $wp_customize ) {

	$wp_customize->add_panel( 'washing_center_panel_id', array(
	    'priority' => 10,
	    'capability' => 'edit_theme_options',
	    'theme_supports' => '',
	    'title' => __( 'Theme Settings', 'washing-center' ),
	    'description' => __( 'Description of what this panel does.', 'washing-center' ),
	) );

	$wp_customize->add_section( 'washing_center_theme_options_section', array(
    	'title'      => __( 'General Settings', 'washing-center' ),
		'priority'   => 30,
		'panel' => 'washing_center_panel_id'
	) );

	// Add Settings and Controls for Layout
	$wp_customize->add_setting('washing_center_theme_options',array(
        'default' => __('Right Sidebar','washing-center'),
        'sanitize_callback' => 'washing_center_sanitize_choices'	        
	));

	$wp_customize->add_control('washing_center_theme_options',array(
        'type' => 'radio',
        'label' => __('Do you want this section','washing-center'),
        'section' => 'washing_center_theme_options_section',
        'choices' => array(
            'Left Sidebar' => __('Left Sidebar','washing-center'),
            'Right Sidebar' => __('Right Sidebar','washing-center'),
            'One Column' => __('One Column','washing-center'),
            'Three Columns' => __('Three Columns','washing-center'),
            'Four Columns' => __('Four Columns','washing-center'),
            'Grid Layout' => __('Grid Layout','washing-center')
        ),
	));

	// Top Bar
	$wp_customize->add_section( 'washing_center_top_bar', array(
    	'title'      => __( 'Top Bar', 'washing-center' ),
		'priority'   => null,
		'panel' => 'washing_center_panel_id'
	) );

	$wp_customize->add_setting('washing_center_email_address',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));	
	$wp_customize->add_control('washing_center_email_address',array(
		'label'	=> __('Add Email Address','washing-center'),
		'section'=> 'washing_center_top_bar',
		'setting'=> 'washing_center_email_address',
		'type'=> 'text'
	));

	$wp_customize->add_setting('washing_center_phone_number',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));	
	$wp_customize->add_control('washing_center_phone_number',array(
		'label'	=> __('Add Phone Number','washing-center'),
		'section'=> 'washing_center_top_bar',
		'setting'=> 'washing_center_phone_number',
		'type'=> 'text'
	));

	//social icons
	$wp_customize->add_section( 'washing_center_social', array(
    	'title'      => __( 'Social Icons', 'washing-center' ),
		'priority'   => null,
		'panel' => 'washing_center_panel_id'
	) );

	$wp_customize->add_setting('washing_center_facebook_url',array(
		'default'	=> '',
		'sanitize_callback'	=> 'esc_url_raw'
	));	
	$wp_customize->add_control('washing_center_facebook_url',array(
		'label'	=> __('Add Facebook link','washing-center'),
		'section'	=> 'washing_center_social',
		'setting'	=> 'washing_center_facebook_url',
		'type'	=> 'url'
	));

	$wp_customize->add_setting('washing_center_twitter_url',array(
		'default'	=> '',
		'sanitize_callback'	=> 'esc_url_raw'
	));	
	$wp_customize->add_control('washing_center_twitter_url',array(
		'label'	=> __('Add Twitter link','washing-center'),
		'section'	=> 'washing_center_social',
		'setting'	=> 'washing_center_twitter_url',
		'type'	=> 'url'
	));

	$wp_customize->add_setting('washing_center_insta_url',array(
		'default'	=> '',
		'sanitize_callback'	=> 'esc_url_raw'
	));	
	$wp_customize->add_control('washing_center_insta_url',array(
		'label'	=> __('Add Instagram link','washing-center'),
		'section'	=> 'washing_center_social',
		'setting'	=> 'washing_center_insta_url',
		'type'	=> 'url'
	));

	$wp_customize->add_setting('washing_center_linkedin_url',array(
		'default'	=> '',
		'sanitize_callback'	=> 'esc_url_raw'
	));
	$wp_customize->add_control('washing_center_linkedin_url',array(
		'label'	=> __('Add Linkedin link','washing-center'),
		'section'	=> 'washing_center_social',
		'setting'	=> 'washing_center_linkedin_url',
		'type'	=> 'url'
	));

	$wp_customize->add_setting('washing_center_pinterest_url',array(
		'default'	=> '',
		'sanitize_callback'	=> 'esc_url_raw'
	));	
	$wp_customize->add_control('washing_center_pinterest_url',array(
		'label'	=> __('Add Pintrest link','washing-center'),
		'section'	=> 'washing_center_social',
		'setting'	=> 'washing_center_pinterest_url',
		'type'	=> 'url'
	));

	//home page slider
	$wp_customize->add_section( 'washing_center_slider_section' , array(
    	'title'      => __( 'Slider Settings', 'washing-center' ),
		'priority'   => null,
		'panel' => 'washing_center_panel_id'
	) );

	$wp_customize->add_setting('washing_center_slider_hide_show',array(
       	'default' => 'true',
       	'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('washing_center_slider_hide_show',array(
	   	'type' => 'checkbox',
	   	'label' => __('Show / Hide slider','washing-center'),
	   	'description' => __('Image Size ( 1400px x 660 )','washing-center'),
	   	'section' => 'washing_center_slider_section',
	));

	for ( $count = 1; $count <= 4; $count++ ) {

		// Add color scheme setting and control.
		$wp_customize->add_setting( 'washing_center_slider' . $count, array(
			'default'           => '',
			'sanitize_callback' => 'washing_center_sanitize_dropdown_pages'
		) );

		$wp_customize->add_control( 'washing_center_slider' . $count, array(
			'label'    => __( 'Select Slide Image Page', 'washing-center' ),
			'section'  => 'washing_center_slider_section',
			'type'     => 'dropdown-pages'
		) );
	}

	// Our Services 
	$wp_customize->add_section('washing_center_arrange_section',array(
		'title'	=> __('Our Services','washing-center'),
		'description'=> __('This section will appear below the services.','washing-center'),
		'panel' => 'washing_center_panel_id',
	));
	
	$wp_customize->add_setting('washing_center_section_title',array(
		'default'	=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));	
	$wp_customize->add_control('washing_center_section_title',array(
		'label'	=> __('Section Title','washing-center'),
		'section'	=> 'washing_center_arrange_section',
		'setting'	=> 'washing_center_section_title',
		'type'		=> 'text'
	));

	$categories = get_categories();
	$cats = array();
	$i = 0;
	$cat_pst[]= 'select';
	foreach($categories as $category){
		if($i==0){
			$default = $category->slug;
			$i++;
		}
		$cat_pst[$category->slug] = $category->name;
	}

	$wp_customize->add_setting('washing_center_arrange_cat',array(
		'default'	=> 'select',
		'sanitize_callback' => 'sanitize_text_field',
	));
	$wp_customize->add_control('washing_center_arrange_cat',array(
		'type'    => 'select',
		'choices' => $cat_pst,
		'label' => __('Select Category to display Post','washing-center'),
		'section' => 'washing_center_arrange_section',
	));

	//Footer
    $wp_customize->add_section( 'washing_center_footer', array(
    	'title'      => __( 'Footer Text', 'washing-center' ),
		'priority'   => null,
		'panel' => 'washing_center_panel_id'
	) );

    $wp_customize->add_setting('washing_center_footer_copy',array(
		'default'	=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));	
	$wp_customize->add_control('washing_center_footer_copy',array(
		'label'	=> __('Footer Text','washing-center'),
		'section'	=> 'washing_center_footer',
		'setting'	=> 'washing_center_footer_copy',
		'type'		=> 'text'
	));

	$wp_customize->get_setting( 'blogname' )->transport          = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport   = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport  = 'postMessage';

	$wp_customize->selective_refresh->add_partial( 'blogname', array(
		'selector' => '.site-title a',
		'render_callback' => 'washing_center_customize_partial_blogname',
	) );
	$wp_customize->selective_refresh->add_partial( 'blogdescription', array(
		'selector' => '.site-description',
		'render_callback' => 'washing_center_customize_partial_blogdescription',
	) );

	//front page
	$num_sections = apply_filters( 'washing_center_front_page_sections', 4 );

	// Create a setting and control for each of the sections available in the theme.
	for ( $i = 1; $i < ( 1 + $num_sections ); $i++ ) {
		$wp_customize->add_setting( 'panel_' . $i, array(
			'default'           => false,
			'sanitize_callback' => 'washing_center_sanitize_dropdown_pages',
			'transport'         => 'postMessage',
		) );

		$wp_customize->add_control( 'panel_' . $i, array(
			/* translators: %d is the front page section number */
			'label'          => sprintf( __( 'Front Page Section %d Content', 'washing-center' ), $i ),
			'description'    => ( 1 !== $i ? '' : __( 'Select pages to feature in each area from the dropdowns. Add an image to a section by setting a featured image in the page editor. Empty sections will not be displayed.', 'washing-center' ) ),
			'section'        => 'theme_options',
			'type'           => 'dropdown-pages',
			'allow_addition' => true,
			'active_callback' => 'washing_center_is_static_front_page',
		) );

		$wp_customize->selective_refresh->add_partial( 'panel_' . $i, array(
			'selector'            => '#panel' . $i,
			'render_callback'     => 'washing_center_front_page_section',
			'container_inclusive' => true,
		) );
	}
}
add_action( 'customize_register', 'washing_center_customize_register' );

function washing_center_customize_partial_blogname() {
	bloginfo( 'name' );
}

function washing_center_customize_partial_blogdescription() {
	bloginfo( 'description' );
}

function washing_center_is_static_front_page() {
	return ( is_front_page() && ! is_home() );
}

function washing_center_is_view_with_layout_option() {
	// This option is available on all pages. It's also available on archives when there isn't a sidebar.
	return ( is_page() || ( is_archive() && ! is_active_sidebar( 'sidebar-1' ) ) );
}

/**
 * Singleton class for handling the theme's customizer integration.
 *
 * @since  1.0.0
 * @access public
 */
final class Washing_Center_Customize {

	/**
	 * Returns the instance.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return object
	 */
	public static function get_instance() {

		static $instance = null;

		if ( is_null( $instance ) ) {
			$instance = new self;
			$instance->setup_actions();
		}

		return $instance;
	}

	/**
	 * Constructor method.
	 *
	 * @since  1.0.0
	 * @access private
	 * @return void
	 */
	private function __construct() {}

	/**
	 * Sets up initial actions.
	 *
	 * @since  1.0.0
	 * @access private
	 * @return void
	 */
	private function setup_actions() {

		// Register panels, sections, settings, controls, and partials.
		add_action( 'customize_register', array( $this, 'sections' ) );

		// Register scripts and styles for the controls.
		add_action( 'customize_controls_enqueue_scripts', array( $this, 'enqueue_control_scripts' ), 0 );
	}

	/**
	 * Sets up the customizer sections.
	 *
	 * @since  1.0.0
	 * @access public
	 * @param  object  $manager
	 * @return void
	 */
	public function sections( $manager ) {

		// Load custom sections.
		load_template( trailingslashit( get_template_directory() ) . '/inc/section-pro.php' );

		// Register custom section types.
		$manager->register_section_type( 'Washing_Center_Customize_Section_Pro' );

		// Register sections.
		$manager->add_section(
			new Washing_Center_Customize_Section_Pro(
				$manager,
				'example_1',
				array(
					'priority' => 9,
					'title'    => esc_html__( 'Washing Center Pro ', 'washing-center' ),
					'pro_text' => esc_html__( 'Go Pro','washing-center' ),
					'pro_url'  => esc_url( 'https://www.luzuk.com/themes/car-wash-wordpress-theme/' ),
				)
			)
		);
	}

	/**
	 * Loads theme customizer CSS.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function enqueue_control_scripts() {

		wp_enqueue_script( 'washing-center-customize-controls', trailingslashit( get_template_directory_uri() ) . '/assets/js/customize-controls.js', array( 'customize-controls' ) );

		wp_enqueue_style( 'washing-center-customize-controls', trailingslashit( get_template_directory_uri() ) . '/assets/css/customize-controls.css' );
	}
}

// Doing this customizer thang!
Washing_Center_Customize::get_instance();