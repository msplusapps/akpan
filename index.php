<?php

require_once './core/init.php';
use Core\Router;

Router::dispatch($_GET['url'] ?? '/');