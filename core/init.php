<?php
session_start();

require_once __DIR__ . '/../vendor/autoload.php';

$GLOBALS['pluginManager'] = new Core\PluginManager(__DIR__ . '/../app/plugins');
$GLOBALS['pluginManager']->discoverPlugins();
$GLOBALS['pluginManager']->activatePlugin('Route Debugger');
