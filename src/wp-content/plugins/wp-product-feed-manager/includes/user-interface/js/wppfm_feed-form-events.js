jQuery( document ).ready(
	function( $ ) {
		var fileNameElement  = $( '#file-name' );
		var merchantsElement = $( '#merchants' );
		var countriesElement = $( '#countries' );
		var level0Element    = $( '#lvl_0' );

		// monitor the four main feed settings and react when they change
		fileNameElement.on(
			'focusout',
			function() {
				if ( '' !== fileNameElement.val() ) {
					countriesElement.prop( 'disabled', false );
					level0Element.prop( 'disabled', false );
					wppfm_validateFileName( jQuery( '#file-name' ) );

					if ( '0' !== merchantsElement.val() ) {
						wppfm_showChannelInputs( merchantsElement.val(), true );
						wppfm_mainInputChanged( false );
					} else {
						wppfm_hideFeedFormMainInputs();
					}
				} else {
					countriesElement.prop( 'disabled', true );
					level0Element.prop( 'disabled', true );
				}
			}
		);

		fileNameElement.on(
			'keyup',
			function() {

				if ( '' !== fileNameElement.val() ) {
					countriesElement.prop( 'disabled', false );
					level0Element.prop( 'disabled', false );
				} else {
					countriesElement.prop( 'disabled', true );
					level0Element.prop( 'disabled', true );
				}
			}
		);

		countriesElement.on(
			'change',
			function() {
				if ( '0' !== countriesElement.val() ) {
					level0Element.prop( 'disabled', false );
				}

				wppfm_mainInputChanged( false );
			}
		);

		$( '#language' ).on(
			'change',
			function() {
				wppfm_setGoogleFeedLanguage( jQuery( '#language' ).val() );

				if ( wppfm_requiresLanguageInput ) {
					wppfm_mainInputChanged( false );
				}
			}
		);

		$( '#google-feed-title-selector' ).on(
			'change',
			function() {
				wppfm_setGoogleFeedTitle( jQuery( '#google-feed-title-selector' ).val() );
			}
		);

		$( '#google-feed-description-selector' ).on(
			'change',
			function() {
				wppfm_setGoogleFeedDescription( jQuery( '#google-feed-description-selector' ).val() );
			}
		);

		merchantsElement.on(
			'change',
			function() {
				if ( '0' !== merchantsElement.val() && '' !== $( '#file-name' ).val() ) {
					wppfm_showChannelInputs( $( '#merchants' ).val(), true );
					wppfm_mainInputChanged( false );
				} else {
					wppfm_hideFeedFormMainInputs();
				}
			}
		);

		$( '#variations' ).on(
			'change',
			function() {
				wppfm_variation_selection_changed();
			}
		);

		$( '#aggregator' ).on(
			'change',
			function() {
				wppfm_aggregatorChanged();
				wppfm_makeFieldsTable(); // reset the attribute mapping
			}
		);

		level0Element.on(
			'change',
			function() {
				wppfm_mainInputChanged( true );
			}
		);

		$( '.cat_select' ).on(
			'change',
			function() {
				wppfm_nextCategory( this.id );
			}
		);

		$( '#wppfm-generate-feed-button-top' ).on(
			'click',
			function() {
				wppfm_generateFeed();
			}
		);

		$( '#wppfm-generate-feed-button-bottom' ).on(
			'click',
			function() {
				wppfm_generateFeed();
			}
		);

		$( '#wppfm-save-feed-button-top' ).on(
			'click',
			function() {
				wppfm_saveFeedData();
			}
		);

		$( '#wppfm-save-feed-button-bottom' ).on(
			'click',
			function() {
				wppfm_saveFeedData();
			}
		);

		$( '#days-interval' ).on(
			'change',
			function() {
				wppfm_saveUpdateSchedule();
			}
		);

		$( '#update-schedule-hours' ).on(
			'change',
			function() {
				wppfm_saveUpdateSchedule();
			}
		);

		$( '#update-schedule-minutes' ).on(
			'change',
			function() {
				wppfm_saveUpdateSchedule();
			}
		);

		$( '#update-schedule-frequency' ).on(
			'change',
			function() {
				wppfm_saveUpdateSchedule();
			}
		);

		$( '#wppfm_auto_feed_fix_mode' ).on(
			'change',
			function() {
				wppfm_auto_feed_fix_changed();
			}
		);

		$( '#wppfm_background_processing_mode' ).on(
			'change',
			function() {
				wppfm_clear_feed_process();
				wppfm_background_processing_mode_changed();
			}
		);

		$( '#wppfm_third_party_attr_keys' ).on(
			'focusout',
			function() {
				wppfm_third_party_attributes_changed();
			}
		);

		$( '#wppfm_notice_mailaddress' ).on(
			'focusout',
			function() {
				wppfm_notice_mailaddress_changed();
			}
		);

		$( '#wppfm-clear-feed-process-button' ).on(
			'click',
			function() {
				wppfm_clear_feed_process();
			}
		);

		$( '#wppfm-reinitiate-plugin-button' ).on(
			'click',
			function() {
				wppfm_reinitiate();
			}
		);

		$( '.category-mapping-selector' ).on(
			'change',
			function() {
				console.log( 'category-mapping-selector selected' );
				console.log( $( this ).val() );
				if ( $( this ).is( ':checked' ) ) {
					wppfm_activateFeedCategoryMapping( $( this ).val() );
				} else {
					wppfm_deactivateFeedCategoryMapping( $( this ).val() );
				}
			}
		);

		$( '.category-selector' ).on(
			'change',
			function() {
				if ( $( this ).is( ':checked' ) ) {
					wppfm_activateFeedCategorySelection( $( this ).val() );
				} else {
					wppfm_deactivateFeedCategorySelection( $( this ).val() );
				}
			}
		);

		$( '#categories-select-all' ).on(
			'change',
			function() {
				if ( $( this ).is( ':checked' ) ) {
					wppfm_activateFeedCategoryMapping( 'wppfm_all_categories_selected' );
				} else {
					wppfm_deactivateFeedCategoryMapping( 'wppfm_all_categories_selected' );
				}
			}
		);


		$( '#wppfm_accept_eula' ).on(
			'change',
			function() {
				if ( $( this ).is( ':checked' ) ) {
					$( '#wppfm_license_activate' ).prop( 'disabled', false );
				} else {
					$( '#wppfm_license_activate' ).prop( 'disabled', true );
				}
			}
		);

		//$( '.edit-output' ).click( function () { wppfm_editOutput( this.id ); } ); TODO: Check this out later. The this.id should get the id of the link but it doesn't.

		$( '#wppfm_prepare_backup' ).on(
			'click',
			function() {
				$( '#wppfm_backup-file-name' ).val( '' );
				$( '#wppfm_backup-wrapper' ).show();
			}
		);

		$( '#wppfm_make_backup' ).on(
			'click',
			function() {
				wppfm_backup();
			}
		);

		$( '#wppfm_cancel_backup' ).on(
			'click',
			function() {
				$( '#wppfm_backup-wrapper' ).hide();
			}
		);

		$( '#wppfm_backup-file-name' ).on(
			'keyup',
			function() {
				if ( '' !== $( '#wppfm_backup-file-name' ).val ) {
					$( '#wppfm_make_backup' ).attr( 'disabled', false );
				}
			}
		);
	}
);
