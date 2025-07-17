<?php get_header("views/admin"); ?>

<!-- Main Content -->
<main class="flex-1 overflow-y-auto">

    <!-- Header -->
    <section class="bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-500 text-white py-16 px-10">
        <div class="text-left">
            <h1 class="text-4xl font-bold mb-2 drop-shadow-lg">Create New Plugin</h1>
            <p class="text-lg max-w-2xl opacity-90">Fill out the form below to create a new plugin.</p>
        </div>
    </section>

    <!-- Plugin Form -->
    <div class="px-10 py-8">
        <form action="<?= url('./admin/plugins/store') ?>" method="post" class="bg-white p-8 rounded-xl shadow-md space-y-6 max-w-2xl mx-auto">

            <div>
                <label for="name" class="block font-medium mb-1">Plugin Name</label>
                <input type="text" id="name" name="name" required class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-indigo-500">
            </div>

            <div>
                <label for="version" class="block font-medium mb-1">Version</label>
                <input type="text" id="version" name="version" value="1.0" required class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-indigo-500">
            </div>

            <div>
                <label for="author" class="block font-medium mb-1">Author</label>
                <input type="text" id="author" name="author" required class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-indigo-500">
            </div>

            <div>
                <label for="description" class="block font-medium mb-1">Description</label>
                <textarea id="description" name="description" rows="4" required class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-indigo-500"></textarea>
            </div>

            <div class="text-right">
                <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded-lg hover:bg-indigo-700 shadow-md transition">
                    🚀 Create Plugin
                </button>
            </div>

        </form>
    </div>

</main>

<?php get_footer("views/admin"); ?>
