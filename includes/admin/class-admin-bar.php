<?php
/**
 * Add options to the admin bar.
 *
 * @package BernskioldMedia\WP\Experience
 **/

namespace BernskioldMedia\WP\Experience;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Admin_Bar
 *
 * @package BernskioldMedia\WP\Experience
 */
class Admin_Bar {

	/**
	 * WordPress Hooks
	 */
	public static function hooks() {
		add_action( 'admin_bar_menu', [ self::class, 'about_bm' ] );
		add_action( 'admin_bar_menu', [ self::class, 'support' ], 60 );
		add_action( 'admin_bar_menu', [ self::class, 'customizer' ], 60 );
		add_action( 'admin_bar_menu', [ self::class, 'remove' ], 999999 );

		add_action( 'wp_enqueue_scripts', [ self::class, 'assets' ] );
		add_action( 'admin_enqueue_scripts', [ self::class, 'assets' ] );
	}

	/**
	 * Load admin bar assets.
	 */
	public static function assets() {
		wp_register_style( 'bm-admin-bar', BM_WP_Experience::get_assets_url( 'styles/dist/admin-bar.css' ), [], BM_WP_Experience::get_version(), 'all' );

		if ( is_admin_bar_showing() ) {
			wp_enqueue_style( 'bm-admin-bar' );
		}

	}

	/**
	 * Remove certain items from the admin bar,
	 * that are most often irrelevant for our users.
	 *
	 * Nodes can be designated as "always", "admin" or "frontend"
	 * to choose where we will remove them from.
	 *
	 * @param \WP_Admin_Bar $wp_admin_bar
	 */
	public static function remove( $wp_admin_bar ) {

		$nodes_to_remove = apply_filters( 'bm_wpexp_remove_admin_bar_items', [
			'comments'   => 'always',
			'wpseo-menu' => 'always',
			'new_draft'  => 'always',
			'customize'  => 'always',
			'updates'    => 'frontend',
		] );

		foreach ( $nodes_to_remove as $id => $place ) {

			if ( is_admin() && 'admin' === $place ) {
				$wp_admin_bar->remove_node( $id );
			}

			if ( ! is_admin() && 'frontend' === $place ) {
				$wp_admin_bar->remove_node( $id );
			}

			if ( 'always' === $place ) {
				$wp_admin_bar->remove_node( $id );
			}
		}

	}

	/**
	 * Add a "Support" menu item to the admin bar.
	 *
	 * @param \WP_Admin_Bar $wp_admin_bar
	 */
	public static function support( $wp_admin_bar ) {

		/**
		 * Allow the option of hiding the admin bar
		 * links via a filter.
		 */
		if ( false === apply_filters( 'bm_wpexp_show_admin_bar_support', true ) ) {
			return;
		}

		/**
		 * Hide the admin bar link in admin.
		 */
		if ( is_admin() ) {
			return;
		}

		$wp_admin_bar->add_node( [
			'id'    => 'bm-support',
			'title' => '<span class="bm-support-icon"></span> ' . esc_html__( 'Help & Support', 'bm-wp-experience' ),
			'href'  => esc_url( apply_filters( 'bm_wpexp_admin_bar_support_url', admin_url( 'admin.php?page=bm-support' ) ) ),
			'meta'  => [
				'title' => esc_html__( 'Help & Support', 'bm-wp-experience' ),
				'class' => 'ab-help-support',
			],
		] );

	}

	/**
	 * Re-hooking the customizer to place it under the home
	 * menu item on frontend.
	 *
	 * @param \WP_Admin_Bar $wp_admin_bar
	 */
	public static function customizer( $wp_admin_bar ) {

		/**
		 * Hide the admin bar link in admin.
		 */
		if ( is_admin() ) {
			return;
		}

		$wp_admin_bar->add_node( [
			'id'     => 'bm-customizer',
			'parent' => 'site-name',
			'title'  => '<span class="bm-support-icon"></span> ' . esc_html__( 'Customize', 'bm-wp-experience' ),
			'href'   => esc_url( admin_url( 'customize.php' ) ),
			'meta'   => [
				'title' => esc_html__( 'Customize the site appearance.', 'bm-wp-experience' ),
				'class' => 'ab-customizer',
			],
		] );

	}

	/**
	 * Add an "About BM" menu item to the admin bar.
	 *
	 * @param \WP_Admin_Bar $wp_admin_bar
	 */
	public static function about_bm( $wp_admin_bar ) {

		/**
		 * Allow the option of hiding the admin bar
		 * links via a filter.
		 */
		if ( false === apply_filters( 'bm_wpexp_show_admin_bar_bm', true ) ) {
			return;
		}

		if ( is_user_logged_in() && current_user_can( 'edit_posts' ) ) {

			$wp_admin_bar->add_node( [
				'id'    => 'bm',
				'title' => '<div class="bm-icon ab-item"><span class="screen-reader-text">' . esc_html__( 'Bernskiold Media', 'bm-wp-experience' ) . '</span></div>',
				'href'  => admin_url( 'admin.php?page=bm-about' ),
				'meta'  => [
					'title' => 'Bernskiold Media',
				],
			] );

			$wp_admin_bar->add_node( [
				'id'     => 'bm-about',
				'parent' => 'bm',
				'title'  => esc_html__( 'About Bernskiold Media', 'bm-wp-experience' ),
				'href'   => esc_url( admin_url( 'admin.php?page=bm-about' ) ),
				'meta'   => [
					'title' => esc_html__( 'About Bernskiold Media', 'bm-wp-experience' ),
				],
			] );

			$wp_admin_bar->add_group( [
				'parent' => 'bm',
				'id'     => 'bm-list',
				'meta'   => [
					'class' => 'ab-sub-secondary',
				],
			] );

			$wp_admin_bar->add_node( [
				'id'     => 'bm-academy',
				'parent' => 'bm-list',
				'title'  => esc_html__( 'Academy', 'bm-wp-experience' ),
				'href'   => esc_url( _x( 'https://www.bernskioldmedia.com/en/academy/', 'BM Academy URL', 'bm-wp-experience' ) ),
				'meta'   => [
					'title' => esc_html__( 'Academy', 'bm-wp-experience' ),
				],
			] );

			$wp_admin_bar->add_node( [
				'id'     => 'bm-services',
				'parent' => 'bm-list',
				'title'  => esc_html__( 'Services', 'bm-wp-experience' ),
				'href'   => esc_url( _x( 'https://www.bernskioldmedia.com/en/services/', 'BM Services URL', 'bm-wp-experience' ) ),
				'meta'   => [
					'title' => esc_html__( 'Services', 'bm-wp-experience' ),
				],
			] );
		}

	}

}

Admin_Bar::hooks();
