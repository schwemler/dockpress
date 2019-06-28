<?php defined( 'ABSPATH' ) OR die( 'This script cannot be accessed directly.' );

$misc = us_config( 'elements_misc' );
$design_options = us_config( 'elements_design_options' );

// Get the available taxonomies for selection
$taxonomies_options = us_get_taxonomies();

// Get the available post types for selection
$available_posts_types = us_grid_available_post_types( TRUE );

// Fetching the available taxonomies for selection
$taxonomies_params = $filter_taxonomies_params = $available_taxonomies = array();

$known_post_type_taxonomies = us_grid_available_taxonomies();

foreach ( $known_post_type_taxonomies as $post_type => $taxonomy_slugs ) {
	if ( isset( $available_posts_types[ $post_type ] ) ) {
		$filter_values = array();
		foreach ( $taxonomy_slugs as $taxonomy_slug ) {
			$taxonomy_class = get_taxonomy( $taxonomy_slug );
			if ( ! empty( $taxonomy_class ) AND ! empty( $taxonomy_class->labels ) AND ! empty( $taxonomy_class->labels->name ) ) {
				if ( isset ( $available_taxonomies[ $taxonomy_slug ] ) ) {
					$available_taxonomies[ $taxonomy_slug ]['post_type'][] = $post_type;
				} else {
					$available_taxonomies[ $taxonomy_slug ] = array(
						'name' => $taxonomy_class->labels->name,
						'post_type' => array( $post_type ),
					);
				}
				$filter_value_label = $taxonomy_class->labels->name;
				$filter_values[ $taxonomy_slug ] = $filter_value_label;
			}
		}
		if ( count( $filter_values ) > 0 ) {
			$filter_taxonomies_params[ 'filter_' . $post_type ] = array(
				'title' => __( 'Filter by', 'us' ),
				'type' => 'select',
				'options' => array_merge(
					array( '' => '– ' . us_translate( 'None' ) . ' –' ), $filter_values
				),
				'std' => '',
				'show_if' => array( 'post_type', '=', $post_type ),
				'group' => us_translate( 'Filter' ),
			);
		}

	}
}

foreach ( $available_taxonomies as $taxonomy_slug => $taxonomy ) {
	$taxonomy_items = array();
	$taxonomy_items_raw = get_categories(
		array(
			'taxonomy' => $taxonomy_slug,
			'hierarchical' => 0,
			'hide_empty' => FALSE,
			'number' => 200,
		)
	);
	if ( $taxonomy_items_raw ) {
		foreach ( $taxonomy_items_raw as $taxonomy_item_raw ) {
			if ( is_object( $taxonomy_item_raw ) ) {
				$taxonomy_items[ $taxonomy_item_raw->slug ] = $taxonomy_item_raw->name;
			}
		}
		if ( count( $taxonomy_items ) > 0 ) {
			// Do not output the only category of Posts
			if ( $taxonomy_slug == 'category' AND count( $taxonomy_items ) == 1 ) {
				continue;
			}
			foreach ( $taxonomy['post_type'] as $taxonomy_post_type ) {
				$taxonomies_params[ 'taxonomy_' . $taxonomy_slug ] = array(
					'title' => sprintf( __( 'Show Items of selected %s', 'us' ), $taxonomy['name'] ),
					'type' => 'checkboxes',
					'options' => $taxonomy_items,
					'show_if' => array( 'post_type', 'in_array', $taxonomy['post_type'] ),
				);
			}

		}
	}
}

$default_layout_templates = array();
$templates_config = us_config( 'grid-templates', array(), TRUE );
foreach ( $templates_config as $template_name => $template ) {
	$default_layout_templates[ $template['title'] ] = $template_name;
}

$grid_config = array(
	'title' => __( 'Grid', 'us' ),
	'description' => __( 'List of images, posts, pages or any custom post types', 'us' ),
	'icon' => 'fas fa-th-large',
	'params' => array(),
);

// General
$general_params = array_merge(
	array(

		'post_type' => array(
			'title' => us_translate( 'Show' ),
			'type' => 'select',
			'options' => array_merge(
				$available_posts_types, array(
					'ids' => __( 'Specific items', 'us' ),
					'related' => __( 'Items with the same taxonomy of current post', 'us' ),
					'current_query' => __( 'Items of the current query (used for archives and search results)', 'us' ),
				)
			),
			'std' => 'post',
			'admin_label' => TRUE,
		),
		'related_taxonomy' => array(
			'type' => 'select',
			'options' => $taxonomies_options,
			'std' => 'category',
			'classes' => 'for_above',
			'show_if' => array( 'post_type', '=', 'related' ),
		),
		'ids' => array(
			'type' => 'autocomplete',
			'settings' => array(
				'multiple' => TRUE,
				'sortable' => TRUE,
				'unique_values' => TRUE,
			),
			'save_always' => TRUE,
			'classes' => 'for_above',
			'show_if' => array( 'post_type', '=', 'ids' ),
		),
		'images' => array(
			'title' => us_translate( 'Images' ),
			'type' => 'upload',
			'is_multiple' => TRUE,
			'extension' => 'png,jpg,jpeg,gif,svg',
			'show_if' => array( 'post_type', '=', 'attachment' ),
		),
		'ignore_sticky' => array(
			'type' => 'switch',
			'switch_text' => __( 'Ignore sticky posts', 'us' ),
			'std' => FALSE,
			'classes' => 'for_above',
			'show_if' => array( 'post_type', '=', 'post' ),
		),
	), $taxonomies_params, array(
		'orderby' => array(
			'title' => us_translate( 'Order' ),
			'type' => 'select',
			'options' => array(
				'date' => __( 'By date of creation (newer first)', 'us' ),
				'date_asc' => __( 'By date of creation (older first)', 'us' ),
				'modified' => __( 'By date of update (newer first)', 'us' ),
				'modified_asc' => __( 'By date of update (older first)', 'us' ),
				'alpha' => __( 'Alphabetically', 'us' ),
				'rand' => us_translate( 'Random' ),
				'menu_order' => sprintf( __( 'By "%s" values from "%s" box', 'us' ), us_translate( 'Order' ), us_translate( 'Page Attributes' ) ),
				'post__in' => __( 'Manually for images and specific items', 'us' ),
			),
			'std' => 'date',
			'show_if' => array( 'post_type', '!=', 'current_query' ),
		),
		'items_quantity' => array(
			'title' => __( 'Items Quantity', 'us' ),
			'type' => 'text',
			'std' => '10',
			'cols' => 2,
			'show_if' => array( 'post_type', '!=', 'current_query' ),
		),
		'exclude_items' => array(
			'title' => __( 'Exclude Items', 'us' ),
			'type' => 'select',
			'options' => array(
				'none' => us_translate( 'None' ),
				'prev' => __( 'of previous Grids on this page', 'us' ),
				'offset' => __( 'by the given quantity from the beginning of output', 'us' ),
			),
			'std' => 'none',
			'cols' => 2,
			'show_if' => array( 'post_type', '!=', 'current_query' ),
		),
		'items_offset' => array(
			'title' => __( 'Items Quantity to skip', 'us' ),
			'type' => 'text',
			'std' => '1',
			'show_if' => array( 'exclude_items', '=', 'offset' ),
		),
		'pagination' => array(
			'title' => us_translate( 'Pagination' ),
			'type' => 'select',
			'options' => array(
				'none' => us_translate( 'None' ),
				'regular' => __( 'Numbered pagination', 'us' ),
				'ajax' => __( 'Load items on button click', 'us' ),
				'infinite' => __( 'Load items on page scroll', 'us' ),
			),
			'std' => 'none',
			'show_if' => array( 'type', 'in_array', array( 'grid', 'masonry' ) ),
		),
		'pagination_btn_text' => array(
			'title' => __( 'Button Label', 'us' ),
			'type' => 'text',
			'std' => __( 'Load More', 'us' ),
			'cols' => 2,
			'show_if' => array( 'pagination', '=', 'ajax' ),
		),
		'pagination_btn_size' => array(
			'title' => __( 'Button Size', 'us' ),
			'description' => $misc['desc_font_size'],
			'type' => 'text',
			'std' => '',
			'cols' => 2,
			'show_if' => array( 'pagination', '=', 'ajax' ),
		),
		'pagination_btn_style' => array(
			'title' => __( 'Button Style', 'us' ),
			'description' => $misc['desc_btn_styles'],
			'type' => 'select',
			'options' => us_get_btn_styles(),
			'std' => '1',
			'show_if' => array( 'pagination', '=', 'ajax' ),
		),
		'pagination_btn_fullwidth' => array(
			'type' => 'switch',
			'switch_text' => __( 'Stretch to the full width', 'us' ),
			'std' => FALSE,
			'show_if' => array( 'pagination', '=', 'ajax' ),
		),
	)
);

// Appearance
$appearance_params = array(
	'items_layout' => array(
		'title' => __( 'Grid Layout', 'us' ),
		'type' => 'us_grid_layout',
		'admin_label' => TRUE,
		'std' => 'blog_1',
		'group' => us_translate( 'Appearance' ),
	),
	'type' => array(
		'title' => __( 'Display as', 'us' ),
		'type' => 'select',
		'options' => array(
			'grid' => __( 'Regular Grid', 'us' ),
			'masonry' => __( 'Masonry', 'us' ),
			'carousel' => __( 'Carousel', 'us' ),
		),
		'std' => 'grid',
		'admin_label' => TRUE,
		'group' => us_translate( 'Appearance' ),
	),
	'items_valign' => array(
		'switch_text' => __( 'Center items vertically', 'us' ),
		'type' => 'switch',
		'std' => FALSE,
		'classes' => 'for_above',
		'show_if' => array( 'type', '!=', 'masonry' ),
		'group' => us_translate( 'Appearance' ),
	),
	'columns' => array(
		'title' => us_translate( 'Columns' ),
		'type' => 'select',
		'options' => array(
			'1' => '1',
			'2' => '2',
			'3' => '3',
			'4' => '4',
			'5' => '5',
			'6' => '6',
			'7' => '7',
			'8' => '8',
			'9' => '9',
			'10' => '10',
		),
		'std' => '2',
		'admin_label' => TRUE,
		'cols' => 2,
		'group' => us_translate( 'Appearance' ),
	),
	'items_gap' => array(
		'title' => __( 'Gap between Items', 'us' ),
		'description' => sprintf( __( 'Examples: %s', 'us' ), '<span class="usof-example">5px</span>, <span class="usof-example">1.5rem</span>, <span class="usof-example">2vw</span>' ),
		'type' => 'text',
		'std' => '1.5rem',
		'cols' => 2,
		'group' => us_translate( 'Appearance' ),
	),
	'img_size' => array(
		'title' => __( 'Post Image Size', 'us' ),
		'description' => $misc['desc_img_sizes'],
		'type' => 'select',
		'options' => array_merge(
			array( 'default' => __( 'As in Grid Layout', 'us' ) ), us_image_sizes_select_values()
		),
		'std' => 'default',
		'cols' => 2,
		'group' => us_translate( 'Appearance' ),
	),
	'title_size' => array(
		'title' => __( 'Post Title Size', 'us' ),
		'description' => $misc['desc_font_size'],
		'type' => 'text',
		'std' => '',
		'cols' => 2,
		'group' => us_translate( 'Appearance' ),
	),
	'overriding_link' => array(
		'title' => __( 'Overriding Link', 'us' ),
		'description' => __( 'Applies to every item of this Grid. All Grid Layout elements become not clickable.', 'us' ),
		'type' => 'select',
		'options' => array(
			'none' => us_translate( 'None' ),
			'post' => __( 'To a Post', 'us' ),
			'popup_post' => __( 'Opens a Post in a popup', 'us' ),
			'popup_post_image' => __( 'Opens a Post Image in a popup', 'us' ),
		),
		'std' => 'none',
		'group' => us_translate( 'Appearance' ),
	),
	'popup_width' => array(
		'title' => __( 'Popup Width', 'us' ),
		'description' => $misc['desc_width'],
		'type' => 'text',
		'std' => '',
		'show_if' => array( 'overriding_link', '=', 'popup_post' ),
		'group' => us_translate( 'Appearance' ),
	),
	'popup_arrows' => array(
		'switch_text' => __( 'Prev/Next arrows', 'us' ),
		'type' => 'switch',
		'std' => TRUE,
		'show_if' => array( 'overriding_link', '=', 'popup_post' ),
		'group' => us_translate( 'Appearance' ),
	),
);

// Carousel
$carousel_params = array(
	'carousel_arrows' => array(
		'type' => 'switch',
		'switch_text' => __( 'Prev/Next arrows', 'us' ),
		'std' => FALSE,
		'show_if' => array( 'type', '=', 'carousel' ),
		'group' => __( 'Carousel', 'us' ),
	),
	'carousel_arrows_style' => array(
		'title' => __( 'Arrows Style', 'us' ),
		'type' => 'select',
		'options' => array(
			'circle' => __( 'Circles', 'us' ),
			'block' => __( 'Full height blocks', 'us' ),
		),
		'std' => 'circle',
		'cols' => 2,
		'show_if' => array( 'carousel_arrows', '!=', FALSE ),
		'group' => __( 'Carousel', 'us' ),
	),
	'carousel_arrows_pos' => array(
		'title' => __( 'Arrows Position', 'us' ),
		'type' => 'select',
		'options' => array(
			'outside' => __( 'Outside', 'us' ),
			'inside' => __( 'Inside', 'us' ),
		),
		'std' => 'outside',
		'cols' => 2,
		'show_if' => array( 'carousel_arrows', '!=', FALSE ),
		'group' => __( 'Carousel', 'us' ),
	),
	'carousel_arrows_size' => array(
		'title' => __( 'Arrows Size', 'us' ),
		'description' => sprintf( __( 'Examples: %s', 'us' ), '<span class="usof-example">26px</span>, <span class="usof-example">3rem</span>' ),
		'type' => 'text',
		'std' => '1.8rem',
		'cols' => 2,
		'show_if' => array( 'carousel_arrows', '!=', FALSE ),
		'group' => __( 'Carousel', 'us' ),
	),
	'carousel_arrows_offset' => array(
		'title' => __( 'Arrows Offset', 'us' ),
		'description' => sprintf( __( 'Examples: %s', 'us' ), '<span class="usof-example">20px</span>, <span class="usof-example">2rem</span>' ),
		'type' => 'text',
		'std' => '',
		'cols' => 2,
		'show_if' => array( 'carousel_arrows', '!=', FALSE ),
		'group' => __( 'Carousel', 'us' ),
	),
	'carousel_dots' => array(
		'type' => 'switch',
		'switch_text' => __( 'Navigation Dots', 'us' ),
		'std' => FALSE,
		'show_if' => array( 'type', '=', 'carousel' ),
		'group' => __( 'Carousel', 'us' ),
	),
	'carousel_center' => array(
		'type' => 'switch',
		'switch_text' => __( 'First item in the center', 'us' ),
		'std' => FALSE,
		'show_if' => array( 'type', '=', 'carousel' ),
		'group' => __( 'Carousel', 'us' ),
	),
	'carousel_slideby' => array(
		'type' => 'switch',
		'switch_text' => __( 'Slide by several items instead of one', 'us' ),
		'std' => FALSE,
		'show_if' => array( 'type', '=', 'carousel' ),
		'group' => __( 'Carousel', 'us' ),
	),
	'carousel_autoplay' => array(
		'type' => 'switch',
		'switch_text' => __( 'Enable Auto Rotation', 'us' ),
		'std' => FALSE,
		'show_if' => array( 'type', '=', 'carousel' ),
		'group' => __( 'Carousel', 'us' ),
	),
	'carousel_interval' => array(
		'title' => __( 'Auto Rotation Interval (in seconds)', 'us' ),
		'type' => 'text',
		'std' => '3',
		'show_if' => array( 'carousel_autoplay', '!=', FALSE ),
		'group' => __( 'Carousel', 'us' ),
	),
	'carousel_autoplay_smooth' => array(
		'type' => 'switch',
		'switch_text' => __( 'Smooth Rotation', 'us' ),
		'std' => FALSE,
		'classes' => 'for_above',
		'show_if' => array( 'carousel_autoplay', '!=', FALSE ),
		'group' => __( 'Carousel', 'us' ),
	),
	'carousel_speed' => array(
		'title' => __( 'Slide Speed (in milliseconds)', 'us' ),
		'type' => 'text',
		'std' => '250',
		'show_if' => array( 'type', '=', 'carousel' ),
		'group' => __( 'Carousel', 'us' ),
	),
	'carousel_transition' => array(
		'title' => __( 'Transition Effect', 'us' ),
		'description' => '<a href="http://cubic-bezier.com/" target="_blank">' . __( 'Use timing function', 'us' ) . '</a>' . '. ' . sprintf( __( 'Examples: %s', 'us' ), '<span class="usof-example">linear</span>, <span class="usof-example">cubic-bezier(0,1,.8,1)</span>, <span class="usof-example">cubic-bezier(.78,.13,.15,.86)</span>' ),
		'type' => 'text',
		'std' => '',
		'show_if' => array( 'type', '=', 'carousel' ),
		'group' => __( 'Carousel', 'us' ),
	),
);

// Filter
$filter_params = array_merge(
	$filter_taxonomies_params, array(
		'filter_style' => array(
			'title' => __( 'Filter Bar Style', 'us' ),
			'type' => 'select',
			'options' => array(
				'style_1' => us_translate( 'Style' ) . ' 1',
				'style_2' => us_translate( 'Style' ) . ' 2',
				'style_3' => us_translate( 'Style' ) . ' 3',
			),
			'std' => 'style_1',
			'cols' => 2,
			'show_if' => array( 'post_type', 'in_array', array_keys( $known_post_type_taxonomies ) ),
			'group' => us_translate( 'Filter' ),
		),
		'filter_align' => array(
			'title' => __( 'Filter Bar Alignment', 'us' ),
			'type' => 'select',
			'options' => array(
				'left' => us_translate( 'Left' ),
				'center' => us_translate( 'Center' ),
				'right' => us_translate( 'Right' ),
			),
			'std' => 'center',
			'cols' => 2,
			'show_if' => array( 'post_type', 'in_array', array_keys( $known_post_type_taxonomies ) ),
			'group' => us_translate( 'Filter' ),
		),
		'filter_show_all' => array(
			'switch_text' => __( 'Show "All" item in filter bar', 'us' ),
			'type' => 'switch',
			'std' => TRUE,
			'show_if' => array( 'post_type', 'in_array', array_keys( $known_post_type_taxonomies ) ),
			'group' => us_translate( 'Filter' ),
		),
	)
);

// Responsive Options
$responsive_params = array(
	'breakpoint_1_width' => array(
		'title' => __( 'Below screen width', 'us' ),
		'type' => 'text',
		'std' => '1200px',
		'cols' => 2,
		'group' => us_translate( 'Responsive Options', 'js_composer' ),
	),
	'breakpoint_1_cols' => array(
		'title' => __( 'show', 'us' ),
		'type' => 'select',
		'options' => $misc['column_values'],
		'std' => '3',
		'cols' => 2,
		'group' => us_translate( 'Responsive Options', 'js_composer' ),
	),
	'breakpoint_1_autoplay' => array(
		'type' => 'switch',
		'switch_text' => __( 'Enable Auto Rotation', 'us' ),
		'std' => TRUE,
		'classes' => 'for_above',
		'show_if' => array( 'type', '=', 'carousel' ),
		'group' => us_translate( 'Responsive Options', 'js_composer' ),
	),
	'breakpoint_2_width' => array(
		'title' => __( 'Below screen width', 'us' ),
		'type' => 'text',
		'std' => '900px',
		'cols' => 2,
		'group' => us_translate( 'Responsive Options', 'js_composer' ),
	),
	'breakpoint_2_cols' => array(
		'title' => __( 'show', 'us' ),
		'type' => 'select',
		'options' => $misc['column_values'],
		'std' => '2',
		'cols' => 2,
		'group' => us_translate( 'Responsive Options', 'js_composer' ),
	),
	'breakpoint_2_autoplay' => array(
		'type' => 'switch',
		'switch_text' => __( 'Enable Auto Rotation', 'us' ),
		'std' => TRUE,
		'classes' => 'for_above',
		'show_if' => array( 'type', '=', 'carousel' ),
		'group' => us_translate( 'Responsive Options', 'js_composer' ),
	),
	'breakpoint_3_width' => array(
		'title' => __( 'Below screen width', 'us' ),
		'type' => 'text',
		'std' => '600px',
		'cols' => 2,
		'group' => us_translate( 'Responsive Options', 'js_composer' ),
	),
	'breakpoint_3_cols' => array(
		'title' => __( 'show', 'us' ),
		'type' => 'select',
		'options' => $misc['column_values'],
		'std' => '1',
		'cols' => 2,
		'group' => us_translate( 'Responsive Options', 'js_composer' ),
	),
	'breakpoint_3_autoplay' => array(
		'type' => 'switch',
		'switch_text' => __( 'Enable Auto Rotation', 'us' ),
		'std' => TRUE,
		'classes' => 'for_above',
		'show_if' => array( 'type', '=', 'carousel' ),
		'group' => us_translate( 'Responsive Options', 'js_composer' ),
	),
);

$grid_config['params'] = array_merge(
	$general_params, $appearance_params, $carousel_params, $filter_params, $responsive_params, $design_options
);

return $grid_config;
