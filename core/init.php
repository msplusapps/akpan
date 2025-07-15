<?php
session_start();

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/helpers.php';
require_once __DIR__ . '/functions.php';


$pluginManager = new Core\PluginManager(__DIR__ . '/../app/plugins');
$pluginManager->discoverPlugins();
