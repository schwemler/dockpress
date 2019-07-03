<?php
/**
 * Template Name: Page with Right Sidebar
**/

get_header(); ?>

<?php do_action( 'advance_automobile_pageright_header' ); ?>

<div class="container">
    <div class="middle-align row">
        <div class="col-lg-8 col-md-8">
            <?php while ( have_posts() ) : the_post(); ?>
                <img src="<?php the_post_thumbnail_url('full'); ?>" >
                <h1><?php the_title(); ?></h1>
                <?php the_content();?>
            <?php endwhile; // end of the loop. ?>
            <?php
                // If comments are open or we have at least one comment, load up the comment template.
                if ( comments_open() || get_comments_number() ) :
                    comments_template();
                endif;
            ?>
        </div>
        <div id="sidebar" class="col-lg-4 col-md-4">
            <?php dynamic_sidebar('sidebar-2'); ?>
        </div>
        <div class="clear"></div> 
    </div>   
</div>

<?php do_action( 'advance_automobile_pageright_footer' ); ?>

<?php get_footer(); ?>