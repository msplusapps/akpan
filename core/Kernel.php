<?php
namespace Core;
class Kernel {
    protected static bool $loaded = false;
    public static function boot() {
        if (!self::$loaded) {
            global $pluginManager;
            if (isset($pluginManager)) {
                foreach ($pluginManager->getPlugins() as $plugin) {
                    if (method_exists($plugin, 'registerRoutes')) {
                        $plugin->registerRoutes();
                    }
                }
            }
            self::loadRoutes();
            self::$loaded = true;
        }
    }
    public static function loadRoutes(string $folder = 'app/routes'): void {
        foreach (glob("app/middlewares/*.php") as $middlewareFile) {
            require_once $middlewareFile;
        }
        foreach (glob("$folder/*.php") as $routeFile) {
            require_once $routeFile;
        }
        foreach (glob('app/plugins/*/routes/*.php') as $pluginRouteFile) {
            require_once $pluginRouteFile;
        }
    }
}
