<?php defined( 'ABSPATH' ) OR die( 'This script cannot be accessed directly.' );

/**
 * The template for displaying the 404 page
 */

$posts_page = get_post( us_get_option( 'posts_page' ) );

// Output specific page
if ( $posts_page ) {
	$posts_page = get_post( apply_filters( 'wpml_object_id', $posts_page->ID, 'page', TRUE ) );

	get_header();

	us_load_template( 'templates/titlebar' );
	?>
	<div class="l-main">
		<div class="l-main-h i-cf">
			<main class="l-content"<?php echo ( us_get_option( 'schema_markup' ) ) ? ' itemprop="mainContentOfPage"' : ''; ?>>

				<?php
				do_action( 'us_before_page' );

				us_open_wp_query_context();
				global $wp_query, $vc_manager;

				$wp_query = new WP_Query(
					array(
						'p' => $posts_page->ID,
						'post_type' => 'any',
					)
				);

				if ( ! empty( $vc_manager ) AND is_object( $vc_manager ) ) {
					$vc_manager->vc()->addPageCustomCss( $posts_page->ID );
					$vc_manager->vc()->addShortcodesCustomCss( $posts_page->ID );
				}

				us_close_wp_query_context();

				// Setting search page ID as $us_page_block_id for grid shortcodes
				global $us_is_in_page_block, $us_page_block_id;
				$us_is_in_page_block = TRUE;
				$us_page_block_id = $posts_page->ID;

				$the_content = apply_filters( 'the_content', $posts_page->post_content );
				echo $the_content;

				$us_is_in_page_block = FALSE;

				do_action( 'us_after_page' );
				?>

			</main>

			<?php us_load_template( 'templates/sidebar' ) ?>

		</div>
	</div>
	<?php

	get_footer();

	// Output default archive layout
} else {
	us_load_template( 'templates/archive' );
}
