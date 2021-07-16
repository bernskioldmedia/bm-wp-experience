<?php
/**
 * Updates Functions
 *
 * @package BernskioldMedia\WP\Experience
 */

namespace BernskioldMedia\WP\Experience;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Updates
 */
class Updates {

	/**
	 * Init.
	 */
	public static function init() {
		// Only run this if we have explicitly said we are on a maintenance plan.
		if ( ! self::is_on_maintenance_plan() ) {
			return;
		}

		remove_action( 'admin_notices', 'update_nag', 3 );
		remove_filter( 'update_footer', 'core_update_footer' );

		// Don't send e-mails for auto-updates on core, plugins or themes.
		add_filter( 'auto_core_update_send_email', [ self::class, 'dont_send_auto_update_emails' ], 10, 2 );
		add_filter( 'auto_plugin_update_send_email', '__return_false' );
		add_filter( 'auto_theme_update_send_email', '__return_false' );
	}

	/**
	 * Check if this website is on a maintenance plan.
	 *
	 * @return bool
	 */
	public static function is_on_maintenance_plan() {
		return defined( 'BM_WP_HAS_MAINTENANCE_PLAN' ) && BM_WP_HAS_MAINTENANCE_PLAN === true;
	}

	/**
	 * Prevent sending auto update e-mails for core updates.
	 *
	 * @param $send
	 * @param  string  $type
	 *
	 * @return bool
	 */
	public static function dont_send_auto_update_emails( $send, $type ) {
		return ! ( ! empty( $type ) && $type === 'success' );
	}

}

Updates::init();
