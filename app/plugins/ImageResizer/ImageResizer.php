<?php

namespace App\Plugins\ImageResizer;

use Core\Plugin;

class ImageResizer extends Plugin {

    public function __construct() {
        $this->name = 'Image Resizer';
        $this->version = '1.0';
        $this->author = 'Jules';
        $this->description = 'A plugin to upload and resize images.';
    }

    public function activate() {
        // Code to run when the plugin is activated
    }

    public function deactivate() {
        // Code to run when the plugin is deactivated
    }

    public function register() {
        // Add a route for the upload form
        \Core\Router::get('imageresizer', ['App\Plugins\ImageResizer\Controllers\ImageResizerController', 'index']);

        // Add a route for the upload processing
        \Core\Router::post('imageresizer/upload', ['App\Plugins\ImageResizer\Controllers\ImageResizerController', 'upload']);
    }
}
