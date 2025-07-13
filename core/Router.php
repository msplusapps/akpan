<?php

class Router {
    protected static $routes = [];

    public static function loadRoutes($folder = 'app/routes') {
        foreach (glob("app/middlewares/*.php") as $middlewareFile) {
            require_once $middlewareFile;
        }
        $routeFile = $folder . '/web.php';
        if (file_exists($routeFile)) {
            require_once $routeFile;
        } else {
            self::debug("❌ Route file not found: $routeFile");
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
        $name = is_array($action) ? implode('@', $action) : 'Closure';
        return $route;
    }

    public static function dispatch($requestUri) {
        static $loaded = false;
        if (!$loaded) {
            self::loadRoutes();
            $loaded = true;
        }
        $requestUri = trim(parse_url($requestUri, PHP_URL_PATH), '/');
        $method = $_SERVER['REQUEST_METHOD'];
        foreach (self::$routes as $route) {
            if ($route->uri === $requestUri && $route->method === $method) {
                foreach ($route->middleware as $mw) {
                    if (function_exists($mw)) {
                        call_user_func($mw);
                    } else {
                        self::debug("⚠️ Middleware '$mw' not found.");
                    }
                }

                if (is_callable($route->action)) {
                    echo call_user_func($route->action);
                    return;
                }

                [$controller, $methodName] = $route->action;
                $controllerPath = "app/controllers/{$controller}.php";

                if (!file_exists($controllerPath)) {
                    return self::fallback("❌ Controller file not found: $controllerPath", $requestUri);
                }

                require_once $controllerPath;

                if (!class_exists($controller)) {
                    return self::fallback("❌ Controller class not found: {$controller}", $requestUri);
                }

                $instance = new $controller;

                if (!method_exists($instance, $methodName)) {
                    return self::fallback("❌ Method '{$methodName}' not found in '{$controller}'", $requestUri);
                }
                return call_user_func([$instance, $methodName]);
            }
        }

        return self::fallback("❌ Route not found: '{$requestUri}'", $requestUri);
    }

    protected static function fallback($msg, $requestUri = '') {
        require_once "app/controllers/_404Controller.php";
        (new _404Controller)->index([$msg, __FILE__, $requestUri]);
    }

    protected static function debug($text) {
        echo "<pre style='color: white; background:#222; padding:8px 12px; font-size:13px; margin-bottom:6px; border-left: 4px solid white;'>$text</pre><br/>";
    }

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