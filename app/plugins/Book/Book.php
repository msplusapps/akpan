<?php
/**
 * Plugin Name: Book Plugin
 * Version: 1.0
 * Author: mr skillz
 * Description: xcxcxcxc
 */

namespace App\Plugins\Book;

use Core\Plugin;
use Core\Router;

class Book extends Plugin
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
        Router::get('Book/', ['BookController', 'index']); // GET /Book

        // Uncomment and customize the following routes as needed:

        // Router::get('Book/view/{id}', ['BookController', 'view']);
        // Router::get('Book/create', ['BookController', 'createForm']);
        // Router::post('Book/create', ['BookController', 'create']);
        // Router::get('Book/edit/{id}', ['BookController', 'editForm']);
        // Router::post('Book/update/{id}', ['BookController', 'update']);
        // Router::post('Book/delete/{id}', ['BookController', 'delete']);
    }
}