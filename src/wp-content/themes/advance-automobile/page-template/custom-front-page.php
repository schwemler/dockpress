<?php
/**
 * Template Name: Custom home
 */

get_header(); ?>

<?php do_action( 'advance_automobile_above_slider' ); ?>

<?php if( get_theme_mod( 'advance_automobile_slider_hide') != '') { ?>
  <section id="slider">
    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel"> 
      <?php $pages = array();
        for ( $count = 1; $count <= 4; $count++ ) {
          $mod = intval( get_theme_mod( 'advance_automobile_slider_page' . $count ));
          if ( 'page-none-selected' != $mod ) {
            $pages[] = $mod;
          }
        }
        if( !empty($pages) ) :
          $args = array(
            'post_type' => 'page',
            'post__in' => $pages,
            'orderby' => 'post__in'
          );
          $query = new WP_Query( $args );
          if ( $query->have_posts() ) :
            $i = 1;
      ?>     
      <div class="carousel-inner" role="listbox">
        <?php  while ( $query->have_posts() ) : $query->the_post(); ?>
          <div <?php if($i == 1){echo 'class="carousel-item active"';} else{ echo 'class="carousel-item"';}?>>
            <img src="<?php the_post_thumbnail_url('full'); ?>"/>
            <div class="carousel-caption">
              <div class="inner_carousel">
                <h2><?php the_title(); ?></h2>
                <p><?php $excerpt = get_the_excerpt(); echo esc_html( advance_automobile_string_limit_words( $excerpt,20 ) ); ?></p>
                <div class="read-btn">
                  <a href="<?php the_permalink(); ?>"><?php echo esc_html_e('READ MORE','advance-automobile'); ?></a>
                </div>
              </div>
            </div>
          </div>
        <?php $i++; endwhile; 
        wp_reset_postdata();?>
      </div>
      <?php else : ?>
        <div class="no-postfound"></div>
      <?php endif;
      endif;?>
      <div class="slider-nex-pre">
        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"><i class="fas fa-chevron-left"></i></span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"><i class="fas fa-chevron-right"></i></span>
        </a>
      </div>
    </div>
    <div class="clearfix"></div>
  </section>
<?php } ?>

<?php do_action( 'advance_automobile_below_slider' ); ?>

<section id="contact-details">
  <div class="container">
    <div class="row m-0">
      <?php if( get_theme_mod( 'advance_automobile_address') != '' || get_theme_mod( 'advance_automobile_address1' )!= '') { ?>
      <div class="col-lg-4 col-md-4">
        <div class="address">
          <div class="row">
            <div class="col-lg-2 col-md-3">
              <i class="fas fa-map-marker-alt"></i>
            </div>
            <div class="col-lg-10 col-md-9">
              <?php if( get_theme_mod('advance_automobile_address') != ''){ ?>
                <p class="address-font"><?php echo esc_html( get_theme_mod('advance_automobile_address','')); ?></p>
              <?php } ?>
              <?php if( get_theme_mod('advance_automobile_address1') != ''){ ?>
                <p><?php echo esc_html( get_theme_mod('advance_automobile_address1','')); ?></p>
              <?php } ?>
            </div>
          </div>
        </div>
      </div>
      <?php } ?>
      <?php if( get_theme_mod( 'advance_automobile_time') != '' || get_theme_mod( 'advance_automobile_time1' )!= '') { ?>
      <div class="col-lg-4 col-md-4">
        <div class="time">
          <div class="row">
            <div class="col-lg-2 col-md-3">
              <i class="far fa-clock"></i>
            </div>
            <div class="col-lg-10 col-md-9">
              <?php if( get_theme_mod('advance_automobile_time') != ''){ ?>
                <p class="address-font"><?php echo esc_html( get_theme_mod('advance_automobile_time','')); ?></p>
              <?php } ?>
              <?php if( get_theme_mod('advance_automobile_time1') != ''){ ?>
                <p><?php echo esc_html( get_theme_mod('advance_automobile_time1','')); ?></p>
              <?php } ?>
            </div>
          </div>
        </div>
      </div>
      <?php } ?>
      <?php if( get_theme_mod( 'advance_automobile_call') != '' || get_theme_mod( 'advance_automobile_call1' )!= '') { ?>
      <div class="col-lg-4 col-md-4">
        <div class="address">
          <div class="row">
            <div class="col-lg-2 col-md-3">
              <i class="fas fa-phone"></i>
            </div>
            <div class="col-lg-10 col-md-9">
              <?php if( get_theme_mod('advance_automobile_call') != ''){ ?>
                  <p class="address-font"><?php echo esc_html( get_theme_mod('advance_automobile_call','')); ?></p>
                <?php } ?>
                <?php if( get_theme_mod('advance_automobile_call1') != ''){ ?>
                  <p><?php echo esc_html( get_theme_mod('advance_automobile_call1','')); ?></p>
              <?php } ?>
            </div>
          </div>
        </div>
      </div>
      <?php } ?>
    </div>
  </div>
</section>

<?php do_action( 'advance_automobile_below_contact_section' ); ?>

<?php if( get_theme_mod('advance_automobile_category3') != '' || get_theme_mod( 'advance_automobile_our_services_title' )!= ''){ ?>
  <section id="category">
    <div class="container">
      <?php if( get_theme_mod('advance_automobile_our_services_title') != ''){ ?>
      <h3><?php echo esc_html(get_theme_mod('advance_automobile_our_services_title','')); ?></h3>
      <?php }?>
      <div class="row owl-carousel m-0">
        <?php 
        $catData = get_theme_mod('advance_automobile_category3');
        if($catData){              
        $page_query = new WP_Query(array( 'category_name' => esc_html( $catData ,'advance-automobile')));?>
        <?php while( $page_query->have_posts() ) : $page_query->the_post(); ?>
          <div class="row">
            <div class="col-lg-6 col-md-6">
              <div class="text-content">
                <h4><?php the_title(); ?></h4>
                <p><?php the_excerpt(); ?></p>
                <div class="explore-btn">
                  <a href="<?php the_permalink(); ?>"><?php echo esc_html_e('EXPLORE MORE','advance-automobile'); ?></a>
                </div>
              </div>
            </div>
            <div class="col-lg-6 col-md-6">
              <div class="imagebox">
                <a href="<?php the_permalink(); ?>"><?php if(has_post_thumbnail()) { ?><?php the_post_thumbnail(); ?><?php } ?></a>
              </div>
            </div>
          </div>
          <?php endwhile; 
          wp_reset_postdata();
        }
        ?>
      </div>
    </div>
  </section>
<?php }?>

<?php do_action( 'advance_automobile_below_our_services_section' ); ?>

<div id="content">
  <div class="container">
    <?php while ( have_posts() ) : the_post(); ?>
      <?php the_content(); ?>
    <?php endwhile; // end of the loop. ?>
  </div>
</div>

<?php get_footer(); ?>