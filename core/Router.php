<?php

class Router
{
    protected static $routes = [];

    public static function loadRoutes($folder = 'app/routes') {
        $uri = trim($_GET['url'] ?? '', '/');
        $routeFile = "{$folder}/" . ($uri ?: 'web') . ".php";
        if (file_exists($routeFile)) {
            require_once $routeFile;
        } else {
            self::debug("[ROUTE NOT FOUND FILE] $routeFile");
        }
    }

    public static function get($uri, $action) {
        return self::add('GET', $uri, $action);
    }

    public static function post($uri, $action) {
        return self::add('POST', $uri, $action);
    }

    protected static function add($method, $uri, $action) {
        $route = new self($method, trim($uri, '/'), $action);
        self::$routes[] = $route;
        $actionDisplay = is_array($action) ? implode('@', $action) : (is_callable($action) ? 'Closure' : 'Unknown');
        return $route;
    }

    public static function dispatch($requestUri) {
        static $loaded = false;
        if (!$loaded) {
            self::loadRoutes();
            $loaded = true;
        }

        $requestUri = trim($requestUri, '/');
        $method = $_SERVER['REQUEST_METHOD'];

        if (empty(self::$routes)) {
            self::debug("[ERROR] No routes registered.");
        }

        foreach (self::$routes as $route) {
            if ($route->uri === $requestUri && $route->method === $method) {
                foreach ($route->middleware as $mw) {
                    $middlewareFile = "app/middlewares/{$mw}.php";

                    if (file_exists($middlewareFile)) {
                        require_once $middlewareFile;
                        if (function_exists($mw)) {
                            call_user_func($mw);
                        } else {
                            self::debug("[ERROR] Middleware function '$mw' not found in file.");
                        }
                    } else {
                        self::debug("[WARNING] Middleware file not found: $middlewareFile");
                    }
                }

                // Run the controller or closure
                if (is_callable($route->action)) {
                    self::debug("[CALLABLE] Inline closure");
                    echo call_user_func($route->action);
                    return;
                }

                [$controller, $methodName] = $route->action;
                $controllerPath = "app/controllers/{$controller}.php";

                if (!file_exists($controllerPath)) {
                    return self::fallback("Controller file not found: {$controllerPath}", $requestUri);
                }

                require_once $controllerPath;

                if (!class_exists($controller)) {
                    return self::fallback("Controller class '{$controller}' not found", $requestUri);
                }

                $instance = new $controller;

                if (!method_exists($instance, $methodName)) {
                    return self::fallback("Method '{$methodName}' not found in '{$controller}'", $requestUri);
                }
                return call_user_func([$instance, $methodName]);
            }
        }

        return self::fallback("Route not found: '{$requestUri}'", $requestUri);
    }

    protected static function fallback($msg, $requestUri = '') {
        self::debug("[404] $msg");

        require_once "app/controllers/_404Controller.php";
        (new _404Controller)->index([
            $msg,
            __FILE__,
            $requestUri
        ]);
    }

    // Debug output
    protected static function debug($text) {
        echo "<pre style='color: white; background:#222; padding:8px 12px; font-size:13px; margin-bottom:6px; border-left: 4px solid white;'>$text</pre><br/>";
    }

    // Class properties and chaining
    protected $method;
    protected $uri;
    protected $action;
    public $middleware = [];
    public $name;

    private function __construct($method, $uri, $action) {
        $this->method = $method;
        $this->uri = $uri;
        $this->action = $action;
    }

    public function middleware($mw) {
        $this->middleware = is_array($mw) ? $mw : [$mw];
        return $this;
    }

    public function name($name) {
        $this->name = $name;
        return $this;
    }
}