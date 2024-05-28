<?php
/*
Plugin Name: Telegram Notifier
Plugin URI: https://github.com/XLixl4snSU/yourls-telegram-notifier
Description: This plugin provides Telegram notifications for newly created shortlinks
Version: 1.0.1
Author: XLixl4snSU
Author URI: https://github.com/XLixl4snSU
*/

// Register on plugin page
yourls_add_action( 'plugins_loaded', 'telegram_notifier_init' );
function telegram_notifier_init() {
    yourls_register_plugin_page( 'telegram_notifier', 'Telegram Notifier', 'telegram_notifier_admin_page' );
}

// Display admin page
function telegram_notifier_admin_page() {
	include_once dirname( __FILE__ ) . '/includes/admin-page.php';
	telegram_notifier_display_page();
}

// Send notification when new link is added
yourls_add_action( 'insert_link', 'telegram_notifier_on_link');
function telegram_notifier_on_link( $args ) {
    // Get Info about added link
	$url = $args[1];
    $shortlink = $args[2];
	$ip = $args[5];
	// Get Variables for Notification
	$base_url = yourls_get_yourls_site();
	$message = yourls_get_option( 'telegram_notifier_user_notification_text' );
	
	// Replace variables set by User with data
	$message = str_replace('%url', $url, $message);
	$message = str_replace('%shortlink', "$base_url/$shortlink", $message);
	$message = str_replace('%ip', $ip, $message);
	telegram_notifier_api_request( $message );
}

// This function sends the actual API request
function telegram_notifier_api_request( $message ) {
	$api_key = yourls_get_option( 'telegram_notifier_api_key' );
	$user_id = yourls_get_option( 'telegram_notifier_user_id' );
	$user_id_array = explode(",", str_replace(' ', '', $user_id));
	foreach ( $user_id_array as $current_id ) {
		// Build HTTP Telegram API request
		$telegram_api_url = "https://api.telegram.org/bot$api_key/sendMessage";
		$request_data = array('chat_id' => $current_id, 'text' => $message);
		$options = array(
		'http' => array(
			'header'  => "Content-type: application/x-www-form-urlencoded",
			'method'  => 'POST',
			'content' => http_build_query($request_data)
			)
		);
		
		// Submit request
		$context  = stream_context_create($options);
		$resp = file_get_contents($telegram_api_url, false, $context);
	}
}
