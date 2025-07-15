<?php
session_start();
require __DIR__ . "/Enc.php";
require __DIR__ . "/Env.php";
require __DIR__ . "/ErrorHandler.php";
require __DIR__ . "/functions.php";
require __DIR__ . "/Database.php"; 
require __DIR__ . "/Model.php";
require __DIR__ . "/Controller.php";
require __DIR__ . "/Router.php";
require_once __DIR__ . '/Migrations.php';
require __DIR__ . "/Plugin.php";
require __DIR__ . "/PluginManager.php";

$pluginManager = new Core\PluginManager(__DIR__ . '/../app/plugins');
$pluginManager->discoverPlugins();
