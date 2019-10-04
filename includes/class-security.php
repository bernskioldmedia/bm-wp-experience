<?php
/**
 * Security
 *
 * We set up the WordPress environment for enterprise-grade
 * WordPress security by tweaking constants and adding
 * various security tweaks.
 *
 * Some additional REST API security-related settings can be found
 * in the REST_API class.
 *
 * @package BernskioldMedia\WP\Experience
 **/

namespace BernskioldMedia\WP\Experience;

/**
 * Class Security
 *
 * @package BernskioldMedia\WP\Experience
 */
class Security {

	/**
	 * Top-level domains on local testing sites.
	 * These are whitelisted for weak passwords.
	 */
	protected const TEST_TLDS = [
		'test',
		'dev',
		'local',
		'',
	];

	/**
	 * Define passwords that we always classify as weak.
	 */
	protected const WEEK_PASSWORDS = [
		'123456',
		'Password',
		'password',
		'12345678',
		'qwerty',
		'12345',
		'123456789',
		'letmein',
		'1234567',
		'football',
		'iloveyou',
		'admin',
		'welcome',
		'monkey',
		'login',
		'abc123',
		'starwars',
		'123123',
		'dragon',
		'passw0rd',
		'master',
		'hello',
		'freedom',
		'whatever',
		'qazwsx',
		'654321',
		'password1',
		'1234',
	];


	public static function init() {

		/**
		 * Disable the core file editor so that nobody
		 * can modify files from the admin.
		 */
		if ( ! defined( 'DISALLOW_FILE_EDIT' ) ) {
			define( 'DISALLOW_FILE_EDIT', true );
		}

		add_filter( 'authenticate', [ self::class, 'prevent_weak_password_auth' ], 30, 3 );

	}

	/**
	 * Prevent users from authenticating if they are using a weak password
	 *
	 * @param \WP_User $user     User object
	 * @param string   $username Username
	 * @param string   $password Password
	 *
	 * @return \WP_User|\WP_Error
	 */
	public static function prevent_weak_password_auth( $user, $username, $password ) {

		// Get the TLD from the domain.
		$tld = preg_replace( '#^.*\.(.*)$#', '$1', wp_parse_url( site_url(), PHP_URL_HOST ) );

		if ( ! in_array( $tld, self::get_test_tlds(), true ) && in_array( strtolower( trim( $password ) ), self::get_weak_passwords(), true ) ) {

			/* translators: 1. Lost Password URL */
			$error_message = sprintf( __( 'Please <a href="%s">reset your password</a> in order to meet the security guidelines for this website.', 'bm-wp-experience' ), esc_url( wp_lostpassword_url() ) );

			return new \WP_Error( 'Auth Error', $error_message );
		}

		return $user;
	}

	/**
	 * Get an array of passwords that we deem
	 * as too weak to be allowed.
	 *
	 * @filter bm_wpexp_weak_passwords
	 *
	 * @return array
	 */
	public static function get_weak_passwords() {
		return apply_filters( 'bm_wpexp_weak_passwords', self::WEEK_PASSWORDS );
	}

	/**
	 * Get test top-level domains.
	 *
	 * @filter bm_wpexp_test_tlds
	 *
	 * @return array
	 */
	public static function get_test_tlds() {
		return apply_filters( 'bm_wpexp_test_tlds', self::TEST_TLDS );
	}


}

Security::init();
