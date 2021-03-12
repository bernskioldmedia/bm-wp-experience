<?php
/**
 * Environments
 *
 * We add some staging-related smartness to reduce workload on
 * environments. Such as automatically hiding non-production from Google,
 * as well as having a clear staging message printed.
 *
 * @package BernskioldMedia\WP\Experience
 **/

namespace BernskioldMedia\WP\Experience;

/**
 * Class Environments
 *
 * @package BernskioldMedia\WP\Experience
 */
class Environments {

	public static function init() {
		add_action( 'admin_bar_menu', [ self::class, 'show_in_admin_bar' ], 40 );
	}

	/**
	 * Add a menu bar item showing the current environment.
	 *
	 * @param  \WP_Admin_Bar  $wp_admin_bar
	 */
	public static function show_in_admin_bar( $wp_admin_bar ) {

		if ( false === apply_filters( 'bm_wpexp_environment_show_admin_bar', true ) ) {
			return;
		}

		$required_role = apply_filters( 'bm_wpexp_environment_role', 'manage_options' );

		if ( ! current_user_can( $required_role ) ) {
			return;
		}

		$wp_admin_bar->add_node( [
			'id'    => 'bm-environment',
			'title' => self::get_admin_bar_environment_label(),
			'href'  => '#',
			'meta'  => [
				'class' => 'ab-environment-label environment--' . wp_get_environment_type(),
			],
		] );

	}

	protected static function get_admin_bar_environment_label() {

		$environment = wp_get_environment_type();

		switch ( $environment ) {
			case 'local':
			case 'development':
				$label = __( 'Local', 'bm-wp-experience' );
				break;

			case 'staging':
				$label = __( 'Staging', 'bm-wp-experience' );
				break;

			case 'production':
			default:
				$label = __( 'Production', 'bm-wp-experience' );
				break;
		}

		return apply_filters( 'bm_wpexp_staging_environment_label', $label, $environment );
	}


}

Environments::init();
