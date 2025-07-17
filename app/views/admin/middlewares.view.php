<?php

use Core\Utils\FileManager;

get_header("views/admin");
?>
<main class="flex-1 bg-gray-100 overflow-y-auto">

    <!-- Hero -->
    <section class="bg-gradient-to-r from-purple-700 via-indigo-600 to-blue-500 text-white py-20 px-10">
        <div class="text-left">
            <h1 class="text-5xl font-bold mb-2 drop-shadow-lg">Registered Middlewares</h1>
            <p class="text-lg max-w-3xl opacity-90">
                These are all middlewares currently registered in the framework.
            </p>
        </div>
    </section>

    <!-- Middlewares -->
    <div class="p-8">
        <?php
        $middlewareDir = 'app/middlewares';
        $middlewareFiles = FileManager::getFiles($middlewareDir);

        // Predefined Tailwind background color classes
        $bgColors = ['bg-red-100', 'bg-green-100', 'bg-yellow-100', 'bg-blue-100', 'bg-purple-100', 'bg-pink-100', 'bg-indigo-100'];
        $textColors = ['text-red-800', 'text-green-800', 'text-yellow-800', 'text-blue-800', 'text-purple-800', 'text-pink-800', 'text-indigo-800'];
        ?>

        <?php if (!empty($middlewareFiles)): ?>
            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3 mb-10">
                <?php foreach ($middlewareFiles as $index => $file): ?>
                    <?php
                    $name = pathinfo($file, PATHINFO_FILENAME);
                    $bg = $bgColors[$index % count($bgColors)];
                    $text = $textColors[$index % count($textColors)];
                    ?>
                    <div class="<?= $bg ?> p-6 rounded-lg shadow hover:shadow-lg transition">
                        <h3 class="text-xl font-semibold <?= $text ?> mb-2"><?= htmlspecialchars($name) ?></h3>
                        <p class="text-sm <?= $text ?> break-words"><?= $file ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p class="text-gray-500">No middlewares found in <code><?= $middlewareDir ?></code>.</p>
        <?php endif; ?>
    </div>

</main>
<?php get_footer("views/admin"); ?>