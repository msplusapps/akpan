<?php get_header("web"); ?>
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
<?php get_footer(); ?>