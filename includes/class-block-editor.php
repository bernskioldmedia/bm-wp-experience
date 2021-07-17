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

		// Disable Yoast metabox if Block Editor.
		add_action( 'add_meta_boxes', [ self::class, 'remove_yoast_metabox_in_block_editor' ], 999 );
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

	/**
	 * Remove the Yoast SEO metabox if we're in the block editor.
	 * The sidebar options are much better for the block editor
	 * so we don't actually need it.
	 *
	 */
	public static function remove_yoast_metabox_in_block_editor() {
		if ( self::is_block_editor() ) {
			foreach ( get_post_types() as $post_type ) {
				remove_meta_box( 'wpseo_meta', $post_type->name, 'normal' );
			}
		}
	}

	/**
	 * Check if we are currently in the block editor.
	 *
	 * @return bool
	 */
	public static function is_block_editor() {
		if ( ! function_exists( 'get_current_screen' ) ) {
			return false;
		}


		$screen = get_current_screen();

		if ( method_exists( $screen, 'is_block_editor' ) ) {
			return $screen->is_block_editor();
		}

		return false;
	}

}

Block_Editor::init();
