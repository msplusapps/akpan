<?php
session_start();

require_once __DIR__ . '/../vendor/autoload.php';

$GLOBALS['pluginManager'] = new Core\PluginManager(base_path('/app/Plugins'));
$GLOBALS['pluginManager']->discoverPlugins();
$GLOBALS['pluginManager']->activatePlugin('Route Debugger');
