<?php defined( 'ABSPATH' ) OR die( 'This script cannot be accessed directly.' );

/**
 * Output a single Grid listing. The universal template that is used by all the possible Grid listings.
 *
 * (!) $query_args should be filtered before passing to this template.
 *
 * @var $query_args                   array Arguments for the new WP_Query. If not set, current global $wp_query will be used instead.
 * @var $us_grid_index                int Grid element number on page
 * @var $post_id                      int post or page where Grid element is placed
 * @var $post_type                    string WordPress post type name to show
 * @var $type                         string layout type: 'grid' / 'masonry' / 'carousel'
 * @var $columns                      int Columns quantity
 * @var $exclude_items                bool Exclude some items from the Grid
 * @var $items_offset                 int Items to skip
 * @var $items_gap                    string Gap between items, ex: '10px' / '1em' / '3%'
 * @var $pagination                   string Pagination type: regular / none / ajax / infinite
 * @var $pagination_btn_text          string Pagination Button text
 * @var $pagination_btn_size          string Pagination Button Size
 * @var $pagination_btn_style         string Pagination Button Style
 * @var $pagination_btn_fullwidth     bool Pagination Button Fullwidth
 * @var $items_layout                 string|int Grid Layout ID
 * @var $img_size                     string Post Image size
 * @var $title_size                   string Post Title size
 * @var $carousel_arrows              bool used in Carousel type
 * @var $carousel_dots                bool used in Carousel type
 * @var $carousel_center              bool used in Carousel type
 * @var $carousel_autoplay            bool used in Carousel type
 * @var $carousel_interval            bool used in Carousel type
 * @var $carousel_slideby             bool used in Carousel type
 * @var $breakpoint_1_width           int responsive option
 * @var $breakpoint_1_cols            int responsive option
 * @var $breakpoint_1_autoplay        int responsive option
 * @var $breakpoint_2_width           int responsive option
 * @var $breakpoint_2_cols            int responsive option
 * @var $breakpoint_2_autoplay        int responsive option
 * @var $breakpoint_3_width           int responsive option
 * @var $breakpoint_3_cols            int responsive option
 * @var $breakpoint_3_autoplay        int responsive option
 * @var $filter                       string Filter type: 'none' / 'category'
 * @var $filter_style                 string Filter Bar style: 'style_1' / 'style_2' / ... / 'style_N
 * @var $filter_align                 string Filter Bar Alignment: 'left' / 'center' / 'right'
 * @var $filter_taxonomy_name         string Name of taxonomy to filter by
 * @var $filter_default_taxonomies    string Default taxonomy(ies) for 'All' filter state
 * @var $filter_taxonomies            array List of taxonomies to filter by
 * @var $filter_show_all              bool Show All switch on/off
 * @var $popup_width                  int Popup Width
 * @var $el_class                     string Additional classes that will be appended to the main .w-grid container
 * @var $grid_elm_id                  string DOM element ID
 * @var $is_widget                    bool if used in widget
 * @var $us_grid_ajax_indexes         array Grid element number on each block for ajax calls
 *
 * @action Before the template: 'us_before_template:templates/us_grid/listing'
 * @action After the template: 'us_after_template:templates/us_grid/listing'
 * @filter Template variables: 'us_template_vars:templates/us_grid/listing'
 */

$us_grid_index = isset( $us_grid_index ) ? intval( $us_grid_index ) : 0;
$grid_elm_id = isset( $el_id ) ? $el_id : 'us_grid_' . $us_grid_index;
$post_id = isset( $post_id ) ? $post_id : NULL;
$is_widget = isset( $is_widget ) ? $is_widget : FALSE;
$classes = isset( $classes ) ? $classes : '';
$filter = isset( $filter ) ? $filter : 'none';

$default_grid_params = us_shortcode_atts( array(), 'us_grid' );
foreach ( $default_grid_params as $param => $value ) {
	if ( ! isset( $$param ) ) {
		$$param = $value;
	}
}

if ( ( ! $is_widget ) AND ( $post_id != NULL ) ) {
	$us_grid_ajax_indexes[ $post_id ] = isset( $us_grid_ajax_indexes[ $post_id ] ) ? ( $us_grid_ajax_indexes[ $post_id ] ) : 1;
} else {
	$us_grid_ajax_indexes = NULL;
}

// Determine Grid Layout
if ( ! empty( $items_layout ) ) {
	if ( $templates_config = us_config( 'grid-templates', array(), TRUE ) AND isset( $templates_config[ $items_layout ] ) ) {
		$grid_layout_settings = us_fix_grid_settings( $templates_config[ $items_layout ] );
	} elseif ( $grid_layout = get_post( (int) $items_layout ) ) {
		if ( $grid_layout instanceof WP_Post AND $grid_layout->post_type === 'us_grid_layout' ) {
			if ( ! empty( $grid_layout->post_content ) AND substr( strval( $grid_layout->post_content ), 0, 1 ) === '{' ) {
				try {
					$grid_layout_settings = json_decode( $grid_layout->post_content, TRUE );
				}
				catch ( Exception $e ) {
				}
			}
		}
	}
}

// Output "No Grid Layout"
if ( ! isset( $grid_layout_settings ) OR empty( $grid_layout_settings ) ) {
	echo '<div>Selected Grid Layout is not found. Check the element settings.</div>';

	return;
}

// TODO: maybe move to shortcode's main file?
// Set items offset to WP Query flow
if ( $exclude_items == 'offset' AND abs( intval( $items_offset ) ) > 0 ) {
	global $us_grid_items_offset;
	$us_grid_items_offset = abs( intval( $items_offset ) );
	$query_args['_id'] = 'us_grid';
	add_action( 'pre_get_posts', 'us_grid_query_offset', 1 );
	add_filter( 'found_posts', 'us_grid_adjust_offset_pagination', 1, 2 );
}

// Filter and execute database query
global $wp_query, $us_grid_skip_ids;
if ( empty ( $us_grid_index ) OR ! is_array( $us_grid_skip_ids ) ) {
	$us_grid_skip_ids = array();
}
$use_custom_query = isset( $query_args ) AND is_array( $query_args ) AND ! empty( $query_args );
if ( $use_custom_query ) {
	us_open_wp_query_context();
	$wp_query = new WP_Query( $query_args );
} else {
	$query_args = $wp_query->query;

	// Extracting query arguments from WP_Query that are not shown but relevant
	if ( ! isset( $query_args['post_type'] ) ) {
		$request_where = substr( $wp_query->request, strpos( $wp_query->request, 'WHERE' ) );
		if ( preg_match_all( '~\.post_type = \'([a-z0-9\_\-]+)\'~', $request_where, $matches ) ) {
			$query_args['post_type'] = $matches[1];
		} elseif ( preg_match( '~\.post_type IN (\((\'([a-z0-9\_\-]+)\'(, )?)+\))~', $request_where, $matches ) ) {
			$post_types_str = substr( $matches[1], 2, - 2 );
			$post_types = explode( "', '", $post_types_str );
			$query_args['post_type'] = $post_types;
		}


	}
	if ( ! isset( $query_args['post_status'] ) AND preg_match_all( '~\.post_status = \'([a-z]+)\'~', $wp_query->request, $matches ) ) {
		$query_args['post_status'] = $matches[1];
	}
}

// Output No results
if ( ! have_posts() ) {
	echo '<h4 class="w-grid-none">' . us_translate( 'No results found.' ) . '</h4>';
	if ( $use_custom_query ) {
		us_close_wp_query_context();
	}

	return;
}

// Setting global variable for Image size to use in grid elements
if ( ! empty( $img_size ) AND $img_size != 'default' ) {
	global $us_grid_img_size;
	$us_grid_img_size = $img_size;
}

// Filter Bar HTML
$filter_html = $data_atts = '';
$filter_classes = $filter_style . ' align_' . $filter_align;
if ( $filter != 'none' AND $type != 'carousel' AND $pagination != 'regular' AND ! $is_widget ) {

	// $categories_names already contains only the used categories
	if ( count( $filter_taxonomies ) > 1 ) {
		$filter_html .= '<div class="g-filters ' . $filter_classes . '"><div class="g-filters-list">';

		$active_tab = ' active';
		// Output "All" item
		if ( $filter_show_all ) {
			$filter_html .= '<a class="g-filters-item' . $active_tab . '" href="javascript:void(0)" data-taxonomy="*">';
			$filter_html .= '<span>' . __( 'All', 'us' ) . '</span>';
			$filter_html .= '</a>';
			$active_tab = '';
		}

		// Output taxonomy Items
		foreach ( $filter_taxonomies as $filter_taxonomy ) {
			$filter_html .= '<a class="g-filters-item' . $active_tab . '" href="javascript:void(0)"';
			$filter_html .= ' data-taxonomy="' . $filter_taxonomy->slug . '"';
			$filter_html .= ' data-amount="' . $filter_taxonomy->count . '"';
			$filter_html .= '>';
			$filter_html .= '<span>' . $filter_taxonomy->name . '</span>';
			$filter_html .= '<span class="g-filters-item-amount">' . $filter_taxonomy->count . '</span>';
			$filter_html .= '</a>';
			$active_tab = '';
		}

		$filter_html .= '</div></div>';

		$data_atts .= ' data-filter_taxonomy_name="' . $filter_taxonomy_name . '"';
		if ( ! $filter_show_all ) {
			$filter_default_taxonomies = $filter_taxonomies[0]->slug;
			$data_atts .= ' data-filter_default_taxonomies="' . $filter_default_taxonomies . '"';
		} elseif ( ! empty( $filter_default_taxonomies ) ) {
			$data_atts .= ' data-filter_default_taxonomies="' . $filter_default_taxonomies . '"';
		}
	}
}

// Load listing Start
$template_vars = array(
	'grid_layout_settings' => $grid_layout_settings,
	'us_grid_index' => $us_grid_index,
	'classes' => $classes,
	'filter_html' => $filter_html,
	'is_widget' => $is_widget,
	'data_atts' => $data_atts,
	'query_args' => $query_args,
	'post_id' => $post_id,
	'us_grid_ajax_indexes' => $us_grid_ajax_indexes,
	'wp_query' => $wp_query,
);
foreach ( $default_grid_params as $param => $value ) {
	$template_vars[ $param ] = isset( $$param ) ? $$param : $value;
}
us_load_template( 'templates/us_grid/listing-start', $template_vars );

// Load posts
global $us_grid_listing_post_atts;
$us_grid_listing_post_atts = array(
	'grid_layout_settings' => $grid_layout_settings,
	'type' => $type,
	'is_widget' => $is_widget,
	'overriding_link' => $overriding_link,
);
while ( have_posts() ) {
	the_post();
	$us_grid_skip_ids[] = get_the_ID();
	us_load_template( 'templates/us_grid/listing-post' );
}

// Load listing End
us_load_template( 'templates/us_grid/listing-end', $template_vars );

// If we are in front end editor mode, apply JS to the current grid
if ( function_exists( 'vc_is_page_editable' ) AND vc_is_page_editable() ) {
	echo '<script>
	jQuery(function($){
		if (typeof $us !== "undefined" && typeof $us.WGrid === "function") {
			var $gridContainer = $("#' . $grid_elm_id . '");
			$gridContainer.wGrid();
		}
	});
	</script>';
}

if ( $use_custom_query ) {
	// Cleaning up
	us_close_wp_query_context();
}

// Reset image size for the next grid element
if ( isset( $us_grid_img_size ) ) {
	$us_grid_img_size = 'default';
}
