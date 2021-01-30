<?php
/**
 * Customizer
 *
 * Adds various opinionated tweaks to the customizer.
 *
 * @package BernskioldMedia\WP\Experience
 */

namespace BernskioldMedia\WP\Experience;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Customizer
 */
class Customizer {

	/**
	 * Option key where to store the CSS last updated time.
	 */
	protected const CSS_LAST_UPDATED_OPTION_KEY = 'bmwp_custom_css_last_updated_time';

	/**
	 * The file name of the custom CSS from the customizer.
	 *
	 * @var string
	 */
	protected static $custom_css_file_name = 'app';

	/**
	 * Custom CSS ID.
	 */
	public const CUSTOM_CSS_ID = 'custom-adjustments';

	/**
	 * Init.
	 */
	public static function init() {

		// Create the custom CSS file on save.
		add_action( 'customize_save_after', [ self::class, 'save_custom_css_to_file' ] );

		// Load the custom CSS file.
		add_action( 'wp_enqueue_scripts', [ self::class, 'load_custom_css' ], 999 );

		// Remove the inline styles.
		remove_action( 'wp_head', 'wp_custom_css_cb', 101 );
	}

	/**
	 * Enqueue the custom CSS file.
	 */
	public static function load_custom_css() {
		wp_register_style( self::CUSTOM_CSS_ID, self::get_custom_css_file_url(), [], self::get_custom_css_last_updated_time(), 'all' );

		// Only load the file if it exists = if we have custom files.
		if ( file_exists( self::get_custom_css_file_path() ) ) {
			wp_enqueue_style( self::CUSTOM_CSS_ID );
		}
	}

	/**
	 * Save the custom CSS to a file.
	 */
	public static function save_custom_css_to_file() {
		$styles = wp_get_custom_css();

		self::maybe_create_custom_css_storage_directory();

		// If we don't have styles, we remove the file.
		if ( empty( $styles ) ) {
			self::remove_custom_css_file();
		} else {
			self::create_custom_css_file( $styles );
		}

		self::set_custom_css_last_updated_time();
	}

	/**
	 * Get the time when the custom CSS was last updated.
	 *
	 * @return null|string|int
	 */
	protected static function get_custom_css_last_updated_time() {
		return get_option( self::CSS_LAST_UPDATED_OPTION_KEY, null );
	}

	/**
	 * Set the time when the custom CSS was last updated.
	 * Defaults to the current time if none given.
	 *
	 * @param  null|int  $time
	 */
	protected static function set_custom_css_last_updated_time( $time = null ) {
		if ( null === $time ) {
			$time = time();
		}

		update_option( self::CSS_LAST_UPDATED_OPTION_KEY, $time );
	}

	/**
	 * Get the custom CSS storage directory path.
	 *
	 * @return string
	 */
	protected static function get_custom_css_storage_directory() {
		$path = WP_CONTENT_DIR . '/custom-css';

		return apply_filters( 'bm_wpexp_custom_css_storage_directory_path', $path );
	}

	/**
	 * Get the custom CSS storage directory URL.
	 *
	 * @return string
	 */
	protected static function get_custom_css_storage_directory_uri() {
		$path = WP_CONTENT_URL . '/custom-css';

		return apply_filters( 'bm_wpexp_custom_css_storage_directory_uri', $path );
	}

	/**
	 * Create the storage directory if it doesn't exist.
	 */
	protected static function maybe_create_custom_css_storage_directory() {
		if ( ! file_exists( self::get_custom_css_storage_directory() ) ) {
			mkdir( self::get_custom_css_storage_directory(), 0755, true );
		}
	}

	/**
	 * Get the custom CSS file name.
	 *
	 * @return string
	 */
	protected static function get_custom_css_file_name() {
		$base = apply_filters( 'bm_wpexp_custom_css_file_name', self::$custom_css_file_name );

		if ( is_multisite() ) {
			return $base . '-' . get_current_blog_id() . '.css';
		}

		return $base . '.css';
	}

	/**
	 * Get the path to the custom CSS file.
	 *
	 * @return string
	 */
	public static function get_custom_css_file_path() {
		return self::get_custom_css_storage_directory() . '/' . self::get_custom_css_file_name();
	}

	/**
	 * Get the custom CSS file URL.
	 *
	 * @return string
	 */
	public static function get_custom_css_file_url() {
		return self::get_custom_css_storage_directory_uri() . '/' . self::get_custom_css_file_name();
	}

	/**
	 * Create the the custom CSS file.
	 *
	 * @param  string  $contents
	 */
	protected static function create_custom_css_file( $contents ) {
		file_put_contents( self::get_custom_css_file_path(), $contents );
	}

	/**
	 * Remove the custom CSS file if it exists.
	 */
	protected static function remove_custom_css_file() {
		$file_path = self::get_custom_css_file_path();

		if ( file_exists( $file_path ) ) {
			unlink( $file_path );
		}
	}

}

Customizer::init();
