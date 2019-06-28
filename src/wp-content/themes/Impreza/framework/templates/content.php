<?php defined( 'ABSPATH' ) OR die( 'This script cannot be accessed directly.' );

/**
 * Outputs page's Content Page Block
 *
 * (!) Should be called after the current $wp_query is already defined
 *
 * @action Before the template: 'us_before_template:templates/content'
 * @action After the template: 'us_after_template:templates/content'
 * @filter Template variables: 'us_template_vars:templates/content'
 */

$page_block_id = us_get_page_area_id( 'content' );

// Output content of Page Block (us_page_block) post
$page_block_content = '';
if ( $page_block_id != '' ) {

	$page_block = get_post( (int) $page_block_id );

	us_open_wp_query_context();
	if ( $page_block ) {
		$translated_page_block_id = apply_filters( 'wpml_object_id', $page_block->ID, 'us_page_block', TRUE );
		if ( $translated_page_block_id != $page_block->ID ) {
			$page_block = get_post( $translated_page_block_id );
		}
		global $wp_query, $vc_manager, $us_is_in_page_block, $us_page_block_id;
		$us_is_in_page_block = TRUE;
		$us_page_block_id = $translated_page_block_id;
		$wp_query = new WP_Query(
			array(
				'p' => $translated_page_block_id,
				'post_type' => 'any',
			)
		);
		if ( ! empty( $vc_manager ) AND is_object( $vc_manager ) ) {
			$vc_manager->vc()->addPageCustomCss( $translated_page_block_id );
			$vc_manager->vc()->addShortcodesCustomCss( $translated_page_block_id );
		}
		$page_block_content = $page_block->post_content;
	}
	us_close_wp_query_context();

	// Apply filters to Page Block content and echoing it ouside of us_open_wp_query_context,
	// so all WP widgets (like WP Nav Menu) would work as they should
	echo apply_filters( 'us_page_block_the_content', $page_block_content );

	$us_is_in_page_block = FALSE;
}
