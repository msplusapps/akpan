<?php

namespace App\Plugins\RouteDebugger;

use Core\Plugin;
use Core\Router;

class RouteDebugger extends Plugin
{

    public function __construct()
    {
        $this->name = 'Route Debugger';
        $this->version = '1.0';
        $this->author = 'Jules';
        $this->description = 'A plugin to debug all registered routes.';
    }

    public function activate()
    {
        // Activation code
    }

    public function deactivate()
    {
        // Deactivation code
    }

    public function registerRoutes()
    {
        if (function_exists('env') && env('DEBUG') === 'true') {
            Router::get('/debug-routes', function () {
                $routes = Router::getRoutes();
                echo '<h1>Registered Routes</h1>';
                echo '<table border="1" cellpadding="5" cellspacing="0">';
                echo '<tr><th>Method</th><th>URI</th><th>Action</th><th>Middleware</th><th>Name</th></tr>';
                foreach ($routes as $route) {
                    $action = is_string($route->action) ? $route->action : (is_array($route->action) ? implode('::', $route->action) : 'Closure');
                    echo '<tr>';
                    echo '<td>' . $route->method . '</td>';
                    echo '<td>' . $route->uri . '</td>';
                    echo '<td>' . $action . '</td>';
                    echo '<td>' . implode(', ', $route->middleware) . '</td>';
                    echo '<td>' . $route->name . '</td>';
                    echo '</tr>';
                }
                echo '</table>';
            });
        }
    }
}
