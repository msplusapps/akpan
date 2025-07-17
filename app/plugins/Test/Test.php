<?php
/**
 * Plugin Name: test Plugin
 * Version: 1.0
 * Author: mr skillz
 * Description: hhhh
 */

namespace App\Plugins\Test;

use Core\Plugin;
use Core\Router;

class Test extends Plugin
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
        Router::get('test/', ['TestController', 'index']); 
    }
}