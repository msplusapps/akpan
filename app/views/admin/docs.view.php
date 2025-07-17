<?php get_header("views/admin"); ?>

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

<!-- ✅ Summernote CSS & JS via CDN -->
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-lite.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-lite.min.js"></script>
<script>
    $(document).ready(function () {
        $('#editor').summernote({
            placeholder: 'Write your documentation content here...',
            tabsize: 2,
            height: 400,
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'italic', 'underline']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['insert', ['link', 'table']],
                ['view', ['codeview']]
            ]
        });
    });
</script>

<?php get_footer("views/admin"); ?>
