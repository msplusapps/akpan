<?php
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/core/functions.php';
require_once __DIR__ . '/core/init.php';

use Core\Router;

Router::dispatch($_SERVER['REQUEST_URI']);
