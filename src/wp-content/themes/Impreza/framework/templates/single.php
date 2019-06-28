<?php defined( 'ABSPATH' ) OR die( 'This script cannot be accessed directly.' );

/**
 * Template to show single page or any post type
 */

$us_layout = US_Layout::instance();

get_header();

global $us_iframe;
if ( ! $us_iframe ) {
	us_load_template( 'templates/titlebar' );
}

?>
<div class="l-main">
	<div class="l-main-h i-cf">

		<main class="l-content"<?php echo ( us_get_option( 'schema_markup' ) ) ? ' itemprop="mainContentOfPage"' : ''; ?>>
			<?php do_action( 'us_before_page' );

			while ( have_posts() ) {
				the_post();

				$content_area_id = is_post_type_archive( 'tribe_events' ) ? '' : us_get_page_area_id( 'content' ); // reset area id for Events Calendar

				if ( $content_area_id != '' AND get_post_status( $content_area_id ) != FALSE ) {
					us_load_template( 'templates/content' );
				} else {
					$the_content = apply_filters( 'the_content', get_the_content() );

					// The page may be paginated itself via <!--nextpage--> tags
					$pagination = wp_link_pages(
						array(
							'before' => '<nav class="post-pagination"><span class="title">' . us_translate( 'Pages:' ) . '</span>',
							'after' => '</nav>',
							'link_before' => '<span>',
							'link_after' => '</span>',
							'echo' => 0,
						)
					);

					// If content has no sections, we'll create them manually
					$has_own_sections = ( strpos( $the_content, ' class="l-section' ) !== FALSE );
					if ( ! ( function_exists( 'vc_is_page_editable' ) AND vc_is_page_editable() ) AND ( ! $has_own_sections OR get_post_type() == 'tribe_events' ) ) {
						$the_content = '<section class="l-section"><div class="l-section-h i-cf">' . $the_content . $pagination . '</div></section>';
					} elseif ( ! empty( $pagination ) ) {
						$the_content .= '<section class="l-section"><div class="l-section-h i-cf">' . $pagination . '</div></section>';
					}

					echo $the_content;

					// Post comments
					if ( comments_open() OR get_comments_number() != '0' ) {

						$show_comments = TRUE;
						// Check comments option of Events Calendar plugin
						if ( function_exists( 'tribe_get_option' ) AND get_post_type() == 'tribe_events' ) {
							$show_comments = tribe_get_option( 'showComments' );
						}

						if ( $show_comments ) {
							?>
							<section class="l-section for_comments">
							<div class="l-section-h i-cf"><?php
								wp_enqueue_script( 'comment-reply' );
								comments_template();
								?></div>
							</section><?php
						}
					}
				}

			}
			do_action( 'us_after_page' );
			?>
		</main>

		<?php us_load_template( 'templates/sidebar' ) ?>

	</div>
</div>

<?php get_footer() ?>
