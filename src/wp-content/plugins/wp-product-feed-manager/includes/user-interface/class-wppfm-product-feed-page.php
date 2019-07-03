<?php

/**
 * WP Product Feed Manager Add Feed Page Class.
 *
 * @package WP Product Feed Manager/User Interface/Classes
 * @version 3.1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'WPPFM_Product_Feed_Page' ) ) :

	/**
	 * WPPFM Feed Form Class
	 */
	class WPPFM_Product_Feed_Page extends WPPFM_Admin_Page {

		public function __construct() {

			parent::__construct();

			wppfm_check_db_version();

			add_option( 'wp_enqueue_scripts', WPPFM_i18n_Scripts::wppfm_feed_settings_i18n() );
			add_option( 'wp_enqueue_scripts', WPPFM_i18n_Scripts::wppfm_list_table_i18n() );
		}

		/**
		 * Collects the html code for the product feed form page and displays it.
		 */
		public function show() {

			echo $this->admin_page_header();

			echo $this->message_field();

			if ( wppfm_wc_installed_and_active() ) {
				if ( ! wppfm_wc_min_version_required() ) {
					echo wppfm_update_your_woocommerce_version_message();
					exit;
				}

				echo $this->tabs();

				echo $this->product_feed_page_data_holder();

				echo $this->main_input_table_wrapper();

				echo $this->category_selector_table_wrapper();

				echo $this->feed_top_buttons();

				echo $this->attribute_mapping_table_wrapper();

				echo $this->feed_bottom_buttons();

				echo $this->feed_list_button();
			} else {
				echo wppfm_you_have_no_woocommerce_installed_message();
			}

			echo $this->admin_page_footer();
		}

		/**
		 * Returns the html code for the tabs.
		 *
		 * @return string
		 */
		private function tabs() {
			return WPPFM_Form_Element::main_form_tabs();
		}

		private function product_feed_page_data_holder() {
			return WPPFM_Form_Element::data_holder();
		}

		/**
		 * Returns the html code for the main input table.
		 */
		private function main_input_table_wrapper() {
			$main_input_wrapper = new WPPFM_Product_Feed_Main_Input_Wrapper();
			$main_input_wrapper->display();
		}

		/**
		 * Returns the html code for the category mapping table.
		 */
		private function category_selector_table_wrapper() {
			$category_table_wrapper = new WPPFM_Product_Feed_Category_Wrapper();
			$category_table_wrapper->display();
		}

		/**
		 * Return the html code for the attribute mapping table.
		 */
		private function attribute_mapping_table_wrapper() {
			$attribute_mapping_wrapper = new WPPFM_Product_Feed_Attribute_Mapping_Wrapper();
			$attribute_mapping_wrapper->display();
		}

		/**
		 * Returns the html code for the Save & Generate Feed and Save Feed buttons at the top of the attributes list.
		 *
		 * @return string
		 */
		private function feed_top_buttons() {
			return WPPFM_Form_Element::feed_generation_buttons( 'wppfm-generate-feed-button-top', 'wppfm-save-feed-button-top' );
		}

		/**
		 * Returns the html code for the Save & Generate Feed and Save Feed buttons at the bottom of the attributes list.
		 *
		 * @return string
		 */
		private function feed_bottom_buttons() {
			return WPPFM_Form_Element::feed_generation_buttons( 'wppfm-generate-feed-button-bottom', 'wppfm-save-feed-button-bottom' );
		}

		/**
		 * Returns the html code for the Open Feed List button.
		 *
		 * @return string
		 */
		private function feed_list_button() {
			return WPPFM_Form_Element::open_feed_list_button();
		}
	}

	// end of WPPFM_Product_Feed_Form class

endif;
