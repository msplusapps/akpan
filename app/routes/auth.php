<?php

Router::get("auth/", ['AuthController', 'index']);
Router::post("auth/login", ['AuthController', 'authenticate']);
Router::get("auth/logout", ['AuthController', 'logout'])->middleware('auth');

Router::get("auth/register", ['AuthController', 'showRegister']);
Router::post("auth/register", ['AuthController', 'register']);
