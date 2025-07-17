<?php

namespace Core;

class Router {
    protected static $routes = [];
    protected static $loadedControllers = [];
    protected $method;
    protected $uri;
    protected $action;
    public $middleware = [];
    public $name;
    

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

    public static function getRoutes() {
        return self::$routes;
    }

    protected static function add($method, $uri, $action) {
        $uri = trim($uri, '/');

        foreach (self::$routes as $route) {
            if ($route->uri === $uri && $route->method === strtoupper($method)) {
                self::debug("🟠 Duplicate route warning: {$method} '{$uri}' defined more than once.");
                trigger_error("Duplicate route found for method {$method} and URI '{$uri}'.", E_USER_WARNING);
            }
        }

        // Shorthand: ['Controller@method']
        if (is_array($action) && count($action) === 1 && str_contains($action[0], '@')) {
            [$controller, $methodName] = explode('@', $action[0]);
            $action = [$controller, $methodName];
        }

        $route = new self($method, $uri, $action);
        self::$routes[] = $route;
        return $route;
    }

    public static function dispatch($requestUri) {
        global $pluginManager;

        static $loaded = false;
        if (!$loaded) {
            if (isset($pluginManager)) {
                foreach ($pluginManager->getPlugins() as $plugin) {
                    if (method_exists($plugin, 'registerRoutes')) {
                        $plugin->registerRoutes();
                    }
                }
            }

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
        $prefixMatched = false;

        foreach (self::$routes as $route) {
            $definedRoute = trim($route->uri, '/');

            if (str_starts_with($requestPath, explode('/', $definedRoute)[0])) {
                $prefixMatched = true;
            }

            if ($definedRoute === $requestPath && $route->method === $method) {
                foreach ($route->middleware as $mw) {
                    if (function_exists($mw)) {
                        call_user_func($mw);
                    } else {
                        self::debug("⚠️ Middleware '$mw' not found.");
                    }
                }

                if (is_callable($route->action)) {
                    self::debug("⚙️ Executing callable route action.");
                    echo call_user_func($route->action);
                    return;
                }

                [$controller, $methodName] = $route->action;

                // Laravel-style fallback
                if (is_string($controller) && str_contains($controller, '@')) {
                    [$controller, $methodName] = explode('@', $controller);
                }

                $isPlugin = str_contains($controller, '\\Plugins\\');
                $controllerFile = '';

                if ($isPlugin) {
                    $controllerFile = 'app/' . str_replace(['App\\', '\\'], ['', '/'], $controller) . '.php';
                } else {
                    $controllerFile = "app/controllers/{$controller}.php";
                    $controller = "App\\Controllers\\{$controller}";
                }

                // Only include controller file once
                if (!class_exists($controller)) {
                    if (!file_exists($controllerFile)) {
                        return self::fallback("❌ Controller file not found: $controllerFile", $requestPath);
                    }

                    if (!in_array($controllerFile, self::$loadedControllers)) {
                        require_once $controllerFile;
                        self::$loadedControllers[] = $controllerFile;
                    } else {
                        self::debug("⚠️ Skipped already loaded controller: $controllerFile");
                    }
                }

                if (!class_exists($controller)) {
                    return self::fallback("❌ Controller class not found: {$controller}", $requestPath);
                }

                $instance = new $controller;

                if (!method_exists($instance, $methodName)) {
                    return self::fallback("❌ Method '{$methodName}' not found in '{$controller}'", $requestPath);
                }
                return call_user_func([$instance, $methodName]);
            }
        }

        if ($prefixMatched) {
            self::debug("⚠️ Prefix matched for '{$requestPath}', but no exact match found.");
        }

        return self::fallback("❌ Route not found: '{$requestPath}'", $requestPath);
    }

    protected static function fallback($msg, $requestUri = '') {
        self::debug("🟥 404 Error: $msg");

        if (file_exists("app/controllers/_404Controller.php")) {
            require_once "app/controllers/_404Controller.php";
            (new \App\Controllers\_404Controller)->index([$msg, __FILE__, $requestUri]);
        } else {
            echo "<h1>404 Not Found</h1><p>$msg</p>";
        }
    }

    protected static function debug($text) {
        if (function_exists('env') && env('DEBUG') === 'true') {
            echo "<pre style='color: white; background:#222; padding:8px 12px; font-size:13px; margin-bottom:6px; border-left: 4px solid lime;'>$text</pre>";
        }
    }

    private function __construct($method, $uri, $action) {
        $this->method = strtoupper($method);
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

    public static function all() {
        return self::$routes;
    }

    public function getMethod() {
        return $this->method;
    }

    public function getUri() {
        return $this->uri;
    }

    public function getAction() {
        return $this->action;
    }

    public function getMiddleware() {
        return $this->middleware;
    }
}