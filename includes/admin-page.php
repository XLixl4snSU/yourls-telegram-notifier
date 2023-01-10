<?php
/**
 * Telegram Notifier admin page
 *
 */

// Display admin page
function telegram_notifier_display_page() {
	// Check if the values were updated by the form
	if( isset( $_POST['telegram_notifier_api_key'] ) ) {
		// Check nonce
		yourls_verify_nonce( 'telegram_notifier_admin' );

		// Process form, update stored values
		telegram_notifier_update_options( 'telegram_notifier_api_key' );
		telegram_notifier_update_options( 'telegram_notifier_user_id' );
		telegram_notifier_update_options( 'telegram_notifier_user_notification_text' );
		telegram_notifier_update_options( 'telegram_notifier_delete_settings_on_uninstall' );
		yourls_redirect( yourls_admin_url( 'plugins.php?page=telegram_notifier' ) );
	}
	
	// Check if user requested a test message
	if( isset( $_POST['test_message'] ) ) {
		$message = 'If you get this message your Yourls Telegram Notifier is set up correctly.';
		telegram_notifier_api_request( $message );
	}

	// Get values from database
	$telegram_notifier_api_key = yourls_get_option( 'telegram_notifier_api_key' );
	$telegram_notifier_user_id = yourls_get_option( 'telegram_notifier_user_id' );
	$telegram_notifier_user_notification_text = yourls_get_option( 'telegram_notifier_user_notification_text' );
	$telegram_notifier_delete_settings_on_uninstall = yourls_get_option( 'telegram_notifier_delete_settings_on_uninstall' );
	
	// Set standard notification text
	$telegram_notifier_user_notification_text = yourls_get_option( 'telegram_notifier_user_notification_text' );
	if ( empty( $telegram_notifier_user_notification_text ) OR $telegram_notifier_user_notification_text == " " ) {
		$telegram_notifier_user_notification_text = 'The URL %url was shorted with the shortlink %shortlink by IP %ip';
		yourls_update_option( 'telegram_notifier_user_notification_text', $telegram_notifier_user_notification_text );
	}
	
	// Create nonce
	$nonce = yourls_create_nonce( 'telegram_notifier_admin' );
    
	$checkbox=$telegram_notifier_delete_settings_on_uninstall=="true" ? 'checked' : '';
	echo <<<HTML
		<h2>Telegram Notifier</h2>
		<p>This plugin allows you to send notifications of newly shortened links via Telegram.
		See the <a href="https://github.com/XLixl4snSU/yourls-telegram-notifier">plugin documentation</a> for setup instructions.</p>
        <h3>Configure the plugin</h3>
		<form method="post">
		<input type="hidden" name="nonce" value="$nonce" />
		<p><label for="telegram_notifier_api_key">Telegram Bot Token</label> <input type="text" id="telegram_notifier_api_key" name="telegram_notifier_api_key" value="$telegram_notifier_api_key" size="70" /></p>
		<p><label for="telegram_notifier_user_id">Telegram User ID(s) (separated by comma)</label> <input type="text" id="telegram_notifier_user_id" name="telegram_notifier_user_id" value="$telegram_notifier_user_id" size="70" /></p>
		<p><label for="telegram_notifier_user_notification_text">Notification text (use %url, %shortlink and %ip as variables)</label> <input type="text" id="telegram_notifier_user_notification_text" name="telegram_notifier_user_notification_text" value="$telegram_notifier_user_notification_text" size="70" /></p>
		
		<input type='hidden' id="telegram_notifier_delete_settings_on_uninstall" name="telegram_notifier_delete_settings_on_uninstall" value='false' >
		<p><label for="telegram_notifier_delete_settings_on_uninstall">Check to delete all stored settings on uninstall/deactivation. </label> <input type="checkbox" id="telegram_notifier_delete_settings_on_uninstall" name="telegram_notifier_delete_settings_on_uninstall" value="true" $checkbox><br> 
		<p><input type="submit" value="Update settings" /></p>
		</form>
		
		<form method="post">
		<p><input type="submit" name="test_message" value="Send test message" /></p>
		</form>
HTML;
}

// Update options in database
function telegram_notifier_update_options($option) {
	$in = $_POST["$option"];
	if( $in ) {
		// Update value in database
		yourls_update_option( "$option", $in );

	}
}


