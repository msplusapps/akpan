<?php
class Env {
    public static function load($path = __DIR__ . '/../.env') {
        if (!file_exists($path)) return;

        $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) {
            if (strpos(trim($line), '#') === 0 || !strpos($line, '=')) continue;

            list($key, $value) = explode('=', $line, 2);
            $_ENV[trim($key)] = trim($value);
        }
    }
}

Env::load();

function env($key, $default = null) {
    $value = $_ENV[$key] ?? $default;

    // Normalize boolean-like strings
    if (strtolower($value) === 'true') return true;
    if (strtolower($value) === 'false') return false;

    return $value;
}


if (env('DEBUG') === 'true') {
    ini_set('display_errors', 1);
    error_reporting(E_ALL);
} else {
    ini_set('display_errors', 0);
    error_reporting(0);
}