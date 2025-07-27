<?php

/**
 * Plugin Name: Zapper Plugin
 * Version: 1.0
 * Author: Peter Akpan
 * Description: Description: This is a file management system.
 */
namespace App\Plugins\Zapper;
use Core\Plugin;
use Core\Router;
use App\Plugins\Zapper\Controllers\ZapperController;
class Zapper extends Plugin
{
    public function activate() {
        // Code to run when the plugin is activated
    }
    public function deactivate() {
        // Code to run when the plugin is deactivated
    }
    public function register() {
        Router::get('zapper/', [ZapperController::class, 'index']); // GET /Zapper
        Router::get('zapper/send', [ZapperController::class, 'send']); // GET /Zapper
        Router::post('zapper/send', [ZapperController::class, 'mobileTransfer']); // GET /Zapper
        Router::get('zapper/api', [ZapperController::class, 'api']); // GET /Zapper
        Router::get('zapper/handshake', [ZapperController::class, 'handshake']); // GET /Zapper
        Router::post('zapper/files', [ZapperController::class, 'files']); // GET /Zapper
        Router::post('zapper/delete', [ZapperController::class, 'delete']); // GET /Zapper
        Router::get('zapper/monitor', [ZapperController::class, 'monitor']); // GET /Zapper
    }
}
