<?php

namespace Core;
class Router {
    protected static array $routes = [];
    /**
     * Register a GET route
     */
    public static function get(string $uri, $action) {
        return self::add('GET', $uri, $action);
    }
    /**
     * Register a POST route
     */
    public static function post(string $uri, $action) {
        return self::add('POST', $uri, $action);
    }
    /**
     * Add route with normalized URI
     */
    protected static function add(string $method, string $uri, $action): Route {
        $uri = self::normalizeUri($uri);
        foreach (self::$routes as $route) {
            if ($route->uri === $uri && $route->method === $method) {
                Response::debug("🟠 Duplicate route: {$method} '{$uri}'");
            }
        }
        // Handle controller@method syntax
        if (is_string($action) && str_contains($action, '@')) {
            [$controller, $methodName] = explode('@', $action);
            $action = [$controller, $methodName];
        }
        $route = new Route($method, $uri, $action);
        self::$routes[] = $route;
        return $route;
    }
    /**
     * Dispatch request to matching route
     */
    public static function dispatch(Request $request) {
        Kernel::boot();
        $requestUri = self::normalizeUri($request->uri);
        $prefixMatched = false;
        foreach (self::$routes as $route) {
            if ($route->method !== $request->method) {
                continue;
            }
            // Convert {param} to regex
            $pattern = preg_replace('/\{([a-zA-Z_][a-zA-Z0-9_-]*)\}/', '([^/]+)', $route->uri);
            $pattern = '#^' . $pattern . '$#';
            if (preg_match($pattern, $requestUri, $matches)) {
                array_shift($matches);
                foreach ($route->middleware as $mw) {
                    if (function_exists($mw)) {
                        call_user_func($mw);
                    } else {
                        Response::debug("⚠️ Middleware '$mw' not found.");
                    }
                }
                return self::execute($route, $matches);
            }
            // Prefix check for debugging
            if (str_starts_with($requestUri, explode('/', $route->uri)[0])) {
                $prefixMatched = true;
            }
        }
        if ($prefixMatched) {
            Response::debug("⚠️ Prefix matched for '{$requestUri}', but no exact route found.");
        }
        Response::fallback("❌ Route not found: '{$requestUri}'", $requestUri);
    }
    /**
     * Execute controller method or callable
     */
    protected static function execute(Route $route, array $params = []) {
        if (is_callable($route->action)) {
            return call_user_func_array($route->action, $params);
        }
        [$controller, $method] = $route->action;
        $controllerClass = "App\\Controllers\\$controller";
        $controllerFile = "app/controllers/{$controller}.php";
        if (!class_exists($controllerClass)) {
            if (!file_exists($controllerFile)) {
                return Response::fallback("❌ Controller file not found: $controllerFile", $route->uri);
            }
            require_once $controllerFile;
        }
        if (!class_exists($controllerClass)) {
            return Response::fallback("❌ Controller class not found: $controllerClass", $route->uri);
        }
        $instance = new $controllerClass;
        if (!method_exists($instance, $method)) {
            return Response::fallback("❌ Method '$method' not found in '$controllerClass'", $route->uri);
        }
        return call_user_func_array([$instance, $method], $params);
    }
    /**
     * Normalize URI (trim, remove query, multiple slashes)
     */
    protected static function normalizeUri(string $uri): string {
        $uri = trim($uri);
        $uri = preg_replace('/\?.*/', '', $uri); // Remove query string
        $uri = preg_replace('#/+#', '/', $uri); // Collapse multiple slashes
        $uri = trim($uri, '/');
        return $uri;
    }
    public static function getRoutes(): array {
        return self::$routes;
    }
}
