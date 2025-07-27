<?php
/**
 * Plugin Name: Inspire Plugin
 * Version: 1.0
 * Author: Peter Akpan
 * Description: This is a random quote generator
 */
namespace App\Plugins\Inspire;
use Core\Plugin;
use Core\Router;
use App\Plugins\Inspire\Controllers\InspireController;

class Inspire extends Plugin
{
    public function activate() {
        // Code to run when the plugin is activated
    }
    public function deactivate() {
        // Code to run when the plugin is deactivated
    }

    public function register() {
        Router::get('inspire/', [InspireController::class, 'index']); // GET /Inspire
    }
}