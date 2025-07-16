<?php

namespace Core\Utils;

use DOMDocument;
use Core\Utils\FileManager;

class Memstack{
    protected string $cacheDir = 'storage/cache';
    protected string $cacheFile;
    protected int $ttl; // Time to live in seconds

    public function __construct(int $ttl = 60){
        $this->ttl = $ttl;
        FileManager::createDirectory($this->cacheDir);
        $uri = $_SERVER['REQUEST_URI'] ?? 'home';
        $safeName = preg_replace('/[^a-z0-9]/i', '_', $uri);
        $this->cacheFile = "{$this->cacheDir}/{$safeName}.php";

        if ($this->isCacheValid()) {
            echo FileManager::readFile($this->cacheFile);
            exit;
        }
        ob_start();
    }

    protected function isCacheValid(): bool{
        if (!file_exists($this->cacheFile)) return false;
        $modifiedTime = filemtime($this->cacheFile);
        return (time() - $modifiedTime) < $this->ttl;
    }

    public function endCache(): void{
        $content = ob_get_clean();
        FileManager::createFile($this->cacheFile, $content);
        echo $content;
    }
}
