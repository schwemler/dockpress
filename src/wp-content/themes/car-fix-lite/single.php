<?php
/**
 * The Template for displaying all single posts.
 *
 * @package Car Fix Lite
 */

get_header(); ?>

<div class="container">
     <div class="page_content_builder">
        <section class="content_align_box">            
                <?php while ( have_posts() ) : the_post(); ?>
                    <?php get_template_part( 'content', 'single' ); ?>
                    <?php the_post_navigation(); ?>
                    <div class="clear"></div>
                    <?php
                    // If comments are open or we have at least one comment, load up the comment template
                    if ( comments_open() || '0' != get_comments_number() )
                    	comments_template();
                    ?>
                <?php endwhile; // end of the loop. ?>                  
         </section>       
        <?php get_sidebar();?>
       
        <div class="clear"></div>
    </div><!-- page_content_builder -->
</div><!-- container -->	
<?php get_footer(); ?>