<?php
/**
 * Installer
 *
 * @package BernskioldMedia\WP\Experience
 */

namespace BernskioldMedia\WP\Experience;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Install
 *
 * @package BernskioldMedia\WP\Experience
 */
class Install {

	/**
	 * Hooks
	 */
	public static function hooks() {

	}

	/**
	 * Main Install Process
	 */
	public static function install() {

		self::scheduled_tasks();

	}

	/**
	 * Scheduled Tasks
	 */
	public static function scheduled_tasks() {

	}

}
