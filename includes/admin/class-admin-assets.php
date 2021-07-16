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
		add_action( 'admin_enqueue_scripts', [ self::class, 'admin_styles' ] );
	}

	/**
	 * Registers and enqueues plugin admin stylesheets.
	 **/
	public static function admin_styles() {
		wp_register_style( 'bm-wp-experience-admin', BM_WP_Experience::get_assets_url() . '/styles/dist/admin.css', false, BM_WP_Experience::get_version() );

		wp_enqueue_style( 'bm-wp-experience-admin' );

		if ( true === apply_filters( 'bm_wpexp_custom_admin_theme', true ) ) {
			wp_register_style( 'bm-wp-experience-admin-theme', BM_WP_Experience::get_assets_url() . '/styles/dist/admin-theme.css', false, BM_WP_Experience::get_version() );

			wp_enqueue_style( 'bm-wp-experience-admin-theme' );
		}
	}
}

Admin_Assets::init();
