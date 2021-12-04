<?php
/**
 * Installer
 */

namespace BernskioldMedia\WP\Experience;

use BernskioldMedia\WP\Experience\Modules\Htaccess\HSTS;
use BMWPEXP_Vendor\BernskioldMedia\WP\PluginBase\Installer;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Install extends Installer {

	public static function install(): void {
		parent::install();
		self::htaccess();
	}

	protected static function htaccess(): void {
		HSTS::activate();
	}

}
