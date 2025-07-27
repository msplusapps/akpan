<?php

namespace Core;
class Response {
    public static function debug(string $text): void {
        if (function_exists('env') && env('DEBUG') === 'true') {
            echo "<pre style='color: white; background:#222; padding:8px 12px; font-size:13px; margin-bottom:6px; border-left: 4px solid lime;'>$text</pre>";
        }
    }
    public static function fallback(string $msg, string $uri): void {
        self::debug("🟥 404 Error: $msg");
        if (file_exists("app/controllers/_404Controller.php")) {
            require_once "app/controllers/_404Controller.php";
            (new \App\Controllers\_404Controller)->index([$msg, __FILE__, $uri]);
        } else {
            echo "<h1>404 Not Found</h1><p>$msg</p>";
        }
    }
}
