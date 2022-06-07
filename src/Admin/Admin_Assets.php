<?php
/**
 * Handles the loading of scripts and styles for the
 * theme through the proper enqueuing methods.
 *
 **/

namespace BernskioldMedia\WP\Experience\Admin;

use BernskioldMedia\WP\Experience\Plugin;
use BMWPEXP_Vendor\BernskioldMedia\WP\PluginBase\Interfaces\Hookable;

if (! defined('ABSPATH')) {
    exit;
}

class Admin_Assets implements Hookable {
    public static function hooks(): void {
        add_action('admin_enqueue_scripts', [ self::class, 'admin_styles' ]);
    }

    /**
     * Registers and enqueues plugin admin stylesheets.
     **/
    public static function admin_styles(): void {
        $screen = get_current_screen();
        error_log( print_r( $screen, true));

        wp_register_style('bm-wp-experience-admin', Plugin::get_assets_url() . '/styles/dist/admin.css', [], Plugin::get_version());

        wp_enqueue_style('bm-wp-experience-admin');

        if (true === apply_filters('bm_wpexp_custom_admin_theme', true)) {
            wp_register_style('bm-wp-experience-admin-theme', Plugin::get_assets_url() . '/styles/dist/admin-theme.css', [], Plugin::get_version());

            wp_enqueue_style('bm-wp-experience-admin-theme');
        }

        if( $screen->base === 'post' && $screen->post_type  === 'wpdmpro'
            || $screen->base === 'edit-tags' && $screen->post_type  === 'wpdmpro' ){
            wp_register_style('bm-wp-experience-admin-download-manager', Plugin::get_assets_url() . '/styles/dist/admin-download-manager.css', [], Plugin::get_version());
            wp_enqueue_style('bm-wp-experience-admin-download-manager');
        }
    }
}
