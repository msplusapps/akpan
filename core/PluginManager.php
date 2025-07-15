<?php

namespace Core;

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
    public function discoverPlugins() {
        if (!is_dir($this->pluginDir)) {
            return;
        }

        foreach (glob($this->pluginDir . '/*', GLOB_ONLYDIR) as $dir) {
            $className = 'App\\Plugins\\' . basename($dir) . '\\' . basename($dir) . 'Plugin';
            if (class_exists($className)) {
                $plugin = new $className();
                $this->plugins[] = $plugin;
                $plugin->activate();
            }
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
