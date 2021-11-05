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
 **/

namespace BernskioldMedia\WP\Experience\Modules;

use WP_Error;
use WP_User;

class Security extends Module {
    /**
     * Define passwords that we always classify as weak.
     */
    protected const WEEK_PASSWORDS = [
        '123456',
        'Password',
        'password',
        '12345678',
        'qwerty',
        '12345',
        '123456789',
        'letmein',
        '1234567',
        'football',
        'iloveyou',
        'admin',
        'welcome',
        'monkey',
        'login',
        'abc123',
        'starwars',
        '123123',
        'dragon',
        'passw0rd',
        'master',
        'hello',
        'freedom',
        'whatever',
        'qazwsx',
        '654321',
        'password1',
        '1234',
    ];

    public static function hooks(): void {
        /*
         * Disable the core file editor so that nobody
         * can modify files from the admin.
         */
        if (! defined('DISALLOW_FILE_EDIT')) {
            define('DISALLOW_FILE_EDIT', true);
        }

        add_filter('authenticate', [ self::class, 'prevent_weak_password_auth' ], 30, 3);
    }

    /**
     * Prevent users from authenticating if they are using a weak password
     *
     * @param WP_User $user     User object
     * @param string  $username Username
     * @param string  $password Password
     *
     * @return WP_User|WP_Error
     */
    public static function prevent_weak_password_auth($user, $username, $password) {
        // On local and development environments we allow a weak password.
        if (in_array(wp_get_environment_type(), [ 'development', 'local' ], true)) {
            return $user;
        }

        // If the password is tweak, prevent saving.
        if (in_array(strtolower(trim($password)), self::get_weak_passwords(), true)) {
            /* translators: 1. Lost Password URL */
            $error_message = sprintf(
                __('Please <a href="%s">reset your password</a> in order to meet the security guidelines for this website.', 'bm-wp-experience'),
                esc_url(wp_lostpassword_url())
            );

            return new WP_Error('Auth Error', $error_message);
        }

        return $user;
    }

    /**
     * Get an array of passwords that we deem
     * as too weak to be allowed.
     *
     * @filter bm_wpexp_weak_passwords
     */
    public static function get_weak_passwords(): array {
        return apply_filters('bm_wpexp_weak_passwords', self::WEEK_PASSWORDS);
    }
}
