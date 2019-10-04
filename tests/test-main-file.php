<?php
/**
 * Class MainFile
 *
 * @package BernskioldMedia\WP\Experience
 */

namespace BernskioldMedia\WP\Experience;

/**
 * Main File Tests
 */
class MainFile extends \WP_UnitTestCase {

	/**
	 * Test: Plugin Version
	 *
	 * Make sure plugin version returns an integer.
	 */
	function test_get_plugin_version() {

		$version = WP_Plugin_Scaffold::get_plugin_version();

		$this->assertInternalType( 'string', $version );

	}

}
