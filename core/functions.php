<?php

    function asset($path = '') {
        // Remove leading slashes and build full path
        $path = ltrim($path, '/');

        // Optional: use env BASE_URL if defined
        $baseUrl = $_ENV['BASE_URL'] ?? '';
        
        return rtrim($baseUrl, '/') . "/public/{$path}";
    }


    function money($t, $len = 0, $base = 'NGN'){
        return $base . "" . number_format($t, $len);
    }

    function show($data){
        echo "<pre>";
        var_dump($data);
        echo "</pre>";
    }

    function redirect($url = null) {
        if (!$url) {
            $url = $_SESSION['last'] ?? './';
        }
        echo "<script>window.location.href='$url'</script>";
        exit;
    }

    function base_path($path = '') {
        return dirname(__DIR__) . '/' . ltrim($path, '/');
    }


    function get_header($tree="web", $name= 'header') {
        $path = __DIR__ ."/../app/views/{$tree}/partials/{$name}.partial.php";
        if (file_exists($path)) {
            require $path;
        } else {
            error_log("Header part not found: $path");
        }
    }

    function get_footer($tree="web", $name = 'footer') {
        $path = __DIR__ ."/../app/views/{$tree}/partials/{$name}.partial.php";
        if (file_exists($path)) {
            require $path;
        } else {
            error_log("Footer part not found: $path");
        }
    }

    function get_navbar($tree="web", $name = 'navbar') {
        $path = __DIR__ ."/../app/views/{$tree}/partials/{$name}.partial.php";
        if (file_exists($path)) {
            require $path;
        } else {
            error_log("Navbar part not found: $path");
        }
    }

    function get_sidebar($tree="web", $name = 'sidebar') {
        $path = __DIR__ ."/../app/views/{$tree}/partials/{$name}.partial.php";
        if (file_exists($path)) {
            require $path;
        } else {
            error_log("Sidebar part not found: $path");
        }
    }

    function clean_html($value){
        return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
    }

    function csrf_token() {
        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }

        $token = $_SESSION['csrf_token'];
        return "<input type='hidden' name='csrf_token' value='{$token}'>";
    }


    function csrf_field(){
        return '<input type="hidden" name="csrf_token" value="' . csrf_token() . '">';
    }

    function verify_csrf(){
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $token = $_POST['csrf_token'] ?? '';
            if (!hash_equals($_SESSION['csrf_token'] ?? '', $token)) {
                die('Invalid CSRF token');
            }
        }
    }

    spl_autoload_register(function ($class) {
        $class = str_replace('\\', '/', $class);
        $paths = [
            "app/models/{$class}.php",
        ];
        foreach ($paths as $path) {
            if (file_exists($path)) {
                require_once $path;
                return;
            }
        }
    });

    if (!function_exists('url')) {
        function url($path = '') {
            $basePath = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\');
            $path = ltrim($path, '/');
            return $basePath . '/' . $path;
        }
    }
