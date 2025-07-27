<?php
get_header("views/admin"); ?>
<main class="flex-1 overflow-y-auto">
    <!-- Hero -->
    <section class="bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-500 text-white py-20 px-10">
        <div class="text-left">
            <h1 class="text-5xl font-bold mb-2 drop-shadow-lg">Tools</h1>
            <p class="text-lg max-w-3xl opacity-90">
                A simple and modern PHP framework built to help developers move faster, with clarity and structure.
            </p>
        </div>
    </section>
    <?php
$tools = [];
    $toolBase = base_path('/core/tools');
    foreach (scandir($toolBase) as $folder) {
        if ($folder === '.' || $folder === '..') continue;
        $toolFile = "{$toolBase}/{$folder}";
        if (file_exists($toolFile)) {
            $meta = read_plugin_metadata($toolFile);
            if ($meta) {
                $meta += [
                    'name' => $folder,
                    'version' => '1.0.0',
                    'description' => '',
                    'author' => '',
                ];
                $meta['folder'] = $folder;
                $tools[] = $meta;
            }
        }
    }
    ?>
    <div class="p-8 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
        <?php
if (!empty($tools)) : ?>
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
            foreach ($tools as $index => $tool) :
                $bg = $cardColors[$index % count($cardColors)];
                $folder = strtolower($tool['folder'] ?? '');
            ?>
                <div class="bg-gradient-to-br <?= $bg ?> text-white shadow-lg rounded-2xl p-6 border border-white/20 hover:shadow-2xl transition relative flex flex-col justify-between">
                    <!-- tool Info -->
                    <div>
                        <div class="flex justify-between items-center mb-4">
                            <span class="text-sm px-3 py-1 rounded-full bg-orange-500 text-white">tool</span>
                            <span class="font-bold text-sm">v<?= htmlspecialchars($tool['version']) ?></span>
                        </div>
                        <h3 class="text-xl font-semibold mb-2"><?= htmlspecialchars($tool['name']) ?></h3>
                        <p class="mb-3"><?= htmlspecialchars($tool['description']) ?></p>
                        <p class="text-sm italic">By <?= htmlspecialchars($tool['author']) ?></p>
                    </div>
                    <!-- Action Buttons -->
                    <div class="flex justify-end mt-6">
                        <a href="<?= url('./admin/tools/delete?{' . urlencode($folder)) ?>"
                           onclick="return confirm('Are you sure you want to delete this tool?')"
                           class="text-white font-bold hover:text-red-200 transition flex items-center gap-2 text-lg">
                            <i class="fas fa-trash-alt"></i>
                        </a>
                        <a target="_blank" href="<?= url('admin/tools/' . htmlspecialchars(strtolower($tool['name']))) ?>"
                           class="ml-4 text-white font-bold hover:text-red-200 transition flex items-center gap-2 text-lg">
                            <i class="fas fa-globe"></i>
                        </a>
                    </div>
                </div>
            <?php
endforeach; ?>
        <?php
else : ?>
            <p class="text-center text-gray-600 text-lg col-span-full">No tools found.</p>
        <?php
endif; ?>
    </div>
</main>
<?php
get_footer("views/admin"); ?>
