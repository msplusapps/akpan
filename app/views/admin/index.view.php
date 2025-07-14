<?php get_header("admin"); ?>

<section class="py-16 bg-white">
    <div class="container mx-auto px-6 max-w-4xl">
        <h2 class="text-3xl font-bold text-center mb-10">📄 Add Documentation</h2>

        <?php if (!empty($error)) : ?>
            <div class="bg-red-100 text-red-800 p-4 mb-6 rounded"><?= $error ?></div>
        <?php elseif (!empty($success)) : ?>
            <div class="bg-green-100 text-green-800 p-4 mb-6 rounded"><?= $success ?></div>
        <?php endif; ?>

        <form method="POST">
            <?= csrf_token(); ?>
            <div class="mb-6">
                <label class="block mb-2 font-semibold text-gray-700">Title</label>
                <input type="text" name="title" value="<?= htmlspecialchars($_POST['title'] ?? '') ?>" required
                    class="w-full p-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-600">
            </div>

            <div class="mb-6">
                <label class="block mb-2 font-semibold text-gray-700">Slug (e.g. <code>routing</code>)</label>
                <input type="text" name="slug" value="<?= htmlspecialchars($_POST['slug'] ?? '') ?>" required
                    class="w-full p-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-600">
            </div>

            <div class="mb-6">
                <label class="block mb-2 font-semibold text-gray-700">Content</label>
                <textarea name="content" id="editor" rows="10"
                    class="w-full p-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-600"><?= htmlspecialchars($_POST['content'] ?? '') ?></textarea>
            </div>

            <button type="submit"
                class="bg-indigo-600 text-white font-bold py-3 px-6 rounded-lg hover:bg-indigo-700 transition duration-300">
                Save Documentation
            </button>
        </form>
    </div>
</section>

<!-- ✅ TinyMCE CDN -->
<script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
<script>
    tinymce.init({
        selector: '#editor',
        plugins: 'link code lists table',
        toolbar: 'undo redo | formatselect | bold italic | alignleft aligncenter alignright | bullist numlist | link code',
        height: 400
    });
</script>

<?php get_footer("admin"); ?>
