<?php

/**
 * WPPFM Product Feed Category Selector Class.
 *
 * @package WP Product Feed Manager/User Interface/Classes
 * @since 2.4.0
 * @version 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'WPPFM_Main_Input_Selector_Element' ) ) :

	class WPPFM_Main_Input_Selector_Element {

		/**
		 * Returns the file name input field code.
		 *
		 * @return string
		 */
		public static function file_name_input_element() {
			return '<tr>
					<th id="main-feed-input-label"><label
						for="file-name">' . __( 'File Name', 'wp-product-feed-manager' ) . '</label> :
					</th>
					<td><input type="text" name="file-name" id="file-name" /></td></tr>';
		}

		/**
		 * Returns the code for the products source selector.
		 *
		 * @return string
		 */
		public static function product_source_selector_element() {
			return '<tr style="display:none;">
					<th id="main-feed-input-label"><label
						for="source-list">' . __( 'Products source', 'wp-product-feed-manager' ) . '</label> :
					</th>
					<td>' . WPPFM_Feed_Form_Control::source_selector() . '</td></tr>';
		}

		/**
		 * Returns the code for the merchant selector.
		 *
		 * @return string
		 */
		public static function merchant_selector_element() {
			return '<tr>
					<th id="main-feed-input-label"><label
						for="merchant-list">' . __( 'Channel', 'wp-product-feed-manager' ) . '</label> :
					</th>
					<td>' . WPPFM_Feed_Form_Control::channel_selector() . '</td></tr>';
		}

		/**
		 * Returns the code for the country selector.
		 *
		 * @return string
		 */
		public static function country_selector_element() {
			return '<tr id="country-list-row" style="display:none;">
					<th id="main-feed-input-label"><label
						for="country-list">' . __( 'Target Country', 'wp-product-feed-manager' ) . '</label> :
					</th>
					<td>' . WPPFM_Feed_Form_Control::country_selector() . '</td></tr>';
		}

		/**
		 * Returns the code for the language selector.
		 *
		 * @return string
		 */
		public static function language_selector_element() {
			return '<tr id="language-list-row" style="display:none;">
					<th id="main-feed-input-label"><label
						for="language-list">' . __( 'Feed Language', 'wp-product-feed-manager' ) . '</label> :
					</th>
					<td>' . WPPFM_Feed_Form_Control::language_selector() . '</td></tr>';
		}

		/**
		 * Returns the code for the default category list.
		 *
		 * @return string
		 */
		public static function category_list_element() {
			return '<tr id="category-list-row" style="display:none;">
					<th id="main-feed-input-label"><label
						for="categories-list">' . __( 'Default Category', 'wp-product-feed-manager' ) . '</label> :
					</th>
					<td>' . WPPFM_Category_Selector_Element::category_mapping_selector( 'lvl', '-1', true ) . '</td></tr>';
		}

		/**
		 * Returns the code for the aggregator selector.
		 *
		 * @return string
		 */
		public static function aggregator_selector_element() {
			return '<tr id="aggregator-selector-row" style="display:none">
					<th id="main-feed-input-label"><label
						for="aggregator-selector">' . __( 'Aggregator Shop', 'wp-product-feed-manager' ) . '</label> :
					</th>
					<td>' . WPPFM_Feed_Form_Control::aggregation_selector() . '</td></tr>';
		}

		/**
		 * Returns the include product variation selector.
		 *
		 * @return string
		 */
		public static function product_variation_selector_element() {
			return '<tr id="add-product-variations-row" style="display:none">
					<th id="main-feed-input-label"><label
						for="product-variations-selector">' . __( 'Include Product Variations', 'wp-product-feed-manager' ) . '</label> :
					</th>
					<td>' . WPPFM_Feed_Form_Control::product_variation_selector() . '</td></tr>';
		}

		/**
		 * Returns the code for the product feed title field.
		 *
		 * @return string
		 */
		public static function google_product_feed_title_element() {
			return '<tr id="google-feed-title-row" style="display:none">
					<th id="main-feed-input-label"><label
						for="google-feed-title-selector">' . __( 'Feed Title', 'wp-product-feed-manager' ) . '</label> :
					</th>
					<td>' . WPPFM_Feed_Form_Control::google_feed_title_selector() . '</td></tr>';
		}

		/**
		 * Returns the code for the product feed description field.
		 *
		 * @return string
		 */
		public static function google_product_feed_description_element() {
			return '<tr id="google-feed-description-row" style="display:none">
					<th id="main-feed-input-label"><label
						for="google-feed-description-selector">' . __( 'Feed Description', 'wp-product-feed-manager' ) . '</label> :
					</th>
					<td>' . WPPFM_Feed_Form_Control::google_feed_description_selector() . '</td></tr>';
		}

		/**
		 * Returns the code for the feed update schedule selector.
		 *
		 * @param  string display style
		 *
		 * @return string
		 */
		public static function feed_update_schedule_selector_element( $display = 'none' ) {
			return '<tr id="update-schedule-row" style="display:' . $display . '">
					<th id="main-feed-input-label"><label
						for="update-schedule">' . __( 'Update Schedule', 'wp-product-feed-manager' ) . '</label> :
					</th>
					<td>' . WPPFM_Feed_Form_Control::schedule_selector() . '</td></tr>';
		}
	}

	// end of WPPFM_Main_Input_Selector_Element class

endif;
