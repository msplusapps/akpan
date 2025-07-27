<?php
namespace Core;
class Request {
    public string $method;
    public string $uri;
    public function __construct() {
        $this->method = $_SERVER['REQUEST_METHOD'];
        $this->uri = $this->normalizeUri($_SERVER['REQUEST_URI']);
    }
    private function normalizeUri(string $uri): string {
        $path = parse_url($uri, PHP_URL_PATH);
        $basePath = trim(dirname($_SERVER['SCRIPT_NAME']), '/');
        if (!empty($basePath) && strpos($path, "/{$basePath}") === 0) {
            $path = substr($path, strlen("/{$basePath}"));
        }
        return trim($path, '/');
    }
}
