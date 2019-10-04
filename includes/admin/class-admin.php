<?php
/**
 * Admin
 *
 * General admin adjustments.
 *
 * @package BernskioldMedia\WP\Experience
 **/

namespace BernskioldMedia\WP\Experience;

class Admin {

	/**
	 * Initialize
	 */
	public static function init() {

		// Remove version from footer.
		add_action( 'admin_menu', [ self::class, 'admin_no_footer_version' ] );

		// Change admin footer text.
		add_filter( 'admin_footer_text', [ self::class, 'change_admin_footer_text' ] );

	}

	/**
	 * Change Admin Footer Text
	 *
	 * @return string
	 */
	public static function change_admin_footer_text() {

		$new_text = __( 'Thank you for creating with <a href="https://wordpress.org">WordPress</a> and <a href="https://www.bernskioldmedia.com/en/?utm_source=clientsite&utm_medium=dashboard&utm_campaign=footerlink">Bernskiold Media</a>.', 'bm-wp-experience' );

		return $new_text;

	}

	/**
	 * Admin No Footer Version
	 *
	 * @return void
	 */
	public static function admin_no_footer_version() {
		remove_filter( 'update_footer', 'core_update_footer' );
	}

}

Admin::init();
