<?php
/*
Plugin Name: One Tap Google Sign in
Plugin URI: https://github.com/surendhar153/one-tap-google-sign-in
Description: One Tap Google Sign in for wordpress
Author: Surendhar
Author URI: https://www.linkedin.com/in/surendhar153/
Version: 1.4.1
Requires PHP: 7.4
Requires at least: 5.1
*/

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'GOTL_VERSION', '1.4.1' );
define( 'GOTL_PLUGIN_DIR_PATH', plugin_dir_path( __FILE__ ) );
define( 'GOTL_PLUGIN_DIR_URL', plugin_dir_url( __FILE__ ) );
define( 'GOTL_PLUGIN_BASENAME', plugin_basename( __FILE__ ) );
define( 'GOTL_PLUGIN_INCLUDES_PATH', GOTL_PLUGIN_DIR_PATH . 'includes' );

require_once GOTL_PLUGIN_INCLUDES_PATH . '/init.php';
