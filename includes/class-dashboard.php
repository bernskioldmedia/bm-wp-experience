<?php
/**
 * Dashboard Extensions
 * 
 * Remove unnecessary dashboard widgets, and add 
 * some custom ones too.
 *
 * @package BernskioldMedia\WP\Experience
 */

namespace BernskioldMedia\WP\Experience;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Dashboard
 */
class Dashboard {

    /**
	 * Init.
	 */
	public static function init() {

		// Remove non-necessary dashboard widgets.
		add_action( 'wp_dashboard_setup', [ self::class, 'remove_dashboard_widgets' ] );

    }
    
    /**
	 * Remove Dashboard Widgets
	 *
	 * @return void
	 */
	public static function remove_dashboard_widgets() {

		global $wp_meta_boxes;

		// Hide Some Default Dashboard Widgets.
		unset( $wp_meta_boxes['dashboard']['normal']['core']['dashboard_plugins'] );
		unset( $wp_meta_boxes['dashboard']['side']['core']['dashboard_primary'] );
		unset( $wp_meta_boxes['dashboard']['side']['core']['dashboard_secondary'] );
		unset( $wp_meta_boxes['dashboard']['normal']['core']['dashboard_incoming_links'] );
		unset( $wp_meta_boxes['dashboard']['side']['core']['dashboard_quick_press'] );
		unset( $wp_meta_boxes['dashboard']['side']['core']['dashboard_recent_drafts'] );

	}

}

Dashboard::init();
