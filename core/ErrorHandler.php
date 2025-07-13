<?php

class ErrorHandler {
    public static function register() {
        ini_set('display_errors', '0'); // Hide from user
        ini_set('log_errors', '1');
        ini_set('error_log', __DIR__ . '/../logs/error.log');
        error_reporting(E_ALL);

        set_error_handler([self::class, 'handleError']);
        set_exception_handler([self::class, 'handleException']);
    }

    public static function handleError($errno, $errstr, $errfile, $errline) {
        $message = "[ERROR] [$errno] $errstr in $errfile on line $errline" . PHP_EOL;
        error_log($message);
        return true; // Don't execute PHP internal error handler
    }

    public static function handleException($exception) {
        $message = "[EXCEPTION] " . $exception->getMessage() .
            " in " . $exception->getFile() .
            " on line " . $exception->getLine() . PHP_EOL;
        error_log($message);
    }
}

ErrorHandler::register();