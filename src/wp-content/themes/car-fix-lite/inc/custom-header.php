<?php
/**
 * @package Car Fix Lite
 * Setup the WordPress core custom header feature.
 *
 * @uses car_fix_lite_header_style()

 */
function car_fix_lite_custom_header_setup() {
	add_theme_support( 'custom-header', apply_filters( 'car_fix_lite_custom_header_args', array(		
		'default-text-color'     => '000000',
		'width'                  => 1400,
		'height'                 => 200,
		'wp-head-callback'       => 'car_fix_lite_header_style',		
	) ) );
}
add_action( 'after_setup_theme', 'car_fix_lite_custom_header_setup' );

if ( ! function_exists( 'car_fix_lite_header_style' ) ) :
/**
 * Styles the header image and text displayed on the blog
 *
 * @see car_fix_lite_custom_header_setup().
 */
function car_fix_lite_header_style() {
	$header_text_color = get_header_textcolor();
	?>
	<style type="text/css">
	<?php
		//Check if user has defined any header image.
		if ( get_header_image() || get_header_textcolor() ) :
	?>
		.site-header{
			background: url(<?php echo esc_url( get_header_image() ); ?>) no-repeat;
			background-position: center top;
		}
		.logo h1 a { color:#<?php echo esc_html(get_header_textcolor()); ?>;}
	<?php endif; ?>	
	</style>
    
    <?php
	// If the header text option is untouched, let's bail.
	if ( display_header_text() ) {
		return;
	}

	// If the header text has been hidden.
	?>
    <style type="text/css">		
		.logo h1,
		.logo p{
			clip: rect(1px, 1px, 1px, 1px);
			position: absolute;
		}
    </style>
    
	<?php       
} 
endif; // car_fix_lite_header_style 