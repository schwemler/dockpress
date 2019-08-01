<?php

/**
 * @package WP Product Feed Manager/Data/Functions
 * @version 2.4.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Converts a string containing a date-time stamp as stored in the meta data to a date time string
 * that can be used in a feed file
 *
 * @since 1.1.0
 *
 * @param string $date_stamp The timestamp that needs to be converted to a string that can be stored in a feed file
 *
 * @return string    A string containing the time or an empty string if the $date_stamp is empty
 */
function wppfm_convert_price_date_to_feed_format( $date_stamp ) {
	if ( $date_stamp ) {
		// register the date
		$feed_string = date( 'Y-m-d', $date_stamp );

		// if set, add the time
		if ( date( 'H', $date_stamp ) !== '00' || date( 'i', $date_stamp ) !== '00' || date( 's', $date_stamp ) !== '00' ) {
			$feed_string .= 'T' . date( 'H:i:s', $date_stamp );
		}

		return $feed_string;
	} else {
		return '';
	}
}

/**
 * After a channel has been updated this function decreases the 'wppfm_channels_to_update' option with one
 *
 * @since 1.4.1
 */
function wppfm_decrease_update_ready_channels() {
	$old = get_option( 'wppfm_channels_to_update' );

	if ( $old > 0 ) {
		update_option( 'wppfm_channels_to_update', $old - 1 );
	} else {
		update_option( 'wppfm_channels_to_update', 0 );
	}
}

/**
 * Checks the current database version and updates it if required
 *
 * @since 2.4.0
 */
function wppfm_check_db_version() {
	$db_management = new WPPFM_Database_Management();
	$db_management->verify_db_version();
}

/**
 * Checks if a specific source key is a money related key or not
 *
 * @since 1.1.0
 *
 * @param string $key The source key to be checked
 *
 * @return boolean    True if the source key is money related, false if not
 */
function wppfm_meta_key_is_money( $key ) {
	// money keys
	$special_price_keys = array(
		'_max_variation_price',
		'_max_variation_regular_price',
		'_max_variation_sale_price',
		'_min_variation_price',
		'_min_variation_regular_price',
		'_min_variation_sale_price',
		'_regular_price',
		'_sale_price',
	);

	return in_array( $key, $special_price_keys ) ? true : false;
}

/**
 * Takes a value and formats it to a money value using the WooCommerce thousands separator, decimal separator and number of decimals values
 *
 * @since 1.1.0
 * @since 1.9.0 added WPML support
 *
 * @param string $money_value The money value to be formatted
 * @param string $feed_language Selected Language in WPML add-on, leave empty if no exchange rate correction is required @since 1.9.0
 *
 * @return string    A formatted money value
 */
function wppfm_prep_money_values( $money_value, $feed_language = '' ) {
	$thousand_separator = get_option( 'woocommerce_price_thousand_sep' );

	if ( ! is_float( $money_value ) ) {
		$val         = wppfm_number_format_parse( $money_value );
		$money_value = floatval( $val );
	}

	if ( has_filter( 'wppfm_wpml_exchange_money_values' ) ) {
		return apply_filters( 'wppfm_wpml_exchange_money_values', $money_value, $feed_language );
	} else {
		$number_decimals = absint( get_option( 'woocommerce_price_num_decimals', 2 ) );
		$decimal_point   = get_option( 'woocommerce_price_decimal_sep' );

		return number_format( $money_value, $number_decimals, $decimal_point, $thousand_separator );
	}
}

/**
 * Checks if there are invalid backups
 *
 * @since 1.8.0
 *
 * @return boolean true if there are no backups or these backups are current
 */
function wppfm_check_backup_status() {
	if ( ! WPPFM_Db_Management::invalid_backup_exist() ) {
		return true;
	} else {
		return false;
	}
}

/**
 * Forces the database to load and update and adds the auto update cron event if it does not exists
 *
 * @since 1.9.0
 *
 * @return boolean
 */
function wppfm_reinitiate_plugin() {
	if ( ! wp_get_schedule( 'wppfm_feed_update_schedule' ) ) {
		// add the schedule cron
		wp_schedule_event( time(), 'hourly', 'wppfm_feed_update_schedule' );
		add_action( 'wppfm_feed_update_schedule', 'activate_feed_update_schedules' );
	}

	// remakes the database
	$db = new WPPFM_Database_Management();
	$db->force_reinitiate_db();

	// resets the license nr
	delete_option( 'wppfm_lic_status' );
	delete_option( 'wppfm_lic_status_date' );
	delete_option( 'wppfm_lic_key' );
	delete_option( 'wppfm_lic_expires' );
	delete_option( 'wppfm_license_notice_suppressed' );

	// reset the keyed options
	WPPFM_Db_Management::clean_options_table();

	do_action( 'wppfm_plugin_reinitialized' );

	return true;
}

function wppfm_clear_feed_process_data() {
	WPPFM_Feed_Controller::clear_feed_queue();
	WPPFM_Feed_Controller::set_feed_processing_flag( false );
	WPPFM_Db_Management::clean_options_table();

	do_action( 'wppfm_feed_process_data_cleared' );

	return true;
}

/**
 * Converts any number string to a string with a number that has no thousands separator
 * and a period as decimal separator
 *
 * @param string $number_string
 *
 * @return string
 */
function wppfm_number_format_parse( $number_string ) {
	$decimal_separator  = get_option( 'woocommerce_price_decimal_sep' );
	$thousand_separator = get_option( 'woocommerce_price_thousand_sep' );

	// convert a number string that is a actual standard number format whilst the woocommerce options are not standard
	// to the woocommerce standard. This sometimes happens with meta values
	if ( ! empty( $decimal_separator ) && strpos( $number_string, $decimal_separator ) === false ) {
		$number_string = ! empty( $thousand_separator ) && strpos( $number_string, $thousand_separator ) === false ? $number_string : str_replace( $thousand_separator, $decimal_separator, $number_string );
	}

	$no_thousands_sep = str_replace( $thousand_separator, '', $number_string );

	return '.' !== $decimal_separator ? str_replace( $decimal_separator, '.', $no_thousands_sep ) : $no_thousands_sep;
}

/**
 * returns the path to the feed file including feed name and extension
 *
 * @param string $feed_name
 *
 * @return string
 */
function wppfm_get_file_path( $feed_name ) {
	// previous to plugin version 1.3.0 feeds where stored in the plugins but after that version they are stored in the upload folder
	if ( file_exists( WP_PLUGIN_DIR . '/wp-product-feed-manager-support/feeds/' . $feed_name ) ) {
		return WP_PLUGIN_DIR . '/wp-product-feed-manager-support/feeds/' . $feed_name;
	} elseif ( file_exists( WPPFM_FEEDS_DIR . '/' . $feed_name ) ) {
		return WPPFM_FEEDS_DIR . '/' . $feed_name;
	} else { // as of version 1.5.0 all spaces in new filenames are replaced by a dash
		$forbidden_name_chars = wppfm_forbidden_file_name_characters();

		return WPPFM_FEEDS_DIR . '/' . str_replace( $forbidden_name_chars, '-', $feed_name );
	}
}

/**
 * @return array with forbidden characters
 */
function wppfm_forbidden_file_name_characters() {
	return array( ' ', '<', '>', ':', '?', ',' ); // characters that are not allowed in a feed file name
}

/**
 * For backward compatibility, the old feed statuses are converted to all lowercase and without spaces
 *
 * @since 2.1.0
 *
 * @param array $list
 */
function wppfm_correct_old_feeds_list_status( &$list ) {
	for ( $i = 0; $i < count( $list ); $i ++ ) {
		$list[ $i ]->status = strtolower( str_replace( ' ', '_', $list[ $i ]->status ) );
	}
}

/**
 * Checks if the WooCommerce plugin is installed and active
 *
 * @since 2.3.0
 * @return boolean true if WooCommerce is installed and active, false if not
 */
function wppfm_wc_installed_and_active() {
	return is_plugin_active( 'woocommerce/woocommerce.php' ) || is_plugin_active_for_network( 'woocommerce/woocommerce.php' ) ? true : false;
}

/**
 * Checks if the WooCommerce plugin has the minimal required version
 *
 * @since 2.3.0
 * @return boolean true if WooCommerce version is at least 3.0.0
 */
function wppfm_wc_min_version_required() {
	$wc_version = get_plugin_data( WPPFM_PLUGIN_DIR . '../woocommerce/woocommerce.php' )['Version'];

	return $wc_version >= WPPFM_MIN_REQUIRED_WC_VERSION ? true : false;
}
