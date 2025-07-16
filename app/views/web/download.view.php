<?php get_header(); ?>

<!-- Hero Section -->
<section class="gradient-bg text-white py-24">
    <div class="container mx-auto px-6 text-center">
        <h1 class="text-4xl md:text-5xl font-bold mb-4">Download Akpan MVC</h1>
        <p class="text-xl md:text-2xl max-w-2xl mx-auto">Get the latest version of Akpan MVC and start building fast, modern PHP applications today.</p>
    </div>
</section>

<!-- Download Section -->
<section class="py-20 bg-white">
    <div class="container mx-auto px-6 max-w-3xl text-center">
        <h2 class="text-2xl md:text-3xl font-bold mb-6">Installation via Composer</h2>
        <div class="bg-gray-900 text-left text-green-400 p-4 rounded-lg mb-8 overflow-x-auto">
            <code>composer create-project msplusapps/akpan your-project-name</code>
        </div>

        <h2 class="text-2xl md:text-3xl font-bold mb-6">Manual Download</h2>
        <p class="text-gray-600 mb-4">Prefer downloading the ZIP? Use the link below:</p>
        <a href="#" class="bg-indigo-600 text-white font-bold py-3 px-8 rounded-lg inline-block hover:bg-indigo-700 transition duration-300">Download ZIP</a>

        <div class="mt-10 text-gray-500">
            <p>Current Version: <strong>v1.0.0</strong></p>
            <p>Requires PHP 8.0 or higher</p>
        </div>
    </div>
</section>

<!-- Why Akpan Section -->
<section class="py-20 bg-gray-100">
    <div class="container mx-auto px-6 max-w-4xl text-center">
        <h2 class="text-3xl font-bold mb-10">Why Choose Akpan MVC?</h2>
        <ul class="grid grid-cols-1 md:grid-cols-2 gap-6 text-left">
            <li class="bg-white p-6 rounded-lg shadow"><strong>🚀 Fast:</strong> Minimal footprint and optimized for speed.</li>
            <li class="bg-white p-6 rounded-lg shadow"><strong>🧼 Clean Code:</strong> Simple, readable syntax that gets out of your way.</li>
            <li class="bg-white p-6 rounded-lg shadow"><strong>📦 Modular:</strong> MVC structure with clear separation of concerns.</li>
            <li class="bg-white p-6 rounded-lg shadow"><strong>🔐 Secure:</strong> Includes CSRF, XSS, and SQLi protection.</li>
        </ul>
    </div>
</section>

<?php get_footer(); ?>
