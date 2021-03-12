<?php

namespace BernskioldMedia\WP\Experience;

/**
 * Class Multisite
 *
 * @package BernskioldMedia\WP\Experience
 * @since   1.4.0
 */
class Multisite {

	public static function init() {

		// Only run on multisite.
		if ( ! is_multisite() ) {
			return;
		}

		/**
		 * Fixes so that WordPress multisite uses the local blog for password resets where the
		 * user is currently signing in, instead of the main blog.
		 */
		add_filter( 'lostpassword_url', [ self::class, 'local_blog_lostpassword_url' ], 10, 2 );
		add_filter( 'network_site_url', [ self::class, 'local_blog_password_reset_urls' ], 10, 3 );
		add_filter( 'retrieve_password_message', [ self::class, 'local_blog_password_reset_email_url' ], 10 );
		add_filter( 'retrieve_password_title', [ self::class, 'local_blog_password_reset_email_name' ] );
	}

	/**
	 * Make the lost password URL go to the local blog instead of the main blog.
	 *
	 * @param $url
	 * @param $redirect
	 *
	 * @return string
	 * @since   1.4.0
	 */
	public static function local_blog_lostpassword_url( $url, $redirect ) {

		$args = [ 'action' => 'lostpassword' ];

		if ( ! empty( $redirect ) ) {
			$args['redirect_to'] = $redirect;
		}

		return add_query_arg( $args, site_url( 'wp-login.php' ) );
	}

	/**
	 * Replace the password reset URL with the local blog version instead of
	 * going to the main blog.
	 *
	 * @param  string  $url
	 * @param  string  $path
	 * @param  string  $scheme
	 *
	 * @return string|void
	 * @since   1.4.0
	 */
	public static function local_blog_password_reset_urls( $url, $path, $scheme ) {

		if ( stripos( $url, "action=lostpassword" ) !== false ) {
			return site_url( 'wp-login.php?action=lostpassword', $scheme );
		}

		if ( stripos( $url, "action=resetpass" ) !== false ) {
			return site_url( 'wp-login.php?action=resetpass', $scheme );
		}

		return $url;
	}

	/**
	 * Fix the body of the password reset email to replace the URLs
	 * for the main blog, with the local blog.
	 *
	 * @param  string  $message
	 *
	 * @return string
	 * @since   1.4.0
	 */
	public static function local_blog_password_reset_email_url( $message ) {
		return str_replace( get_site_url( 1 ), get_site_url(), $message );
	}

	/**
	 * Fix the title in the email to use the local blog name instead of main blog name
	 * for password resets.
	 *
	 * @param  string  $title
	 *
	 * @return string
	 * @since   1.4.0
	 */
	public static function local_blog_password_reset_email_name( $title ) {
		/* translators: 1. Blog Name */
		return sprintf( __( '[%s] Password Reset', 'bm-wp-experience' ), wp_specialchars_decode( get_option( 'blogname' ), ENT_QUOTES ) );
	}

}

Multisite::init();
