<?php
// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$gotl_options = get_option( 'gotl_admin_settings' );

$googleclientid = isset($gotl_options['googleclientid'])? $gotl_options['googleclientid'] : "";
$enable_wp_login_button = isset($gotl_options['enable_wp_login_button'])? $gotl_options['enable_wp_login_button'] : "";
$enable_wc_login_button = isset($gotl_options['enable_wc_login_button'])? $gotl_options['enable_wc_login_button'] : "";
$enable_auto_login = isset($gotl_options['enable_auto_login'])? $gotl_options['enable_auto_login'] : "";
?>
<style type="text/css">
	form.gotl-admin-settings-form table th {
		text-align: left;
	}
	.donate-image{
		width: auto;
		height: 300px;
	}
	.donation-group {
		text-align: center;
	}
</style>
<div class="wrap">
	<h1>Google One Tap Login</h1>
	<p>Version: <?php echo esc_html(GOTL_VERSION); ?></p>
	<form method="POST" class="gotl-admin-settings-form">
		<?php wp_nonce_field( "gotl-admin-settings" );?>
		<table>
		<tr>
			<th scope="row"><label for="googleclientid">Google Client ID</label></th>
			<td><input name="googleclientid" type="text" id="googleclientid" value="<?php echo esc_attr($googleclientid);?>" class="regular-text" /></td>
		</tr>
		<tr>
			<th scope="row"><label for="enable_wp_login_button">Enable on WP LOGIN</label></th>
			<td><input name="enable_wp_login_button" type="checkbox" id="enable_wp_login_button" value="yes" class="regular-text" <?php echo $enable_wp_login_button==="yes"? "checked":"";?>/></td>
		</tr>
		<tr>
			<th scope="row"><label for="enable_wc_login_button">Enable on WooCommerce My Account</label></th>
			<td><input name="enable_wc_login_button" type="checkbox" id="enable_wc_login_button" value="yes" class="regular-text" <?php echo $enable_wc_login_button==="yes"? "checked":"";?>/></td>
		</tr>
		<tr>
			<th scope="row"><label for="enable_auto_login">Enable Auto Login</label></th>
			<td><input name="enable_auto_login" type="checkbox" id="enable_auto_login" value="yes" class="regular-text" <?php echo $enable_auto_login==="yes"? "checked":"";?>/></td>
		</tr>
		</table>
		<?php submit_button(); ?>
	</form>
	<div class="donation-group">
		<h3>Coffee is always a good idea</h3>
		<p>
			<a href="https://www.buymeacoffee.com/surendhar153" class="button button-primary">Donate</a>
		</p>
		<img class="donate-image" src="<?php echo GOTL_PLUGIN_DIR_URL.'/assets/images/get-me-a-coffee.png'; ?>">
	</div>
</div>
