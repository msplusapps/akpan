<?php get_header("views/tools"); ?>

<!-- Contact Hero -->
<section class="gradient-bg text-white py-24">
    <div class="container mx-auto px-6 text-center">
        <h1 class="text-4xl md:text-5xl font-bold mb-4">Contact Us</h1>
        <p class="text-xl md:text-2xl max-w-2xl mx-auto">We’d love to hear from you — whether you have questions, feedback, or want to contribute to Akpan MVC.</p>
    </div>
</section>

<!-- Contact Form Section -->
<section class="py-20 bg-white">
    <div class="container mx-auto px-6 max-w-3xl">
        <h2 class="text-3xl font-bold text-center mb-10">Send a Message</h2>
        <form action="#" method="POST" class="bg-gray-50 p-8 rounded-lg shadow-lg">
            <div class="mb-6">
                <label class="block mb-2 font-semibold text-gray-700">Full Name</label>
                <input type="text" name="name" required class="w-full p-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-600">
            </div>
            <div class="mb-6">
                <label class="block mb-2 font-semibold text-gray-700">Email Address</label>
                <input type="email" name="email" required class="w-full p-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-600">
            </div>
            <div class="mb-6">
                <label class="block mb-2 font-semibold text-gray-700">Message</label>
                <textarea name="message" rows="5" required class="w-full p-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-600"></textarea>
            </div>
            <button type="submit" class="bg-indigo-600 text-white font-bold py-3 px-6 rounded-lg hover:bg-indigo-700 transition duration-300">Send Message</button>
        </form>
    </div>
</section>

<!-- Contact Info -->
<section class="py-20 bg-gray-100">
    <div class="container mx-auto px-6 text-center">
        <h2 class="text-3xl font-bold mb-8">Other Ways to Reach Us</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div>
                <i class="fas fa-envelope text-indigo-600 text-3xl mb-4"></i>
                <p class="font-semibold">Email</p>
                <p class="text-gray-600">support@akpanmvc.com</p>
            </div>
            <div>
                <i class="fas fa-map-marker-alt text-indigo-600 text-3xl mb-4"></i>
                <p class="font-semibold">Address</p>
                <p class="text-gray-600">Uyo, Akwa Ibom State, Nigeria</p>
            </div>
            <div>
                <i class="fas fa-phone text-indigo-600 text-3xl mb-4"></i>
                <p class="font-semibold">Phone</p>
                <p class="text-gray-600">+234 800 123 4567</p>
            </div>
        </div>
    </div>
</section>

<?php get_footer("views/tools"); ?>
