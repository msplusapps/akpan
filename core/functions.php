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

    function redirect($url=last_url){
        // echo "redirect";
        echo "<script>window.location.href='$url'</script>";
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
