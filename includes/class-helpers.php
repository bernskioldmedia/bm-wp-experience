<?php
/**
 * Helpers
 *
 * This class contains small helpers that can be used in this plugin,
 * and referenced on all sites running this as a platform base.
 *
 * @package BernskioldMedia\WP\Experience
 */

namespace BernskioldMedia\WP\Experience;

/**
 * Class Helpers
 */
class Helpers {

	/**
	 * WordPress has a function to check if a plugin is active.
	 * Unfortunately it is only loaded in the admin. We want a function
	 * we can rely on throughout the system.
	 *
	 * @param  string  $plugin_file  The name of the main plugin file, relative to the main plugin dir. Example: my-plugin/my-plugin.php.
	 *
	 * @return bool
	 */
	public static function is_plugin_active( string $plugin_file ): bool {
		return in_array( $plugin_file, (array) get_option( 'active_plugins', [] ), true ) || self::is_plugin_active_for_network( $plugin_file );
	}

	/**
	 * WordPress has its own function to check if a plugin is network activated.
	 * Unfortunately it is only loaded in the admin. We want a function we can
	 * rely on throughout the system.
	 *
	 * @param  string  $plugin_file  The name of the main plugin file, relative to the main plugin dir. Example: my-plugin/my-plugin.php.
	 *
	 * @return bool
	 */
	public static function is_plugin_active_for_network( string $plugin_file ): bool {
		if ( ! is_multisite() ) {
			return false;
		}

		$plugins = get_site_option( 'active_sitewide_plugins' );

		if ( isset( $plugins[ $plugin_file ] ) ) {
			return true;
		}

		return false;
	}
}
