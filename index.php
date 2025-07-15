<?php

require_once './core/init.php';
use Core\Router;

$router->dispatch($_GET['url'] ?? '/');