<?php

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/core/functions.php';
require_once __DIR__ . '/core/init.php';
use Core\Request;
use Core\Router;
// Create request instance
$request = new Request();
// Dispatch using the request object
Router::dispatch($request);
