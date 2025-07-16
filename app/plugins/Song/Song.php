<?php

namespace App\Plugins\Song;

use Core\Plugin;
use Core\Router;

class Song extends Plugin {

    public function __construct() {
        $this->name = 'Song Plugin';
        $this->version = '1.0';
        $this->author = 'Mr Epic';
        $this->description = 'This is a song plugin.';
    }

    public function activate() {
        // Code to run when the plugin is activated
    }

    public function deactivate() {
        // Code to run when the plugin is deactivated
    }

    // ✅ This is the correct method your PluginManager looks for
    public function register() {
        // Router::get('song/', ['App\\Plugins\\Song\\Controllers\\SongController', 'index']);

        // Router::get('/song', function () {
        //     echo '✅ Song plugin route is working!';
        // });
        Router::get('song/', ['SongController', 'index']);         // GET /song
        // // Show a single song by ID
        // Router::get('song/view/{id}', ['SongController', 'view']); // GET /song/view/5

        // // Show create form (optional for web apps)
        // Router::get('song/create', ['SongController', 'createForm']); // GET /song/create

        // // Create new song (submission endpoint)
        // Router::post('song/create', ['SongController', 'create']);    // POST /song/create

        // // Show update form (optional)
        // Router::get('song/edit/{id}', ['SongController', 'editForm']); // GET /song/edit/5

        // // Update song
        // Router::post('song/update/{id}', ['SongController', 'update']); // POST /song/update/5

        // // Delete song
        // Router::post('song/delete/{id}', ['SongController', 'delete']); // POST /song/delete/5
    }
}
