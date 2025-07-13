<?php

Router::get('/auth', ['AuthController', 'index'])->name('auth');
Router::post('/auth', ['AuthController', 'authenticate']);
// Router::post('/logout', ['AuthController', 'logout'])->middleware('auth');

// Router::get('/register', ['AuthController', 'showRegister'])->name('register');
// Router::post('/register', ['AuthController', 'register']);
