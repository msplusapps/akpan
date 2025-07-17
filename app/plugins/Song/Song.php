<?php
/**
 * Plugin Name: Song Player Plugin
 * Version: 1.0
 * Author: Mr Epic
 * Description: This is a plugin. It comes with routes, controllers, and a migrations file.
 */

namespace App\Plugins;

use Core\Plugin;
use Core\Router;

class Song extends Plugin
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
        Router::get('song/', ['SongController', 'index']); // GET /song

        // Uncomment and customize the following routes as needed:

        // Router::get('song/view/{id}', ['SongController', 'view']);         // View single song
        // Router::get('song/create', ['SongController', 'createForm']);     // Show create form
        // Router::post('song/create', ['SongController', 'create']);        // Handle create submission
        // Router::get('song/edit/{id}', ['SongController', 'editForm']);    // Show edit form
        // Router::post('song/update/{id}', ['SongController', 'update']);   // Handle update submission
        // Router::post('song/delete/{id}', ['SongController', 'delete']);   // Handle delete
    }
}
