<?php
get_header("views/admin"); ?>
<main class="flex-1 overflow-y-auto">
    <!-- Hero -->
    <section class="bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-500 text-white py-20 px-10">
        <div class="text-left">
            <h1 class="text-5xl font-bold mb-2 drop-shadow-lg">Doctor</h1>
            <p class="text-lg max-w-4xl opacity-90">
                A simple and modern PHP framework built to help developers move faster, with clarity and structure.
            </p>
        </div>
    </section>
    <!-- Methods Grid -->
    <section class="max-w-6xl mx-auto px-6 py-12">
        <h2 class="text-3xl font-bold text-indigo-800 mb-8">Available Methods</h2>
        <?php
if (!empty($methods)) : ?>
            <div class="grid gap-6 grid-cols-1 sm:grid-cols-2 lg:grid-cols-3">
                <?php
foreach ($methods as $method): ?>
                    <div class="bg-white rounded-xl shadow p-6 flex flex-col justify-between space-y-4">
                        <div>
                            <h3 class="font-mono text-xl text-gray-900 mb-2"><?= htmlspecialchars($method) ?>()</h3>
                            <p class="text-sm text-gray-500">Execute this method to run internal checks or diagnostics.</p>
                        </div>
                        <form method="POST" action="<?= url('admin/tools/doctor/run/' . urlencode(trim($method))) ?>">
                            <button type="submit"
                                    class="bg-indigo-600 hover:bg-indigo-700 text-white font-medium w-full py-2 rounded transition">
                                Run
                            </button>
                        </form>
                    </div>
                <?php
endforeach; ?>
            </div>
        <?php
else : ?>
            <div class="bg-white text-center text-red-600 p-6 rounded-xl shadow">
                <p>No callable methods found in the Doctor tool.</p>
            </div>
        <?php
endif; ?>
    </section>
</main>
<?php
get_footer("views/admin"); ?>
