<?php get_header("views/admin"); ?>
    <!-- Main Content -->
    <main class="flex-1 overflow-y-auto">

        <!-- Hero -->
        <section class="bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-500 text-white py-20 px-10">
            <div class="text-left">
                <h1 class="text-5xl font-bold mb-2 drop-shadow-lg">Installed Plugins</h1>
                <p class="text-lg max-w-3xl opacity-90">
                    A simple and modern PHP framework built to help developers move faster, with clarity and structure.
                </p>
            </div>
        </section>

        <!-- Plugin Data Load -->
         <!-- Create New Plugin Button -->
        <div class="px-10 mt-4">
            <a href="<?= url('./admin/plugins/create') ?>" 
            class="inline-block bg-white text-indigo-700 hover:bg-indigo-50 font-semibold px-6 py-2 rounded-lg shadow-md transition">
                ➕ Create New Plugin
            </a>
        </div>

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
        <div class="p-8 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            <?php if (!empty($plugins)) : ?>
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
                    <div class="bg-gradient-to-br <?= $bg ?> text-white shadow-lg rounded-2xl p-6 border border-white/20 hover:shadow-2xl transition relative flex flex-col justify-between">
    
                        <div>
                            <div class="flex justify-between items-center mb-4">
                                <span class="text-sm px-3 py-1 rounded-full bg-orange-500 text-white">Plugin</span>
                                <span class="font-bold text-sm">v<?= htmlspecialchars($plugin['version']) ?></span>
                            </div>

                            <h3 class="text-xl font-semibold mb-2"><?= htmlspecialchars($plugin['name']) ?></h3>
                            <p class="mb-3"><?= htmlspecialchars($plugin['description']) ?></p>
                            <p class="text-sm italic">By <?= htmlspecialchars($plugin['author']) ?></p>
                        </div>

                        <!-- Delete Button at Bottom -->
                        <div class="flex justify-end mt-6">
                            <a href="<?= url('./admin/plugins/delete?plugin=' . urlencode($plugin['name'] ?? '')) ?>" 
                            onclick="return confirm('Are you sure you want to delete this plugin?')"
                            class="text-white font-bold hover:text-red-200 transition flex items-center gap-1 text-xl">
                                <i class="fas fa-trash-alt"></i>
                            </a>
                        </div>


                    </div>

                <?php endforeach; ?>
            <?php else : ?>
                <p class="text-center text-gray-600 text-lg col-span-full">No plugins found.</p>
            <?php endif; ?>
        </div>
        
    </main>

<?php get_footer("views/admin"); ?>
