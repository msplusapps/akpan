<?php

namespace Core\Utils;

class Cache {
    private static $storagePath;

    public static function init() {
        self::$storagePath = base_path('storage/framework');
        if (!is_dir(self::$storagePath)) {
            mkdir(self::$storagePath, 0755, true);
        }
    }

    public static function isEnabled() {
        $configFile = self::$storagePath . '/cache.json';
        if (!file_exists($configFile)) {
            return false;
        }
        $config = json_decode(file_get_contents($configFile), true);
        return $config['enabled'] ?? false;
    }

    public static function enable() {
        $configFile = self::$storagePath . '/cache.json';
        $config = ['enabled' => true];
        file_put_contents($configFile, json_encode($config));
    }

    public static function disable() {
        $configFile = self::$storagePath . '/cache.json';
        $config = ['enabled' => false];
        file_put_contents($configFile, json_encode($config));
    }

    public static function clear() {
        $cacheDir = base_path('storage/cache');
        if (is_dir($cacheDir)) {
            $files = glob($cacheDir . '/*');
            foreach ($files as $file) {
                if (is_file($file)) {
                    unlink($file);
                }
            }
        }
    }
}

Cache::init();
