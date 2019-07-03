<?php
/**
 * The header for our theme
 *
 * @package WordPress
 * @subpackage washing-center
 * @since 1.0
 * @version 0.1
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js no-svg">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="<?php echo esc_url( __( 'http://gmpg.org/xfn/11', 'washing-center' ) ); ?>">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<div class="toggle"><a class="toggleMenu" href="#"><?php esc_html_e('Menu','washing-center'); ?></a></div>

<div class="header-box">
	<div class="topbar">
		<div class="container">
			<div class="row">
				<div class="col-lg-4 col-md-4">
					<?php if( get_theme_mod( 'washing_center_phone_number') != '') { ?>
						<span><i class="fas fa-envelope"></i><?php echo esc_html( get_theme_mod( 'washing_center_email_address','' ) ); ?></span>
					<?php }?>
				</div>
				<div class="col-lg-3 col-md-3">
					<?php if( get_theme_mod( 'washing_center_phone_number') != '') { ?>
						<span><i class="fas fa-phone"></i><?php echo esc_html( get_theme_mod( 'washing_center_phone_number','' ) ); ?></span>
					<?php }?>
				</div>
				<div class="col-lg-5 col-md-5">
					<div class="social-icons">
						<?php if( get_theme_mod( 'washing_center_facebook_url') != '') { ?>
				      		<a href="<?php echo esc_url( get_theme_mod( 'washing_center_facebook_url','' ) ); ?>"><i class="fab fa-facebook-f" aria-hidden="true"></i></a>
					    <?php } ?>
					    <?php if( get_theme_mod( 'washing_center_twitter_url') != '') { ?>
					      	<a href="<?php echo esc_url( get_theme_mod( 'washing_center_twitter_url','' ) ); ?>"><i class="fab fa-twitter"></i></a>
					    <?php } ?>
					    <?php if( get_theme_mod( 'washing_center_insta_url') != '') { ?>
					      	<a href="<?php echo esc_url( get_theme_mod( 'washing_center_insta_url','' ) ); ?>"><i class="fab fa-instagram"></i></a>
					    <?php } ?>
					    <?php if( get_theme_mod( 'washing_center_linkedin_url') != '') { ?>
				     		<a href="<?php echo esc_url( get_theme_mod( 'washing_center_linkedin_url','' ) ); ?>"><i class="fab fa-linkedin-in"></i></a>
					    <?php } ?>	 
					    <?php if( get_theme_mod( 'washing_center_pinterest_url') != '') { ?>
					      	<a href="<?php echo esc_url( get_theme_mod( 'washing_center_pinterest_url','' ) ); ?>"><i class="fab fa-pinterest-p"></i></a>
					    <?php } ?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<header class="top-header">
		<div class="container">
			<div class="row">
				<div class="col-lg-3 col-md-3">
					<div class="logo">
				        <?php if( has_custom_logo() ){ washing_center_the_custom_logo();
				           }else{ ?>
				          <h1><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
				          <?php $description = get_bloginfo( 'description', 'display' );
				          if ( $description || is_customize_preview() ) : ?> 
				            <p class="site-description"><?php echo esc_html($description); ?></p>
				        <?php endif; }?>
				    </div>
				</div>
				<div class="col-lg-9 col-md-9">
					<div id="header" class="menu-section">
						<nav class="nav">
							<?php wp_nav_menu( array('theme_location'  => 'primary') ); ?>
						</nav>
					</div>
				</div>
			</div>
		</div>
	</header>
</div>