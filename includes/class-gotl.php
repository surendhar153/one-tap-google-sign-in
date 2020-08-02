<?php
// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class GOTL {

	public function __construct() {
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ), 50 );
		add_action( 'wp_footer', array( $this, 'gotl_one_tap_widget' ), 50 );
		add_action( 'init', array( $this, 'gotl_widget_endpoint' ) );
	}

	/**
	 * Enqueuing Scripts
	 */
	public function enqueue_scripts() {
		wp_register_script( 'one-tap-client-js', 'https://accounts.google.com/gsi/client', array(), false, false );
		wp_enqueue_script( 'one-tap-client-js' );
	}

	public function gotl_one_tap_widget() {
		$nonce = wp_create_nonce( 'gotl-login-widget' );
		global $wp;
		$current_url = home_url( add_query_arg( array(), $wp->request ) );
		if ( !is_user_logged_in() ) {
			$gotl_options = get_option( 'gotl_admin_settings' );
			?>
			<div id="g_id_onload"
				data-client_id="<?php echo $gotl_options['googleclientid'];?>"
				data-login_uri="<?php echo home_url();?>/?gotl-signin"
				data-wpnonce="<?php echo $nonce;?>"
				data-redirect_uri="<?php echo $current_url;?>">
			</div>
			<?php
		}
	}

	public function gotl_widget_endpoint(){
		if ( array_key_exists('gotl-signin', $_REQUEST) && wp_verify_nonce($_REQUEST['wpnonce'], 'gotl-login-widget') && $_REQUEST['g_csrf_token'] && $_COOKIE['g_csrf_token'] && $_REQUEST['g_csrf_token'] == $_COOKIE['g_csrf_token'] && $_REQUEST['credential'] ) {

			$id_token = $_REQUEST['credential'];
			$g_csrf_token = $_REQUEST['g_csrf_token'];

			$autoloader = GOTL_PLUGIN_INCLUDES_PATH . '/vendor/autoload.php';
			if ( is_readable( $autoloader ) ) {
				require $autoloader;
			}
			$gotl_options = get_option( 'gotl_admin_settings' );

			$client = new Google_Client(['client_id' => $gotl_options['googleclientid']]);
			$payload = $client->verifyIdToken($id_token);

			if ($payload) {

				$wp_user = get_user_by('email', $payload['email']);

				if ($wp_user) {
					$this->login_user($wp_user->ID, $payload, $_REQUEST['redirect_uri']);
				}else{
					$this->register_user($payload, $_REQUEST['redirect_uri']);
				}

			} else {
				// Invalid ID token
			}

		}
	}

	public function register_user($payload, $redirect_uri){
		$username_parts = array();
		if ( isset( $payload['given_name'] ) ) {
			$username_parts[] = sanitize_user( $payload['given_name'], true );
		}

		if ( isset( $payload['family_name'] ) ) {
			$username_parts[] = sanitize_user( $payload['family_name'], true );
		}

		if ( empty( $username_parts ) ) {
			$email_parts    = explode( '@', $payload['email'] );
			$email_username = $email_parts[0];
			$username_parts[] = sanitize_user( $email_username, true );
		}

		$username = strtolower( implode( '.', $username_parts ) );

		$default_user_name = $username;
		$suffix=1;
		while (username_exists($username)) {
			$username = $default_user_name . $suffix;
			$suffix++;
		}
		$new_userid = register_new_user( $username, $payload['email'] );
		
		wp_set_current_user ( $new_userid );
		wp_set_auth_cookie  ( $new_userid, true );

		if ( wp_safe_redirect( $redirect_uri ) ) {
			exit;
		}
	}

	public function login_user($id, $payload, $redirect_uri){

		wp_clear_auth_cookie();
		wp_set_current_user ( $id );
		wp_set_auth_cookie ( $id, true );

		if ( wp_safe_redirect( $redirect_uri ) ) {
			exit;
		}
	}

}

new GOTL();