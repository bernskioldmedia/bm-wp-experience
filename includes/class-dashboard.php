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
		add_action( 'wp_dashboard_setup', [ self::class, 'remove_dashboard_widgets' ] );
		add_action( 'wp_network_dashboard_setup', [ self::class, 'remove_dashboard_widgets' ] );
		add_action( 'wp_user_dashboard_setup', [ self::class, 'remove_dashboard_widgets' ] );

		add_action( 'wp_dashboard_setup', [ self::class, 'add_bm_academy_dashboard_widget' ] );
	}

	/**
	 * Remove Dashboard Widgets
	 *
	 * @return void
	 */
	public static function remove_dashboard_widgets() {
		remove_meta_box( 'dashboard_primary', get_current_screen(), 'side' );
		remove_meta_box( 'dashboard_secondary', get_current_screen(), 'side' );
		remove_meta_box( 'dashboard_plugins', get_current_screen(), 'normal' );
		remove_meta_box( 'dashboard_incoming_links', get_current_screen(), 'normal' );
		remove_meta_box( 'dashboard_quick_press', get_current_screen(), 'side' );
		remove_meta_box( 'dashboard_recent_drafts', get_current_screen(), 'side' );

		remove_meta_box( 'wpseo-dashboard-overview', get_current_screen(), 'side' );

		if ( Updates::is_on_maintenance_plan() ) {
			remove_meta_box( 'dashboard_site_health', 'dashboard', 'normal' );
		}
	}

	public static function add_bm_academy_dashboard_widget() {
		wp_add_dashboard_widget( 'bm_academy', __( 'Bernskiold Media Academy', 'bm-wp-experience' ), static function () {
			$feed = fetch_feed( 'https://bernskioldmedia.com/sv/feed/' );

			if ( is_wp_error( $feed ) ) {
				echo __( 'Unfortunately the academy content is not currently available.', 'bm-wp-experience' );
			} else {
				$feed->init();
				$feed->set_output_encoding( 'UTF-8' );
				$feed->handle_content_type();
				$feed->set_cache_duration( 21600 );
				$limit = $feed->get_item_quantity( 5 );
				$items = $feed->get_items( 0, $limit );

				include BM_WP_Experience::get_view_path( 'dashboard-widgets/academy-feed' );
			}
		}, null, null, 'side' );
	}
}

Dashboard::init();
