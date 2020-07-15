<?php
/**
 * Class SampleTest
 *
 * @package Bm_Wp_Experience
 */

/**
 * Sample test case.
 */
class SampleTest extends WP_UnitTestCase {

	/**
	 * Test that GitHub URL is strong.
	 *
	 */
	public function test_get_github_url() {
		$this->assertIsString( \BernskioldMedia\WP\Experience\BM_WP_Experience::get_github_url() );
	}

	public function test_get_database_version() {
		$this->assertIsString( \BernskioldMedia\WP\Experience\BM_WP_Experience::get_database_version() );
	}

	public function test_get_version() {
		$this->assertIsString( \BernskioldMedia\WP\Experience\BM_WP_Experience::get_version() );
	}

	public function test_get_ajax_url() {
		$assumed_url  = '/wp-admin/admin-ajax.php';
		$received_url = \BernskioldMedia\WP\Experience\BM_WP_Experience::get_ajax_url();

		$this->assertIsString( $received_url );
		$this->assertEquals( $assumed_url, $received_url );
	}

	public function test_get_assets_url() {
		$assets_url = \BernskioldMedia\WP\Experience\BM_WP_Experience::get_assets_url();

		$this->assertIsString( $assets_url );
	}

	public function test_get_url() {
		$actual = \BernskioldMedia\WP\Experience\BM_WP_Experience::get_url();
		$this->assertIsString( $actual );
	}

	public function test_get_path() {
		$actual = \BernskioldMedia\WP\Experience\BM_WP_Experience::get_path();
		$this->assertIsString( $actual );
	}

	public function test_get_view_path() {
		$actual = \BernskioldMedia\WP\Experience\BM_WP_Experience::get_view_path( 'test' );

		$this->assertIsString( $actual );
	}

}
