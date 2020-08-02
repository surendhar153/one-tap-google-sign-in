<?php
// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$gotl_options = get_option( 'gotl_admin_settings' );
?>
<div class="wrap">
	<h1>Google One Tap Login</h1>
	<p>Version: <?php echo GOTL_VERSION; ?></p>
	<form method="POST">
		<?php wp_nonce_field( "gotl-admin-settings" );?>
		<tr>
			<th scope="row"><label for="googleclientid">Google Client ID</label></th>
			<td><input name="googleclientid" type="text" id="googleclientid" value="<?php echo $gotl_options['googleclientid'];?>" class="regular-text" /></td>
		</tr>
		<?php submit_button(); ?>
	</form>
</div>