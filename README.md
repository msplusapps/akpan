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
class WebController extends Controller {
    public function index() {
        return $this->view('home', ['title' => 'Welcome']);
    }
}

Use $this->view('file', ['data' => 'value']) to pass data to views.

## 🧬 Models

class User extends Model {
    protected $table = 'users';
}

$users = User::all();
$user = User::find(1);

## 📚 Views
Views are .view.php files stored in app/views/.

Render them from a controller:
return $this->view('auth/login', ['title' => 'Login']);
Example app/views/auth/login.view.php:
<h1><?= $title ?></h1>
<form method="POST" action="/auth">
    <input name="email" />
    <input name="password" type="password" />
    <button>Login</button>
</form>



## 📜 Migrations
Add .sql files to app/migrations/.

Example 2024_07_12_create_users_table.sql:

CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100),
  email VARCHAR(100) UNIQUE,
  password VARCHAR(255),
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
Migrations are executed once and logged to the msk_migrations table.

## 🧪 Local Testing
Run the app locally using PHP’s built-in server:


php -S localhost:8000 -t public
Then visit: http://localhost:8000

## Debugging
Debug output is automatically displayed via Router::debug():


[ROUTE LOADED] app/routes/web.php
[DISPATCH] GET '/'
[EXECUTE] WebController::index()
Errors are saved to logs/error.log for further inspection.


## 📜 License
AkpanMVC is open-sourced software licensed under the MIT license.

## 🙌 Author
msplusapps
GitHub: @msplusapps
Packagist: msplusapps/akpan

## 💡 Contribute
Fork this repository

Create your feature branch (git checkout -b feature/new-feature)

Commit your changes

Push to the branch

Open a Pull Request

❤️ Thank You
Thanks for using AkpanMVC — we’d love to hear your feedback and ideas!