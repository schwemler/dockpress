<?php
/**
 *Car Fix Lite About Theme
 *
 * @package Car Fix Lite
 */

//about theme info
add_action( 'admin_menu', 'car_fix_lite_abouttheme' );
function car_fix_lite_abouttheme() {    	
	add_theme_page( __('About Theme Info', 'car-fix-lite'), __('About Theme Info', 'car-fix-lite'), 'edit_theme_options', 'car_fix_lite_guide', 'car_fix_lite_mostrar_guide');   
} 

//Info of the theme
function car_fix_lite_mostrar_guide() { 	
?>
<div class="wrap-GT">
	<div class="gt-left">
   		   <div class="heading-gt">
			  <h3><?php esc_html_e('About Theme Info', 'car-fix-lite'); ?></h3>
		   </div>
          <p><?php esc_html_e('Car Fix is a visually refreshing, youthful and vibrant, intuitive and modern, purposeful and deliberate, extensively designed and carefully crafted, clean and clutter-free, car repair WordPress theme. It is a reliable set of tools for developing effective and professional websites for your automobile business. This theme especially designed to completely satisfying the needs of wide range of auto service applications, ranging from car repair shops, car washes, mechanics shops, brakes shops, wheel shop, car dealers, garages, car rental agencies and many other small auto business services.','car-fix-lite'); ?></p>
<div class="heading-gt"> <?php esc_html_e('Theme Features', 'car-fix-lite'); ?></div>
 

<div class="col-2">
  <h4><?php esc_html_e('Theme Customizer', 'car-fix-lite'); ?></h4>
  <div class="description"><?php esc_html_e('The built-in customizer panel quickly change aspects of the design and display changes live before saving them.', 'car-fix-lite'); ?></div>
</div>

<div class="col-2">
  <h4><?php esc_html_e('Responsive Ready', 'car-fix-lite'); ?></h4>
  <div class="description"><?php esc_html_e('The themes layout will automatically adjust and fit on any screen resolution and looks great on any device. Fully optimized for iPhone and iPad.', 'car-fix-lite'); ?></div>
</div>

<div class="col-2">
<h4><?php esc_html_e('Cross Browser Compatible', 'car-fix-lite'); ?></h4>
<div class="description"><?php esc_html_e('Our themes are tested in all mordern web browsers and compatible with the latest version including Chrome,Firefox, Safari, Opera, IE11 and above.', 'car-fix-lite'); ?></div>
</div>

<div class="col-2">
<h4><?php esc_html_e('E-commerce', 'car-fix-lite'); ?></h4>
<div class="description"><?php esc_html_e('Fully compatible with WooCommerce plugin. Just install the plugin and turn your site into a full featured online shop and start selling products.', 'car-fix-lite'); ?></div>
</div>
<hr />  
</div><!-- .gt-left -->
	
<div class="gt-right">			
        <div>				
            <a href="<?php echo esc_url( CAR_FIX_LITE_LIVE_DEMO ); ?>" target="_blank"><?php esc_html_e('Live Demo', 'car-fix-lite'); ?></a> | 
            <a href="<?php echo esc_url( CAR_FIX_LITE_PROTHEME_URL ); ?>" target="_blank"><?php esc_html_e('Purchase Pro', 'car-fix-lite'); ?></a> | 
            <a href="<?php echo esc_url( CAR_FIX_LITE_THEME_DOC ); ?>" target="_blank"><?php esc_html_e('Documentation', 'car-fix-lite'); ?></a>
        </div>		
</div><!-- .gt-right-->
<div class="clear"></div>
</div><!-- .wrap-GT -->
<?php } ?>