<?php
use Core\Router;

// 🏠 Home Page
Router::get('/', ['WebController', 'index']);

// 📄 Documentation Page
Router::get('/documentation', ['WebController', 'documentation']);

// 📖 download Page
Router::get('/about', ['WebController', 'about']);

// 📖 About Page
Router::get('/download', ['WebController', 'download']);

// 📞 Contact Page
Router::get('/contact', ['WebController', 'contact']);

// 💼 Services Page
Router::get('/services', ['WebController', 'services']);

// 📰 Blog Page
Router::get('/blog', ['WebController', 'blog']);
