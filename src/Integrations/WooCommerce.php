<?php

namespace BernskioldMedia\WP\Experience\Integrations;

use BMWPEXP_Vendor\BernskioldMedia\WP\PluginBase\Interfaces\Hookable;

class WooCommerce extends Integration {

	public static string $plugin_file = 'woocommerce/woocommerce.php';

	public static function hooks(): void {
		// Disable startup wizard.
		add_filter( 'woocommerce_enable_setup_wizard', function() {
			return false;
		}, 20 );

		// Disable marketing.
		add_filter( 'woocommerce_marketing_menu_items', '__return_empty_array' );
		add_filter( 'woocommerce_admin_features', [ self::class, 'disable_marketing_features' ] );

		/**
		 * Suppress notices about connecting your store to woocommerce to receive updates and extensions.
		 * Also suppress general message for woocommerce.com plugin
		 */
		add_filter( 'woocommerce_helper_suppress_admin_notices', '__return_true' );

		// No suggestions from WooCommerce marketplace.
		add_filter( 'woocommerce_allow_marketplace_suggestions', '__return_false', 999 );

		// Remove extension library from menus.
		remove_submenu_page( 'woocommerce', 'wc-addons' );
		remove_submenu_page( 'woocommerce', 'wc-addons&section=helper' );

		// Remove SkyVerge support dashboard.
		add_action( 'admin_menu', function() { remove_menu_page( 'skyverge' ); }, 99 );
		add_action( 'admin_enqueue_scripts', function() { wp_dequeue_style( 'sv-wordpress-plugin-admin-menus' ); }, 20 );

		// Hide WooCommerce dashboard widgets.
		add_action( 'wp_dashboard_setup', [ self::class, 'hide_woocommerce_dashboard_widgets' ] );

		// Remove WooCommerce widgets.
		add_action( 'widgets_init', [ self::class, 'unregister_woocommerce_widgets' ], 99 );

		// Hide notice to install WC Admin.
		add_filter( 'woocommerce_show_admin_notice', [ self::class, 'hide_wc_admin_install_notice' ], 10, 2 );

		// Remove Processing Order Count in wp-admin.
		add_filter( 'woocommerce_menu_order_count', 'false' );

		// Delete the WooCommerce usage tracker cron event
		wp_clear_scheduled_hook( 'woocommerce_tracker_send_event' );
	}

	public static function disable_marketing_features( array $features ): array {
		$marketing = array_search( 'marketing', $features, true );
		unset( $features[ $marketing ] );

		return $features;
	}

	public static function hide_woocommerce_dashboard_widgets(): void {
		// Status
		remove_meta_box( 'woocommerce_dashboard_status', 'dashboard', 'normal' );

		// Setup help
		remove_meta_box( 'wc_admin_dashboard_setup', 'dashboard', 'normal' );

		// Elementor
		remove_meta_box( 'e-dashboard-overview', 'dashboard', 'normal' );
	}

	public static function unregister_woocommerce_widgets(): void {
		$widgets = apply_filters( 'bm_wpexp_woocommerce_widgets', [
			'WC_Widget_Products',
			'WC_Widget_Product_Categories',
			'WC_Widget_Product_Tag_Cloud',
			'WC_Widget_Cart',
			'WC_Widget_Layered_Nav',
			'WC_Widget_Layered_Nav_Filters',
			'WC_Widget_Price_Filter',
			'WC_Widget_Product_Search',
			'WC_Widget_Recently_Viewed',
			'WC_Widget_Recent_Reviews',
			'WC_Widget_Top_Rated_Products',
			'WC_Widget_Rating_Filter',
		] );

		foreach ( $widgets as $widget ) {
			unregister_widget( $widget );
		}
	}

	public static function hide_wc_admin_install_notice( bool $notice_enabled, string $notice ): bool {
		if ( 'wc_admin' === $notice ) {
			return false;
		}

		return $notice_enabled;
	}
}
