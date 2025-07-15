<?php
session_start();

require_once __DIR__ . '/../vendor/autoload.php';

$pluginManager = new Core\PluginManager(__DIR__ . '/../app/plugins');
$pluginManager->discoverPlugins();
