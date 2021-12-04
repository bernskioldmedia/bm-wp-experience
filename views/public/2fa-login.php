<?php

$backup_codes_action = add_query_arg( [
	'action'  => 'load_backup_codes',
	'user_id' => $user->ID,
], wp_login_url() );

$redirect_to = isset( $_REQUEST['redirect_to'] ) ? esc_url_raw( wp_unslash( $_REQUEST['redirect_to'] ) ) : admin_url();
$remember_me = ! empty( $_REQUEST['rememberme'] );
?>

<?php if ( isset( $error ) ) : ?>
	<div id="login_error">
		<strong><?php esc_html_e( 'Error', 'bm-wp-experience' ); ?></strong>: <?php echo esc_html( $error ); ?>
	</div>
<?php endif; ?>

<form class="two-factor-validation-form two-factor-one-time-code-form" name="2fa_validation" id="loginform" action="<?php echo esc_url( add_query_arg( 'action', '2fa_validation',
	wp_login_url() ) ); ?>" method="post">
	<p><?php esc_html_e( 'Please enter the verification code from your authenticator app.', 'bm-wp-experience' ); ?></p>

	<p>
		<label class="screen-reader-text" for="two_factor_token"><?php esc_html_e( 'Authentication Code:', 'bm-wp-experience' ); ?></label>
		<input
			class="two-factor-token-input input"
			type="number"
			name="two_factor_token"
			id="two_factor_token"
			inputmode="numeric"
			pattern="[0-9]*"
			autocomplete="one-time-code"
			autofocus
		/>
	</p>

	<input type="hidden" name="user_id" value="<?php echo esc_attr( $user->ID ); ?>" />
	<input type="hidden" name="redirect_to" value="<?php echo $redirect_to; ?>" />
	<input type="hidden" name="rememberme" id="rememberme" value="<?php echo $remember_me; ?>" />

	<?php submit_button( __( 'Log In', 'bm-wp-experience' ) ); ?>
</form>

<p id="nav" class="two-factor-backup-code-action">
	<a href="<?php echo esc_url( $backup_codes_action ); ?>">
		<?php esc_html_e( 'Login using backup code', 'bm-wp-experience' ); ?>
	</a>
</p>

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
