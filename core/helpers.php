<?php
if (!function_exists('env')) {
    function env($key, $default = null){
        static $vars = null;

        if ($vars === null) {
            $envPath = base_path('.env'); // adjust path if needed

            if (!file_exists($envPath)) {
                throw new Exception(".env file not found at $envPath");
            }

            $lines = file($envPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            $vars = [];

            foreach ($lines as $line) {
                if (str_starts_with(trim($line), '#') || !str_contains($line, '=')) {
                    continue;
                }

                list($name, $value) = explode('=', $line, 2);
                $name = trim($name);
                $value = trim($value, " \t\n\r\0\x0B\"'");
                $vars[$name] = $value;
                putenv("$name=$value"); // optional
            }
        }

        return $vars[$key] ?? $default;
    }
}
