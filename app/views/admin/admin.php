<?php
use Core\Router;

// echo 'reading home route';
Router::get("admin/", ['AdminController', 'index'])->middleware('auth');


Router::get("admin/docs", ['AdminController', 'docs'])->middleware('auth');


Router::get("admin/plugins", ['AdminController', 'plugins'])->middleware('auth');


Router::get('admin/cache', ['AdminController', 'cache']);
Router::post('admin/cache/update', ['AdminController', 'updateCache'])->middleware('auth');
Router::post('admin/cache/clear', ['AdminController', 'clearCache'])->middleware('auth');

