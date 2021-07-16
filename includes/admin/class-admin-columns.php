<?php
/**
 * Admin Columns
 *
 * @package BernskioldMedia\WP\Experience
 **/

namespace BernskioldMedia\WP\Experience;

class Admin_Columns {

	/**
	 * Initialize
	 */
	public static function init() {
		$acp_file_path = 'admin-columns-pro/admin-columns-pro.php';
		if ( is_plugin_active( $acp_file_path ) || is_plugin_active_for_network( $acp_file_path ) ) {
			self::create_repository();
		}
	}

	public static function create_repository() {
		add_filter( 'acp/storage/repositories', function ( $repositories, $factory ) {
			/**
			 * Developers!
			 *
			 * When you want to save new ACP columns to this repository,
			 * set the second arg "false" to "true".
			 *
			 * Remember to set this back to "false" before shipping.
			 * We need the repository to be read-only.
			 */
			$repositories['bm_wp_experience'] = $factory->create( BM_WP_Experience::get_path() . '/acp-columns', false );

			return $repositories;
		}, 20, 2 );
	}


}

Admin_Columns::init();
