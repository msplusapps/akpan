<?php

use Core\Router;
use App\Controllers\AdminController;

// echo 'reading home route';
Router::get("admin/", [AdminController::class, 'index'])->middleware('auth');
// Router::get('/about', ['WebController', 'about'])->name('about');
// Router::get('/contact', ['WebController', 'contact'])->name('contact');

