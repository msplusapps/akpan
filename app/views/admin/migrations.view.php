<?php get_header("views/admin"); ?>
<main class="flex-1 bg-gray-100 overflow-y-auto">
    <!-- Hero -->
    <section class="bg-gradient-to-r from-green-600 via-teal-500 to-cyan-500 text-white py-20 px-10">
        <div class="text-left">
            <h1 class="text-5xl font-bold mb-2 drop-shadow-lg">Registered Migrations</h1>
            <p class="text-lg max-w-3xl opacity-90">
                Below are all migration SQL files discovered in the framework and plugins.
            </p>
        </div>
    </section>

    <!-- Migration List -->
    <section class="px-8 pt-10 pb-6">
        <h2 class="text-3xl font-bold mb-4 text-gray-800">Discovered Migration SQL Files</h2>
        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">

        <?php
            function collectMigrations($directory) {
                $files = glob($directory . '/*.sql');
                return array_filter($files, fn($f) => basename($f) !== 'index.php');
            }

            $coreMigrations = collectMigrations("app/migrations");
            $pluginMigrations = glob("app/plugins/*/migrations/*.sql");

            $allMigrations = [];

            foreach ($coreMigrations as $file) {
                $allMigrations[] = ['type' => 'Core', 'file' => $file];
            }

            foreach ($pluginMigrations as $file) {
                $allMigrations[] = ['type' => 'Plugin', 'file' => $file];
            }

            foreach ($allMigrations as $migration) {
                $type = $migration['type'];
                $file = $migration['file'];
                $filename = basename($file);
                $contents = file_get_contents($file);
                $snippet = substr(trim($contents), 0, 1000); // Limit preview to 1000 chars
                $labelColor = $type === 'Core' ? 'bg-green-600' : 'bg-purple-600';

                echo "<div class='bg-white rounded-2xl p-6 shadow-lg border-l-8 border-cyan-500 hover:border-green-600 transition relative'>";
                echo "<div class='absolute top-3 right-3 text-xs px-3 py-1 rounded-full text-white $labelColor font-semibold'>$type</div>";
                echo "<h3 class='text-xl font-bold text-cyan-800 mb-2'>" . htmlspecialchars($filename) . "</h3>";
                echo "<pre class='bg-gray-100 text-sm p-3 rounded text-gray-800 overflow-x-auto mb-3'><code>" . htmlspecialchars($snippet) . "</code></pre>";
                echo "<p class='text-sm text-gray-600'>Path: <code>$file</code></p>";
                echo "</div>";
            }
        ?>
        </div>
    </section>
</main>
<?php get_footer("views/admin"); ?>