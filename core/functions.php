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