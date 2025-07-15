<?php
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/core/functions.php';
require_once __DIR__ . '/core/init.php';

use Core\Router;

// Capture output
ob_start();
Router::dispatch('/test');
$output = ob_get_clean();

// Display warning if any
$error = error_get_last();
if ($error && $error['type'] === E_USER_WARNING) {
    echo "Warning: " . $error['message'] . "\n";
}

// Display output
echo "Output: " . $output . "\n";
