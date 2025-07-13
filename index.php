<?php

require_once './core/init.php';
Router::dispatch($_GET['url'] ?? '/');