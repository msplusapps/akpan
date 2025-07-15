<?php

namespace App\Plugins\Auth;

use Core\Plugin;
use Core\Router;
use Core\Database;

class AuthPlugin extends Plugin
{
    public function __construct()
    {
        $this->name = 'Auth';
        $this->version = '1.0';
        $this->author = 'Mr Promise Peter';
        $this->description = 'A simple authentication system for Akpan MVC.';
    }

    public function activate()
    {
        $this->createUsersTable();
        $this->registerRoutes();
    }

    public function deactivate()
    {
        // Optional: Code to run when the plugin is deactivated
    }

    private function createUsersTable()
    {
        $db = new Database();
        $sql = "CREATE TABLE IF NOT EXISTS msk_users (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(100) NOT NULL,
            username VARCHAR(100) NOT NULL UNIQUE,
            email VARCHAR(100) NOT NULL UNIQUE,
            password VARCHAR(255) NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )";

        $db->query($sql); // Assumes query() exists in your Core\Database
    }

    private function registerRoutes()
    {
        Router::get('/auth/login', ['AuthController', 'login']);
        Router::post('/auth/login', ['AuthController', 'authenticate']);

        Router::get('/auth/register', ['AuthController', 'register']);
        Router::post('/auth/register', ['AuthController', 'process_register']);

        Router::get('/auth/logout', ['AuthController', 'logout']);
    }
}
