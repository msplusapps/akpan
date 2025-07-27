<?php get_header("views/admin"); ?>
<main class="flex-1 overflow-y-auto">
    <!-- Hero -->
    <section class="bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-500 text-white py-20 px-10">
        <div class="text-left">
            <h1 class="text-5xl font-bold mb-2 drop-shadow-lg">Piko</h1>
            <p class="text-lg max-w-3xl opacity-90">
                Your modern PHP code style checker and fixer. Inspired by Laravel Pint, built from scratch.
            </p>
        </div>
    </section>
    <!-- Tool Actions -->
    <section class="max-w-6xl mx-auto px-6 py-12">
        <h2 class="text-3xl font-bold text-indigo-800 mb-8">Available Actions</h2>
        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            <!-- Check Style -->
            <div class="bg-white rounded-xl shadow p-6 flex flex-col justify-between">
                <div>
                    <h3 class="font-bold text-xl text-indigo-700 mb-2">Check Style</h3>
                    <p class="text-gray-600 text-sm mb-4">Analyze your code for PSR-12 and custom style issues.</p>
                </div>
                <a href="<?= url('admin/tools/piko/run/checkStyle') ?>"
                   class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold w-full py-2 rounded text-center">
                    Run Check
                </a>
            </div>
            <!-- Fix Style -->
            <div class="bg-white rounded-xl shadow p-6 flex flex-col justify-between">
                <div>
                    <h3 class="font-bold text-xl text-green-600 mb-2">Fix Style</h3>
                    <p class="text-gray-600 text-sm mb-4">Automatically fix code style violations (basic fix).</p>
                </div>
                <a href="<?= url('admin/tools/piko/run/fixStyle') ?>"
                   class="bg-green-600 hover:bg-green-700 text-white font-semibold w-full py-2 rounded text-center">
                    Auto Fix
                </a>
            </div>
            <!-- Format Code -->
            <div class="bg-white rounded-xl shadow p-6 flex flex-col justify-between">
                <div>
                    <h3 class="font-bold text-xl text-blue-600 mb-2">Format Code</h3>
                    <p class="text-gray-600 text-sm mb-4">Beautify and format all PHP files according to PSR-12.</p>
                </div>
                <a href="<?= url('admin/tools/piko/run/formatCode') ?>"
                   class="bg-blue-600 hover:bg-blue-700 text-white font-semibold w-full py-2 rounded text-center">
                    Format
                </a>
            </div>
            <!-- Inspect Classes -->
            <div class="bg-white rounded-xl shadow p-6 flex flex-col justify-between">
                <div>
                    <h3 class="font-bold text-xl text-purple-600 mb-2">Inspect Classes</h3>
                    <p class="text-gray-600 text-sm mb-4">Scan the project for classes and generate a detailed report.</p>
                </div>
                <a href="<?= url('admin/tools/piko/run/inspect') ?>"
                   class="bg-purple-600 hover:bg-purple-700 text-white font-semibold w-full py-2 rounded text-center">
                    Inspect
                </a>
            </div>
            <!-- List PHP Files -->
            <div class="bg-white rounded-xl shadow p-6 flex flex-col justify-between">
                <div>
                    <h3 class="font-bold text-xl text-yellow-600 mb-2">List Files</h3>
                    <p class="text-gray-600 text-sm mb-4">Show all PHP files in the project with paths.</p>
                </div>
                <a href="<?= url('admin/tools/piko/run/listFiles') ?>"
                   class="bg-yellow-500 hover:bg-yellow-600 text-white font-semibold w-full py-2 rounded text-center">
                    List Files
                </a>
            </div>
            <!-- Prettify Code -->
            <div class="bg-white rounded-xl shadow p-6 flex flex-col justify-between">
                <div>
                    <h3 class="font-bold text-xl text-pink-600 mb-2">Prettify Code</h3>
                    <p class="text-gray-600 text-sm mb-4">Run advanced beautifier for a clean and modern code layout.</p>
                </div>
                <a href="<?= url('admin/tools/piko/run/prettify') ?>"
                   class="bg-pink-600 hover:bg-pink-700 text-white font-semibold w-full py-2 rounded text-center">
                    Prettify
                </a>
            </div>
        </div>
    </section>
    <!-- Output Section -->
    <section class="max-w-6xl mx-auto px-6 py-6">
        <div class="bg-white rounded-xl shadow p-6">
            <h2 class="text-xl font-bold mb-4 text-gray-700">Result</h2>
            <div id="result-container">
                <?php if (!empty($result)): ?>
                    <?= $result ?>
                <?php else: ?>
                    <p class="text-gray-500">Run any tool above to see results here.</p>
                <?php endif; ?>
            </div>
        </div>
    </section>
</main>
<?php get_footer("views/admin"); ?>
