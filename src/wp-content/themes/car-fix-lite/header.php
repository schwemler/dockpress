<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div class="container">
 *
 * @package Car Fix Lite
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<?php if ( is_singular() && pings_open( get_queried_object() ) ) : ?>
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
<?php endif; ?>
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php
$car_fix_lite_show_top_contactinfo_section 	  		= get_theme_mod('car_fix_lite_show_top_contactinfo_section', false);
$car_fix_lite_show_top_slidesection 	  		    = get_theme_mod('car_fix_lite_show_top_slidesection', false);
$car_fix_lite_show_services_6column_panel 	  	    = get_theme_mod('car_fix_lite_show_services_6column_panel', false);
$car_fix_lite_show_site_welcome_pagecolumn	        = get_theme_mod('car_fix_lite_show_site_welcome_pagecolumn', false);
$car_fix_lite_show_features_services_panel 	  	    = get_theme_mod('car_fix_lite_show_features_services_panel', false);
$car_fix_lite_show_socialsection 	  			    = get_theme_mod('car_fix_lite_show_socialsection', false);
?>
<div id="sitelayout_type" <?php if( get_theme_mod( 'car_fix_lite_boxlayout' ) ) { echo 'class="boxlayout"'; } ?>>
<?php
if ( is_front_page() && !is_home() ) {
	if( !empty($car_fix_lite_show_top_slidesection)) {
	 	$inner_cls = '';
	}
	else {
		$inner_cls = 'siteinner';
	}
}
else {
$inner_cls = 'siteinner';
}
?>

<div class="site-header <?php echo esc_attr($inner_cls); ?>"> 
  <div class="container">  
    <div class="header-top">
    <div class="left">    
   <?php if( $car_fix_lite_show_top_contactinfo_section != ''){ ?> 
             <?php 
               $car_fix_lite_top_telphone_no = get_theme_mod('car_fix_lite_top_telphone_no');
               if( !empty($car_fix_lite_top_telphone_no) ){ ?> 
                 <span>  <i class="fas fa-phone-square"></i> 
				 <?php echo esc_html($car_fix_lite_top_telphone_no); ?></span>
               <?php } ?>    
   
             <?php
               $car_fix_lite_top_contact_emailid = get_theme_mod('car_fix_lite_top_contact_emailid');
               if( !empty($car_fix_lite_top_contact_emailid) ){ ?> 
                 <span> <i class="fas fa-envelope"></i>
                 <a href="<?php echo esc_url('mailto:'.get_theme_mod('car_fix_lite_top_contact_emailid')); ?>"><?php echo esc_html(get_theme_mod('car_fix_lite_top_contact_emailid')); ?></a></span>
               <?php } ?>
               
           <?php } ?>        
    
    </div> 
    <div class="right">
      <?php if( $car_fix_lite_show_socialsection != ''){ ?> 
           <div class="header-socialicons">                                                
                   <?php $car_fix_lite_fb_link = get_theme_mod('car_fix_lite_fb_link');
                    if( !empty($car_fix_lite_fb_link) ){ ?>
                    <a title="facebook" class="fab fa-facebook-f" target="_blank" href="<?php echo esc_url($car_fix_lite_fb_link); ?>"></a>
                   <?php } ?>
                
                   <?php $car_fix_lite_twitt_link = get_theme_mod('car_fix_lite_twitt_link');
                    if( !empty($car_fix_lite_twitt_link) ){ ?>
                    <a title="twitter" class="fab fa-twitter" target="_blank" href="<?php echo esc_url($car_fix_lite_twitt_link); ?>"></a>
                   <?php } ?>
            
                  <?php $car_fix_lite_gplus_link = get_theme_mod('car_fix_lite_gplus_link');
                    if( !empty($car_fix_lite_gplus_link) ){ ?>
                    <a title="google-plus" class="fab fa-google-plus" target="_blank" href="<?php echo esc_url($car_fix_lite_gplus_link); ?>"></a>
                  <?php }?>
            
                  <?php $car_fix_lite_linked_link = get_theme_mod('car_fix_lite_linked_link');
                    if( !empty($car_fix_lite_linked_link) ){ ?>
                    <a title="linkedin" class="fab fa-linkedin" target="_blank" href="<?php echo esc_url($car_fix_lite_linked_link); ?>"></a>
                  <?php } ?>                  
         </div><!--end .header-socialicons--> 
      <?php } ?> 
    </div> <!--.right-->  
    <div class="clear"></div> 
</div>    
<div class="logonavigation">  
     <div class="logo">
        <?php car_fix_lite_the_custom_logo(); ?>
           <h1><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo('name'); ?></a></h1>
            <?php $description = get_bloginfo( 'description', 'display' );
            if ( $description || is_customize_preview() ) : ?>
                <p><?php echo esc_html($description); ?></p>
            <?php endif; ?>
      </div><!-- logo -->
        
      <div class="header-nav">
          <div class="toggle">
         <a class="toggleMenu" href="#"><?php esc_html_e('Menu','car-fix-lite'); ?></a>
       </div><!-- toggle --> 
       <div class="topsitenav">                   
         <?php wp_nav_menu( array('theme_location' => 'primary') ); ?>
       </div><!--.topsitenav -->
        </div><!--.header-nav -->
      <div class="clear"></div>  
 
  </div><!-- .logonavigation -->   
  </div><!-- .container -->   
  </div><!--.site-header --> 
  
<?php 
if ( is_front_page() && !is_home() ) {
if($car_fix_lite_show_top_slidesection != '') {
	for($i=1; $i<=3; $i++) {
	  if( get_theme_mod('car_fix_lite_top_slider_pageno'.$i,false)) {
		$slider_Arr[] = absint( get_theme_mod('car_fix_lite_top_slider_pageno'.$i,true));
	  }
	}
?> 
<div class="header_slider_section">                
<?php if(!empty($slider_Arr)){ ?>
<div id="slider" class="nivoSlider">
<?php 
$i=1;
$slidequery = new WP_Query( array( 'post_type' => 'page', 'post__in' => $slider_Arr, 'orderby' => 'post__in' ) );
while( $slidequery->have_posts() ) : $slidequery->the_post();
$image = wp_get_attachment_url( get_post_thumbnail_id($post->ID)); 
$thumbnail_id = get_post_thumbnail_id( $post->ID );
$alt = get_post_meta($thumbnail_id, '_wp_attachment_image_alt', true); 
?>
<?php if(!empty($image)){ ?>
<img src="<?php echo esc_url( $image ); ?>" title="#slidecaption<?php echo esc_attr( $i ); ?>" alt="<?php echo esc_attr($alt); ?>" />
<?php }else{ ?>
<img src="<?php echo esc_url( get_template_directory_uri() ) ; ?>/images/slides/slider-default.jpg" title="#slidecaption<?php echo esc_attr( $i ); ?>" alt="<?php echo esc_attr($alt); ?>" />
<?php } ?>
<?php $i++; endwhile; ?>
</div>   

<?php 
$j=1;
$slidequery->rewind_posts();
while( $slidequery->have_posts() ) : $slidequery->the_post(); ?>                 
    <div id="slidecaption<?php echo esc_attr( $j ); ?>" class="nivo-html-caption">     
      <div class="custominfo">       
    	<h2><?php the_title(); ?></h2>
    	<?php the_excerpt(); ?>
		<?php
        $car_fix_lite_top_slider_readmoretext = get_theme_mod('car_fix_lite_top_slider_readmoretext');
        if( !empty($car_fix_lite_top_slider_readmoretext) ){ ?>
            <a class="slide_more" href="<?php the_permalink(); ?>"><?php echo esc_html($car_fix_lite_top_slider_readmoretext); ?></a>
        <?php } ?>
       </div><!-- .custominfo -->                    
    </div>   
<?php $j++; 
endwhile;
wp_reset_postdata(); ?>  
<div class="clear"></div>  
</div><!--end .header_slider_section -->     
<?php } ?>
<?php } } ?>
       
        
<?php if ( is_front_page() && ! is_home() ) {
 if( $car_fix_lite_show_services_6column_panel != ''){ ?>  
  <div class="first_services_section">
     <div class="container">
        <?php
         $car_fix_lite_section_tittle_bx = get_theme_mod('car_fix_lite_section_tittle_bx');
         if( !empty($car_fix_lite_section_tittle_bx) ){ ?>
            <h2 class="section-title"><?php echo esc_html($car_fix_lite_section_tittle_bx); ?></h2>
        <?php } ?>
        
       <?php 
        for($n=1; $n<=6; $n++) {    
        if( get_theme_mod('car_fix_lite_our_services_pgecolumn'.$n,false)) {      
            $queryvar = new WP_Query('page_id='.absint(get_theme_mod('car_fix_lite_our_services_pgecolumn'.$n,true)) );		
            while( $queryvar->have_posts() ) : $queryvar->the_post(); ?>     
            <div class="six_column_box three_column">                                       
                <?php if(has_post_thumbnail() ) { ?>
                <div class="iconbox"><a href="<?php the_permalink(); ?>"><?php the_post_thumbnail();?></a></div>        
                <?php } ?>
                <div class="six_pagecontent_box">		
                  <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3> 
                  <?php the_excerpt(); ?>	
                </div>             
            </div>
            <?php endwhile;
            wp_reset_postdata();                                  
        } } ?>                                 
    <div class="clear"></div>  
   </div><!-- .container -->
</div><!-- .first_services_section -->               
                	      
<?php } ?>


<?php if( $car_fix_lite_show_features_services_panel != ''){ ?>  
<section id="second_features_section">
<div class="container">  

<?php
    $car_fix_lite_our_features_services_sectiontittle = get_theme_mod('car_fix_lite_our_features_services_sectiontittle');
       if( !empty($car_fix_lite_our_features_services_sectiontittle) ){ ?>
       <h2 class="section-title"><?php echo esc_html($car_fix_lite_our_features_services_sectiontittle); ?></h2>
 <?php } ?>
 
 <?php
    $car_fix_lite_our_features_services_shortdescription = get_theme_mod('car_fix_lite_our_features_services_shortdescription');
       if( !empty($car_fix_lite_our_features_services_shortdescription) ){ ?>
       <p class="short_description"><?php echo esc_html($car_fix_lite_our_features_services_shortdescription); ?></p>
 <?php } ?>
                    
<?php 
for($n=1; $n<=3; $n++) {    
if( get_theme_mod('car_fix_lite_features_services_pagebox'.$n,false)) {      
	$queryvar = new WP_Query('page_id='.absint(get_theme_mod('car_fix_lite_features_services_pagebox'.$n,true)) );		
	while( $queryvar->have_posts() ) : $queryvar->the_post(); ?>     
	<div class="features_3box_services <?php if($n % 3 == 0) { echo "last_column"; } ?>">                                       
		<?php if(has_post_thumbnail() ) { ?>
		<div class="features_imgbx"><a href="<?php the_permalink(); ?>"><?php the_post_thumbnail();?></a></div>        
		<?php } ?>
		<div class="column_3content_box">
		<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>                                     
		<?php the_excerpt(); ?>	
        <a class="featurepagereadmore" href="<?php the_permalink(); ?>"><?php esc_html_e('Read more...','car-fix-lite'); ?> <i class="fas fa-plus"></i></a>	                        
		</div>                                   
	</div>
	<?php endwhile;
	wp_reset_postdata();                                  
} } ?>                                 
<div class="clear"></div>  
</div><!-- .container -->                  
</section><!-- #second_features_section-->                      	      
<?php } ?>


<?php if( $car_fix_lite_show_site_welcome_pagecolumn != ''){ ?>  
<section id="third_welcome_section">
<div class="container">                               
<?php 
if( get_theme_mod('car_fix_lite_site_welcome_pagecolumn',false)) {     
$queryvar = new WP_Query('page_id='.absint(get_theme_mod('car_fix_lite_site_welcome_pagecolumn',true)) );			
    while( $queryvar->have_posts() ) : $queryvar->the_post(); ?>     
     <div class="welcome_imagebx"><?php the_post_thumbnail();?></div>    
     <div class="welcome_content_column">   
     <h3><?php the_title(); ?></h3>   
     <?php the_content();  ?>     
    </div>                                          
    <?php endwhile;
     wp_reset_postdata(); ?>                                    
    <?php } ?>                                 
<div class="clear"></div>                       
</div><!-- container -->
</section><!-- #third_welcome_section-->
<?php } ?>
<?php } ?>