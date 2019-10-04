<?php
/**
 * Security
 *
 * We set up the WordPress environment for enterprise-grade
 * WordPress security by tweaking constants and adding
 * various security tweaks.
 *
 * Some additional REST API security-related settings can be found
 * in the REST_API class.
 *
 * @package BernskioldMedia\WP\Experience
 **/

namespace BernskioldMedia\WP\Experience;

/**
 * Class Security
 *
 * @package BernskioldMedia\WP\Experience
 */
class Security {


	public static function init() {

		/**
		 * Disable the core file editor so that nobody
		 * can modify files from the admin.
		 */
		if ( ! defined( 'DISALLOW_FILE_EDIT' ) ) {
			define( 'DISALLOW_FILE_EDIT', true );
		}

	}


}

Security::init();
