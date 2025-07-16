<?php
use Core\Router;

// 🏠 Home Page
Router::get('/plugins', ['pluginsController', 'index']);