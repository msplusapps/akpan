<?php

namespace App\Plugins\Example;

use Core\Plugin;

class ExamplePlugin extends Plugin {

    public function __construct() {
        $this->name = 'Example Plugin';
        $this->version = '1.0';
        $this->author = 'Your Name';
        echo $this->description = 'This is an example plugin.';
    }

    public function activate() {
        // Code to run when the plugin is activated
    }

    public function deactivate() {
        // Code to run when the plugin is deactivated
    }

    public function registerRoutes() {
        \Core\Router::get('/test', function () {
            return 'This is the plugin test route';
        });
    }
}
