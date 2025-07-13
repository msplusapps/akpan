<?php

class Controller {

    /**
     * Load a model from app/models/
     */
    public function model($model) {
        $file = "app/models/{$model}.php";
        if (file_exists($file)) {
            require_once $file;
            return new $model();
        } else {
            die("Model '{$model}' not found.");
        }
    }

    /**
     * Load a view from app/views/
     */
    public function view($view, $data = []){
        extract($data);

        $path = "app/views/{$view}.view.php";

        if (!file_exists($path)) {
            error_log("[VIEW ERROR] View file not found: {$path}");
            echo "<h2 style='color:red;'>View file not found: {$path}</h2>";
            return;
        }

        require_once $path;
    }


    /**
     * Redirect to a different URL
     */
    public function redirect($path) {
        header("Location: {$path}");
        exit;
    }

    /**
     * Check if the request is POST
     */
    public function isPost() {
        return $_SERVER['REQUEST_METHOD'] === 'POST';
    }

    /**
     * Check if the request is GET
     */
    public function isGet() {
        return $_SERVER['REQUEST_METHOD'] === 'GET';
    }

    /**
     * Get sanitized input from $_POST or $_GET
     */
    public function input($key, $default = null) {
        $value = $_POST[$key] ?? $_GET[$key] ?? $default;
        return htmlspecialchars(trim($value));
    }

    /**
     * Generate and store CSRF token
     */
    public function csrfToken() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (empty($_SESSION['_csrf'])) {
            $_SESSION['_csrf'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['_csrf'];
    }

    /**
     * Validate CSRF token
     */
    public function guardCsrf($token) {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (!isset($_SESSION['_csrf']) || $token !== $_SESSION['_csrf']) {
            die("Invalid CSRF token.");
        }
    }
}
