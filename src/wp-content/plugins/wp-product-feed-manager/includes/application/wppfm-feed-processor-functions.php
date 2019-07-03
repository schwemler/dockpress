<?php

/**
 * @package WP Product Review Feed Manager/Functions
 * @version 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

trait WPPFM_Feed_Processor_Functions {

	/**
	 * Adds a string to the feed
	 *
	 * @param array $line_data
	 *
	 * @return boolean
	 */
	private function add_file_format_line_to_feed( $line_data ) {
		return false !== file_put_contents( $this->_feed_file_path, $line_data['file_format_line'], FILE_APPEND ) ? true : false;
	}

	/**
	 * Adds an error message to the feed
	 *
	 * @param array $error_message_data
	 *
	 * @return boolean
	 */
	private function add_error_message_to_feed( $error_message_data ) {
		return false !== file_put_contents( $this->_feed_file_path, $error_message_data['feed_line_message'], FILE_APPEND ) ? true : false;
	}


	/**
	 * register the update in the database
	 *
	 * @param string $feed_id
	 * @param string $feed_name
	 * @param string $nr_products
	 * @param string $status
	 */
	private function register_feed_update( $feed_id, $feed_name, $nr_products, $status = null ) {
		$data_class = new WPPFM_Data();

		// register the update and update the feed Last Change time
		$data_class->update_feed_data( $feed_id, $this->get_file_url( $feed_name ), $nr_products );

		$actual_status = $status ? $status : $data_class->get_feed_status( $feed_id );

		if ( '4' !== $actual_status && '5' !== $actual_status && '6' !== $actual_status ) { // no errors
			$data_class->update_feed_status( $feed_id, $status ); // put feed on status hold if no errors are reported
		}
	}

	/**
	 * returns the url to the feed file including feed name and extension
	 *
	 * @param string $feed_name
	 *
	 * @return string
	 */
	protected function get_file_url( $feed_name ) {
		// previous to plugin version 1.3.0 feeds where stored in the plugins but after that version they are stored in the upload folder
		if ( file_exists( WP_PLUGIN_DIR . '/wp-product-feed-manager-support/feeds/' . $feed_name ) ) {
			$file_url = plugins_url() . '/wp-product-feed-manager-support/feeds/' . $feed_name;
		} elseif ( file_exists( WPPFM_FEEDS_DIR . '/' . $feed_name ) ) {
			$file_url = WPPFM_UPLOADS_URL . '/wppfm-feeds/' . $feed_name;
		} else { // as of version 1.5.0 all spaces in new filenames are replaced by a dash
			$forbidden_name_chars = array(
				' ',
				'<',
				'>',
				':',
				'?',
				',',
			); // characters that are not allowed in a feed file name
			$file_url             = WPPFM_UPLOADS_URL . '/wppfm-feeds/' . str_replace( $forbidden_name_chars, '-', $feed_name );
		}

		return apply_filters( 'wppfm_feed_url', $file_url, $feed_name );
	}

	private function get_products_main_data( $product_id, $parent_product_id, $post_columns_query_string ) {
		$queries_class   = new WPPFM_Queries();
		$prep_meta_class = new WPPFM_Feed_Value_Editors();

		$product_data = $queries_class->read_post_data( $product_id, $post_columns_query_string );

		// WPML support
		if ( has_filter( 'wpml_translation' ) ) {
			$product_data = apply_filters( 'wpml_translation', $product_data, $this->_feed_data->language );
		}

		// parent ids are required to get the main data from product variations
		$meta_parent_ids = 0 !== $parent_product_id ? array( $parent_product_id ) : $this->get_meta_parent_ids( $product_id );

		array_unshift( $meta_parent_ids, $product_id ); // add the product id to the parent ids

		$meta_data = $queries_class->read_meta_data( $product_id, $parent_product_id, $meta_parent_ids, $this->_pre_data['database_fields']['meta_fields'] );

		foreach ( $meta_data as $meta ) {
			$meta_value = $prep_meta_class->prep_meta_values( $meta, $this->_feed_data->language );

			if ( array_key_exists( $meta->meta_key, $product_data ) ) {
				$meta_key = $meta->meta_key;

				if ( '' === $product_data->$meta_key ) {
					$product_data = (object) array_merge( (array) $product_data, array( $meta->meta_key => $meta_value ) );
				}
			} else {
				$product_data = (object) array_merge( (array) $product_data, array( $meta->meta_key => $meta_value ) );
			}
		}

		foreach ( $this->_pre_data['database_fields']['active_custom_fields'] as $field ) {
			$product_data->{$field} = $this->get_custom_field_data( $product_data->ID, $parent_product_id, $field );
		}

		foreach ( $this->_pre_data['database_fields']['third_party_custom_fields'] as $third_party_field ) {
			$product_data->{$third_party_field} = $this->get_third_party_custom_field_data( $product_data->ID, $parent_product_id, $third_party_field );
		}

		$this->add_procedural_data( $product_data, $this->_pre_data['column_names'], $this->_feed_data->language, $this->_feed_data->feedId );

		return $product_data;
	}
}
