<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Akpan MVC - The Modern PHP Framework</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .feature-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
        .nav-link {
            position: relative;
        }
        .nav-link:after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: 0;
            left: 0;
            background-color: #fff;
            transition: width 0.3s ease;
        }
        .nav-link:hover:after {
            width: 100%;
        }
        .code-block {
            font-family: 'Courier New', monospace;
            background-color: #2d3748;
            color: #f7fafc;
            border-radius: 0.5rem;
        }
    </style>
</head>
<body class="font-sans antialiased text-gray-800">
    <!-- Navigation -->
    <nav class="gradient-bg text-white fixed w-full z-50 shadow-lg">
        <div class="container mx-auto px-6 py-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <i class="fas fa-code text-2xl mr-2"></i>
                    <span class="font-bold text-xl">Akpan MVC</span>
                </div>
                <div class="hidden md:flex space-x-8">
                    <a href="#features" class="nav-link">Features</a>
                    <a href="#docs" class="nav-link">Documentation</a>
                    <a href="#community" class="nav-link">Community</a>
                    <a href="#download" class="nav-link">Download</a>
                </div>
                <div class="md:hidden">
                    <button id="menu-btn" class="text-white focus:outline-none">
                        <i class="fas fa-bars text-2xl"></i>
                    </button>
                </div>
            </div>
            <!-- Mobile menu -->
            <div id="mobile-menu" class="hidden md:hidden mt-4 pb-4">
                <a href="#features" class="block py-2">Features</a>
                <a href="#docs" class="block py-2">Documentation</a>
                <a href="#community" class="block py-2">Community</a>
                <a href="#download" class="block py-2">Download</a>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="gradient-bg text-white pt-32 pb-20">
        <div class="container mx-auto px-6 text-center">
            <h1 class="text-4xl md:text-6xl font-bold mb-6">Build Better Web Applications</h1>
            <p class="text-xl md:text-2xl mb-12 max-w-3xl mx-auto">Akpan MVC is a modern, lightweight PHP framework designed for developers who value simplicity and performance.</p>
            <div class="flex flex-col md:flex-row justify-center space-y-4 md:space-y-0 md:space-x-4">
                <a href="#download" class="bg-white text-indigo-700 font-bold py-3 px-8 rounded-full hover:bg-gray-100 transition duration-300">Get Started</a>
                <a href="#docs" class="border-2 border-white text-white font-bold py-3 px-8 rounded-full hover:bg-white hover:text-indigo-700 transition duration-300">Documentation</a>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-20 bg-gray-50">
        <div class="container mx-auto px-6">
            <h2 class="text-3xl md:text-4xl font-bold text-center mb-16">Powerful Features</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div class="feature-card bg-white p-8 rounded-lg shadow-md transition duration-300">
                    <div class="text-indigo-600 mb-4">
                        <i class="fas fa-bolt text-4xl"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-3">Lightning Fast</h3>
                    <p class="text-gray-600">Optimized for performance with minimal overhead. Akpan MVC delivers blazing fast response times for your applications.</p>
                </div>
                
                <!-- Feature 2 -->
                <div class="feature-card bg-white p-8 rounded-lg shadow-md transition duration-300">
                    <div class="text-indigo-600 mb-4">
                        <i class="fas fa-code text-4xl"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-3">Elegant Syntax</h3>
                    <p class="text-gray-600">Clean, expressive syntax that makes development enjoyable and your code easy to maintain.</p>
                </div>
                
                <!-- Feature 3 -->
                <div class="feature-card bg-white p-8 rounded-lg shadow-md transition duration-300">
                    <div class="text-indigo-600 mb-4">
                        <i class="fas fa-shield-alt text-4xl"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-3">Secure by Default</h3>
                    <p class="text-gray-600">Built-in protection against common vulnerabilities like CSRF, XSS, and SQL injection.</p>
                </div>
                
                <!-- Feature 4 -->
                <div class="feature-card bg-white p-8 rounded-lg shadow-md transition duration-300">
                    <div class="text-indigo-600 mb-4">
                        <i class="fas fa-database text-4xl"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-3">Database Agnostic</h3>
                    <p class="text-gray-600">Works with MySQL, PostgreSQL, SQLite, and more. Choose the database that fits your needs.</p>
                </div>
                
                <!-- Feature 5 -->
                <div class="feature-card bg-white p-8 rounded-lg shadow-md transition duration-300">
                    <div class="text-indigo-600 mb-4">
                        <i class="fas fa-mobile-alt text-4xl"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-3">API Ready</h3>
                    <p class="text-gray-600">Easily build RESTful APIs with built-in JSON response handling and authentication.</p>
                </div>
                
                <!-- Feature 6 -->
                <div class="feature-card bg-white p-8 rounded-lg shadow-md transition duration-300">
                    <div class="text-indigo-600 mb-4">
                        <i class="fas fa-rocket text-4xl"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-3">Modular Architecture</h3>
                    <p class="text-gray-600">Organize your code into reusable modules that can be shared across projects.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Code Example Section -->
    <section class="py-20 bg-gray-800 text-white">
        <div class="container mx-auto px-6">
            <h2 class="text-3xl md:text-4xl font-bold text-center mb-12">Simple and Expressive</h2>
            <div class="flex flex-col lg:flex-row items-center">
                <div class="lg:w-1/2 mb-10 lg:mb-0 lg:pr-10">
                    <h3 class="text-2xl font-bold mb-4">Create a route in seconds</h3>
                    <p class="text-gray-300 mb-6">Akpan MVC's routing system is intuitive and powerful. Define routes with closures or controller methods.</p>
                    <h3 class="text-2xl font-bold mb-4">Built-in templating</h3>
                    <p class="text-gray-300">Our lightweight templating engine helps you separate presentation logic from business logic.</p>
                </div>
                <div class="lg:w-1/2 code-block p-6 overflow-x-auto">
                    <pre><code class="language-php">
// Define a simple route
Route::get('/welcome', function() {
    return view('welcome', [
        'title' => 'Welcome to Akpan MVC'
    ]);
});

// Route to controller
Route::get('/users', 'UserController@index');

// Database query example
$users = DB::table('users')
            ->where('active', true)
            ->orderBy('name')
            ->get();

// Model example
class User extends Model {
    protected $fillable = ['name', 'email'];
}
                    </code></pre>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="py-16 bg-indigo-700 text-white">
        <div class="container mx-auto px-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-center">
                <div class="p-6">
                    <div class="text-4xl font-bold mb-2">2.5K+</div>
                    <div class="text-xl">GitHub Stars</div>
                </div>
                <div class="p-6">
                    <div class="text-4xl font-bold mb-2">500+</div>
                    <div class="text-xl">Active Developers</div>
                </div>
                <div class="p-6">
                    <div class="text-4xl font-bold mb-2">100%</div>
                    <div class="text-xl">Open Source</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Community Section -->
    <section id="community" class="py-20 bg-white">
        <div class="container mx-auto px-6 text-center">
            <h2 class="text-3xl md:text-4xl font-bold mb-6">Join Our Community</h2>
            <p class="text-xl text-gray-600 max-w-2xl mx-auto mb-12">Connect with other developers, get help, and contribute to the future of Akpan MVC.</p>
            <div class="flex flex-wrap justify-center gap-6">
                <a href="#" class="bg-gray-800 text-white px-6 py-3 rounded-lg flex items-center hover:bg-gray-700 transition duration-300">
                    <i class="fab fa-github mr-2 text-xl"></i> GitHub
                </a>
                <a href="#" class="bg-blue-500 text-white px-6 py-3 rounded-lg flex items-center hover:bg-blue-600 transition duration-300">
                    <i class="fab fa-twitter mr-2 text-xl"></i> Twitter
                </a>
                <a href="#" class="bg-indigo-600 text-white px-6 py-3 rounded-lg flex items-center hover:bg-indigo-700 transition duration-300">
                    <i class="fab fa-discord mr-2 text-xl"></i> Discord
                </a>
                <a href="#" class="bg-red-500 text-white px-6 py-3 rounded-lg flex items-center hover:bg-red-600 transition duration-300">
                    <i class="fab fa-youtube mr-2 text-xl"></i> YouTube
                </a>
            </div>
        </div>
    </section>

    <!-- Download Section -->
    <section id="download" class="py-20 bg-gray-100">
        <div class="container mx-auto px-6">
            <div class="max-w-4xl mx-auto text-center">
                <h2 class="text-3xl md:text-4xl font-bold mb-6">Ready to Get Started?</h2>
                <p class="text-xl text-gray-600 mb-10">Install Akpan MVC today and start building amazing web applications.</p>
                <div class="bg-white rounded-lg shadow-xl p-8 mb-10">
                    <div class="code-block p-4 mb-6 text-left">
                        <pre><code class="language-bash">composer create-project msplusapps/akpan your-project-name</code></pre>
                    </div>
                    <p class="text-gray-600 mb-6">Or download the latest release:</p>
                    <a href="#" class="gradient-bg text-white font-bold py-3 px-8 rounded-full inline-block hover:opacity-90 transition duration-300">Download v1.0.0</a>
                </div>
                <div class="text-gray-600">
                    <p>Requires PHP 8.0 or higher</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-12">
        <div class="container mx-auto px-6">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <h3 class="text-xl font-bold mb-4">Akpan MVC</h3>
                    <p class="text-gray-400">A modern PHP framework for web artisans.</p>
                </div>
                <div>
                    <h4 class="font-bold mb-4">Resources</h4>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-400 hover:text-white">Documentation</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white">API Reference</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white">Tutorials</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-bold mb-4">Community</h4>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-400 hover:text-white">GitHub</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white">Forums</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white">Discord</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-bold mb-4">Legal</h4>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-400 hover:text-white">License</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white">Privacy Policy</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white">Terms of Use</a></li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-800 mt-12 pt-8 text-center text-gray-400">
                <p>&copy; 2023 Akpan MVC. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script>
        // Mobile menu toggle
        document.getElementById('menu-btn').addEventListener('click', function() {
            const menu = document.getElementById('mobile-menu');
            menu.classList.toggle('hidden');
        });

        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                
                const targetId = this.getAttribute('href');
                const targetElement = document.querySelector(targetId);
                
                if (targetElement) {
                    // Close mobile menu if open
                    const menu = document.getElementById('mobile-menu');
                    menu.classList.add('hidden');
                    
                    // Scroll to target
                    window.scrollTo({
                        top: targetElement.offsetTop - 80,
                        behavior: 'smooth'
                    });
                }
            });
        });

        // Add shadow to navbar on scroll
        window.addEventListener('scroll', function() {
            const nav = document.querySelector('nav');
            if (window.scrollY > 50) {
                nav.classList.add('shadow-xl');
            } else {
                nav.classList.remove('shadow-xl');
            }
        });
    </script>
</body>
</html>