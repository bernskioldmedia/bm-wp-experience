<?php
/**
 * Plugin Name: BM WP Experience
 * Plugin URI:  https://www.bernskioldmedia.com
 * Description: Provides an opinionated WordPress experience with clean-up and tweaks that we at Bernskiold Media have found runs WordPress best.
 * Version:     1.4.0
 * Author:      Bernskiold Media
 * Author URI:  https://www.bernskioldmedia.com
 * Text Domain: bm-wp-experience
 * Domain Path: /languages/
 *
 * **************************************************************************
 *
 *  This program is free software: you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation, either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 *  GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License
 *  along with this program. If not, see <http://www.gnu.org/licenses/>.
 *
 * **************************************************************************
 *
 * @package BernskioldMedia\WP\Experience
 */

namespace BernskioldMedia\WP\Experience;

use Puc_v4_Factory;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require 'vendor/yahnis-elsts/plugin-update-checker/plugin-update-checker.php';

/**
 * Class BM_WP_Experience
 *
 * @package BernskioldMedia\WP\Experience
 */
class BM_WP_Experience {

	/**
	 * Version
	 *
	 * @var string
	 */
	protected const VERSION = '1.4.0';

	/**
	 * Database Version
	 *
	 * @var string
	 */
	protected const DATABASE_VERSION = '1000';

	/**
	 * URL to the GitHub Repository for the plugin.
	 */
	protected const GITHUB_REPO = 'https://github.com/bernskioldmedia/bm-wp-experience';

	/**
	 * Plugin Class Instance Variable
	 *
	 * @var object
	 */
	protected static $_instance = null;

	/**
	 * Data Stores
	 *
	 * @var array
	 */
	protected $data_stores = [];

	/**
	 * Plugin Instantiator
	 *
	 * @return object
	 */
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}

		return self::$_instance;
	}

	/**
	 * Cloning is forbidden.
	 *
	 * @since 1.2
	 */
	private function __clone() {
	}

	/**
	 * Unserializing instances of this class is forbidden.
	 *
	 * @since 1.2
	 */
	private function __wakeup() {
	}

	/**
	 * Constructor
	 */
	public function __construct() {
		$this->admin_includes();
		$this->classes();
		$this->init_hooks();

		do_action( 'bm_wp_experience_loaded' );
	}

	/**
	 * Hooks that are run on the time of init.
	 */
	private function init_hooks() {
		require_once 'includes/class-install.php';
		register_activation_hook( __FILE__, [ Install::class, 'install' ] );

		add_action( 'init', [ $this, 'init' ] );
	}

	/**
	 * Initialize when WordPress is initialized.
	 *
	 * @return void
	 */
	public function init() {
		do_action( 'before_bm_wp_experience_init' );

		// Localization support.
		$this->load_languages();

		do_action( 'bm_wp_experience_init' );
	}

	/**
	 * Admin Includes
	 *
	 */
	public function admin_includes() {
		if ( is_admin() ) {
			require_once 'includes/admin/class-admin.php';
			require_once 'includes/admin/class-admin-assets.php';
			require_once 'includes/admin/class-admin-pages.php';
		}
	}

	/**
	 * Include various includes in the system.
	 */
	private function classes() {
		// Contrary to its name, it is also loaded publicly.
		require_once 'includes/admin/class-admin-bar.php';

		require_once 'includes/class-block-editor.php';
		require_once 'includes/class-cleanup.php';
		require_once 'includes/class-customizer.php';
		require_once 'includes/class-dashboard.php';
		require_once 'includes/class-environments.php';
		require_once 'includes/class-media.php';
		require_once 'includes/class-multisite.php';
		require_once 'includes/class-plugins.php';
		require_once 'includes/class-rest-api.php';
		require_once 'includes/class-security.php';
		require_once 'includes/class-users.php';
	}

	/**
	 * Load translations in the right order.
	 */
	public function load_languages() {
		$locale = is_admin() && function_exists( 'get_user_locale' ) ? get_user_locale() : get_locale();
		$locale = apply_filters( 'plugin_locale', $locale, 'bm-wp-experience' );

		unload_textdomain( 'bm-wp-experience' );

		// Start checking in the main language dir.
		load_textdomain( 'bm-wp-experience', WP_LANG_DIR . '/bm-wp-experience/bm-wp-experience-' . $locale . '.mo' );

		// Otherwise, load from the plugin.
		load_plugin_textdomain( 'bm-wp-experience', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
	}

	/**
	 * Get the path to the plugin folder, or the specified
	 * file relative to the plugin folder home.
	 *
	 * @param  string  $file
	 *
	 * @return string
	 */
	public static function get_path( $file = '' ) {
		return untrailingslashit( plugin_dir_path( __FILE__ ) ) . '/' . $file;
	}

	/**
	 * Get View Template Path
	 *
	 * @param  string  $view_name
	 *
	 * @return string
	 */
	public static function get_view_path( $view_name ) {
		return self::get_path( 'views/' . $view_name . '.php' );
	}

	/**
	 * Get the URL to the plugin folder, or the specified
	 * file relative to the plugin folder home.
	 *
	 * @param  string  $file
	 *
	 * @return string
	 */
	public static function get_url( $file = '' ) {
		$plugins_url = plugins_url( basename( plugin_dir_path( __FILE__ ) ), basename( __FILE__ ) );

		return untrailingslashit( $plugins_url ) . '/' . $file;
	}

	/**
	 * Get the URL to the assets folder, or the specified
	 * file relative to the assets folder home.
	 *
	 * @param  string  $file
	 *
	 * @return string
	 */
	public static function get_assets_url( $file = '' ) {
		return self::get_url( 'assets/' . $file );
	}

	/**
	 * Get AJAX URL
	 *
	 * @return string
	 */
	public static function get_ajax_url() {
		return admin_url( 'admin-ajax.php', 'relative' );
	}

	/**
	 * Get the Plugin's Version
	 *
	 * @return string
	 */
	public static function get_version() {
		return self::VERSION;
	}

	/**
	 * Get the database version number.
	 *
	 * @return string
	 */
	public static function get_database_version() {
		return self::DATABASE_VERSION;
	}

	/**
	 * Get the URL to the GitHub repository.
	 *
	 * @return string
	 */
	public static function get_github_url() {
		return self::GITHUB_REPO;
	}

}

/**
 * Main Plugin Class Function
 *
 * @return object
 */
function bm_wp_experience() {
	return BM_WP_Experience::instance();
}

// Initialize the class instance only once.
bm_wp_experience();

/**
 * Update Checker
 */
$bm_wp_experience_updater = Puc_v4_Factory::buildUpdateChecker( BM_WP_Experience::get_github_url(), __FILE__, 'bm-wp-experience' );
$bm_wp_experience_updater->getVcsApi()->enableReleaseAssets();

// Add our own plugin icon.
$bm_wp_experience_updater->addResultFilter( function ( $plugin_info ) {
	$plugin_info->icons = [
		'svg' => BM_WP_Experience::get_assets_url( 'icons/bm.svg' ),
	];

	return $plugin_info;
} );
