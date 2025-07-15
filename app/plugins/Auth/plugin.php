<?php

use Core\Plugin;
use Core\Router;
use Core\Database;

class AuthPlugin extends Plugin {

    public function __construct() {
        $this->name = 'Auth';
        $this->version = '1.0';
        $this->author = 'Mr Promise Peter';
        echo $this->description = 'A simple authentication system.';
    }

    public function activate() {
        $this->createUsersTable();
        $this->registerRoutes();
    }

    public function deactivate() {
        // Code to run when the plugin is deactivated
    }

    private function createUsersTable() {
        $db = new Database();
        $sql = "CREATE TABLE IF NOT EXISTS msk_users2 (
            id INT AUTO_INCREMENT PRIMARY KEY,
            username VARCHAR(255) NOT NULL,
            password VARCHAR(255) NOT NULL,
            email VARCHAR(255) NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )";
        $db->query($sql);
    }

    private function registerRoutes() {
        Router::get('/auth/login', 'AuthController@login');
        Router::post('/auth/login', 'AuthController@login');
        Router::get('/auth/register', 'AuthController@register');
        Router::post('/auth/register', 'AuthController@register');
        Router::get('/auth/logout', 'AuthController@logout');
    }
}
