<?php

namespace Core;

use Core\Migrations;

class PluginManager {

    private array $plugins = [];
    private array $loadedPlugins = [];
    private array $activationCount = [];
    private array $loadCount = [];
    private string $pluginDir;

    public function __construct($pluginDir) {
        $this->pluginDir = $pluginDir;
    }

    public function discoverPlugins() {
        if (!is_dir($this->pluginDir)) {
            $this->debug("❌ Plugin directory not found: {$this->pluginDir}");
            return;
        }

        $requestUri = $_SERVER['REQUEST_URI'] ?? '/';
        $requestPath = trim(parse_url($requestUri, PHP_URL_PATH), '/');
        $requestSegments = explode('/', $requestPath);
        $targetPlugin = ucfirst($requestSegments[2] ?? '');

        foreach (glob($this->pluginDir . '/*', GLOB_ONLYDIR) as $dir) {
            $pluginName = basename($dir);
            $expectedFile = "{$dir}/{$pluginName}.php";
            $className = "App\\Plugins\\{$pluginName}\\{$pluginName}";

            // Skip if it's not the plugin we want
            if ($pluginName !== $targetPlugin) {
                continue;
            }

            // Debug load attempt
            $this->loadCount[$pluginName] = ($this->loadCount[$pluginName] ?? 0) + 1;
            $this->debug("🔍 Scanning Plugin: {$pluginName} (Load count: {$this->loadCount[$pluginName]})");

            // Prevent duplicate loading
            if (in_array($pluginName, $this->loadedPlugins)) {
                $this->debug("⚠️ Plugin '{$pluginName}' already loaded. Skipping. File: {$expectedFile}");
                break;
            }

            // Check if plugin file exists
            if (!file_exists($expectedFile)) {
                $this->debug("❌ Plugin file not found: {$expectedFile}");
                break;
            }

            // Try including the plugin file
            require_once $expectedFile;
            $this->debug("📄 Included plugin file: {$expectedFile}");

            // Check if the plugin class exists
            if (!class_exists($className)) {
                $this->debug("❌ Plugin class not found: {$className}");
                break;
            }

            // Instantiate and store the plugin
            $plugin = new $className();
            $this->plugins[] = $plugin;
            $this->loadedPlugins[] = $pluginName;
            $this->debug("✅ Plugin instantiated: {$pluginName}");

            // Register plugin (optional)
            if (method_exists($plugin, 'register')) {
                $this->debug("📌 Registering routes for plugin: {$pluginName}");
                $plugin->register();
            }

            // Activate plugin
            if (method_exists($plugin, 'activate')) {
                $this->activationCount[$pluginName] = ($this->activationCount[$pluginName] ?? 0) + 1;
                $this->debug("🚀 Activating plugin '{$pluginName}' [Times Activated: {$this->activationCount[$pluginName]}]");
                $plugin->activate();
            }

            // Run migrations
            if (class_exists(Migrations::class)) {
                $this->debug("🗂️ Running migrations for: {$pluginName}");
                $migrations = new Migrations();
                $migrations->runPluginMigrations($pluginName);
            }

            break; // ✅ Only process the first matched plugin
        }

    }

    public function getPlugins(): array {
        return $this->plugins;
    }

    public function activatePlugin(string $pluginName): void {
        foreach ($this->plugins as $plugin) {
            if ($plugin->getName() === $pluginName && method_exists($plugin, 'activate')) {
                if (!isset($this->activationCount[$pluginName])) {
                    $this->activationCount[$pluginName] = 0;
                }
                $this->activationCount[$pluginName]++;
                $this->debug("🛠 Manually activating plugin: {$pluginName} [Activation count: {$this->activationCount[$pluginName]}]");
                $plugin->activate();
            }
        }
    }

    public function deactivatePlugin(string $pluginName): void {
        foreach ($this->plugins as $plugin) {
            if ($plugin->getName() === $pluginName && method_exists($plugin, 'deactivate')) {
                $this->debug("🛑 Deactivating plugin: {$pluginName}");
                $plugin->deactivate();
            }
        }
    }

    private function debug(string $message): void {
        if (getenv('DEBUG') === 'true' || ($_ENV['DEBUG'] ?? 'false') === 'true') {
            echo "<pre style='background:#222;color:#ffb700;padding:6px;margin:4px 0;border-left:4px solid orange'>{$message}</pre>";
        }
    }
}
