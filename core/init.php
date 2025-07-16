<?php
session_start();

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/helpers.php';
// require __DIR__ .'/Utils/N.php';

$GLOBALS['pluginManager'] = new Core\PluginManager(base_path('/app/Plugins'));
$GLOBALS['pluginManager']->discoverPlugins();
$GLOBALS['pluginManager']->activatePlugin('Route Debugger');


