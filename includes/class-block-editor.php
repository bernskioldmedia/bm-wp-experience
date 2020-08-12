<?php
/**
 * Tweak the Block Editor
 *
 * Most often we we build sites with the block editor,
 * we want to lock it down as much as possible. These options
 * exist here.
 *
 * @package BernskioldMedia\WP\Experience
 */

namespace BernskioldMedia\WP\Experience;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Block_Editor
 */
class Block_Editor {

	/**
	 * Init.
	 */
	public static function init() {

		// Disable the block directory in the editor.
		add_action( 'plugins_loaded', [ self::class, 'disable_block_directory' ] );

	}

	/**
	 * Disable the block directory.
	 *
	 * As we typically don't want people to install their own blocks
	 * from within the editor on a whim, we disable the block directory
	 * very broadly.
	 *
	 * To enable the directory, define BM_WP_ENABLE_BLOCK_DIRECTORY
	 * as true in your config.
	 */
	public static function disable_block_directory() {

		// If we have explicitly set to enable the block directory, don't run this.
		if ( defined( 'BM_WP_ENABLE_BLOCK_DIRECTORY' ) && BM_WP_ENABLE_BLOCK_DIRECTORY ) {
			return;
		}

		remove_action( 'enqueue_block_editor_assets', 'wp_enqueue_editor_block_directory_assets' );
		remove_action( 'enqueue_block_editor_assets', 'gutenberg_enqueue_block_editor_assets_block_directory' );

	}

}

Block_Editor::init();
