<?php

Router::get("auth/", ['AuthController', 'index']);
Router::post("auth/", ['AuthController', 'authenticate']);
Router::get("auth/logout", ['AuthController', 'logout'])->middleware('auth');

Router::get("auth/register", ['AuthController', 'register']);
Router::post("auth/register", ['AuthController', 'process_register']);
