<?php
/*
Plugin Name: One Tap Google Sign in
Plugin URI: https://bit.ly/one-tap-google-sign-in-for-wordpress
Description: One Tap Google Sign in for wordpress
Author: S.E.Surendhar
Author URI: https://bit.ly/surendhar-linkedin
Version: 1.1.5
*/

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'GOTL_VERSION', '1.1.2' );
define( 'GOTL_PLUGIN_DIR_PATH', plugin_dir_path( __FILE__ ) );
define( 'GOTL_PLUGIN_DIR_URL', plugin_dir_url( __FILE__ ) );
define( 'GOTL_PLUGIN_INCLUDES_PATH', GOTL_PLUGIN_DIR_PATH . 'includes' );

require_once GOTL_PLUGIN_INCLUDES_PATH . '/init.php';
