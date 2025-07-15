<?php
session_start();

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/Env.php';

$router = new Core\Router();
$pluginManager = new Core\PluginManager(__DIR__ . '/../app/plugins');
$pluginManager->setRouter($router);
$pluginManager->discoverPlugins();
