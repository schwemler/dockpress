<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content-ts">
 *
 * @package Advance Automobile
 */

?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo( 'charset' ); ?>">
  <meta name="viewport" content="width=device-width">
  <link rel="profile" href="<?php echo esc_url( __( 'http://gmpg.org/xfn/11', 'advance-automobile' ) ); ?>">
  <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
  
<div id="header">
  <div class="top-header">
    <div class="container">
      <div class="row">
        <div class="col-lg-4 col-md-4">
          <div class="mail">
            <?php if( get_theme_mod('advance_automobile_mail1') != ''){ ?>
              <i class="fas fa-envelope"></i><span><?php echo esc_html( get_theme_mod('advance_automobile_mail1','')); ?></span>
            <?php } ?>
          </div>
        </div>
        <div class="col-lg-6 col-md-5">
          <div class="social-icons">
            <?php if( get_theme_mod( 'advance_automobile_facebook_url') != '') { ?>
              <a href="<?php echo esc_url( get_theme_mod( 'advance_automobile_facebook_url','' ) ); ?>"><i class="fab fa-facebook-f" aria-hidden="true"></i></a>
            <?php } ?>
            <?php if( get_theme_mod( 'advance_automobile_twitter_url') != '') { ?>
              <a href="<?php echo esc_url( get_theme_mod( 'advance_automobile_twitter_url','' ) ); ?>"><i class="fab fa-twitter"></i></a>
            <?php } ?>
            <?php if( get_theme_mod( 'advance_automobile_youtube_url') != '') { ?>
              <a href="<?php echo esc_url( get_theme_mod( 'advance_automobile_youtube_url','' ) ); ?>"><i class="fab fa-youtube"></i></a>
            <?php } ?>
            <?php if( get_theme_mod( 'advance_automobile_google_plus_url') != '') { ?>
              <a href="<?php echo esc_url( get_theme_mod( 'advance_automobile_google_plus_url','' ) ); ?>"><i class="fab fa-google-plus-g"></i></a>
            <?php } ?>
            <?php if( get_theme_mod( 'advance_automobile_linkedin_url') != '') { ?>
              <a href="<?php echo esc_url( get_theme_mod( 'advance_automobile_linkedin_url','' ) ); ?>"><i class="fab fa-linkedin-in"></i></a>
            <?php } ?>
          </div>
        </div>
        <div class="col-lg-2 col-md-3">
          <div class="book-btn">
            <?php if ( get_theme_mod('advance_automobile_book1','') != "" ) {?>
              <a href="<?php echo esc_html(get_theme_mod('advance_automobile_book')); ?>"><?php echo esc_html(get_theme_mod('advance_automobile_book1','')); ?></a>
            <?php }?>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="toggle">
    <a class="toggleMenu" href="#"><?php esc_html_e('Menu','advance-automobile'); ?></a>
  </div>
  <div class="main-menu">
    <div class="container">
      <div class="row">
        <div class="col-lg-3 col-md-4">
          <div class="logo">
            <?php if( has_custom_logo() ){ advance_automobile_the_custom_logo();
             }else{ ?>
              <h1><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
              <?php $description = get_bloginfo( 'description', 'display' );
                if ( $description || is_customize_preview() ) : ?> 
                <p class="site-description"><?php echo esc_html($description); ?></p>       
              <?php endif; }?>
          </div>
        </div>
        <div class="col-lg-8 col-md-7">
          <div class="nav">
            <?php wp_nav_menu( array('theme_location'  => 'primary') ); ?>
          </div>
        </div>
        <div class="col-lg-1 col-md-1">
          <div class="search-box">
            <i class="fas fa-search"></i>
          </div>
        </div>
      </div>
      <div class="serach_outer">
        <div class="closepop"><i class="far fa-window-close"></i></div>
        <div class="serach_inner">
          <?php get_search_form(); ?>
        </div>
      </div>
    </div>
  </div>
</div>