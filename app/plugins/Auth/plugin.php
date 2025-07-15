<?php

namespace Auth;

use Core\Plugin;
use Core\Router;
use Core\Database;

class AuthPlugin extends Plugin {

    public function __construct() {
        $this->name = 'Auth';
        $this->version = '1.0';
        $this->author = 'Mr Promise Peter';
        echo $this->description = 'A simple authentication system for Akpan MVC.';
    }

    public function activate() {
        $this->createUsersTable();
    }

    public function deactivate() {
        // Code to run when the plugin is deactivated
    }

    public function register(Router $router) {
        $router->get('/auth/login', 'AuthController@login');
        $router->post('/auth/login', 'AuthController@login');
        $router->get('/auth/register', 'AuthController@register');
        $router->post('/auth/register', 'AuthController@register');
        $router->get('/auth/logout', 'AuthController@logout');
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
}
