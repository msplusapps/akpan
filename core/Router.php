<?php

class Router {
    protected static $routes = [];

    public static function loadRoutes($folder = 'app/routes') {
        foreach (glob("app/middlewares/*.php") as $middlewareFile) {
            require_once $middlewareFile;
        }
        foreach (glob("$folder/*.php") as $routeFile) {
            require_once $routeFile;
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

        $requestPath = parse_url($requestUri, PHP_URL_PATH);
        $basePath = trim(dirname($_SERVER['SCRIPT_NAME']), '/');

        if (!empty($basePath) && strpos($requestPath, "/{$basePath}") === 0) {
            $requestPath = substr($requestPath, strlen("/{$basePath}"));
        }

        $requestPath = trim($requestPath, '/');
        $method = $_SERVER['REQUEST_METHOD'];

        // Show all routes
        foreach (self::$routes as $r) {
            $m = strtoupper($r->method);
            $u = $r->uri;
            $a = is_array($r->action) ? implode('@', $r->action) : 'Closure';
        }

        $prefixMatched = false;

        foreach (self::$routes as $route) {
            $definedRoute = trim($route->uri, '/');

            if (str_starts_with($requestPath, explode('/', $definedRoute)[0])) {
                $prefixMatched = true;
            }

            if ($definedRoute === $requestPath && $route->method === $method) {
                self::debug("✅ Match found: {$method} /{$definedRoute}");

                foreach ($route->middleware as $mw) {
                    if (function_exists($mw)) {
                        self::debug("🛡️ Running middleware: $mw");
                        call_user_func($mw);
                    } else {
                        self::debug("⚠️ Middleware '$mw' not found.");
                    }
                }

                if (is_callable($route->action)) {
                    self::debug("🔧 Calling closure action");
                    echo call_user_func($route->action);
                    return;
                }

                [$controller, $methodName] = $route->action;
                $controllerPath = "app/controllers/{$controller}.php";

                if (!file_exists($controllerPath)) {
                    return self::fallback("❌ Controller file not found: $controllerPath", $requestPath);
                }

                require_once $controllerPath;

                if (!class_exists($controller)) {
                    return self::fallback("❌ Controller class not found: {$controller}", $requestPath);
                }

                $instance = new $controller;

                if (!method_exists($instance, $methodName)) {
                    return self::fallback("❌ Method '{$methodName}' not found in '{$controller}'", $requestPath);
                }

                self::debug("🔧 Executing: {$controller}::{$methodName}()");
                return call_user_func([$instance, $methodName]);
            }
        }

        if ($prefixMatched) {
            return self::fallback("⚠️ No exact route found for '{$requestPath}', but similar prefix exists.", $requestPath);
        }

        return self::fallback("❌ Route not found: '{$requestPath}'", $requestPath);
    }

    protected static function fallback($msg, $requestUri = '') {
        self::debug("🟥 404 Error: $msg");
        require_once "app/controllers/_404Controller.php";
        (new _404Controller)->index([$msg, __FILE__, $requestUri]);
    }

    protected static function debug($text){
        if (env('DEBUG') === 'true') {
            echo "<pre style='color: white; background:#222; padding:8px 12px; font-size:13px; margin-bottom:6px; border-left: 4px solid white;'>$text</pre><br/>";
        }
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
