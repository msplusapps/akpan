<?php

namespace App\Plugins\Auth;

use Core\Plugin;
use Core\Router;
use Core\Database;
use Core\Model;

class AuthPlugin extends Plugin {

    public $idd = 0;

    public function __construct() {
        $this->name = 'Auth';
        $this->version = '1.0';
        $this->author = 'Jules';
        $this->description = 'A simple authentication system.';
    }

    public function activate() {
        $this->registerRoutes();
    }

    public function deactivate() {
        // Code to run when the plugin is deactivated
    }


    public function registerRoutes() {
        echo $this->idd++;
        Router::get('/auth/signin', 'AuthController@signin');
        // Router::post('/auth/login', 'AuthController@login');
        // Router::get('/auth/register', 'AuthController@register');
        // Router::post('/auth/register', 'AuthController@register');
        // Router::get('/auth/logout', 'AuthController@logout');
    }
}
