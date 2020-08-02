<?php
/*
Plugin Name: Google One Tap Sign in
Plugin URI: https://github.com/surendhar153/wp-google-one-tap-sign-in
Description: Google One Tap Login for wordpress
Author: S.E.Surendhar
Author URI: https://www.linkedin.com/surendhar153/
Version: 1.0
*/

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'GOTL_VERSION', '1.0' );
define( 'GOTL_PLUGIN_DIR_PATH', plugin_dir_path( __FILE__ ) );
define( 'GOTL_PLUGIN_DIR_URL', plugin_dir_url( __FILE__ ) );
define( 'GOTL_PLUGIN_INCLUDES_PATH', GOTL_PLUGIN_DIR_PATH . 'includes' );

require_once GOTL_PLUGIN_INCLUDES_PATH . '/init.php';