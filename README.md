# AkpanMVC

**AkpanMVC** is a lightweight, beginner-friendly PHP MVC framework built for rapid development. It supports clean routing, controller architecture, SQL migrations, middleware, and simple view rendering.

---

## 🚀 Features

- ✅ Simple expressive routing (`GET`, `POST`)
- ✅ Middleware support (`auth`, `guest`, custom)
- ✅ Controller-based architecture
- ✅ SQL-based migration system
- ✅ Blade-like views with data passing
- ✅ PSR-4 Composer autoloading
- ✅ `.env` configuration loader
- ✅ Debugging with styled console output
- ✅ Session-based user auth structure
- ✅ Auto-loading route/middleware files
- ✅ Composer ready

---

## 📦 Installation

Install AkpanMVC using Composer:

```bash
composer create-project msplusapps/akpan myproject
```

## 🗂 Directory Structure
myproject/
├── app/
│   ├── controllers/         → Controllers like AuthController.php
│   ├── models/              → Models like User.php
│   ├── views/               → Views like home.view.php
│   ├── routes/              → Route files (web.php, auth.php)
│   ├── middlewares/         → Middleware functions (auth.php, guest.php)
│   └── migrations/          → .sql migration files
├── core/
│   ├── Router.php
│   ├── Controller.php
│   ├── Model.php
│   ├── Env.php
│   ├── Database.php
│   └── Migrations.php
├── public/
│   └── index.php            → Entry point
├── logs/
│   └── error.log
├── .env
├── composer.json
└── README.md

## ⚙️ .env Configuration

DB_HOST=localhost
DB_NAME=akpanmvc
DB_USER=root
DB_PASS=


## 🌐 Routing
Router::get('/', ['WebController', 'index'])->name('home');

Router::get('/login', ['AuthController', 'login'])->name('login');
Router::post('/auth', ['AuthController', 'authenticate'])->middleware('guest');

Router::get('/dashboard', ['DashboardController', 'index'])->middleware('auth');

##🧍‍♂️ Middleware
// app/middlewares/auth.php
function auth() {
    if (!isset($_SESSION['user'])) {
        header("Location: /login");
        exit;
    }
}

Router::get('/dashboard', ['DashboardController', 'index'])->middleware('auth');

## 🧩 Controllers