<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Akpan MVC Documentation</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 text-gray-800">

  <!-- Header -->
  <header class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white shadow-lg sticky top-0 z-50">
    <div class="container mx-auto px-6 py-4 flex justify-between items-center">
      <h1 class="text-xl md:text-2xl font-bold">📘 Akpan MVC Documentation</h1>
      <nav class="space-x-4 hidden md:block">
        <a href="#intro" class="hover:underline">Intro</a>
        <a href="#install" class="hover:underline">Install</a>
        <a href="#structure" class="hover:underline">Structure</a>
        <a href="#routing" class="hover:underline">Routing</a>
        <a href="#controllers" class="hover:underline">Controllers</a>
        <a href="#models" class="hover:underline">Models</a>
        <a href="#views" class="hover:underline">Views</a>
        <a href="#migrations" class="hover:underline">Migrations</a>
      </nav>
    </div>
  </header>

  <main class="max-w-5xl mx-auto px-4 py-12 space-y-16">

    <!-- Intro -->
    <section id="intro">
      <h2 class="text-3xl font-bold mb-4">🔰 Introduction</h2>
      <p>
        <strong>Akpan MVC</strong> is a modern, lightweight PHP framework built to simplify web development using the MVC pattern.
        It comes bundled with routing, controllers, views, middleware, and a built-in migration system.
      </p>
    </section>

    <!-- Install -->
    <section id="install">
      <h2 class="text-3xl font-bold mb-4">📦 Installation</h2>
      <p>Install using Composer:</p>
      <pre class="bg-gray-800 text-white p-4 rounded mt-2"><code>composer create-project msplusapps/akpan myproject</code></pre>
      <p class="mt-4">After installation, navigate to the folder and run:</p>
      <pre class="bg-gray-800 text-white p-4 rounded mt-2"><code>php -S localhost:8000 -t public</code></pre>
    </section>

    <!-- Structure -->
    <section id="structure">
      <h2 class="text-3xl font-bold mb-4">📁 Directory Structure</h2>
      <pre class="bg-gray-100 p-4 rounded text-sm"><code>
project/
│
├── app/
│   ├── controllers/
│   ├── models/
│   ├── views/
│   ├── routes/
│   ├── middlewares/
│   └── migrations/
│
├── core/
│   ├── Router.php
│   ├── Controller.php
│   ├── Model.php
│   ├── Migrations.php
│   └── Database.php
│
├── public/
│   └── index.php
│
├── .env
└── composer.json
      </code></pre>
    </section>

    <!-- .env -->
    <section id="env">
      <h2 class="text-3xl font-bold mb-4">⚙️ .env Configuration</h2>
      <pre class="bg-gray-800 text-white p-4 rounded"><code>DB_HOST=localhost
DB_NAME=akpanmvc
DB_USER=root
DB_PASS=secret</code></pre>
      <p class="mt-2">Environment variables are loaded automatically by the framework via <code>Env::load()</code>.</p>
    </section>

    <!-- Routing -->
    <section id="routing">
      <h2 class="text-3xl font-bold mb-4">🛣️ Routing</h2>
      <p>Define routes in <code>app/routes/web.php</code>:</p>
      <pre class="bg-gray-800 text-white p-4 rounded"><code>
Router::get('/', ['WebController', 'index'])->name('home');

Router::get('/login', ['AuthController', 'login'])->name('login');
Router::post('/login', ['AuthController', 'authenticate']);
      </code></pre>
    </section>

    <!-- Middleware -->
    <section id="middleware">
      <h2 class="text-3xl font-bold mb-4">🛡 Middleware</h2>
      <p>Create middleware functions inside <code>app/middlewares/</code>:</p>
      <pre class="bg-gray-800 text-white p-4 rounded"><code>
// auth.php
function auth() {
  if (!isset($_SESSION['user'])) {
    header('Location: /login');
    exit;
  }
}
      </code></pre>
      <p>Apply it on a route:</p>
      <pre class="bg-gray-800 text-white p-4 rounded"><code>
Router::get('/dashboard', ['UserController', 'dashboard'])
      ->middleware('auth')
      ->name('dashboard');
      </code></pre>
    </section>

    <!-- Controllers -->
    <section id="controllers">
      <h2 class="text-3xl font-bold mb-4">🧠 Controllers</h2>
      <p>Create controllers inside <code>app/controllers</code>.</p>
      <pre class="bg-gray-800 text-white p-4 rounded"><code>
class WebController extends Controller {
    public function index() {
        return $this->view('home', ['title' => 'Welcome']);
    }
}
      </code></pre>
    </section>

    <!-- Models -->
    <section id="models">
      <h2 class="text-3xl font-bold mb-4">🗃 Models</h2>
      <p>Extend the base Model:</p>
      <pre class="bg-gray-800 text-white p-4 rounded"><code>
class User extends Model {
    protected $table = 'users';
}
      </code></pre>
    </section>

    <!-- Views -->
    <section id="views">
      <h2 class="text-3xl font-bold mb-4">🖼 Views</h2>
      <p>All views are stored in <code>app/views/</code> as <code>.php</code> files.</p>
      <pre class="bg-gray-800 text-white p-4 rounded"><code>
&lt;h1&gt;<?= $title ?? 'Default Title' ?>&lt;/h1&gt;
      </code></pre>
    </section>

    <!-- Migrations -->
    <section id="migrations">
      <h2 class="text-3xl font-bold mb-4">📤 Migrations</h2>
      <p>Store your SQL files in <code>app/migrations/</code>.</p>
      <pre class="bg-gray-800 text-white p-4 rounded"><code>
// 2025_01_01_create_users_table.sql
CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100),
  email VARCHAR(100),
  password VARCHAR(255),
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
      </code></pre>
      <p>The framework will auto-run pending migrations on load.</p>
    </section>

    <!-- Local Testing -->
    <section id="test">
      <h2 class="text-3xl font-bold mb-4">🧪 Local Testing</h2>
      <p>Run your project using:</p>
      <pre class="bg-gray-800 text-white p-4 rounded"><code>php -S localhost:8000 -t public</code></pre>
      <p>Ensure your database is ready and credentials are correct in <code>.env</code>.</p>
    </section>

  </main>

  <footer class="bg-gray-900 text-white py-8 text-center">
    <p>&copy; <?= date('Y') ?> Akpan MVC. Open Source. MIT Licensed.</p>
  </footer>

</body>
</html>
