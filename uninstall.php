<?php

// No direct call.
if( !defined( 'YOURLS_UNINSTALL_PLUGIN' ) ) die();

// Check if settings should be deleted on deactivation, delete if true

$delete_settings = yourls_get_option( 'telegram_notifier_delete_settings_on_uninstall' );

if ( $delete_settings == "true" ) {
	yourls_delete_option( 'telegram_notifier_api_key' );
	yourls_delete_option( 'telegram_notifier_user_id' );
	yourls_delete_option( 'telegram_notifier_user_notification_text' );
	yourls_delete_option( 'telegram_notifier_delete_settings_on_uninstall' );
}