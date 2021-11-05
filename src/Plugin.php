<?php

namespace BernskioldMedia\WP\Experience;

use BMWPEXP_Vendor\BernskioldMedia\WP\PluginBase\BasePlugin;

class Plugin extends BasePlugin {
    protected static string $slug             = 'bm-wp-experience';
    protected static string $version          = '3.0.0';
    protected static string $textdomain       = 'bm-wp-experience';
    protected static string $plugin_file_path = BM_WP_EXPERIENCE_FILE_PATH;

    protected static array $boot = [
        Admin\Admin_Bar::class, // Boots publicly because it is loaded in public views too.
    ];

    protected static array $admin_boot = [
        Admin\Admin::class,
        Admin\Admin_Assets::class,
        Admin\Admin_Columns::class,
        Admin\Admin_Pages::class,
    ];

    protected static array $modules = [
        Modules\Block_Editor::class,
        Modules\Cleanup::class,
        Modules\Comments::class,
        Modules\Customizer::class,
        Modules\Dashboard::class,
        Modules\Environments::class,
        Modules\Media::class,
        Modules\Multisite::class,
        Modules\Plugins::class,
        Modules\Rest_Api::class,
        Modules\Security::class,
        Modules\Updates::class,
        Modules\Users::class,
    ];

    public function __construct() {
        parent::__construct();

        add_action('init', [ self::class, 'boot_modules' ]);

        if (is_admin() && ! empty(self::$admin_boot)) {
            add_action('admin_init', [ self::class, 'boot_admin' ]);
        }

        register_activation_hook(__FILE__, [ Install::class, 'install' ]);
    }

    public static function boot_modules(): void {
        foreach (self::$modules as $bootableClass) {
            $bootableClass::hooks();
        }
    }

    public static function boot_admin(): void {
        foreach (self::$admin_boot as $bootableClass) {
            $bootableClass::hooks();
        }
    }

    /**
     * Get View Template Path
     */
    public static function get_view_path(string $view_name): string {
        return self::get_path('views/' . $view_name . '.php');
    }
}
