<?php
/**
 * Handles the loading of scripts and styles for the
 * theme through the proper enqueuing methods.
 *
 * @package BernskioldMedia\WP\Experience
 **/

namespace BernskioldMedia\WP\Experience;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Admin Assets Class
 *
 * @package BernskioldMedia\WP\Experience
 */
class Admin_Assets {

	/**
	 * Assets Constructor
	 */
	public static function init() {

		// Styles.
		// add_action( 'wp_enqueue_scripts', [ self::class, 'public_styles' ] );
		add_action( 'admin_enqueue_scripts', [ self::class, 'admin_styles' ] );

		// Scripts.
		// add_action( 'wp_enqueue_scripts', [ self::class, 'public_scripts' ] );
		// add_action( 'admin_enqueue_scripts', [ self::class, 'admin_scripts' ] );

	}

	/**
	 * Registers and enqueues public stylesheets.
	 **/
	public static function public_styles() {

		/**
		 * Register Main Stylesheet.
		 */
		wp_register_style( 'bm-wp-experience-public', BM_WP_Experience::get_assets_url() . '/styles/dist/app.css', false, BM_WP_Experience::get_version(), 'all' );

		/**
		 * Enqueue Stylesheets.
		 */
		wp_enqueue_style( 'bm-wp-experience-public' );

	}

	/**
	 * Registers and enqueues plugin admin stylesheets.
	 **/
	public static function admin_styles() {

		/**
		 * Register Main Stylesheet.
		 */
		wp_register_style( 'bm-wp-experience-admin', BM_WP_Experience::get_assets_url() . '/styles/dist/admin.css', false, BM_WP_Experience::get_version(), 'all' );

		/**
		 * Enqueue Stylesheets.
		 */
		wp_enqueue_style( 'bm-wp-experience-admin' );

	}

	/**
	 * Enqueue Scripts on public side
	 *
	 * We want to allow the use of good script debugging here too,
	 * so be mindful and use the SCRIPTS_DEBUG constant
	 * to load both minified for production and non-minified files
	 * for testing purposes.
	 **/
	public static function public_scripts() {

		/**
		 * Register the main, minified
		 * and compiled script file.
		 */
		wp_register_script( 'bm-wp-experience-app', BM_WP_Experience::get_assets_url() . '/scripts/dist/app.js', [ 'jquery' ], BM_WP_Experience::get_version(), true );

		// Enqueue.
		wp_enqueue_script( 'bm-wp-experience-app' );

	}

	/**
	 * Enqueue Scripts on admin side
	 *
	 * We want to allow the use of good script debugging here too,
	 * so be mindful and use the SCRIPTS_DEBUG constant
	 * to load both minified for production and non-minified files
	 * for testing purposes.
	 **/
	public static function admin_scripts() {

		/**
		 * Register the main, minified
		 * and compiled script file.
		 */
		wp_register_script( 'bm-wp-experience-admin', BM_WP_Experience::get_assets_url() . '/scripts/dist/admin.js', [ 'jquery' ], BM_WP_Experience::get_version(), true );

		// Enqueue.
		wp_enqueue_script( 'bm-wp-experience-admin' );

	}
}

Admin_Assets::init();
