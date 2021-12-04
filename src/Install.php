<?php
/**
 * Installer
 */

namespace BernskioldMedia\WP\Experience;

use BernskioldMedia\WP\Experience\Modules\Htaccess\HSTS;
use BernskioldMedia\WP\Experience\Modules\Htaccess\ResponseHeaders;
use BMWPEXP_Vendor\BernskioldMedia\WP\PluginBase\Installer;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Install extends Installer {

	public static function install(): void {
		parent::install();

		if ( true === apply_filters( 'bm_wpexp_modify_htaccess_on_install', true ) ) {
			ResponseHeaders::activate();
		}
	}
}
