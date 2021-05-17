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
				data-client_id="<?php echo esc_html( $gotl_options['googleclientid']);?>"
				data-login_uri="<?php echo esc_url( home_url().'/?gotl-signin' );?>"
				data-wpnonce="<?php echo $nonce;?>"
				data-redirect_uri="<?php echo esc_url( $current_url );?>">
			</div>
			<?php
		}
	}

	public function gotl_widget_endpoint(){

		if ( array_key_exists('gotl-signin', $_GET) ) {

			if ( !wp_verify_nonce($_POST['wpnonce'], 'gotl-login-widget') ) {
				error_log( 'gotl - wpnonce failed' );
				return;
			}

			if ( !isset($_POST['g_csrf_token']) && !empty($_POST['g_csrf_token']) ) {
				error_log( 'gotl - post g_csrf_token not available' );
				return;
			}

			if ( !isset($_COOKIE['g_csrf_token']) && !empty($_COOKIE['g_csrf_token']) ) {
				error_log( 'gotl - cookie g_csrf_token not available' );
				return;
			}

			if ( $_POST['g_csrf_token'] != $_COOKIE['g_csrf_token'] ) {
				error_log( 'gotl - g_csrf_token is not same in post and cookie' );
				return;
			}

			if ( !isset($_POST['credential']) && !empty($_POST['credential']) ) {
				error_log( 'gotl - credential is not available' );
				return;
			}

			$id_token = sanitize_text_field( $_POST['credential'] );

			$autoloader = GOTL_PLUGIN_INCLUDES_PATH . '/vendor/autoload.php';
			if ( is_readable( $autoloader ) ) {
				require $autoloader;
			}
			$gotl_options = get_option( 'gotl_admin_settings' );

			$client = new Google_Client(['client_id' => esc_html($gotl_options['googleclientid'])]);
			$payload = $client->verifyIdToken($id_token);

			if ($payload) {

				$wp_user = get_user_by('email', sanitize_email($payload['email']));

				if ($wp_user) {
					$action = $this->login_user($wp_user->ID, $payload, esc_url_raw($_POST['redirect_uri']));
				}else{
					$action = $this->register_user($payload, esc_url_raw($_POST['redirect_uri']));
				}

				if( is_wp_error( $action ) ) {
					error_log( 'gotl - '.print_r($action) );
					return;
				}

			} else {
				error_log( 'gotl - invaild id' );
				return;
			}

		}
	}

	public function register_user($payload, $redirect_uri){
		$errors = new WP_Error();

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
		$new_userid = register_new_user( sanitize_user($username), $payload['email'] );
		
		if (is_wp_error($new_userid)) {
			$errors->add( 'registration_failed', __( '<strong>Error</strong>: Registration Failed' ) );
		}

		$user_data = array();
		$user_data['ID'] = $new_userid;
		$user_data['first_name'] = $payload['given_name'];
		$user_data['last_name'] = $payload['family_name'];
		$user_data['display_name'] = $payload['name'];

		wp_update_user($user_data);

		update_user_meta($new_userid, 'gotl_profilepicture_url', esc_url_raw($payload['picture']));
		update_user_meta($new_userid, 'nickname', $payload['given_name']);

		wp_set_current_user ( $new_userid );
		wp_set_auth_cookie  ( $new_userid, true );

		if ( $errors->has_errors() ) {
			return $errors;
		}

		if ( wp_safe_redirect( $redirect_uri ) ) {
			exit;
		}
	}

	public function login_user($id, $payload, $redirect_uri){

		$user_data = array();
		$user_data['ID'] = $id;
		$user_data['first_name'] = $payload['given_name'];
		$user_data['last_name'] = $payload['family_name'];
		$user_data['display_name'] = $payload['name'];

		wp_update_user($user_data);

		update_user_meta($id, 'gotl_profilepicture_url', esc_url_raw($payload['picture']));
		update_user_meta($id, 'nickname', $payload['given_name']);

		wp_clear_auth_cookie();
		wp_set_current_user ( $id );
		wp_set_auth_cookie ( $id, true );

		if ( wp_safe_redirect( $redirect_uri ) ) {
			exit;
		}
	}

}

new GOTL();
