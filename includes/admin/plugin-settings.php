<?php
// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function one_tap_google_sign_in_settings_page(){
    add_menu_page( 
        __( 'Google One Tap', 'google-one-tap-login' ),
        'Google One Tap',
        'manage_options',
        'google-one-tap-login-settings',
        'gotl_plugin_settings_page',
        'dashicons-google',
        80
    ); 
}
add_action( 'admin_menu', 'one_tap_google_sign_in_settings_page' );
 
/**
 * Display a custom menu page
 */
function gotl_plugin_settings_page(){
    if ($_POST && wp_verify_nonce($_POST['_wpnonce'], 'gotl-admin-settings') ) {
        $admin_settings = array();
        $admin_settings['googleclientid'] = sanitize_text_field($_POST['googleclientid']);
        $admin_settings['enable_wp_login_button'] = (isset($_POST['enable_wp_login_button'])) ? sanitize_text_field($_POST['enable_wp_login_button']) : "" ;
        $admin_settings['enable_wc_login_button'] = (isset($_POST['enable_wc_login_button'])) ? sanitize_text_field($_POST['enable_wc_login_button']) : "" ;
        $admin_settings['enable_auto_login'] = (isset($_POST['enable_auto_login'])) ? sanitize_text_field($_POST['enable_auto_login']) : "" ;
        update_option('gotl_admin_settings', $admin_settings);
    }
	include GOTL_PLUGIN_INCLUDES_PATH . '/admin/templates/plugin-settings.php';
}

add_filter( 'plugin_action_links_' . GOTL_PLUGIN_BASENAME, 'gotl_plugin_action_links' );

function gotl_plugin_action_links( $actions ) {
    $url = esc_url( add_query_arg(
		'page',
		'google-one-tap-login-settings',
		get_admin_url() . 'admin.php'
	) );
   $actions[] = '<a href="'. $url .'">Settings</a>';
   return $actions;
}