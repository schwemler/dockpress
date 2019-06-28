<?php defined( 'ABSPATH' ) OR die( 'This script cannot be accessed directly.' );

/**
 * The template for displaying Archive Pages
 */

$us_layout = US_Layout::instance();

get_header();

// Output Title Bar
$titlebar_vars = array();
if ( is_category() OR is_tag() OR is_tax() ) {
	$term = get_queried_object();
	if ( $term ) {
		$taxonomy = $term->taxonomy;
		$term = $term->term_id;
	}
	$titlebar_vars['subtitle'] = nl2br( get_term_field( 'description', $term, $taxonomy, 'edit' ) );
}
us_load_template( 'templates/titlebar', $titlebar_vars );

?>
<div class="l-main">
	<div class="l-main-h i-cf">

		<main class="l-content"<?php echo ( us_get_option( 'schema_markup' ) ) ? ' itemprop="mainContentOfPage"' : ''; ?>>
			<?php
			$content_area_id = us_get_page_area_id( 'content' );

			if ( $content_area_id != '' AND get_post_status( $content_area_id ) != FALSE ) {
				us_load_template( 'templates/content' );
			} else {
			?>
			<section class="l-section<?php echo ( us_get_option( 'row_height' ) == 'small' ) ? ' height_small' : ''; ?>">
				<div class="l-section-h i-cf">

					<?php
					do_action( 'us_before_archive' );
					global $us_grid_loop_running;
					$us_grid_loop_running = TRUE;

					// Use Grid element with default values and "Regular" pagination
					us_load_template( 'templates/us_grid/listing', array( 'pagination' => 'regular' ) ); 

					$us_grid_loop_running = FALSE;
					do_action( 'us_after_archive' );
					?>

				</div>
			</section>
			<?php } ?>
		</main>

		<?php us_load_template( 'templates/sidebar' ) ?>

	</div>
</div>

<?php get_footer() ?>
