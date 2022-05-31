<?php

$redirect_to = isset( $_REQUEST['redirect_to'] ) ? esc_url_raw( wp_unslash( $_REQUEST['redirect_to'] ) ) : admin_url();
$remember_me = ! empty( $_REQUEST['rememberme'] );
?>

<?php if ( isset( $error ) ) : ?>
	<div id="login_error"><strong><?php esc_html_e( 'Error', 'bm-wp-experience' ); ?></strong>: <?php echo esc_html( $error ); ?></div>
<?php endif ?>

<form class="two-factor-validation-form two-factor-backup-code-form" name="2fa_backup_code_validation" id="loginform" action="<?php echo esc_url( add_query_arg( 'action',
	'2fa_backup', wp_login_url() ) ); ?>" method="post">
	<p><?php esc_html_e( 'Please enter one of your backup codes to log into your account.', 'bm-wp-experience' ); ?></p>

	<p>
		<label for="backup_code" class="screen-reader-text"><?php esc_html_e( 'Backup Code:', 'bm-wp-experience' ); ?></label>
		<input name="backup_code" id="backup_code" class="input two-factor-backup-code-input" value="" pattern="[0-9]*" autofocus type="number" />
	</p>

	<input type="hidden" name="backup_code_used" value="1" />
	<input type="hidden" name="user_id" id="user_id" value="<?php echo esc_attr( $user->ID ); ?>" />
	<input type="hidden" name="redirect_to" value="<?php echo esc_attr( $redirect_to ); ?>" />
	<input type="hidden" name="rememberme" id="rememberme" value="<?php echo esc_attr( $remember_me ); ?>" />

	<?php submit_button( __( 'Log In', 'bm-wp-experience' ) ); ?>
</form>

<style>
	#login form.two-factor-validation-form > p:first-child {
		margin-bottom: 0.75rem;
	}

	input[type=number]::-webkit-inner-spin-button,
	input[type=number]::-webkit-outer-spin-button {
		-webkit-appearance: none;
		margin: 0;
	}
</style>
