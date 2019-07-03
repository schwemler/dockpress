<?php

/**
 * @package WP Product Feed Manager/User Interface/Functions
 * @version 1.1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Add the feed manager menu in the Admin page
 *
 * @param bool $channel_updated default false
 */
function wppfm_add_feed_manager_menu( $channel_updated = false ) {
	// defines the feed manager menu
	add_menu_page(
		__( 'WP Feed Manager', 'wp-product-feed-manager' ),
		__( 'Feed Manager', 'wp-product-feed-manager' ),
		'manage_woocommerce',
		'wp-product-feed-manager',
		'wppfm_feed_manager_main_page',
		esc_url( WPPFM_PLUGIN_URL . '/images/app-rss-plus-xml-icon.png' )
	);

	// add the settings
	add_submenu_page(
		'wp-product-feed-manager',
		__( 'Settings', 'wp-product-feed-manager' ),
		__( 'Settings', 'wp-product-feed-manager' ),
		'manage_woocommerce',
		'wppfm-options-page',
		'wppfm_options_page'
	);
}

add_action( 'admin_menu', 'wppfm_add_feed_manager_menu' );

/**
 * Adds links to the started guide and premium site in the plugin description on the Plugins page
 *
 * @since 2.6.0
 *
 * @param array $actions associative array of action names to anchor tags
 * @param string $plugin_file plugin file name
 * @param array $plugin_data array of plugin data from the plugin file
 * @param string $context plugin status context
 *
 * @return array
 */
function wppfm_plugins_action_links( $actions, $plugin_file, $plugin_data, $context ) {
	$actions['starter_guide'] = '<a href="' . WPPFM_EDD_SL_STORE_URL . '/support/documentation" target="_blank">' . __( 'Starter Guide', 'wp-product-feed-manager' ) . '</a>';

	if ( 'WP Product Feed Manager' === WPPFM_EDD_SL_ITEM_NAME ) {
		$actions['go_premium'] = '<a style="color:green;" href="' . WPPFM_EDD_SL_STORE_URL . '" target="_blank"><b>' . __( 'Go Premium', 'wp-product-feed-manager' ) . '</b></a>';
	} else {
		$actions['support'] = '<a href="' . WPPFM_EDD_SL_STORE_URL . '/support" target="_blank">' . __( 'Get Support', 'wp-product-feed-manager' ) . '</a>';
	}

	return $actions;
}

add_filter( 'plugin_action_links_' . WPPFM_PLUGIN_CONSTRUCTOR, 'wppfm_plugins_action_links', 10, 4 );

function wppfm_feed_manager_main_page() {

	global $wppfm_tab_data;

	$active_tab          = isset( $_GET['tab'] ) ? $_GET['tab'] : 'feed-list';
	$page_start_function = 'wppfm_main_admin_page'; // default

	$list_tab = new WPPFM_Tab(
		'feed-list',
		'feed-list' === $active_tab ? true : false,
		__( 'Feed List', 'wp-product-feed-manager' ),
		'wppfm_main_admin_page'
	);

	$product_feed_tab = new WPPFM_Tab(
		'product-feed',
		'product-feed' === $active_tab ? true : false,
		__( 'Product Feed', 'wp-product-feed-manager' ),
		'wppfm_add_product_feed_page'
	);

	$wppfm_tab_data = apply_filters( 'wppfm_main_form_tabs', array( $list_tab, $product_feed_tab ), $active_tab );

	foreach ( $wppfm_tab_data as $tab ) {
		if ( $tab->get_page_identifier() === $active_tab ) {
			$page_start_function = $tab->get_class_identifier();
			break;
		}
	}

	$page_start_function();
}

/**
 * starts the main admin page
 */
function wppfm_main_admin_page() {
	$start = new WPPFM_Main_Admin_Page();

	// now let's get things going
	$start->show();
}

function wppfm_add_product_feed_page() {
	$add_new_feed_page = new WPPFM_Product_Feed_Page();
	$add_new_feed_page->show();
}

/**
 * options page
 */
function wppfm_options_page() {
	$add_options_page = new WPPFM_Add_Options_Page();
	$add_options_page->show();
}

/**
 * Checks if the backups are valid for the current database version and warns the user if not
 *
 * @since 1.9.6
 */
function wppfm_check_backups() {
	if ( ! wppfm_check_backup_status() ) {
		$msg = __( 'Due to the latest update your Feed Manager backups are no longer valid! Please open the Feed Manager Settings page, remove all your backups in and make a new one.', 'wp-product-feed-manager' )
		?>
		<div class="notice notice-warning is-dismissible">
		<p><?php echo $msg; ?></p>
		</div>
		<?php
	}
}

add_action( 'admin_notices', 'wppfm_check_backups' );

/**
 * Sets the global background process
 *
 * @since 1.10.0
 *
 * @global WPPFM_Feed_Processor $background_process
 */
function initiate_background_process() {
	global $background_process;

	if( isset( $_GET['tab'] ) ) {
		$active_tab = $_GET['tab'];
		set_transient( 'wppfm_set_global_background_process', $active_tab, WPPFM_TRANSIENT_LIVE );
	} else {
		$active_tab = ! get_transient( 'wppfm_set_global_background_process' ) ? 'feed-list' : get_transient( 'wppfm_set_global_background_process' );
	}

	if ( ( 'product-feed' === $active_tab || 'feed-list' === $active_tab ) ) {
		if ( ! class_exists( 'WPPFM_Feed_Processor' ) ) {
			require_once( __DIR__ . '/../application/class-wppfm-feed-processor.php' );
		}

		$background_process = new WPPFM_Feed_Processor();
	}

	if ( 'product-review-feed' === $active_tab ) {
		if ( ! class_exists( 'WPPRFM_Review_Feed_Processor' ) ) {
			require_once( __DIR__ . '/../../../wp-product-review-feed-manager/includes/classes/class-wpprfm-review-feed-processor.php' );
		}

		$background_process = new WPPRFM_Review_Feed_Processor();
	}
}

// register the background process
add_action( 'wp_loaded', 'initiate_background_process' );

/**
 * Returns an array of possible feed types that can be altered using the wppfm_feed_types filter.
 *
 * @return array with possible feed types
 */
function wppfm_list_feed_type_text() {

	return apply_filters(
		'wppfm_feed_types',
		array(
			'1' => 'Product Feed',
		)
	);
}
