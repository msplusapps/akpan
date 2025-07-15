<?php

namespace Core;

use Core\Migrations;

class PluginManager {

    /**
     * @var array A list of all available plugins
     */
    private $plugins = [];

    /**
     * @var string The directory where plugins are stored
     */
    private $pluginDir;

    public function __construct($pluginDir) {
        $this->pluginDir = $pluginDir;
    }

    /**
     * Discover all available plugins
     */
    public function discoverPlugins(){
        // echo "<strong>🔍 Scanning plugins in:</strong> {$this->pluginDir}<br/>";

        if (!is_dir($this->pluginDir)) {
            echo "❌ Plugin directory does not exist.<br/>";
            return;
        }

        foreach (glob($this->pluginDir . '/*', GLOB_ONLYDIR) as $dir) {
            $pluginName = basename($dir);
            $className = "App\\Plugins\\{$pluginName}\\{$pluginName}Plugin";
            $expectedFile = "{$dir}/{$pluginName}Plugin.php";

            if (!file_exists($expectedFile)) {
                echo "❌ Plugin file not found at: {$expectedFile}<br/>";
                continue;
            }

            require_once $expectedFile;

            if (class_exists($className)) {
                $plugin = new $className();
                $this->plugins[] = $plugin;

                if (method_exists($plugin, 'register')) {
                    echo "📌 Calling register()<br/>";
                    $plugin->register();
                }

                if (method_exists($plugin, 'activate')) {
                    $plugin->activate();
                }

                if (class_exists(Migrations::class)) {
                    echo "🗂️ Running migrations for plugin: {$pluginName}<br/>";
                    $migrations = new Migrations();
                    $migrations->runPluginMigrations($pluginName);
                }
            } else {
                echo "❌ Plugin class not found: {$className}<br/>";
            }

            echo "<hr/>";
        }
    }


    /**
     * Get a list of all available plugins
     *
     * @return array
     */
    public function getPlugins() {
        return $this->plugins;
    }

    /**
     * Activate a plugin
     *
     * @param string $pluginName The name of the plugin to activate
     */
    public function activatePlugin($pluginName) {
        foreach ($this->plugins as $plugin) {
            if ($plugin->getName() === $pluginName) {
                $plugin->activate();
                // Here you would typically store the activation status in a database or a file
            }
        }
    }

    /**
     * Deactivate a plugin
     *
     * @param string $pluginName The name of the plugin to deactivate
     */
    public function deactivatePlugin($pluginName) {
        foreach ($this->plugins as $plugin) {
            if ($plugin->getName() === $pluginName) {
                $plugin->deactivate();
                // Here you would typically update the activation status
            }
        }
    }
}
