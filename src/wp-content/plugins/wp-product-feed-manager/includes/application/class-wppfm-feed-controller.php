<?php

/**
 * WP Product Feed Controller Class.
 *
 * @package WP Product Feed Manager/Application/Classes
 * @version 1.1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'WPPFM_Feed_Controller' ) ) :

	/**
	 * Feed Controller Class
	 *
	 * @since 1.10.0
	 */
	class WPPFM_Feed_Controller {

		/**
		 * Removes a feed id from the feed queue
		 *
		 * @param string $feed_id
		 */
		public static function remove_id_from_feed_queue( $feed_id ) {
			$feed_queue = self::get_feed_queue();
			$key        = array_search( $feed_id, $feed_queue );

			if ( false !== $key ) {
				unset( $feed_queue[ $key ] );
				$feed_queue = array_values( $feed_queue ); // resort after unset
				update_site_option( 'wppfm_feed_queue', $feed_queue );

				if ( self::feed_queue_is_empty() ) {
					wppfm_clear_feed_process_data();
				}
			}
		}

		/**
		 * Adds an feed id to the feed queue
		 *
		 * @param string $feed_id
		 */
		public static function add_id_to_feed_queue( $feed_id ) {
			$feed_queue = self::get_feed_queue();

			if ( ! in_array( $feed_id, $feed_queue ) ) {
				array_push( $feed_queue, $feed_id );
				update_site_option( 'wppfm_feed_queue', $feed_queue );
			}
		}

		/**
		 * Gets the next feed id from the feed queue
		 */
		public static function get_next_id_from_feed_queue() {
			$feed_queue = self::get_feed_queue();

			return count( $feed_queue ) > 0 ? $feed_queue[0] : false;
		}

		/**
		 * Empties the feed queue
		 */
		public static function clear_feed_queue() {
			update_site_option( 'wppfm_feed_queue', array() );
		}

		/**
		 * Checks if the feed queue is empty
		 *
		 * @return bool
		 */
		public static function feed_queue_is_empty() {
			$queue = self::get_feed_queue();

			return ( count( $queue ) < 1 ) ? true : false;
		}

		/**
		 * Returns the number of product ids that are still in the queue
		 *
		 * @since 2.3.0
		 * @return int number of product ids still in the queue
		 */
		public static function nr_ids_remaining_in_queue() {
			$queue = self::get_feed_queue();

			return count( $queue );
		}

		/**
		 * Sets the background_process_is_running option
		 *
		 * @param bool $set (default false)
		 */
		public static function set_feed_processing_flag( $set = false ) {
			$status = false !== $set ? 'true' : 'false';
			update_site_option( 'wppfm_background_process_is_running', $status );
		}

		/**
		 * Get the background_process_is_running status
		 *
		 * @return bool
		 */
		public static function feed_is_processing() {
			$status = get_option( 'wppfm_background_process_is_running', 'false' );

			return 'true' === $status ? true : false;
		}

		/**
		 * Checks if a running feed size is still increasing, in order to identify a failing feed process
		 *
		 * @since 2.2.0
		 *
		 * @param string $feed_file
		 *
		 * @return boolean
		 */
		public static function feed_processing_failed( $feed_file ) {
			$trans = get_transient( 'wppfm_feed_file_size' );

			if ( '' === $feed_file ) {
				return null;
			}

			if ( false === ( $trans ) ) {
				$trans = '0|0';
				set_transient( 'wppfm_feed_file_size', $trans, WPPFM_TRANSIENT_LIVE );
			}

			// get the last data
			$stored            = explode( '|', $trans );
			$prev_feed_size    = $stored[0];
			$prev_feed_counter = $stored[1];
			$curr_feed_size    = file_exists( $feed_file ) ? filesize( $feed_file ) : 0;

			// if file size is 0, return true
			if ( false === $curr_feed_size ) {
				return true;
			}

			// if the size of the feed has not grown
			if ( $curr_feed_size <= $prev_feed_size ) {
				// and the delay time has passed
				if ( $prev_feed_counter + apply_filters( 'wppfm_delay_failed_label', WPPFM_DELAY_FAILED_LABEL, $feed_file ) < time() ) {
					delete_transient( 'wppfm_feed_file_size' ); // reset the counter

					return true;
				} else {
					return false;
				}
			} else {
				set_transient( 'wppfm_feed_file_size', $curr_feed_size . '|' . time(), WPPFM_TRANSIENT_LIVE );

				return false;
			}
		}

		/**
		 * Returns the current feed queue
		 *
		 * @return array with feed ids in the queue or an empty array
		 */
		protected static function get_feed_queue() {
			return get_site_option( 'wppfm_feed_queue', array() );
		}
	}

endif;
