<?php

namespace Core\Utils;

use DOMDocument;
use Core\Utils\FileManager;

class Memstack{
    protected string $cacheDir = 'Storage/cache';
    protected string $cacheFile;
    protected int $ttl; // Time to live in seconds

    public function __construct(int $ttl = 60){
        $this->ttl = $ttl;

        // Ensure cache directory exists
        FileManager::createDirectory($this->cacheDir);

        // Use the request URI as part of the filename
        $uri = $_SERVER['REQUEST_URI'] ?? 'home';
        $safeName = preg_replace('/[^a-z0-9]/i', '_', $uri);
        echo $this->cacheFile = "{$this->cacheDir}/{$safeName}.php";

        // Check if valid cache exists
        if ($this->isCacheValid()) {
            echo FileManager::readFile($this->cacheFile);
            exit; // Stop PHP execution to serve cached content
        }else{
            $url = 'http://localhost/Apps/akpan/';

            $html = file_get_contents($url);

            if ($html !== false) {
                echo $html; // Outputs full HTML of the page
            } else {
                echo "Failed to fetch page.";
            }
//             $url = 'http://localhost/Apps/akpan/';

// // 3. Get the HTML content (use cURL or file_get_contents)
//             $html = file_get_contents($url);
//             show($html); 
            // $dom = new DOMDocument();
            // show($dom->loadHTML());
            // $url = $_SERVER['REQUEST_URI'];
            // $html = file_get_contents($url);
            // echo $html;

            // echo $this->cacheSecureName();
            // FileManager::createFile($this->cacheFile, );
        }

        // Start output buffering to capture page content
        ob_start();
    }

    // Check if the cache file is still valid
    protected function isCacheValid(): bool{
        if (!file_exists($this->cacheFile)) return false;
        $modifiedTime = filemtime($this->cacheFile);
        return (time() - $modifiedTime) < $this->ttl;
    }

    protected function cacheSecureName($length=24) : string {
       $letters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $numbers = '0123456789';

        // Ensure at least 2 letters
        $code = '';
        $code .= $letters[random_int(0, strlen($letters) - 1)];
        $code .= $letters[random_int(0, strlen($letters) - 1)];

        // Fill the rest with numbers
        for ($i = 2; $i < $length; $i++) {
            $code .= $numbers[random_int(0, strlen($numbers) - 1)];
        }

        // Shuffle the final string to mix letters randomly
        return str_shuffle($code);
    }

    // Call this at the end of the page to save the cache
    public function endCache(): void{
        $content = ob_get_clean(); // Get and clear output buffer
        FileManager::createFile($this->cacheFile, $content); // Save to cache
        echo $content; // Output to browser
    }
}
