<?php

use Core\Plugin;
use Core\Router;

class ImageResizerPlugin extends Plugin {

    public function __construct() {
        $this->name = 'ImageResizer';
        $this->version = '1.0';
        $this->author = 'Jules';
        $this->description = 'A simple image resizing plugin.';
    }

    public function activate() {
    }

    public function deactivate() {
        // Code to run when the plugin is deactivated
    }

    public function register(Router $router) {
        $router->get('/image/resize', 'ImageController@resize');
    }
}
