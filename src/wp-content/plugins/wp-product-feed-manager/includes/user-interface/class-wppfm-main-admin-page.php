<?php

/**
 * WPPFM Main Admin Page Class.
 *
 * @package WP Product Feed Manager/User Interface/Classes
 * @version 1.7.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'WPPFM_Main_Admin_Page' ) ) :

	/**
	 * Main Admin Page Class
	 */
	class WPPFM_Main_Admin_Page extends WPPFM_Admin_Page {

		private $_list_table;

		function __construct() {

			parent::__construct();

			wppfm_check_db_version();

			$this->prepare_feed_list();
		}

		/**
		 * Collects the html code for the main page and displays it.
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

				echo $this->main_admin_page();

				echo $this->main_admin_buttons();
			} else {
				echo wppfm_you_have_no_woocommerce_installed_message();
			}

			echo $this->admin_page_footer();
		}

		/**
		 * Prepares the list table
		 */
		private function prepare_feed_list() {
			$show_type_column = apply_filters( 'wppfm_special_feeds_add_on_active', false );

			// prepare the table elements
			$this->_list_table = new WPPFM_List_Table();

			$this->_list_table->set_table_id( 'wppfm-feed-list' );

			$list_columns = array(
				'col_feed_name'        => __( 'Name', 'wp-product-feed-manager' ),
				'col_feed_url'         => __( 'Url', 'wp-product-feed-manager' ),
				'col_feed_last_change' => __( 'Updated', 'wp-product-feed-manager' ),
				'col_feed_products'    => __( 'Products', 'wp-product-feed-manager' ),
			);

			if ( $show_type_column ) {
				$list_columns['col_feed_type'] = __( 'Type', 'wp-product-feed-manager' );
			}

			$list_columns['col_feed_status']  = __( 'Status', 'wp-product-feed-manager' );
			$list_columns['col_feed_actions'] = __( 'Actions', 'wp-product-feed-manager' );

			// set the column names
			$this->_list_table->set_column_titles( $list_columns );
		}

		/**
		 * Returns the tabs
		 *
		 * @return string html
		 */
		private function tabs() {
			return WPPFM_Form_Element::main_form_tabs();
		}

		/**
		 * Returns a html string containing the main admin page body code
		 *
		 * @return string html
		 */
		private function main_admin_page() {
			return $this->main_admin_body_top();
		}

		/**
		 * Returns the html for the main body top
		 *
		 * @return string html
		 */
		private function main_admin_body_top() {
			return $this->_list_table->display();
		}

		private function main_admin_buttons() {
			return '<div class="button-wrapper" id="page-bottom-buttons"><input class="button-primary" type="button" ' .
				'onclick="parent.location=\'admin.php?page=wp-product-feed-manager&tab=product-feed\'" name="new" value="' .
				esc_html__( 'Add New Feed', 'wp-product-feed-manager' ) . '" id="add-new-feed-button" /></div>';
		}

	}

	// end of WPPFM_Main_Admin_Page class
endif;
