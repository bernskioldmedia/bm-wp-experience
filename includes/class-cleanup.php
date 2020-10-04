<?php
/**
 * Cleanup WordPress Output
 *
 * Some things added to WordPress are not things we need.
 * These are cleanup and tweaks functions.
 *
 * @package BernskioldMedia\WP\Experience
 */

namespace BernskioldMedia\WP\Experience;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Cleanup
 */
class Cleanup {

	/**
	 * Init.
	 */
	public static function init() {

		// Clean up wp_head().
		self::wp_head_cleanup();

		// Remove WordPress Version from RSS Feeds.
		add_filter( 'the_generator', '__return_false' );

		// Rewrites the search URL.
		add_action( 'template_redirect', [ self::class, 'nice_search_url' ] );

		// Blank Search Query Fix.
		add_filter( 'request', [ self::class, 'blank_search_fix' ] );

	}

	/**
	 * Clean up wp_head() from unnecessary bloat.
	 *
	 * Remove unnecessary <link>'s
	 */
	public static function wp_head_cleanup() {

		if ( self::should_disable_feed_urls() ) {
			remove_action( 'wp_head', 'feed_links', 2 );
			remove_action( 'wp_head', 'feed_links_extra', 3 );
		}

		remove_action( 'wp_head', 'rsd_link' );
		remove_action( 'wp_head', 'wlwmanifest_link' );
		remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10 );
		remove_action( 'wp_head', 'wp_generator' );
		remove_action( 'wp_head', 'wp_shortlink_wp_head', 10 );

		// all actions related to emojis.
		remove_action( 'admin_print_styles', 'print_emoji_styles' );
		remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
		remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
		remove_action( 'wp_print_styles', 'print_emoji_styles' );
		remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
		remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
		remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );

		// filter to remove TinyMCE emojis.
		add_filter( 'tiny_mce_plugins', [ self::class, 'disable_emojicons_tinymce' ] );

	}

	/**
	 * Disable Emojis in TincyMCE
	 *
	 * @param  array  $plugins  Active Plugins Array.
	 *
	 * @return array
	 */
	public static function disable_emojicons_tinymce( $plugins ) {

		if ( is_array( $plugins ) ) {
			return array_diff( $plugins, [ 'wpemoji' ] );
		} else {
			return [];
		}

	}

	/**
	 * Redirects search results from /?s=query to /search/query/
	 * and converts %20 to + in the URL.
	 *
	 * @link http://txfx.net/wordpress-plugins/nice-search/
	 * @link https://github.com/roots/roots/blob/master/lib/cleanup.php
	 */
	public static function nice_search_url() {

		global $wp_rewrite;

		if ( ! isset( $wp_rewrite ) || ! is_object( $wp_rewrite ) || ! $wp_rewrite->using_permalinks() ) {
			return;
		}

		$search_base = $wp_rewrite->search_base;

		if ( is_search() && ! is_admin() && strpos( $_SERVER['REQUEST_URI'], "/{$search_base}/" ) === false ) {
			wp_safe_redirect( home_url( "/{$search_base}/" . rawurlencode( get_query_var( 's' ) ) ) );
			exit();
		}

	}

	/**
	 * Fix for empty search queries redirecting to home page
	 *
	 * @link http://wordpress.org/support/topic/blank-search-sends-you-to-the-homepage#post-1772565
	 * @link http://core.trac.wordpress.org/ticket/11330
	 * @link https://github.com/roots/roots/blob/master/lib/cleanup.php
	 *
	 * @param  array  $query_vars  Query Vars.
	 *
	 * @return array
	 */
	public static function blank_search_fix( $query_vars ) {

		if ( isset( $_GET['s'] ) && empty( $_GET['s'] ) && ! is_admin() ) {
			$query_vars['s'] = ' ';
		}

		return $query_vars;

	}

	/**
	 * Lets you select in the application config whether to
	 * disable feed URLs in the <head> or not.
	 *
	 * If undefined, defaults to true = disable.
	 *
	 * @return bool
	 */
	protected static function should_disable_feed_urls(): bool {

		if ( ! defined( 'BM_WP_DISABLE_FEED_URLS' ) ) {
			return true;
		}

		return BM_WP_DISABLE_FEED_URLS;

	}
}

Cleanup::init();
