<?php

/**
 * WPPFM Form Element Class.
 *
 * @package WP Product Feed Manager/User Interface/Classes
 * @since 2.4.0
 * @version 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'WPPFM_Form_Element' ) ) :

	/**
	 * WPPFM Category Selector Element Class
	 *
	 * Contains the html elements code for the forms
	 */
	class WPPFM_Form_Element {

		/**
		 * Returns the code for the tabs in all main forms
		 *
		 * @return string html code for the tabs
		 */
		public static function main_form_tabs() {

			// Get the WPPFM_Tab objects
			$tabs = $GLOBALS['wppfm_tab_data'];

			$html_code = '<h2 class="nav-tab-wrapper">';

			// Html for the tabs
			foreach ( $tabs as $tab ) {
				$html_code .= '<a href="admin.php?' . $tab->get_page_tab_url() . '"';
				$html_code .= 'class="nav-tab' . $tab->tab_selected_string() . '">' . $tab->get_tab_title() . '</a>';
			}

			$html_code .= '</h2>';

			return $html_code;
		}

		/**
		 * Returns the code that stores product feed specific data in the page source code.
		 *
		 * @return string
		 */
		public static function data_holder() {
			$feed_data_to_store  = json_encode( self::ajax_feed_data_to_database_array() );

			$html_code  = '<var id="wppfm-ajax-feed-data-to-database-conversion-array" style="display:none;">' . $feed_data_to_store . '</var>';

			return $html_code;
		}

		/**
		 * Returns the code for both Save & Generate and Save buttons.
		 *
		 * @param   string  $generate_button_id ID for the Save & Generate button
		 * @param   string  $save_button_id     ID for the Save button
		 * @param   string  $initial_display    sets the initial display to any of the display style options (default none)
		 *
		 * @return string
		 */
		public static function feed_generation_buttons( $generate_button_id, $save_button_id, $initial_display = 'none' ) {
			return '<div class="button-wrapper" id="page-center-buttons" style="display:' . $initial_display . ';">
				<input class="button-primary" type="button" name="generate-top"
					value="' . __( 'Save & Generate Feed', 'wp-product-feed-manager' ) .
					'" id="' . $generate_button_id . '" disabled/>
				<input class="button-primary" type="button" name="save-top"
					value="' . __( 'Save Feed', 'wp-product-feed-manager' ) .
					'" id="' . $save_button_id . '" disabled/>
				</div>';
		}

		/**
		 * Returns the code for the Open Feed List button.
		 *
		 * @return string
		 */
		public static function open_feed_list_button() {
			return '<div class="button-wrapper" id="page-bottom-buttons" style="display:none;"><input class="button-primary" type="button" ' .
				'onclick="parent.location=\'admin.php?page=wp-product-feed-manager\'" name="new" value="' .
				__( 'Open Feed List', 'wp-product-feed-manager' ) . '" id="add-new-feed-button" /></div>';
		}

		/**
		 * Returns a conversion table between the ajax data items from a feed generation process to the corresponding database items.
		 *
		 * @since 2.5.0
		 *
		 * @return mixed|void
		 */
		private static function ajax_feed_data_to_database_array() {
			return apply_filters(
				'wppfm_feed_data_ajax_to_database_conversion_table',
				array(
					(object) [ 'feed' => 'feedId', 'db' => 'product_feed_id', 'type' => '%d' ],
					(object) [ 'feed' => 'channel', 'db' => 'channel_id', 'type' => '%d' ],
					(object) [ 'feed' => 'language', 'db' => 'language', 'type' => '%s' ],
					(object) [ 'feed' => 'includeVariations', 'db' => 'include_variations', 'type' => '%d' ],
					(object) [ 'feed' => 'isAggregator', 'db' => 'is_aggregator', 'type' => '%d' ],
					(object) [ 'feed' => 'country', 'db' => 'country_id', 'type' => '%s' ],
					(object) [ 'feed' => 'dataSource', 'db' => 'source_id', 'type' => '%d' ],
					(object) [ 'feed' => 'title', 'db' => 'title', 'type' => '%s' ],
					(object) [ 'feed' => 'feedTitle', 'db' => 'feed_title', 'type' => '%s' ],
					(object) [ 'feed' => 'feedDescription', 'db' => 'feed_description', 'type' => '%s' ],
					(object) [ 'feed' => 'mainCategory', 'db' => 'main_category', 'type' => '%s' ],
					(object) [ 'feed' => 'url', 'db' => 'url', 'type' => '%s' ],
					(object) [ 'feed' => 'status', 'db' => 'status_id', 'type' => '%d' ],
					(object) [ 'feed' => 'updateSchedule', 'db' => 'schedule', 'type' => '%s' ],
					(object) [ 'feed' => 'feedType', 'db' => 'feed_type_id', 'type' => '%d' ],
				)
			);
		}
	}

	// end of WPPFM_Form_Element class

endif;
