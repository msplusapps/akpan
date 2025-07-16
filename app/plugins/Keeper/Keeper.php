<?php
/**
 * Plugin Name: Keeper Plugin
 * Version: 1.0
 * Author: Mr Epic
 * Description: This is an authentication plugin. It comes with routes, controllers, and a migrations file.
 */

namespace App\Plugins\Keeper;

use Core\Plugin;
use Core\Router;

class Keeper extends Plugin
{
    public function activate()
    {
        // Code to run when the plugin is activated
    }

    public function deactivate()
    {
        // Code to run when the plugin is deactivated
    }

    public function register()
    {
        // Define plugin routes here

        // Router::get('keeper/', ['KeeperController', 'index']);         // GET /keeper
        // Router::get('keeper/view/{id}', ['KeeperController', 'view']); // GET /keeper/view/5
        // Router::get('keeper/create', ['KeeperController', 'createForm']); // GET /keeper/create
        // Router::post('keeper/create', ['KeeperController', 'create']);    // POST /keeper/create
        // Router::get('keeper/edit/{id}', ['KeeperController', 'editForm']); // GET /keeper/edit/5
        // Router::post('keeper/update/{id}', ['KeeperController', 'update']); // POST /keeper/update/5
        // Router::post('keeper/delete/{id}', ['KeeperController', 'delete']); // POST /keeper/delete/5
    }
}
