<?php

use Core\Router;
use App\Controllers\WebController;

// 🏠 Home Page
Router::get('/', [WebController::class, 'index']);

// 📄 Documentation Page
Router::get('/documentation', [WebController::class, 'documentation']);

// 📖 download Page
Router::get('/about', [WebController::class, 'about']);

// 📖 About Page
Router::get('/download', [WebController::class, 'download']);

// 📞 Contact Page
Router::get('/contact', [WebController::class, 'contact']);

// 💼 Services Page
Router::get('/services', [WebController::class, 'services']);

// 📰 Blog Page
Router::get('/blog', [WebController::class, 'blog']);
