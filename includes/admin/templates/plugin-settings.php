<?php
// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$gotl_options = get_option( 'gotl_admin_settings' );
?>
<style type="text/css">
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
	<form method="POST">
		<?php wp_nonce_field( "gotl-admin-settings" );?>
		<tr>
			<th scope="row"><label for="googleclientid">Google Client ID</label></th>
			<td><input name="googleclientid" type="text" id="googleclientid" value="<?php echo esc_attr($gotl_options['googleclientid']);?>" class="regular-text" /></td>
		</tr>
		<?php submit_button(); ?>
	</form>
	<div class="donation-group">
		<h3>Coffee is always a good idea</h3>
		<p>
			<a href="https://bit.ly/paypal-surendhar153" class="button button-primary">Donate</a>
		</p>
		<img class="donate-image" src="<?php echo GOTL_PLUGIN_DIR_URL.'/assets/images/get-me-a-coffee.png'; ?>">
	</div>
</div>
