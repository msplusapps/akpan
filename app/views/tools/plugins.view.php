<?php get_header("views/tools"); ?>

<!-- About Hero Section -->
<section class="bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-500 text-white py-24">
    <div class="container mx-auto px-6 text-center">
        <h1 class="text-6xl md:text-7xl font-bold mb-4 drop-shadow-lg">Installed Plugins</h1>
        <p class="text-xl md:text-2xl max-w-4xl mx-auto opacity-90">A simple and modern PHP framework built to help developers move faster, with clarity and structure.</p>
    </div>
</section>

<?php
$plugins = [];
$pluginBase = plugins_path();

foreach (scandir($pluginBase) as $folder) {
    if ($folder === '.' || $folder === '..') continue;

    $pluginFile = $pluginBase . '/' . $folder . '/' . $folder . '.php';

    if (file_exists($pluginFile)) {
        $meta = read_plugin_metadata($pluginFile);

        if ($meta) {
            $plugins[] = $meta;
        }
    }
}
?>

<!-- Available Plugins -->
<section class="py-24 bg-gradient-to-br from-indigo-100 via-purple-100 to-pink-100">
    <div class="container mx-auto px-6 text-center">
        <h2 class="text-4xl font-bold mb-12 text-indigo-800">Available Plugins</h2>

        <?php if (!empty($plugins)) : ?>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-10">
                <?php
                $cardColors = [
                    'from-pink-600 to-pink-500',
                    'from-purple-500 to-purple-600',
                    'from-indigo-600 to-indigo-500',
                    'from-blue-500 to-blue-600',
                    'from-green-600 to-green-500',
                    'from-yellow-500 to-yellow-600',
                    'from-red-600 to-red-500',
                    'from-cyan-500 to-cyan-600',
                ];

                foreach ($plugins as $index => $plugin) :
                    $bg = $cardColors[$index % count($cardColors)];
                ?>
                    <div class="bg-gradient-to-br <?= $bg ?> rounded-2xl shadow-xl p-6 border hover:shadow-2xl transition duration-300 text-left">
                        <div class="flex items-center mb-4">
                            <div class="bg-white text-indigo-700 rounded-full p-3 mr-4 shadow-md">
                                <i class="fas fa-plug text-2xl"></i>
                            </div>
                            <div>
                                <h4 class="text-xl font-bold text-white"><?= htmlspecialchars($plugin['name']) ?> <span class="text-sm text-white/80">v<?= $plugin['version'] ?></span></h4>
                            </div>
                        </div>
                        <p class="text-white/90 mb-3"><?= htmlspecialchars($plugin['description']) ?></p>
                        <p class="text-sm text-white italic">By <?= htmlspecialchars($plugin['author']) ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else : ?>
            <p class="text-gray-600 text-lg">No plugins found.</p>
        <?php endif; ?>
    </div>
</section>

<?php get_footer("views/tools"); ?>
