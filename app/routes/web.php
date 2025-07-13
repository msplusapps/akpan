<?php


Router::get('/', ['WebController', 'index'])->middleware('auth')->name('home');

// Router::get('/', ['AuthController', 'login'])
//     ->middleware('guest')
//     ->name('login');