<?php

namespace BernskioldMedia\WP\Experience\Modules;

use BernskioldMedia\WP\PluginBase\Interfaces\Hookable;
use PHPMailer\PHPMailer\PHPMailer;

class Mail implements Hookable {

	public static function hooks(): void {
		add_action( 'phpmailer_init', [ self::class, 'send_mail_via_smtp' ] );
	}

	public static function send_mail_via_smtp( PHPMailer $mailer ): void {

		if ( ! self::should_send_via_smtp() ) {
			return;
		}

		$mailer->set( 'Host', self::get_smtp_host() );
		$mailer->set( 'Port', self::get_smtp_port() );
		$mailer->set( 'Username', self::get_smtp_username() );
		$mailer->set( 'Password', self::get_smtp_password() );
		$mailer->set( 'SMTPAuth', true );
		$mailer->set( 'SMTPSecure', self::get_smtp_secure_type() );
		$mailer->isSMTP();
	}

	protected static function should_send_via_smtp(): bool {
		if ( 'production' !== wp_get_environment_type() ) {
			return self::should_send_smtp_outside_production();
		}

		return self::should_send_smtp_in_production();
	}

	protected static function should_send_smtp_outside_production(): bool {
		return defined( 'BM_WP_SMTP_OUTSIDE_PRODUCTION' ) && true === BM_WP_SMTP_OUTSIDE_PRODUCTION;
	}

	protected static function should_send_smtp_in_production(): bool {
		return defined( 'BM_WP_SMTP_ENABLED' ) && true === BM_WP_SMTP_ENABLED;
	}

	protected static function get_smtp_host(): ?string {
		return defined( 'BM_WP_SMTP_HOST' ) ? BM_WP_SMTP_HOST : null;
	}

	protected static function get_smtp_username(): ?string {
		return defined( 'BM_WP_SMTP_USERNAME' ) ? BM_WP_SMTP_USERNAME : null;
	}

	protected static function get_smtp_password(): ?string {
		return defined( 'BM_WP_SMTP_PASSWORD' ) ? BM_WP_SMTP_PASSWORD : null;
	}

	protected static function get_smtp_port(): int {
		return defined( 'BM_WP_SMTP_PORT' ) ? BM_WP_SMTP_PORT : 587;
	}

	protected static function get_smtp_secure_type(): string {
		return defined( 'BM_WP_SMTP_SECURITY' ) ? BM_WP_SMTP_SECURITY : 'tls';
	}

}
