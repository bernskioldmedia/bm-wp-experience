<?php
/**
 * REST API Tweaks
 *
 * These are additional security tweaks for the REST API
 * that makes it inaccessible unless you are authorized.
 **/

namespace BernskioldMedia\WP\Experience;

/**
 * Class REST_API
 *
 * @package BernskioldMedia\WP\Experience
 */
class REST_API {

	/**
	 * WordPress Hooks
	 */
	public static function hooks() {
		add_filter( 'rest_authentication_errors', [ self::class, 'restrict' ], 99 );
		add_filter( 'rest_endpoints', [ self::class, 'restrict_user_endpoints' ] );
		add_filter( 'determine_current_user', [ self::class, 'handle_basic_auth' ], 20 );
	}

	/**
	 * If we have chosen to restrict the REST API, we send a 403
	 * status back if we are not authenticated.
	 *
	 * @param  \WP_Error|null|bool  $result  Error from another authentication handler,
	 *                                       null if we should handle it, or another value
	 *                                       if not.
	 *
	 * @return \WP_Error|null|bool
	 */
	public static function restrict( $result ) {

		// Respect other handlers
		if ( null !== $result ) {
			return $result;
		}

		$is_restricted = self::get_restricted_status();

		if ( 'all' === $is_restricted && ! is_user_logged_in() ) {
			return new \WP_Error( 'rest_api_restricted', __( 'Authentication is required.', 'bm-wp-experience' ), [
				'status' => rest_authorization_required_code(),
			] );
		}

		return $result;

	}

	/**
	 * Restrict requests to user endpoints unless authenticated.
	 * This will prevent
	 *
	 * @param  array  $endpoints  Array of endpoints
	 *
	 * @return array
	 */
	public static function restrict_user_endpoints( $endpoints ) {

		$restrict = self::get_restricted_status();

		if ( 'none' === $restrict ) {
			return $endpoints;
		}

		if ( ! is_user_logged_in() ) {
			$keys = preg_grep( '/\/wp\/v2\/users\b/', array_keys( $endpoints ) );

			foreach ( $keys as $key ) {
				unset( $endpoints[ $key ] );
			}

			return $endpoints;
		}

		return $endpoints;
	}

	/**
	 * Get Restriction Status
	 *
	 * If nothing is set, we default to restricting everything.
	 *
	 * @return string
	 */
	public static function get_restricted_status() {

		$level = 'all';

		if ( defined( 'BM_WP_RESTRICT_REST_API' ) ) {

			if ( in_array( BM_WP_RESTRICT_REST_API, [ 'all', 'users', 'none' ], true ) ) {
				$level = BM_WP_RESTRICT_REST_API;
			}
		}

		return apply_filters( 'bm_wpexp_rest_api_restriction_level', $level );

	}

	/**
	 * Handle Basic Authentication
	 *
	 * @param  \WP_User|null  $user
	 *
	 * @return  null|\WP_User
	 */
	public static function handle_basic_auth( $user ) {

		// Don't authenticate twice
		if ( ! empty( $user ) ) {
			return $user;
		}

		// Check that we're trying to authenticate
		if ( ! isset( $_SERVER['PHP_AUTH_USER'] ) ) {
			return $user;
		}

		$username = wp_strip_all_tags( $_SERVER['PHP_AUTH_USER'] );
		$password = wp_strip_all_tags( $_SERVER['PHP_AUTH_PW'] );

		/**
		 * In multi-site, wp_authenticate_spam_check filter is run on authentication. This filter calls
		 * get_currentuserinfo which in turn calls the determine_current_user filter. This leads to infinite
		 * recursion and a stack overflow unless the current function is removed from the determine_current_user
		 * filter during authentication.
		 */
		remove_filter( 'determine_current_user', [ self::class, 'handle_basic_auth' ], 20 );

		$user = wp_authenticate( $username, $password );

		add_filter( 'determine_current_user', [ self::class, 'handle_basic_auth' ], 20 );


		if ( is_wp_error( $user ) ) {
			return null;
		}

		return $user->ID;

	}

}

REST_API::hooks();
