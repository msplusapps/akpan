<?php get_header("web"); ?>

<!-- About Hero Section -->
<section class="gradient-bg text-white py-24">
    <div class="container mx-auto px-6 text-center">
        <h1 class="text-4xl md:text-5xl font-bold mb-4">About Akpan MVC</h1>
        <p class="text-xl md:text-2xl max-w-2xl mx-auto">A simple and modern PHP framework built to help developers move faster, with clarity and structure.</p>
    </div>
</section>

<!-- Our Mission -->
<section class="py-20 bg-white">
    <div class="container mx-auto px-6 text-center">
        <h2 class="text-3xl md:text-4xl font-bold mb-6">Our Mission</h2>
        <p class="text-gray-600 text-lg max-w-3xl mx-auto">
            Akpan MVC was created to simplify web application development with clean architecture, elegant routing, and out-of-the-box security. Whether you're building APIs, dashboards, or full-stack applications, our framework gives you a head start.
        </p>
    </div>
</section>

<!-- Core Values -->
<section class="bg-gray-50 py-20">
    <div class="container mx-auto px-6 text-center">
        <h2 class="text-3xl md:text-4xl font-bold mb-12">Core Values</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
            <div>
                <i class="fas fa-lightbulb text-indigo-600 text-4xl mb-4"></i>
                <h4 class="text-xl font-bold mb-2">Simplicity</h4>
                <p class="text-gray-600">Keep the codebase lean and developer-friendly.</p>
            </div>
            <div>
                <i class="fas fa-lock text-indigo-600 text-4xl mb-4"></i>
                <h4 class="text-xl font-bold mb-2">Security</h4>
                <p class="text-gray-600">Protect apps by default with modern security features.</p>
            </div>
            <div>
                <i class="fas fa-bolt text-indigo-600 text-4xl mb-4"></i>
                <h4 class="text-xl font-bold mb-2">Performance</h4>
                <p class="text-gray-600">Deliver fast responses with minimal resource usage.</p>
            </div>
        </div>
    </div>
</section>

<!-- Meet the Creator -->
<section class="py-20 bg-white">
    <div class="container mx-auto px-6 text-center">
        <h2 class="text-3xl md:text-4xl font-bold mb-6">Meet the Creator</h2>
        <p class="text-gray-700 max-w-2xl mx-auto mb-8">Akpan MVC was developed by <strong>Promise Peter Akpan</strong>, a passionate full-stack developer focused on building tools that empower developers and educators.</p>
        <img src="<?= asset('images/mrakpan.png') ?>" alt="Creator Image" class="mx-auto w-32 h-32 rounded-full shadow-lg">
    </div>
</section>

<!-- Call to Action -->
<section class="py-20 bg-indigo-700 text-white text-center">
    <div class="container mx-auto px-6">
        <h2 class="text-3xl md:text-4xl font-bold mb-4">Ready to Build?</h2>
        <p class="text-lg mb-8">Start your next project with Akpan MVC — lightweight, flexible, and developer-friendly.</p>
        <a href="./documentation" class="bg-white text-indigo-700 font-bold py-3 px-8 rounded-full hover:bg-gray-100 transition duration-300">Explore Docs</a>
    </div>
</section>

<?php get_footer(); ?>
