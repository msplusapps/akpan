# Plugin System

This document explains how to create and use plugins in this application.

## Creating a Plugin

To create a new plugin, follow these steps:

1.  Create a new directory for your plugin in the `app/plugins` directory. The name of the directory should be the name of your plugin in PascalCase. For example, if your plugin is named "My Plugin", the directory should be named `MyPlugin`.

2.  Inside your plugin's directory, create a `plugin.php` file. This file will contain the main class for your plugin.

3.  The main plugin class must extend the `Core\Plugin` class and implement the `activate()` and `deactivate()` methods. The class name should be the name of your plugin in PascalCase followed by "Plugin". For example, if your plugin is named "My Plugin", the class name should be `MyPluginPlugin`.

Here is an example of a simple plugin:

```php
<?php

use Core\Plugin;

class MyPluginPlugin extends Plugin {

    public function __construct() {
        $this->name = 'My Plugin';
        $this->version = '1.0';
        $this->author = 'Your Name';
        $this->description = 'This is my custom plugin.';
    }

    public function activate() {
        // Code to run when the plugin is activated
    }

    public function deactivate() {
        // Code to run when the plugin is deactivated
    }
}
```

## Activating and Deactivating Plugins

To activate or deactivate a plugin, you can use the `PluginManager` class. The `PluginManager` is available globally after it is initialized in `core/init.php`.

Here is an example of how to activate a plugin:

```php
$pluginManager->activatePlugin('My Plugin');
```

And here is an example of how to deactivate a plugin:

```php
$pluginManager->deactivatePlugin('My Plugin');
```

You can also get a list of all available plugins:

```php
$plugins = $pluginManager->getPlugins();
```
