<?php defined( 'ABSPATH' ) OR die( 'This script cannot be accessed directly.' );

/**
 * Shortcode: us_grid
 *
 * Dev note: if you want to change some of the default values or acceptable attributes, overload the element config.
 *
 */

// If we are running US Grid loop already, return nothing
global $us_grid_loop_running;
if ( isset( $us_grid_loop_running ) AND $us_grid_loop_running ) {
	return FALSE;
}
$us_grid_loop_running = TRUE;

$classes = ( ! empty( $el_class ) ) ? ( ' ' . $el_class ) : '';
if ( ! empty( $css ) AND function_exists( 'vc_shortcode_custom_css_class' ) ) {
	$classes .= ' ' . vc_shortcode_custom_css_class( $css );
}

// Grid indexes for CSS, start from 1
global $us_grid_index;
$us_grid_index = isset( $us_grid_index ) ? ( $us_grid_index + 1 ) : 1;

// Get the page we are on for AJAX calls
global $us_is_in_page_block, $us_page_block_id;
if ( isset( $us_is_in_page_block ) AND $us_is_in_page_block AND ! empty( $us_page_block_id ) ) {
	$post_id = $us_page_block_id;
} else {
	$post_id = get_the_ID();
}

// Grid indexes for ajax, start from 1
global $us_grid_ajax_indexes;
$us_grid_ajax_indexes[ $post_id ] = isset( $us_grid_ajax_indexes[ $post_id ] ) ? ( $us_grid_ajax_indexes[ $post_id ] + 1 ) : 1;

// Preparing the query
$query_args = array();
if ( ! empty( $post_type ) AND ! in_array( $post_type, array( 'ids', 'related', 'current_query' ) ) ) {
	$query_args['post_type'] = explode( ',', $post_type );
}
if ( ! empty( $ignore_sticky ) AND $ignore_sticky ) {
	$query_args['ignore_sticky_posts'] = 1;
}

// Exclude the current post from grid
if ( is_singular() ) {
	$current_post_id = get_the_ID();
	if ( ! empty( $current_post_id ) ) {
		$query_args['post__not_in'] = array( $current_post_id );
	}
}

// Posts from selected taxonomies
$known_post_type_taxonomies = us_grid_available_taxonomies();
if ( ! empty( $known_post_type_taxonomies[ $post_type ] ) ) {
	foreach ( $known_post_type_taxonomies[ $post_type ] as $taxonomy ) {
		if ( ! empty( ${'taxonomy_' . $taxonomy} ) ) {
			if ( ! isset( $query_args['tax_query'] ) ) {
				$query_args['tax_query'] = array();
			}
			$query_args['tax_query'][] = array(
				'taxonomy' => $taxonomy,
				'field' => 'slug',
				'terms' => explode( ',', ${'taxonomy_' . $taxonomy} ),
			);
		}
	}
}

// Set posts order
$orderby_translate = array(
	'date' => 'date',
	'date_asc' => 'date',
	'modified' => 'modified',
	'modified_asc' => 'modified',
	'alpha' => 'title',
	'menu_order' => 'menu_order',
);
$order_translate = array(
	'date' => 'DESC',
	'date_asc' => 'ASC',
	'modified' => 'DESC',
	'modified_asc' => 'ASC',
	'alpha' => 'ASC',
	'menu_order' => 'ASC',
);

if ( $orderby == 'post__in' ) {
	$query_args['orderby'] = $orderby; // for 'post__in' needs a string
} elseif ( $orderby == 'rand' ) {
	$rand_int = rand();
	$query_args['orderby'] = 'rand(' . $rand_int . ')';
} else {
	$query_args['orderby'] = array( $orderby_translate[ $orderby ] => $order_translate[ $orderby ] ); // for other cases needs an array
}

// Pagination
if ( $pagination == 'regular' ) {
	$request_paged = is_front_page() ? 'page' : 'paged';
	if ( get_query_var( $request_paged ) ) {
		$query_args['paged'] = get_query_var( $request_paged );
	}
}

// Generate query for Related items
if ( $post_type == 'related' AND ! empty( $related_taxonomy ) ) {
	$current_post_id = get_the_ID();
	$query_args['ignore_sticky_posts'] = 1;
	$query_args['post_type'] = get_post_type( $current_post_id );
	$query_args['tax_query'] = array(
		array(
			'taxonomy' => $related_taxonomy,
			'terms' => wp_get_object_terms( $current_post_id, $related_taxonomy, array( 'fields' => 'ids' ) ),
		),
	);
}

// Generate query for Specific items
if ( ! empty( $ids ) ) {
	$ids = explode( ',', $ids );
	$query_args['ignore_sticky_posts'] = 1;
	$query_args['post_type'] = 'any';
	$query_args['post__in'] = $ids;
}
if ( ! empty( $images ) ) {
	$ids = explode( ',', $images );
	$query_args['post__in'] = $ids;
}

// Generate query for Media attachments
if ( ! empty( $post_type ) AND ( $post_type == 'attachment' ) ) {
	$query_args['post_status'] = 'inherit';
	$query_args['post_mime_type'] = 'image';
} else {
	// Providing proper post statuses
	$query_args['post_status'] = array( 'publish' => 'publish' );
	$query_args['post_status'] += (array) get_post_stati( array( 'public' => TRUE ) );
	// Add private states if user is capable to view them
	if ( is_user_logged_in() AND current_user_can( 'read_private_posts' ) ) {
		$query_args['post_status'] += (array) get_post_stati( array( 'private' => TRUE ) );
	}
	$query_args['post_status'] = array_values( $query_args['post_status'] );
}

// Filter data
$filter = ( ! empty( $post_type ) AND ! empty( ${'filter_' . $post_type} ) ) ? ${'filter_' . $post_type} : 'none';
$filter_taxonomy_name = $filter_default_taxonomies = '';
$filter_taxonomies = array();

if ( $filter != 'none' AND $type != 'carousel' AND ! empty( $post_type ) ) {
	if ( ! empty( ${'filter_' . $post_type} ) ) {
		$filter_taxonomy_name = ${'filter_' . $post_type};
	}
	$terms_args = array(
		'hierarchical' => FALSE,
		'taxonomy' => $filter_taxonomy_name,
		'number' => 100,
	);
	if ( ! empty( ${'taxonomy_' . $filter_taxonomy_name} ) ) {
		$terms_args['slug'] = explode( ',', ${'taxonomy_' . $filter_taxonomy_name} );
		if ( is_user_logged_in() ) {
			$terms_args['hide_empty'] = FALSE;
		}
		$filter_default_taxonomies = ${'taxonomy_' . $filter_taxonomy_name};
	}
	$filter_taxonomies = get_terms( $terms_args );
	if ( isset( $filter_show_all ) AND ! $filter_show_all AND ! empty( $filter_taxonomies[0] ) ) {
		$query_args['tax_query'] = array(
			array(
				'taxonomy' => $filter_taxonomy_name,
				'field' => 'slug',
				'terms' => $filter_taxonomies[0],
			),
		);
	}
}

// Exclude posts of previous grids on the same page
if ( $exclude_items == 'prev' ) {
	global $us_grid_skip_ids;
	if ( ! empty( $us_grid_skip_ids ) AND is_array( $us_grid_skip_ids ) ) {
		if ( empty( $query_args['post__not_in'] ) OR ! is_array( $query_args['post__not_in'] ) ) {
			$query_args['post__not_in'] = array();
		}
		$query_args['post__not_in'] = array_merge( $query_args['post__not_in'], $us_grid_skip_ids );
	}
}

// Posts per page
if ( $items_quantity < 1 ) {
	$items_quantity = 9999;
}
$query_args['posts_per_page'] = $items_quantity;

// Reset query for using on archives
if ( is_archive() OR is_search() OR is_home() ) {
	if ( $post_type == 'current_query' ) {
		$query_args = NULL;
	}
}

// Load Grid Listing template with given params
$template_vars = array(
	'query_args' => $query_args,
	'us_grid_index' => $us_grid_index,
	'us_grid_ajax_indexes' => $us_grid_ajax_indexes,
	'classes' => $classes,
	'post_id' => $post_id,
	'filter' => $filter,
	'filter_taxonomy_name' => $filter_taxonomy_name,
	'filter_default_taxonomies' => $filter_default_taxonomies,
	'filter_taxonomies' => $filter_taxonomies,
);

$default_grid_params = us_shortcode_atts( array(), 'us_grid' );
foreach ( $default_grid_params as $param => $value ) {
	$template_vars[ $param ] = isset( $$param ) ? $$param : $value;
}

us_load_template( 'templates/us_grid/listing', $template_vars );

$us_grid_loop_running = FALSE;
